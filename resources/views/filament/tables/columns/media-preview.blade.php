<div class="flex items-center p-2">
    @php
        $record = $getRecord();
        $filePath = $record->file_path;
        $tipeMedia = $record->tipe_media;
        $url = \Illuminate\Support\Facades\Storage::disk('public')->url($filePath);
    @endphp

    @if ($tipeMedia === 'gambar')
        <img src="{{ $url }}" alt="{{ $record->nama_media }}" 
            class="h-10 w-10 object-cover rounded shadow-sm">
    @elseif ($tipeMedia === 'video')
        <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center shadow-sm">
            <x-heroicon-o-video-camera class="w-6 h-6 text-gray-500" />
        </div>
    @endif
</div>
