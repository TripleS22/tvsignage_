<div class="flex items-center justify-center p-2">
    @php
        $record = $record ?? (isset($getRecord) ? $getRecord() : null);
        if ($record) {
            $filePath = $record->file_path;
            $tipeMedia = $record->tipe_media;
            $url = \Illuminate\Support\Facades\Storage::disk('public')->url($filePath);
        }
    @endphp

    @if ($record)
        @if ($tipeMedia === 'gambar')
            <img src="{{ $url }}" alt="{{ $record->nama_media }}" 
                class="max-h-96 rounded-lg shadow-lg cursor-pointer transition-transform hover:scale-[1.02]"
                onclick="window.open('{{ $url }}', '_blank')">
        @elseif ($tipeMedia === 'video')
            <video controls class="max-h-96 rounded-lg shadow-lg w-full" poster="{{ $url }}">
                <source src="{{ $url }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @endif
    @else
        <p class="text-gray-500">No media record found.</p>
    @endif
</div>
