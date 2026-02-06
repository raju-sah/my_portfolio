<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>💕 Valentine's Week - Send Love</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #1a1a2e;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="valentine-page" id="valentinePage">
        <!-- Floating Hearts Background -->
        <div class="floating-elements" id="floatingElements"></div>

        <!-- Main Content -->
        <div class="valentine-container">
            <!-- Hero Section -->
            <div class="valentine-hero">
                <h1 class="valentine-title">
                    <span class="heart-beat">💕</span> Valentine's Week
                </h1>
                <p class="valentine-subtitle">Share your love with someone special</p>

                <!-- Countdown Timer -->
                <div class="countdown-container" id="countdown">
                    <div class="countdown-item">
                        <span class="countdown-value" id="days">00</span>
                        <span class="countdown-label">Days</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-value" id="hours">00</span>
                        <span class="countdown-label">Hours</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-value" id="minutes">00</span>
                        <span class="countdown-label">Minutes</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-value" id="seconds">00</span>
                        <span class="countdown-label">Seconds</span>
                    </div>
                </div>
                <p class="countdown-text">until Valentine's Day ❤️</p>
            </div>

            <!-- Day Cards -->
            <div class="day-cards-grid">
                @foreach($dayConfig as $key => $day)
                <div class="day-card {{ $day['is_active'] ? 'active' : 'inactive' }} {{ $day['is_today'] ? 'today' : '' }}"
                    data-day="{{ $key }}"
                    data-theme="{{ $day['theme'] }}"
                    onclick="{{ $day['is_active'] ? 'openModal(\'' . $key . '\')' : '' }}">
                    <div class="day-card-inner">
                        <span class="day-emoji">{{ $day['emoji'] }}</span>
                        <h3 class="day-name">{{ $day['name'] }}</h3>
                        <p class="day-date">Feb {{ substr($day['date'], 3) }}</p>
                        @if($day['is_today'])
                        <span class="today-badge">TODAY!</span>
                        @elseif(!$day['is_active'])
                        <span class="locked-icon">🔒</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tracker Section -->
            <div class="tracker-section">
                <button class="tracker-btn" onclick="openTracker()">
                    📊 View My Links
                </button>
            </div>
        </div>

        <!-- Create Modal -->
        <div class="modal-overlay" id="createModal">
            <div class="modal-content">
                <button class="modal-close" onclick="closeModal()">&times;</button>
                <div class="modal-header">
                    <span class="modal-emoji" id="modalEmoji">🌹</span>
                    <h2 class="modal-title" id="modalTitle">Send a Rose</h2>
                </div>
                <form id="valentineForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="day_type" id="dayType" value="">

                    <div class="form-group">
                        <label for="sender_name">Your Name 💝</label>
                        <input type="text" name="sender_name" id="sender_name" required
                            placeholder="Enter your lovely name" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message 💌</label>
                        <textarea name="message" id="message" required
                            placeholder="Write something from your heart..." maxlength="1000" rows="4"></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        💝 Send Love
                    </button>
                </form>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal-overlay" id="successModal">
            <div class="modal-content success-modal">
                <button class="modal-close" onclick="closeSuccessModal()">&times;</button>
                <div class="success-icon">🎉</div>
                <h2>Love Sent Successfully!</h2>
                <p>Share this magical link with your special someone</p>

                <div class="share-link-container">
                    <input type="text" id="shareUrl" readonly class="share-url-input">
                    <button class="copy-btn" onclick="copyLink()">📋 Copy</button>
                </div>

                <div class="qr-container" id="qrContainer">
                    <canvas id="qrCode"></canvas>
                </div>

                <div class="action-buttons">
                    <a href="#" id="previewLink" target="_blank" class="action-btn preview-btn">
                        👁️ Preview
                    </a>
                    <button class="action-btn download-btn" onclick="downloadQr()">
                        📥 Download QR
                    </button>
                    <button class="action-btn share-btn" onclick="shareLink()">📤 Share</button>
                </div>
            </div>
        </div>

        <!-- Tracker Modal -->
        <div class="modal-overlay" id="trackerModal">
            <div class="modal-content tracker-modal">
                <button class="modal-close" onclick="closeTrackerModal()">&times;</button>
                <h2>📊 My Valentine Links</h2>
                <button class="refresh-btn" onclick="loadTrackerData()">🔄 Refresh</button>

                <div class="tracker-table-container">
                    <table class="tracker-table">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Opens</th>
                                <th>Likes</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="trackerBody">
                            <!-- Dynamic content -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --valentine-primary: #ff4d6d;
            --valentine-secondary: #ff758f;
            --valentine-dark: #1a1a2e;
            --valentine-light: #fff;
            --valentine-gold: #ffd700;
        }

        .valentine-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        /* Floating Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .floating-item {
            position: absolute;
            font-size: 2rem;
            animation: float 15s infinite ease-in-out;
            opacity: 0.6;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Valentine Container */
        .valentine-container {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Hero Section */
        .valentine-hero {
            text-align: center;
            padding: 3rem 0;
        }

        .valentine-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ff4d6d, #ff758f, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(255, 77, 109, 0.3);
        }

        .heart-beat {
            display: inline-block;
            animation: heartbeat 1.5s infinite;
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .valentine-subtitle {
            font-size: 1.3rem;
            color: #ff758f;
            margin-bottom: 2rem;
        }

        /* Countdown */
        .countdown-container {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .countdown-item {
            background: rgba(255, 77, 109, 0.2);
            border: 2px solid rgba(255, 77, 109, 0.4);
            border-radius: 15px;
            padding: 1.5rem 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .countdown-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ff4d6d;
            display: block;
        }

        .countdown-label {
            font-size: 0.9rem;
            color: #ff758f;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .countdown-text {
            color: #ccc;
            margin-top: 1rem;
        }

        /* Day Cards Grid */
        .day-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
            padding: 2rem 0;
        }

        .day-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .day-card.active {
            border-color: rgba(255, 77, 109, 0.5);
            background: rgba(255, 77, 109, 0.1);
        }

        .day-card.active:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(255, 77, 109, 0.3);
            border-color: #ff4d6d;
        }

        .day-card.today {
            border-color: #ffd700;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 77, 109, 0.2));
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.4);
            }

            50% {
                box-shadow: 0 0 0 15px rgba(255, 215, 0, 0);
            }
        }

        .day-card.inactive {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .day-emoji {
            font-size: 3rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .day-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.3rem;
        }

        .day-date {
            font-size: 0.9rem;
            color: #aaa;
        }

        .today-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #ffd700, #ff8c00);
            color: #000;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            animation: badge-bounce 1s infinite;
        }

        @keyframes badge-bounce {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .locked-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.2rem;
            opacity: 0.7;
        }

        /* Tracker Button */
        .tracker-section {
            text-align: center;
            padding: 2rem 0;
        }

        .tracker-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tracker-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 1rem;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border: 2px solid rgba(255, 77, 109, 0.3);
            border-radius: 25px;
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: modalSlide 0.4s ease;
        }

        @keyframes modalSlide {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 77, 109, 0.2);
            border: none;
            color: #ff4d6d;
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: #ff4d6d;
            color: #fff;
        }

        .modal-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .modal-emoji {
            font-size: 4rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .modal-title {
            font-size: 1.8rem;
            color: #ff4d6d;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #ff758f;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 77, 109, 0.3);
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff4d6d;
            box-shadow: 0 0 15px rgba(255, 77, 109, 0.3);
        }

        .submit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(255, 77, 109, 0.4);
        }

        .submit-btn {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #ff4d6d, #ff758f);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(255, 77, 109, 0.4);
        }

        /* Success Modal */
        .success-modal {
            text-align: center;
        }

        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .success-modal h2 {
            color: #ff4d6d;
            margin-bottom: 0.5rem;
        }

        .success-modal p {
            color: #aaa;
            margin-bottom: 1.5rem;
        }

        .share-link-container {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .share-url-input {
            flex: 1;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 77, 109, 0.3);
            border-radius: 8px;
            color: #fff;
            font-size: 0.9rem;
        }

        .copy-btn {
            padding: 0.8rem 1rem;
            background: #ff4d6d;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            background: #ff758f;
        }

        .qr-container {
            background: #fff;
            padding: 1rem;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        #qrCode {
            display: block;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .action-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .preview-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }

        .share-btn {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: #fff;
        }

        .download-btn {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }

        .action-btn:hover {
            transform: scale(1.05);
        }

        /* Tracker Modal */
        .tracker-modal {
            max-width: 900px;
        }

        .tracker-modal h2 {
            color: #ff4d6d;
            margin-bottom: 1rem;
        }

        .refresh-btn {
            background: rgba(255, 77, 109, 0.2);
            color: #ff4d6d;
            border: 1px solid rgba(255, 77, 109, 0.4);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background: #ff4d6d;
            color: #fff;
        }

        .tracker-table-container {
            overflow-x: auto;
        }

        .tracker-table {
            width: 100%;
            border-collapse: collapse;
        }

        .tracker-table th,
        .tracker-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tracker-table th {
            color: #ff758f;
            font-weight: 600;
        }

        .tracker-table td {
            color: #ddd;
        }

        .status-badge {
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background: #ffd700;
            color: #000;
        }

        .status-accepted {
            background: #38ef7d;
            color: #000;
        }

        .status-rejected {
            background: #ff4d6d;
            color: #fff;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .valentine-title {
                font-size: 2rem;
            }

            .countdown-container {
                gap: 0.8rem;
            }

            .countdown-item {
                padding: 1rem;
            }

            .countdown-value {
                font-size: 1.5rem;
            }

            .day-cards-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .day-card {
                padding: 1.5rem 0.5rem;
            }

            .day-emoji {
                font-size: 2rem;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .tracker-modal {
                max-width: 100%;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
    <script>
        const dayConfig = @json($dayConfig);
        const valentineDate = new Date('{{ $valentineDate }}').getTime();

        // Floating elements
        const floatingEmojis = ['❤️', '💕', '💖', '💝', '💘', '🌹', '🍫', '🧸', '💋', '🤗', '💍'];

        function createFloatingElement() {
            const container = document.getElementById('floatingElements');
            const emoji = document.createElement('div');
            emoji.className = 'floating-item';
            emoji.textContent = floatingEmojis[Math.floor(Math.random() * floatingEmojis.length)];
            emoji.style.left = Math.random() * 100 + '%';
            emoji.style.fontSize = (Math.random() * 2 + 1) + 'rem';
            emoji.style.animationDuration = (Math.random() * 10 + 10) + 's';
            emoji.style.animationDelay = Math.random() * 5 + 's';
            container.appendChild(emoji);

            setTimeout(() => emoji.remove(), 25000);
        }

        // Create initial floating elements
        for (let i = 0; i < 20; i++) {
            setTimeout(createFloatingElement, i * 500);
        }
        setInterval(createFloatingElement, 1500);

        // Countdown Timer
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = valentineDate - now;

            if (distance < 0) {
                document.getElementById('countdown').innerHTML = '<h2 style="color: #ff4d6d;">Happy Valentine\'s Day! 💕</h2>';
                return;
            }

            document.getElementById('days').textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById('hours').textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById('minutes').textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById('seconds').textContent = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Modal Functions
        function openModal(dayType) {
            const modal = document.getElementById('createModal');
            const day = dayConfig[dayType];

            document.getElementById('modalEmoji').textContent = day.emoji;
            document.getElementById('modalTitle').textContent = 'Send ' + day.name.replace(' Day', '');
            document.getElementById('dayType').value = dayType;

            modal.classList.add('active');
        }

        function closeModal() {
            document.getElementById('createModal').classList.remove('active');
            document.getElementById('valentineForm').reset();
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('active');
        }

        function openTracker() {
            document.getElementById('trackerModal').classList.add('active');
            loadTrackerData();
        }

        function closeTrackerModal() {
            document.getElementById('trackerModal').classList.remove('active');
        }



        // Form Submit
        document.getElementById('valentineForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = document.querySelector('.submit-btn');
            submitBtn.disabled = true;
            submitBtn.textContent = '💕 Sending Love...';

            try {
                const response = await fetch('{{ route("valentine.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    closeModal();
                    showSuccess(data.share_url, data.uuid);
                } else {
                    alert('Something went wrong. Please try again.');
                }
            } catch (error) {
                console.error(error);
                alert('Error sending love. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = '💝 Send Love';
            }
        });

        // Show Success
        function showSuccess(shareUrl, uuid) {
            document.getElementById('shareUrl').value = shareUrl;
            document.getElementById('previewLink').href = shareUrl;

            // Generate QR Code
            const canvas = document.getElementById('qrCode');
            QRCode.toCanvas(canvas, shareUrl, {
                width: 200,
                margin: 2
            }, function(error) {
                if (error) console.error(error);
            });

            document.getElementById('successModal').classList.add('active');
        }

        // Copy Link
        function copyLink() {
            const input = document.getElementById('shareUrl');
            input.select();
            document.execCommand('copy');

            const btn = document.querySelector('.copy-btn');
            btn.textContent = '✅ Copied!';
            setTimeout(() => btn.textContent = '📋 Copy', 2000);
        }

        // Share Link
        async function shareLink() {
            const url = document.getElementById('shareUrl').value;

            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Valentine\'s Day Love',
                        text: 'Someone sent you love! 💕',
                        url: url
                    });
                } catch (err) {
                    console.log('Share cancelled');
                }
            } else {
                copyLink();
            }
        }

        // Download QR Code
        function downloadQr() {
            const canvas = document.getElementById('qrCode');
            const link = document.createElement('a');
            link.download = 'valentine_qr.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        // Load Tracker Data
        async function loadTrackerData() {
            try {
                const response = await fetch('{{ route("valentine.tracker") }}');
                const data = await response.json();

                const tbody = document.getElementById('trackerBody');
                tbody.innerHTML = '';

                if (data.submissions.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; color: #888;">No submissions yet. Start spreading love! 💕</td></tr>';
                    return;
                }

                data.submissions.forEach(s => {
                    const dayInfo = dayConfig[s.day_type] || {
                        emoji: '❤️',
                        name: s.day_type
                    };
                    tbody.innerHTML += `
                <tr>
                    <td>${dayInfo.emoji} ${dayInfo.name}</td>
                    <td>${s.sender_name}</td>
                    <td><span class="status-badge status-${s.status}">${s.status}</span></td>
                    <td>${s.open_count}</td>
                    <td>${s.likes_count}</td>
                    <td>${s.created_at}</td>
                    <td>
                        <button onclick="window.open('${s.share_url}', '_blank')" style="background: none; border: none; cursor: pointer; font-size: 1.2rem;">👁️</button>
                        <button onclick="navigator.clipboard.writeText('${s.share_url}')" style="background: none; border: none; cursor: pointer; font-size: 1.2rem;">📋</button>
                    </td>
                </tr>
            `;
                });
            } catch (error) {
                console.error(error);
            }
        }
    </script>
</body>

</html>