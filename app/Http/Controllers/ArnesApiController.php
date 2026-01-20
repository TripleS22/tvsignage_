<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArnesApiController extends Controller
{
    /**
     * Base URL for Arnes API
     */
    private const ARNES_API_BASE = 'https://apiweb.arnes.co.id/v1';

    /**
     * Get schedule data from Arnes API for a specific outlet.
     * 
     * @param string $kode_outlet The outlet code (e.g., BTS for Baltos)
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchedule($kode_outlet)
    {
        try {
            $response = Http::timeout(10)->get(self::ARNES_API_BASE . "/information/{$kode_outlet}", [
                'page' => 1
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Transform schedule data for frontend consumption
                $schedules = [];
                if (isset($data['schedules']['data']) && is_array($data['schedules']['data'])) {
                    $schedules = collect($data['schedules']['data'])->map(function ($item) {
                        return [
                            'id' => $item['id'] ?? null,
                            'jam' => $item['etd'] ?? $item['departure_time'] ?? '-',
                            'tujuan' => $item['destination'] ?? $item['route'] ?? '-',
                            'nama_driver' => $item['driver_name'] ?? $item['driver'] ?? '-',
                            'nama_kendaraan' => $item['vehicle_name'] ?? $item['vehicle'] ?? $item['bus_name'] ?? '-',
                            'status' => $item['status'] ?? '',
                            'etd_time' => $item['etd'] ?? null,
                        ];
                    })->toArray();
                }

                return response()->json([
                    'success' => true,
                    'schedules' => $schedules,
                    'total' => $data['schedules']['total'] ?? 0,
                    'current_page' => $data['schedules']['current_page'] ?? 1,
                    'last_page' => $data['schedules']['last_page'] ?? 1,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch schedule data',
                'schedules' => []
            ], 500);

        } catch (\Exception $e) {
            Log::error('Arnes API Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error connecting to Arnes API',
                'schedules' => []
            ], 500);
        }
    }
}
