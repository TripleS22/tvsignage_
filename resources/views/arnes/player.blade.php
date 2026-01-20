<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arnes Signage Player</title>
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
        @font-face {
            font-family: 'Gotham';
            src: url('/font/font_gotham/GOTHAM-BLACK.OTF') format('opentype');
            font-weight: 800;
            font-style: normal;
        }

        :root {
            --primary-orange: #E8662A;
            --dark-orange: #D55A20;
            --glass-bg: rgba(255, 255, 255, 0.2);
            --status-ontime: #22c55e;
            --status-delay: #ef4444;
            --status-departed: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Gotham', sans-serif;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            background: #ffffff;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        header {
            background: var(--primary-orange);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            flex-shrink: 0;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-title {
            flex: 1;
            text-align: center;
            color: #fff;
            font-size: 4.5rem; /* Enlarged Nama Outlet */
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .header-date {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: right;
            white-space: nowrap;
        }

        .change-btn {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s, background 0.2s;
            opacity: 0; /* Hidden by default */
        }

        header:hover .change-btn {
            opacity: 1; /* Show on hover */
        }

        .change-btn:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        /* Main Content */
        main {
            flex: 1;
            position: relative;
            background: #fff;
            display: flex;
            overflow: hidden;
        }

        /* View Container - for switching between schedule and ads */
        .view-container {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .view-panel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 0.5s ease-in-out;
        }

        .view-panel.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Schedule View */
        #schedule-view {
            background: #f8f9fa;
            padding: 0; /* Removed excessive margins */
            display: flex;
            flex-direction: column;
        }

        .schedule-table-container {
            flex: 1;
            overflow: hidden;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.25rem;
        }

        .schedule-table thead {
            background: var(--primary-orange);
            color: white;
        }

        .schedule-table th {
            padding: 20px 12px;
            text-align: left;
            font-weight: 700;
            font-size: 1.4rem;
            text-transform: uppercase;
        }

        .schedule-table th:first-child,
        .schedule-table th:last-child {
            text-align: center;
        }

        .schedule-table tbody tr {
            background: white;
            border-bottom: 2px solid #f0f0f0;
            transition: background 0.2s;
        }

        .schedule-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .schedule-table td {
            padding: 22px 12px;
            font-size: 1.4rem;
            vertical-align: middle;
        }

        .schedule-table td:first-child {
            text-align: center;
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--primary-orange);
        }

        .schedule-table td:last-child {
            text-align: center;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-badge.ON-TIME {
            background: var(--status-ontime);
            color: white;
        }

        .status-badge.DELAY,
        .status-badge.TERLAMBAT {
            background: var(--status-delay);
            color: white;
        }

        .status-badge.DEPARTED,
        .status-badge.BERANGKAT {
            background: var(--status-departed);
            color: white;
        }

        .status-badge.EMPTY {
            background: #9ca3af;
            color: white;
        }

        .empty-schedule-row {
            text-align: center;
            color: #666;
            font-style: italic;
            font-size: 1.5rem;
            height: 200px;
        }

        /* Player View - Full Screen Pop Up */
        #player-view {
            position: fixed; /* Fixed to cover whole screen */
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            transform: scale(1);
            transition: opacity 0.4s ease-in-out, transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        #player-view.hidden {
            opacity: 0;
            transform: scale(0.85); /* Popup effect */
            pointer-events: none;
        }

        #player-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #player-container img,
        #player-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.8s ease-in-out;
        }

        .fade-out {
            opacity: 0;
        }

        .empty-state {
            color: #666;
            font-style: italic;
            font-size: 1.2rem;
        }

        .loading {
            color: #666;
            font-size: 1.2rem;
        }

        /* Footer Styles */
        footer {
            background: var(--primary-orange);
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            flex-shrink: 0;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-arnes-img {
            height: 45px;
            width: auto;
            object-fit: contain;
        }

        .time-display {
            color: #fff;
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 2px;
        }

        /* Modal Styles */
        #outlet-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            display: none;
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: #fff;
            width: 90%;
            max-width: 500px;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: var(--primary-orange);
            font-size: 1.5rem;
        }

        .outlet-list {
            list-style: none;
            margin-top: 20px;
        }

        .outlet-item {
            padding: 15px;
            border-radius: 12px;
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

        .close-btn {
            margin-top: 20px;
            border: none;
            background: none;
            color: #666;
            cursor: pointer;
            font-size: 1rem;
        }

        .close-btn:hover {
            color: var(--primary-orange);
        }

        /* View indicator */
        .view-indicator {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }

        .view-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ccc;
            transition: background 0.3s;
        }

        .view-dot.active {
            background: var(--primary-orange);
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <button class="change-btn" onclick="toggleModal()">Ganti</button>
        </div>
        <div class="header-title" id="display-outlet-name">
            {{ $currentOutlet ? $currentOutlet->nama_outlet : 'Pilih Outlet' }}
        </div>
        <div class="header-date" id="display-date">
            <!-- Will be set by JavaScript -->
        </div>
    </header>

    <main>
        <div class="view-container">
            <!-- Schedule View -->
            <div id="schedule-view" class="view-panel">
                <div class="schedule-table-container">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th style="width: 15%">JAM</th>
                                <th style="width: 25%">TUJUAN</th>
                                <th style="width: 25%">NAMA DRIVER</th>
                                <th style="width: 20%">NAMA KENDARAAN</th>
                                <th style="width: 15%">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="schedule-body">
                            <!-- Schedule rows will be inserted here -->
                        </tbody>
                    </table>
                    <div id="empty-schedule" class="empty-schedule" style="display: none;">
                        Tidak ada jadwal tersedia
                    </div>
                </div>
            </div>

            <!-- Player View (Ads) - Full Screen Pop Up -->
            <div id="player-view" class="hidden">
                <div id="player-container">
                    @if(count($playlist) > 0)
                        <div class="loading">Memuat Media...</div>
                    @else
                        <div class="empty-state">Tidak ada media tersedia</div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="logo-container">
            <img src="/img/logo arnes signage.png" alt="Arnes Logo" class="logo-arnes-img">
        </div>
        <div class="time-display" id="live-clock">
            00:00
        </div>
    </footer>

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
            <button class="close-btn" onclick="toggleModal()">Tutup</button>
        </div>
    </div>

    <script>
        // Configuration
        const SCHEDULE_DISPLAY_DURATION = 15000; // 15 seconds for schedule
        const ADS_DISPLAY_DURATION = 10000; // 10 seconds for ads (or video duration)
        const SCHEDULE_REFRESH_INTERVAL = 30000; // Refresh schedule every 30 seconds

        // State
        let playlist = @json($playlist);
        let jedaDefault = {{ $jeda }};
        let currentIndex = 0;
        let timer = null;
        let scheduleData = [];
        let currentView = 'schedule'; // 'schedule' or 'player'
        let viewRotationTimer = null;

        // Outlet info
        const currentOutlet = @json($currentOutlet);
        const kodeOutlet = currentOutlet ? currentOutlet.kode_outlet : null;

        // Format Indonesian date
        function formatIndonesianDate() {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const now = new Date();
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            
            return `${dayName}, ${date} ${month} ${year}`;
        }

        // Update date display
        function updateDate() {
            document.getElementById('display-date').textContent = formatIndonesianDate();
        }

        // Update clock display
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('live-clock').textContent = `${hours}:${minutes}`;
        }

        // Check if time is delayed (past current time)
        function isTimeDelayed(etdTime) {
            if (!etdTime) return false;
            
            const now = new Date();
            const [hours, minutes] = etdTime.split(':').map(Number);
            const etdDate = new Date();
            etdDate.setHours(hours, minutes, 0, 0);
            
            return now > etdDate;
        }

        // Resolve status based on status string and ETD time
        function resolveStatus(status, etdTime) {
            const normalizedStatus = (status || '').toUpperCase();
            const delayed = etdTime ? isTimeDelayed(etdTime) : false;

            if (!normalizedStatus) {
                return { label: '-', className: 'EMPTY' };
            }

            if (normalizedStatus.includes('DELAY')) {
                return { label: 'TERLAMBAT', className: 'DELAY' };
            }

            if (normalizedStatus.includes('DEPARTED')) {
                return delayed
                    ? { label: 'BERANGKAT', className: 'DEPARTED' }
                    : { label: 'ON TIME', className: 'ON-TIME' };
            }

            if (delayed) {
                return { label: 'TERLAMBAT', className: 'DELAY' };
            }

            return { label: 'ON TIME', className: 'ON-TIME' };
        }

        // Fetch schedule data from API
        async function fetchSchedule() {
            if (!kodeOutlet) {
                console.log('No outlet selected');
                return;
            }

            try {
                const response = await fetch(`/api/arnes/schedule/${kodeOutlet}`);
                const data = await response.json();
                
                if (data.success && data.schedules) {
                    scheduleData = data.schedules;
                    renderScheduleTable();
                } else {
                    console.error('Failed to fetch schedule:', data.message);
                    scheduleData = [];
                    renderScheduleTable();
                }
            } catch (error) {
                console.error('Error fetching schedule:', error);
                scheduleData = [];
                renderScheduleTable();
            }
        }

        // Render schedule table
        function renderScheduleTable() {
            const tbody = document.getElementById('schedule-body');
            const table = document.querySelector('.schedule-table');

            // Table is always visible now
            table.style.display = 'table';

            if (scheduleData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="empty-schedule-row">
                            Tidak ada jadwal tersedia
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = scheduleData.map(item => {
                const statusInfo = resolveStatus(item.status, item.etd_time);
                return `
                    <tr>
                        <td>${item.jam || '-'}</td>
                        <td>${item.tujuan || '-'}</td>
                        <td>${item.nama_driver || '-'}</td>
                        <td>${item.nama_kendaraan || '-'}</td>
                        <td>
                            <span class="status-badge ${statusInfo.className}">
                                ${statusInfo.label}
                            </span>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Switch between schedule and player view
        function switchView(view) {
            const playerView = document.getElementById('player-view');

            if (view === 'schedule') {
                playerView.classList.add('hidden');
                currentView = 'schedule';
            } else {
                playerView.classList.remove('hidden');
                currentView = 'player';
            }
        }

        // Start view rotation
        function startViewRotation() {
            // If no playlist, always show schedule
            if (playlist.length === 0) {
                switchView('schedule');
                return;
            }

            function rotate() {
                if (currentView === 'schedule') {
                    // Switch to player - but only when ready
                    playNext(() => {
                        switchView('player');
                    });
                } else {
                    // Switch to schedule
                    switchView('schedule');
                    viewRotationTimer = setTimeout(rotate, SCHEDULE_DISPLAY_DURATION);
                }
            }

            // Start with schedule view
            switchView('schedule');
            viewRotationTimer = setTimeout(rotate, SCHEDULE_DISPLAY_DURATION);
        }

        // Toggle modal
        function toggleModal() {
            const modal = document.getElementById('outlet-modal');
            modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
        }

        // Select outlet
        function selectOutlet(id) {
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
                    window.location.href = '/arnes/' + id;
                }
            })
            .catch(error => console.error('Error selecting outlet:', error));
        }

        let currentMediaName = '-';
        let gabunganId = {{ $currentOutlet && $currentOutlet->gabungan ? $currentOutlet->gabungan->id : 'null' }};
        let outletId = {{ $currentOutlet ? $currentOutlet->id : 'null' }};

        // Heartbeat / Ping logic
        function sendPing() {
            if (!outletId) return;
            
            // Collect media list
            const mediaList = playlist.map(m => m.nama);
            
            // Collect schedule summary (top 10)
            const scheduleSummary = scheduleData.slice(0, 10).map(s => ({
                jam: s.jam,
                tujuan: s.tujuan,
                status: s.status
            }));

            fetch(`/api/ping/${outletId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    gabungan_id: gabunganId,
                    active_media_name: currentMediaName,
                    media_list: mediaList,
                    schedule_summary: scheduleSummary
                })
            }).catch(e => console.error('Ping failed:', e));
        }

        // Start heartbeat every 60 seconds
        if (outletId) {
            setInterval(sendPing, 60000);
            sendPing(); // Initial ping
        }

        // Play next media
        function playNext(callbackWhenReady) {
            if (playlist.length === 0) {
                console.log('Playlist kosong.');
                if (currentView === 'player') {
                    switchView('schedule');
                    viewRotationTimer = setTimeout(() => startViewRotation(), SCHEDULE_DISPLAY_DURATION);
                }
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
                    
                    if (callbackWhenReady) callbackWhenReady();

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
                    console.log('Video selesai, switch to schedule...');
                    switchView('schedule');
                    viewRotationTimer = setTimeout(() => {
                        playNext(() => switchView('player'));
                    }, SCHEDULE_DISPLAY_DURATION);
                };

                element.onerror = () => {
                    console.error('Gagal memuat video:', media.file_url);
                    playNext(callbackWhenReady);
                };

                let durasiMs = (media.durasi || 60) * 1000;
                timer = setTimeout(() => {
                    switchView('schedule');
                    viewRotationTimer = setTimeout(() => {
                        playNext(() => switchView('player'));
                    }, SCHEDULE_DISPLAY_DURATION);
                }, durasiMs);
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
                    playNext(callbackWhenReady);
                };

                timer = setTimeout(() => {
                    switchView('schedule');
                    viewRotationTimer = setTimeout(() => {
                        playNext(() => switchView('player'));
                    }, SCHEDULE_DISPLAY_DURATION);
                }, (media.durasi || jedaDefault) * 1000);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            updateClock();
            setInterval(updateClock, 1000);
            setInterval(updateDate, 60000);

            // Fetch initial schedule
            if (kodeOutlet) {
                fetchSchedule();
                // Refresh schedule periodically
                setInterval(fetchSchedule, SCHEDULE_REFRESH_INTERVAL);
            }

            // Start view rotation
            startViewRotation();
        });

        // Background sync: Check for playlist updates every 30 seconds
        @if($currentOutlet)
        setInterval(() => {
            fetch(`/api/playlist/{{ $currentOutlet->id }}`)
                .then(res => res.json())
                .then(data => {
                    if (data.playlist && data.playlist.length > 0) {
                        if (JSON.stringify(data.playlist) !== JSON.stringify(playlist)) {
                            console.log('Playlist diperbarui dari server.');
                            playlist = data.playlist;
                            jedaDefault = data.jeda;
                        }
                    }
                })
                .catch(err => console.error('Gagal sinkronisasi data:', err));
        }, 30000);
        @endif
    </script>
</body>
</html>
