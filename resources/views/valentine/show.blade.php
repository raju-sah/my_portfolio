<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $dayConfig['emoji'] }} {{ $dayConfig['name'] }} - Valentine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
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
    <div class="valentine-receiver" id="receiverPage" style="--theme-color: {{ $dayConfig['bg_color'] }};">
        <!-- Floating Elements -->
        <div class="floating-elements" id="floatingElements"></div>

        <!-- Celebration Overlay (hidden by default) -->
        <div class="celebration-overlay" id="celebrationOverlay">
            <div class="confetti-container" id="confettiContainer"></div>
        </div>

        <div class="receiver-container">
            <!-- Card Display -->
            <div class="love-card">
                <div class="card-header">
                    <span class="day-emoji">{{ $dayConfig['emoji'] }}</span>
                    <h1 class="day-title">Happy {{ $dayConfig['name'] }}</h1>
                </div>

                <div class="card-content">
                    <p class="sender-name">From: <strong>{{ $submission->sender_name }}</strong></p>
                    <div class="message-box">
                        <p class="message">{{ $submission->message }}</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="card-stats">
                    <!-- <span class="stat-item">👁️ <span id="openCount">{{ $submission->open_count }}</span> views</span> -->
                    <span class="stat-item">❤️ <span id="likesCount">{{ $submission->likes_count }}</span> likes</span>
                </div>

                <!-- Action Buttons -->
                @if($submission->status === 'pending')
                @if($isValentineDay)
                <!-- Valentine Day Special: Yes/No Buttons -->
                <div class="valentine-special">
                    <p class="proposal-text">Will you be my Valentine? 💕</p>
                    <div class="yes-no-container">
                        <button class="yes-btn" onclick="acceptValentine()">
                            ❤️ YES!
                        </button>
                        <button class="no-btn" id="noBtn" onmouseover="evadeButton()" onclick="evadeButton()">
                            ❌ No
                        </button>
                    </div>
                    <div class="no-tooltip" id="noTooltip"></div>
                </div>
                @else
                <!-- Regular Day Buttons -->
                <div class="action-buttons">
                    <button class="action-btn like-btn" onclick="interact('like')">
                        ❤️ Like
                    </button>
                    <button class="action-btn accept-btn" onclick="interact('accept')">
                        ✅ Accept
                    </button>
                    <button class="action-btn reject-btn" onclick="interact('reject')">
                        ❌ Reject
                    </button>
                </div>
                @endif
                @else
                <!-- Already Responded -->
                <div class="response-status">
                    @if($submission->status === 'accepted')
                    <div class="accepted-status">
                        <span class="status-icon">💖</span>
                        <p>This love was accepted! 🎉</p>
                    </div>
                    @else
                    <div class="rejected-status">
                        <span class="status-icon">💔</span>
                        <p>This love was not accepted 😢</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Success Content (hidden by default) -->
            <div class="success-content" id="successContent" style="display: none;">
                <div class="success-heart">💖</div>
                <h2 id="sassyGreeting" class="sassy-heading"></h2>
                <p class="love-quote" id="loveQuote"></p>

                <div class="dates-card">
                    <div class="dating-ideas-container">
                        <h3 class="dating-ideas-title">💖 Dating Ideas</h3>
                        <div class="date-ideas-grid" id="dateIdeasGrid">
                            <!-- Ideas will be loaded here -->
                        </div>
                        <div class="show-more-container">
                            <button id="showMoreIdeas" class="show-more-btn" onclick="showMoreDateIdeas()">
                                Show More Ideas ✨
                            </button>
                        </div>
                    </div>
                </div>

                <p class="final-message">Wishing you both a magical {{ $dayConfig['name'] }}! 💕</p>
            </div>

        </div>
    </div>

    <style>
        :root {
            --theme-color: {{ $dayConfig['bg_color'] }};
        }

        .valentine-receiver {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--theme-color), #1a1a2e);
            position: relative;
            overflow: hidden;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
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
            opacity: 0.5;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.5;
            }

            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Celebration Overlay */
        .celebration-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 100;
            display: none;
        }

        .celebration-overlay.active {
            display: block;
        }

        .confetti-piece {
            position: absolute;
            font-size: 2rem;
            animation: confetti-fall 4s ease-out forwards;
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-50px) rotate(0deg) scale(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
                transform: translateY(0) rotate(0deg) scale(1);
            }

            100% {
                transform: translateY(100vh) rotate(720deg) scale(0.5);
                opacity: 0;
            }
        }

        /* Receiver Container */
        .receiver-container {
            position: relative;
            z-index: 10;
            max-width: 500px;
            width: 100%;
        }

        /* Love Card */
        .love-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dotted rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            border-bottom: 2px dotted var(--theme-color);
        }

        .card-header {
            margin-bottom: 1.5rem;
        }

        .day-emoji {
            font-size: 4rem;
            display: block;
            margin-bottom: 0.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .day-title {
            font-size: 2rem;
            background: linear-gradient(135deg, var(--theme-color), #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sender-name {
            color: #ff758f;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .message-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dotted rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .message {
            color: #fff;
            font-size: 1.2rem;
            line-height: 1.6;
            font-style: italic;
        }

        .card-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
            padding: 1rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-item {
            color: #aaa;
            font-size: 0.95rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .action-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .like-btn {
            background: linear-gradient(135deg, #ff4d6d, #ff758f);
            color: #fff;
        }

        .accept-btn {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: #fff;
        }

        .reject-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #aaa;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .action-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        /* Valentine Special Yes/No */
        .valentine-special {
            padding-top: 1rem;
        }

        .proposal-text {
            font-size: 1.5rem;
            color: #ff4d6d;
            margin-bottom: 1.5rem;
            animation: pulse 1.5s infinite;
        }

        .yes-no-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            position: relative;
            min-height: 60px;
        }

        .yes-btn,
        .no-btn {
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 700;
        }

        .yes-btn {
            background: linear-gradient(135deg, #ff4d6d, #ff758f);
            color: #fff;
            box-shadow: 0 5px 25px rgba(255, 77, 109, 0.4);
        }

        .yes-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 40px rgba(255, 77, 109, 0.6);
        }

        .no-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #aaa;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: absolute;
            transition: all 0.2s ease;
        }

        .no-tooltip {
            position: fixed;
            background: rgba(26, 26, 46, 0.95);
            color: #ff4d6d;
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            font-size: 0.9rem;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
            border: 1px solid rgba(255, 77, 109, 0.3);
            max-width: 250px;
            text-align: center;
        }

        .no-tooltip.visible {
            opacity: 1;
        }

        /* Response Status */
        .response-status {
            padding: 1.5rem;
        }

        .accepted-status,
        .rejected-status {
            padding: 1rem;
            border-radius: 15px;
        }

        .accepted-status {
            background: rgba(56, 239, 125, 0.2);
            border: 1px solid rgba(56, 239, 125, 0.4);
        }

        .rejected-status {
            background: rgba(255, 77, 109, 0.2);
            border: 1px solid rgba(255, 77, 109, 0.4);
        }

        .status-icon {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .accepted-status p {
            color: #38ef7d;
        }

        .rejected-status p {
            color: #ff758f;
        }

        /* Success Content */
        .success-content {
            text-align: center;
            padding: 2rem;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-heart {
            font-size: 5rem;
            animation: heartbeat 1s infinite;
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


        .sassy-heading {
            font-size: 2.8rem;
            font-weight: 900;
            background: linear-gradient(135deg, #ff00c1, #ff4d6d, #ffd700);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: -1px;
            display: inline-block;
        }

        /* Funky Animations Pool */
        .anim-float { animation: sassyFloat 3s infinite ease-in-out; }
        .anim-shake { animation: sassyShake 0.5s infinite ease-in-out; }
        .anim-bounce { animation: sassyBounce 1s infinite ease-in-out; }
        .anim-glow { animation: sassyGlow 2s infinite ease-in-out; }
        .anim-zoom { animation: sassyZoom 3s infinite ease-in-out; }

        @keyframes sassyFloat {
            0%, 100% { transform: rotate(-2deg) translateY(0); }
            50% { transform: rotate(1deg) translateY(-10px); }
        }

        @keyframes sassyShake {
            0% { transform: translateX(0) rotate(0); }
            25% { transform: translateX(-5px) rotate(-1deg); }
            75% { transform: translateX(5px) rotate(1deg); }
            100% { transform: translateX(0) rotate(0); }
        }

        @keyframes sassyBounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        @keyframes sassyGlow {
            0%, 100% { filter: drop-shadow(0 0 5px #ff00c1); }
            50% { filter: drop-shadow(0 0 20px #ffd700); }
        }

        @keyframes sassyZoom {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .love-quote {
            font-size: 1.3rem;
            color: #fff;
            font-style: italic;
            margin: 1.5rem 0;
            line-height: 1.6;
        }

        /* Dating Ideas Card */
        .dates-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dotted rgba(255, 215, 0, 0.4);
            border-radius: 25px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            margin: 2rem 0;
            animation: modalSlide 0.5s ease;
        }

        .dating-ideas-container {
            text-align: left;
        }

        .dating-ideas-title {
            color: #ffd700;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        }

        .date-ideas-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .date-idea-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dotted rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
            animation: fadeInScale 0.5s ease forwards;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .date-idea-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffd700;
        }


        .date-idea-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 215, 0, 0.08);
            border-color: rgba(255, 215, 0, 0.5);
        }

        .date-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .date-idea-card h3 {
            color: #ffd700;
            font-size: 1rem;
            margin: 0.5rem 0;
        }

        .date-idea-card p {
            font-size: 0.8rem;
            color: #ddd;
            margin: 0;
            line-height: 1.4;
        }

        .show-more-container {
            text-align: center;
            margin-top: 1rem;
        }

        .show-more-btn {
            background: transparent;
            border: 2px solid #ffd700;
            color: #ffd700;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .show-more-btn:hover {
            background: #ffd700;
            color: #1a1a2e;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
        }

        /* Heart Burst Animation */
        .heart-bubble {
            position: fixed;
            pointer-events: none;
            z-index: 10000;
            font-size: 1.5rem;
            animation: heartBurst 1s ease-out forwards;
        }

        @keyframes heartBurst {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
                opacity: 1;
            }
            100% {
                transform: translate(var(--tx), var(--ty)) scale(1.5) rotate(var(--rot));
                opacity: 0;
            }
        }

        .final-message {
            color: #ff758f;
            font-size: 1.1rem;
            margin-top: 1.5rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .valentine-receiver {
                padding: 1rem;
            }

            .love-card {
                padding: 1.5rem;
            }

            .day-emoji {
                font-size: 3rem;
            }

            .day-title {
                font-size: 1.5rem;
            }

            .message {
                font-size: 1rem;
            }

            .yes-no-container {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .no-btn {
                position: relative;
            }
        }
    </style>

    <script>
        const dayType = @json($submission->day_type);
        const isValentineDay = @json($isValentineDay);
        const submissionUuid = @json($submission->uuid);
        const metaData = @json($submission->meta_data ?? []);
        const dayEmoji = @json($dayConfig['emoji']);

        // Date Ideas Pool
        const dateIdeasPool = [
            { icon: '🎬', title: 'Movie Date', description: 'Cozy up with popcorn and a romantic movie' },
            { icon: '🧺', title: 'Picnic', description: 'Pack some snacks and enjoy nature together' },
            { icon: '🍽', title: 'Candle Dinner', description: 'A romantic dinner with candles and soft music' },
            { icon: '☕', title: 'Coffee Date', description: 'A cozy café with your favorite drinks' },
            { icon: '🌆', title: 'Night Walk', description: 'Stroll under the stars hand in hand' },
            { icon: '🎡', title: 'Fun Park', description: 'Enjoy rides and win prizes together' },
            { icon: '🏞', title: 'Nature Date', description: 'Hiking or exploring a beautiful trail' },
            { icon: '🎮', title: 'Gaming Date', description: 'Play video games and challenge each other' },
            { icon: '📸', title: 'Photo Walk', description: 'Capture beautiful moments around the city' },
            { icon: '🎨', title: 'Art Date', description: 'Visit a gallery or paint together' },
            { icon: '🍳', title: 'Cooking Together', description: 'Try a new recipe and enjoy the meal' },
            { icon: '✨', title: 'Stargazing', description: 'Find a quiet spot and look at the constellations' },
            { icon: '🚗', title: 'Road Trip', description: 'Drive to a nearby town or scenic viewpoint' },
            { icon: '🌊', title: 'Beach Day', description: 'Listen to the waves and walk on the sand' }
        ];

        let shownIdeasCount = 0;
        let clickCount = 0;

        // Funky Greetings Pool
        const sassyGreetings = [
            "Slay! It's giving soulmate energy 💅✨",
            "No cap, your rizz is actually illegal 👑🔥",
            "Main character energy achieved! 🌟✨",
            "W Rizz! You really did that, bestie 💅🔥",
            "Certified iconic behavior. Period! 💅💎",
            "You're the literal blueprint, fr fr 📈✨",
            "Rent free in their head? Obviously 🧠💖",
            "Ate and left no crumbs! 🍽️🔥",
            "Living for this energy right now 💅✨",
            "Understand the assignment? Always! ✅🔥",
            "Big W! This is the one! 🏆💖",
            "Sheeesh! That rizz is unmatched 😤🔥",
            "It's the compatibility for me! 💖📈",
            "Manifesting this forever, fr fr ✨🙌"
        ];

        const sassyAnims = ['anim-float', 'anim-shake', 'anim-bounce', 'anim-glow', 'anim-zoom'];

        function setRandomGreeting() {
            const h2 = document.getElementById('sassyGreeting');
            const greeting = sassyGreetings[Math.floor(Math.random() * sassyGreetings.length)];
            const anim = sassyAnims[Math.floor(Math.random() * sassyAnims.length)];
            
            h2.textContent = greeting;
            // Remove previous anims
            sassyAnims.forEach(a => h2.classList.remove(a));
            // Add new anim
            h2.classList.add(anim);
        }

        function showMoreDateIdeas() {
            const grid = document.getElementById('dateIdeasGrid');
            const btn = document.getElementById('showMoreIdeas');
            
            let countToLoad = 0;
            if (clickCount === 0) {
                countToLoad = 4; // Initial load
            } else {
                countToLoad = 5; // Subsequent clicks
            }

            for (let i = 0; i < countToLoad && shownIdeasCount < dateIdeasPool.length; i++) {
                const idea = dateIdeasPool[shownIdeasCount];
                const card = document.createElement('div');
                card.className = 'date-idea-card';
                card.style.animationDelay = (i * 0.1) + 's';
                card.innerHTML = `
                    <span class="date-icon">${idea.icon}</span>
                    <h3>${idea.title}</h3>
                    <p>${idea.description}</p>
                `;
                grid.appendChild(card);
                shownIdeasCount++;
            }

            clickCount++;

            // Hide button after 2 clicks as requested (4 + 5 + 5 = 14) 
            // OR if we run out of ideas
            if (clickCount >= 3 || shownIdeasCount >= dateIdeasPool.length) {
                btn.style.display = 'none';
            }
        }
        const dayEmojis = {
            'rose': ['🌹', '❤️', '💕'],
            'propose': ['💍', '❤️', '💕', '💖'],
            'chocolate': ['🍫', '🍬', '💝'],
            'teddy': ['🧸', '💕', '❤️'],
            'promise': ['🤝', '💫', '✨'],
            'hug': ['🤗', '💕', '❤️'],
            'kiss': ['💋', '❤️', '💕'],
            'valentine': ['❤️', '💕', '💖', '💝', '💘', '🌹', '🍫', '🧸']
        };

        const floatingEmojis = dayEmojis[dayType] || ['❤️', '💕'];

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

        for (let i = 0; i < 15; i++) {
            setTimeout(createFloatingElement, i * 500);
        }
        setInterval(createFloatingElement, 2000);

        // Heart Burst Function
        function burstHearts(btn) {
            const rect = btn.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            const emojis = ['❤️', '💖', '💝', '💕', '💗'];

            for (let i = 0; i < 15; i++) {
                const heart = document.createElement('div');
                heart.className = 'heart-bubble';
                heart.textContent = emojis[Math.floor(Math.random() * emojis.length)];
                
                // Random directions
                const angle = Math.random() * Math.PI * 2;
                const distance = 50 + Math.random() * 150;
                const tx = Math.cos(angle) * distance;
                const ty = Math.sin(angle) * distance;
                const rot = (Math.random() - 0.5) * 60;

                heart.style.left = centerX + 'px';
                heart.style.top = centerY + 'px';
                heart.style.setProperty('--tx', `${tx}px`);
                heart.style.setProperty('--ty', `${ty}px`);
                heart.style.setProperty('--rot', `${rot}deg`);

                document.body.appendChild(heart);
                setTimeout(() => heart.remove(), 1000);
            }
        }

        // Interaction
        async function interact(action) {
            if (action === 'like') {
                const likesCount = document.getElementById('likesCount');
                const likeBtn = document.querySelector('.like-btn');
                if (!likesCount || !likeBtn) return;

                const previousCount = parseInt(likesCount.textContent);
                
                // Anim
                burstHearts(likeBtn);
                
                // Optimistic Update
                likesCount.textContent = previousCount + 1;
                const originalBtnText = likeBtn.innerHTML;
                likeBtn.textContent = '❤️ Liked!';
                likeBtn.disabled = true;
                
                try {
                    const response = await fetch(`/valentine/${submissionUuid}/interact`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ action })
                    });

                    const data = await response.json();
                    if (!data.success) {
                        // Revert on failure
                        likesCount.textContent = previousCount;
                        likeBtn.innerHTML = originalBtnText;
                        likeBtn.disabled = false;
                        alert('Something went wrong. Reverting like.');
                    }
                } catch (error) {
                    console.error(error);
                    // Revert on error
                    likesCount.textContent = previousCount;
                    likeBtn.innerHTML = originalBtnText;
                    likeBtn.disabled = false;
                }
                return;
            }

            try {
                const response = await fetch(`/valentine/${submissionUuid}/interact`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        action
                    })
                });

                const data = await response.json();

                if (data.success) {
                    if (action === 'accept') {
                        showSuccess(data.meta_data);
                    } else {
                        location.reload();
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }

        // Valentine Day Special - Evade No Button
        const noTooltips = [
            "Nice try, villain. 😏",
            "System error: rejection not supported. 🤖",
            "This button is emotionally unavailable. 💔",
            "Love.exe has blocked this action. 💻",
            "Destiny disabled this option. ✨",
            "The universe says no to your no. 🌌",
            "Error 404: Rejection not found. 🔍",
            "This button runs on love allergies. 🤧",
            "Cupid disabled this feature. 🏹",
            "Your click was lost in the cloud of love. ☁️",
            "Button.exe has feelings too. 😢",
            "This button is on a coffee break. ☕",
            "Access denied by the heart department. 💖",
            "Button is practicing social distancing. 📏",
            "Try again in your next life. 👻"
        ];

        let noClickCount = 0;

        function evadeButton() {
            const btn = document.getElementById('noBtn');
            const tooltip = document.getElementById('noTooltip');
            const container = btn.parentElement;

            // Random position
            const containerRect = container.getBoundingClientRect();
            const maxX = window.innerWidth - 150;
            const maxY = window.innerHeight - 100;

            const newX = Math.random() * maxX;
            const newY = Math.random() * maxY;

            btn.style.position = 'fixed';
            btn.style.left = newX + 'px';
            btn.style.top = newY + 'px';

            // Show tooltip
            tooltip.textContent = noTooltips[noClickCount % noTooltips.length];
            tooltip.style.left = (newX + 80) + 'px';
            tooltip.style.top = (newY - 50) + 'px';
            tooltip.classList.add('visible');

            setTimeout(() => tooltip.classList.remove('visible'), 2000);

            noClickCount++;
        }

        // Accept Valentine
        async function acceptValentine() {
            try {
                const response = await fetch(`/valentine/${submissionUuid}/interact`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        action: 'accept'
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showCelebration();
                    showSuccess(data.meta_data);
                }
            } catch (error) {
                console.error(error);
            }
        }

        // Celebration Confetti
        function showCelebration() {
            const overlay = document.getElementById('celebrationOverlay');
            const container = document.getElementById('confettiContainer');
            overlay.classList.add('active');

            const celebrationEmojis = ['❤️', '💕', '💖', '🎉', '✨', '🌟', '🧸', '🍫', '🌹', '💋', '🤗', '💝'];

            for (let i = 0; i < 100; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti-piece';
                    confetti.textContent = celebrationEmojis[Math.floor(Math.random() * celebrationEmojis.length)];
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.fontSize = (Math.random() * 2 + 1) + 'rem';
                    confetti.style.animationDelay = Math.random() * 2 + 's';
                    container.appendChild(confetti);

                    setTimeout(() => confetti.remove(), 5000);
                }, i * 50);
            }
        }

        // Show Success
        function showSuccess(meta) {
            const card = document.querySelector('.love-card');
            const successContent = document.getElementById('successContent');

            card.style.display = 'none';
            successContent.style.display = 'block';

            if (meta && meta.love_quote) {
                document.getElementById('loveQuote').textContent = meta.love_quote;
            }

            // Set a unique sassy greeting and animation
            setRandomGreeting();

            // Load initial 4 ideas
            showMoreDateIdeas();
        }


    </script>
</body>

</html>