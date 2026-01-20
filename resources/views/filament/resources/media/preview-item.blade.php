@php
    $state = $getContainer()->getState();
    $mediaId = $state['media_id'] ?? null;
    $record = $mediaId ? \App\Models\Media::find($mediaId) : null;
@endphp

<div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 aspect-video w-full h-full">
    @if ($record)
        @if ($record->tipe_media === 'gambar')
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->file_path) }}" 
                 alt="{{ $record->nama_media }}" 
                 class="object-cover w-full h-full">
        @elseif ($record->tipe_media === 'video')
            <div class="relative w-full h-full flex items-center justify-center bg-black">
                <video class="w-full h-full object-cover opacity-50">
                    <source src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($record->file_path) }}" type="video/mp4">
                </video>
                <div class="absolute inset-0 flex items-center justify-center">
                    <x-heroicon-o-play-circle class="w-8 h-8 text-white opacity-80" />
                </div>
            </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center p-2 text-gray-400">
            <x-heroicon-o-photo class="w-6 h-6 mb-1" />
            <span class="text-[10px] uppercase font-bold tracking-tighter">No Media</span>
        </div>
    @endif
</div>
