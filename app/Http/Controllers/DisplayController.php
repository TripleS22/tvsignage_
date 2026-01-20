<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Gabungan;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index(Request $request)
    {
        return $this->renderPlayer($request);
    }

    /**
     * Force Jalan Rasa Player view.
     */
    public function jalanRasa(Request $request, $outlet_id = null)
    {
        return $this->renderPlayer($request, 'player', $outlet_id, 'JalanRasa');
    }

    /**
     * Force Arnes Player view.
     */
    public function arnes(Request $request, $outlet_id = null)
    {
        return $this->renderPlayer($request, 'arnes.player', $outlet_id, 'Arnes');
    }

    /**
     * Shared logic for rendering player.
     * 
     * @param Request $request
     * @param string|null $forceView View name to use
     * @param int|null $id Outlet ID from URL
     * @param string|null $filterRole Filter outlets by user role ('Arnes' or 'Jalan Rasa')
     */
    private function renderPlayer(Request $request, $forceView = null, $id = null, $filterRole = null)
    {
        // Filter outlets by role if specified
        if ($filterRole) {
            $outlets = Outlet::withoutGlobalScopes()
                ->whereHas('user.roles', function ($query) use ($filterRole) {
                    $query->where('name', $filterRole);
                })
                ->get();
        } else {
            $outlets = Outlet::withoutGlobalScopes()->get();
        }

        $currentOutlet = null;
        $playlist = [];
        $jeda = 5;

        // Determine outlet ID: URL param > Session
        $outlet_id = $id ?? session('selected_outlet_id');

        if ($outlet_id) {
            $currentOutlet = Outlet::withoutGlobalScopes()
                ->with(['gabungan.media', 'user'])
                ->find($outlet_id);
                
            if ($currentOutlet) {
                // Verify the outlet belongs to the correct role (security check)
                if ($filterRole && $currentOutlet->user && !$currentOutlet->user->hasRole($filterRole)) {
                    // Outlet doesn't belong to this player type, ignore it
                    $currentOutlet = null;
                } else {
                    // If provided via URL, save to session for persistence
                    if ($id) {
                        session(['selected_outlet_id' => $id]);
                    }

                    if ($currentOutlet->gabungan) {
                        $playlist = $this->formatPlaylistData($currentOutlet->gabungan);
                        $jeda = $currentOutlet->gabungan->jeda_detik;
                    }

                    // If no specific view forced, auto-detect based on role
                    if (!$forceView) {
                        if ($currentOutlet->user && $currentOutlet->user->hasRole('Arnes')) {
                            return view('arnes.player', compact('outlets', 'currentOutlet', 'playlist', 'jeda'));
                        }
                    }
                }
            }
        }

        $view = $forceView ?? 'player';
        return view($view, compact('outlets', 'currentOutlet', 'playlist', 'jeda'));
    }

    /**
     * Store selected outlet in session.
     */
    public function selectOutlet(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlet,id'
        ]);

        session(['selected_outlet_id' => $request->outlet_id]);

        return response()->json(['success' => true]);
    }

    /**
     * API untuk mendapatkan data playlist terbaru bagi outlet tertentu.
     */
    public function getPlaylist($id)
    {
        $outlet = Outlet::with(['gabungan.media'])->find($id);
        
        if (!$outlet || !$outlet->gabungan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Outlet or composition not found'
            ], 404);
        }

        return response()->json([
            'outlet_name' => $outlet->nama_outlet,
            'jeda' => $outlet->gabungan->jeda_detik,
            'playlist' => $this->formatPlaylistData($outlet->gabungan)
        ]);
    }

    /**
     * Heartbeat API to track online status and active content.
     */
    public function ping(Request $request, $id)
    {
        $request->validate([
            'gabungan_id' => 'nullable|exists:gabungan,id',
            'active_media_name' => 'nullable|string',
            'media_list' => 'nullable|array',
            'schedule_summary' => 'nullable|array'
        ]);

        $publish = \App\Models\Publish::where('outlet_id', $id)
            ->where('status', 'published')
            ->first();

        if (!$publish) {
            $publish = \App\Models\Publish::firstOrNew(['outlet_id' => $id]);
        }

        $publish->is_online = true;
        $publish->last_ping = now();
        
        if ($request->gabungan_id) {
            $publish->gabungan_id = $request->gabungan_id;
        }

        // Format detailed notes
        $notes = [];
        
        if ($request->active_media_name) {
            $notes[] = "🔴 NOW PLAYING:\n" . $request->active_media_name;
        }

        if ($request->media_list && is_array($request->media_list)) {
            $notes[] = "📂 PLAYLIST:\n- " . implode("\n- ", $request->media_list);
        }

        if ($request->schedule_summary && is_array($request->schedule_summary)) {
            $schedLines = collect($request->schedule_summary)->take(10)->map(function($s) {
                return ($s['jam'] ?? '-') . " | " . ($s['tujuan'] ?? '-') . " | " . ($s['status'] ?? '-');
            })->toArray();
            
            if (!empty($schedLines)) {
                $notes[] = "🕒 SCHEDULE SNAPSHOT:\n" . implode("\n", $schedLines);
            }
        }

        if (!empty($notes)) {
            $publish->notes = implode("\n\n", $notes);
        }

        $publish->save();

        return response()->json(['success' => true]);
    }

    /**
     * Format data playlist agar konsisten.
     */
    private function formatPlaylistData($gabungan)
    {
        return $gabungan->media->map(function($m) {
            return [
                'id' => $m->id,
                'nama' => $m->nama_media,
                'tipe_media' => $m->tipe_media,
                'file_url' => asset('storage/' . $m->file_path),
                'durasi' => $m->durasi
            ];
        });
    }
}
