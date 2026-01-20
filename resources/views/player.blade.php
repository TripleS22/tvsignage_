<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signage Player - Jalan Rasa</title>
    <style>
        /* Gotham Font Faces */
        @font-face {
            font-family: 'Gotham';
            src: url('/font/font_gotham/GOTHAM-BOOK.OTF') format('opentype');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Gotham';
            src: url('/font/font_gotham/GOTHAM-MEDIUM.OTF') format('opentype');
            font-weight: 500;
            font-style: normal;
        }
        @font-face {
            font-family: 'Gotham';
            src: url('/font/font_gotham/GOTHAM-BOLD.OTF') format('opentype');
            font-weight: 700;
            font-style: normal;
        }

        :root {
            --primary-orange: #FF6B35;
            --dark-orange: #E85A2A;
            --glass-bg: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Gotham', sans-serif;
        }

        body {
            background: #ffffff;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles - REMOVED */
        /* header {
            background: linear-gradient(to bottom, var(--primary-orange), var(--dark-orange));
            height: 10vh;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            z-index: 10;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .header-title {
            color: #fff;
            font-size: 2.8rem;
            font-weight: 700;
            text-transform: capitalize;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        } */

        /* Middle Content (Player) */
        main {
            flex: 1;
            position: relative;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        #player-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #player-container img, #player-container video {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Biar full screen */
            transition: opacity 0.8s ease-in-out;
        }

        .fade-out {
            opacity: 0;
        }

        /* Footer Styles - REMOVED */
        /* footer {
            background: linear-gradient(to top, var(--primary-orange), var(--dark-orange));
            height: 13vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 60px;
            border-top-left-radius: 70px;
            border-top-right-radius: 70px;
            z-index: 10;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.2);
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            transition: transform 0.5s ease-in-out;
        }

        footer.hidden {
            transform: translateY(100%);
        }

        .logo-container h1 {
            font-size: 2.5rem;
            font-style: italic;
            letter-spacing: -1px;
        }

        .time-badge {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(15px);
            padding: 12px 40px;
            border-radius: 100px;
            color: #fff;
            font-size: 1.6rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1), inset 0 0 10px rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
        } */

        .menu-button {
            background: var(--primary-orange);
            border: none;
            cursor: pointer;
            padding: 15px;
            border-radius: 50%;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            transition: opacity 0.5s ease-in-out, transform 0.3s;
            box-shadow: 0px 0px 4px 1px rgba(0, 0, 0, 0.3);
            opacity: 0; /* Hidden by default */
        }

        .menu-button.visible {
            opacity: 1;
        }

        .menu-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(0,0,0,0.4);
        }

        .menu-button span {
            display: block;
            width: 35px;
            height: 4px;
            background-color: #fff;
            margin: 6px 0;
            border-radius: 2px;
            transition: 0.3s;
        }

        /* Selection Modal */
        #outlet-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            display: none;
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: #fff;
            width: 90%;
            max-width: 500px;
            border-radius: 30px;
            padding: 30px;
            text-align: center;
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: var(--primary-orange);
        }

        .outlet-list {
            list-style: none;
            margin-top: 20px;
        }

        .outlet-item {
            padding: 15px;
            border-radius: 15px;
            background: #f8f8f8;
            margin-bottom: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }

        .outlet-item:hover {
            background: var(--primary-orange);
            color: #fff;
        }

        .empty-state {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>

    <!-- <header>
        <div class="header-title" id="display-outlet-name">
            {{ $currentOutlet ? $currentOutlet->nama_outlet : 'Pilih Outlet' }}
        </div>
    </header> -->

    <main>
        <div id="player-container">
            @if(count($playlist) > 0)
                <div class="loading">Memuat Media...</div>
            @else
                <div class="empty-state">Silakan pilih outlet melalui tombol menu di bawah</div>
            @endif
        </div>
    </main>

    <!-- <footer id="footer">
        <div class="logo-container"> -->
            <!-- Gunakan logo default jika tidak ada file logo spesifik -->
            <!-- <h1 style="color: white; font-weight: 700;">Jalan Rasa</h1>
        </div> -->

        <!-- <div class="time-badge" id="live-clock">
            {{ now()->format('d/m/Y H:i') }} WIB
        </div>
    </footer> -->

    <!-- Floating Menu Button -->
    <button class="menu-button" onclick="toggleModal()">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Modal Pilihan Outlet -->
    <div id="outlet-modal">
        <div class="modal-content">
            <h2>Pilih Outlet</h2>
            <ul class="outlet-list">
                @foreach($outlets as $outlet)
                    <li class="outlet-item" onclick="selectOutlet({{ $outlet->id }})">
                        {{ $outlet->nama_outlet }} ({{ $outlet->kode_outlet }})
                    </li>
                @endforeach
            </ul>
            <button onclick="toggleModal()" style="margin-top: 20px; border: none; background: none; color: #666; cursor: pointer;">Tutup</button>
        </div>
    </div>

    <script>
        let playlist = @json($playlist);
        let jedaDefault = {{ $jeda }};
        let currentIndex = 0;
        let timer = null;
        let hideMenuTimeout = null;
        let currentMediaName = '-';
        let gabunganId = {{ $currentOutlet && $currentOutlet->gabungan ? $currentOutlet->gabungan->id : 'null' }};
        let outletId = {{ $currentOutlet ? $currentOutlet->id : 'null' }};

        // Heartbeat / Ping logic
        function sendPing() {
            if (!outletId) return;
            
            // Collect media list
            const mediaList = playlist.map(m => m.nama);

            fetch(`/api/ping/${outletId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    gabungan_id: gabunganId,
                    active_media_name: currentMediaName,
                    media_list: mediaList
                })
            }).catch(e => console.error('Ping failed:', e));
        }

        // Start heartbeat every 60 seconds
        if (outletId) {
            setInterval(sendPing, 60000);
            sendPing(); // Initial ping
        }

        const menuBtn = document.querySelector('.menu-button');

        // Auto-hide menu button after 3 seconds of inactivity
        function resetMenuTimer() {
            menuBtn.classList.add('visible');
            if (hideMenuTimeout) clearTimeout(hideMenuTimeout);
            hideMenuTimeout = setTimeout(() => {
                menuBtn.classList.remove('visible');
            }, 3000);
        }

        // Show menu button on interaction
        document.addEventListener('mousemove', resetMenuTimer);
        document.addEventListener('mousedown', resetMenuTimer);
        document.addEventListener('touchstart', resetMenuTimer);
        
        // Initial timer
        resetMenuTimer();

        /* Clock update function - REMOVED since no clock display */
        /* function updateClock() {
            const now = new Date();
            const date = now.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
            const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
            document.getElementById('live-clock').innerText = `${date} ${time} WIB`;
        }

        setInterval(updateClock, 1000); */

        function toggleModal() {
            const modal = document.getElementById('outlet-modal');
            modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
        }

        function selectOutlet(id) {
            // Send POST request to store outlet in session
            fetch('/select-outlet', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ outlet_id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/';
                }
            })
            .catch(error => console.error('Error selecting outlet:', error));
        }

        function playNext() {
            if (playlist.length === 0) {
                console.log('Playlist kosong.');
                return;
            }

            const container = document.getElementById('player-container');
            const media = playlist[currentIndex];
            console.log('Pre-loading media:', media.nama);
            
            currentIndex = (currentIndex + 1) % playlist.length;
            if (timer) clearTimeout(timer);

            let element;
            let isReady = false;

            const handleReady = () => {
                if (isReady) return;
                isReady = true;

                // Add fade-out to old elements
                const oldElements = container.querySelectorAll('img, video, .loading, .empty-state');
                oldElements.forEach(el => el.classList.add('fade-out'));

                setTimeout(() => {
                    // Remove old elements and show new one
                    container.innerHTML = '';
                    element.classList.remove('fade-out');
                    container.appendChild(element);
                    
                    currentMediaName = media.nama;

                    // Start duration timer/ended listener
                    if (media.tipe_media === 'video') {
                        element.play().catch(e => console.error('Auto-play failed:', e));
                    }
                }, 500);
            };

            if (media.tipe_media === 'video') {
                element = document.createElement('video');
                element.src = media.file_url;
                element.muted = true;
                element.playsInline = true;
                element.style.width = '100%';
                element.style.height = '100%';
                element.style.objectFit = 'cover';
                element.classList.add('fade-out'); // Start hidden

                element.oncanplaythrough = handleReady;
                element.onended = () => {
                    console.log('Video selesai, lanjut...');
                    playNext();
                };

                element.onerror = () => {
                    console.error('Gagal memuat video:', media.file_url);
                    playNext();
                };

                let durasiMs = (media.durasi || 60) * 1000;
                timer = setTimeout(playNext, durasiMs);
            } else {
                element = document.createElement('img');
                element.src = media.file_url;
                element.style.width = '100%';
                element.style.height = '100%';
                element.style.objectFit = 'cover';
                element.classList.add('fade-out'); // Start hidden

                element.onload = handleReady;
                element.onerror = () => {
                    console.error('Gagal memuat gambar:', media.file_url);
                    playNext();
                };

                timer = setTimeout(playNext, (media.durasi || jedaDefault) * 1000);
            }
        }

        // Mulai jika ada playlist
        if (playlist.length > 0) {
            playNext();
        }

        // Background Sync: Cek pembaruan data setiap 30 detik (untuk testing, bisa dinaikkan nanti)
        @if($currentOutlet)
        setInterval(() => {
            fetch(`/api/playlist/{{ $currentOutlet->id }}`)
                .then(res => res.json())
                .then(data => {
                    if (data.playlist && data.playlist.length > 0) {
                        // Cek apakah ada perubahan (sederhana: cek panjang atau id pertama)
                        if (JSON.stringify(data.playlist) !== JSON.stringify(playlist)) {
                            console.log('Playlist diperbarui dari server.');
                            playlist = data.playlist;
                            jedaDefault = data.jeda;
                            // Jika playlist sebelumnya kosong, mulai putar
                            if (!timer && playlist.length > 0) playNext();
                        }
                    }
                })
                .catch(err => console.error('Gagal sinkronisasi data:', err));
        }, 30000);
        @endif
    </script>
</body>
</html>
