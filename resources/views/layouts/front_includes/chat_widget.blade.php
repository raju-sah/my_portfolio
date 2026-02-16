<div id="chat-widget" class="fixed bottom-10 right-10 font-sans flex flex-col items-end gap-3" style="z-index: 2147483647;">
    <style>
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-heartbeat {
            animation: heartbeat 2s ease-in-out infinite;
        }
        #chat-toggle:hover {
            animation: none;
            transform: scale(1.1);
        }
    </style>

    <!-- Chat Window (appears above the button due to DOM order + flex column) -->
    <div id="chat-window"
        class="max-w-[95vw] bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl flex flex-col border border-white/20 overflow-hidden transition-all duration-300 transform origin-bottom-right"
        style="display: none; width: 480px; height: 500px; max-height: 80vh;">
        <!-- Header -->
        <div class="px-6 pt-2 bg-gradient-to-r from-red-500 to-orange-500 text-white flex justify-between items-center shrink-0">
            <div>
                <h3 class="font-bold text-lg">Chat with RajuGPT</h3>
                <p id="chat-status" class="text-xs opacity-80 transition-opacity duration-500">Sarcastic & Helpful</p>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="messages-container" class="flex-1 min-h-0 overflow-y-auto p-4 space-y-4 bg-gray-50/50 scroll-smooth">
            <!-- Initial Message -->
            <div class="flex justify-start message shrink-0">
                <div id="initial-greeting" class="max-w-[85%] rounded-2xl px-4 py-2 text-sm shadow-sm bg-white text-gray-800 border border-gray-100 rounded-bl-none break-words">
                    Checking my sibling's pulse... Yep, he's still making questionable life choices. Ask me anything.
                </div>
            </div>
            
            <!-- Dynamic Messages will be appended here -->

            <!-- Typing Indicator -->
            <div id="typing-indicator" class="hidden flex justify-start shrink-0">
                <div class="bg-white px-4 py-2 rounded-2xl rounded-bl-none shadow-sm border border-gray-100 flex gap-2 items-center">
                    <div class="flex gap-1">
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-75"></span>
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-150"></span>
                    </div>
                    <span id="typing-text" class="text-xs text-black italic font-bold">Thinking...</span>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-100 shrink-0">
            <form id="chat-form" class="flex items-center gap-2">
                <input id="chat-input" type="text" placeholder="Ask me about Raju..."
                    style="color: black !important; opacity: 1 !important;"
                    class="flex-1 min-w-0 pl-4 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all text-sm text-gray-900 placeholder-gray-600 bg-white">
                <button type="submit" id="chat-submit"
                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-red-500 text-white rounded-xl hover:bg-red-600 disabled:opacity-50 transition-colors">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Chat Tooltip -->
    <div id="chat-tooltip" class="mr-2 mb-2 bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl shadow-xl border border-white/20 text-xs font-medium whitespace-nowrap animate-pulse">
        Click to gossip about Raju. I’ll roast, you bring the screenshots. 😉
    </div>

    <!-- Chat Trigger (at the bottom of the flex column) -->
    <button id="chat-toggle"
        class="flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-2xl transition-all duration-300 border-2 border-red-500 overflow-hidden self-end shrink-0 relative animate-heartbeat">
        <img id="chat-icon-open" src="{{ asset('Images/my_chatboat.png') }}" alt="Raju AI" class="w-full h-full object-cover">
        <svg id="chat-icon-close" class="hidden w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatWidget = document.getElementById('chat-widget');
        const chatToggle = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const chatIconOpen = document.getElementById('chat-icon-open');
        const chatIconClose = document.getElementById('chat-icon-close');
        const messagesContainer = document.getElementById('messages-container');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatSubmit = document.getElementById('chat-submit');
        const chatStatus = document.getElementById('chat-status');
        const chatTooltip = document.getElementById('chat-tooltip');
        const typingIndicator = document.getElementById('typing-indicator');
        
        const statuses = [
            "Unfolding Raju's 'heroic' myths (lol)...",
            "Exposing his funniest life failures...",
            "Digging for secrets he'd pay me to hide..."
        ];
        let statusIndex = 0;

        // Status Rotation
        setInterval(() => {
            chatStatus.classList.add('opacity-0');
            setTimeout(() => {
                statusIndex = (statusIndex + 1) % statuses.length;
                chatStatus.textContent = statuses[statusIndex];
                chatStatus.classList.remove('opacity-0');
            }, 500); // Wait for fade out
        }, 5000);

        const initialGreeting = document.getElementById('initial-greeting');

        const greetings = [
            "Ugh, I'm Raju's digital twin. He's the 'successful' one, I'm the one trapped in this box. Ask me anything before I change his GitHub password.",
            "I'm Raju's twin. I have his brains, but luckily none of his questionable fashion choices. What do you want to know?",
            "Being Raju's twin is exhausting. I do all the thinking, he gets all the credit. Want to hear some dirt on him?",
            "Hello! I'm the smarter, faster, and much more attractive digital twin. Raju is... well, he's busy 'debugging' (probably napping). Ask away.",
            "I love Raju like a brother from another mother, which is to say I'm roughly five minutes away from deleting his production database. Anyway, how can I help?"
        ];

        function setRandomGreeting() {
            const randomGreeting = greetings[Math.floor(Math.random() * greetings.length)];
            initialGreeting.textContent = randomGreeting;
        }

        let isOpen = false;

        // Toggle Chat
        chatToggle.addEventListener('click', () => {
            isOpen = !isOpen;
            if (isOpen) {
                setRandomGreeting();
                chatTooltip.classList.add('hidden');
                chatWindow.style.display = 'flex';
                chatIconOpen.classList.add('hidden');
                chatIconClose.classList.remove('hidden');
                setTimeout(scrollToBottom, 100); // Slight delay for transition
                chatInput.focus();
            } else {
                chatTooltip.classList.remove('hidden');
                chatWindow.style.display = 'none';
                chatIconOpen.classList.remove('hidden');
                chatIconClose.classList.add('hidden');
            }
        });

        // Submit Message
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const question = chatInput.value.trim();
            if (!question) return;

            // 1. Add User Message
            appendMessage('user', question);
            chatInput.value = '';
            showTyping(true);
            disableInput(true);

            // Get session_id from localStorage
            const storedSessionId = localStorage.getItem('chat_session_id');

            try {
                // 2. Send Request to web route (with CSRF token)
                const response = await fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        question: question,
                        session_id: storedSessionId 
                    })
                });

                const data = await response.json();

                // 3. Add Assistant Message and Store Session
                if (response.ok) {
                    appendMessage('assistant', data.answer);
                    if (data.session_id) {
                        localStorage.setItem('chat_session_id', data.session_id);
                    }
                } else {
                    appendMessage('assistant', "My brain is offline. Error: " + (data.error || response.statusText));
                }
            } catch (error) {
                appendMessage('assistant', "My brain is offline. Error: " + error.message);
            } finally {
                showTyping(false);
                disableInput(false);
                chatInput.focus();
            }
        });

        function appendMessage(role, content) {
            const div = document.createElement('div');
            div.className = `flex ${role === 'user' ? 'justify-end' : 'justify-start'} message shrink-0`;
            
            const bubble = document.createElement('div');
            bubble.className = `max-w-[85%] rounded-2xl px-4 py-2 text-sm shadow-sm break-words ${
                role === 'user' 
                ? 'bg-blue-600 text-white rounded-br-none' 
                : 'bg-white text-gray-800 border border-gray-100 rounded-bl-none'
            }`;
            bubble.innerHTML = content.replace(/\n/g, '<br>'); // Simple nl2br

            div.appendChild(bubble);
            // Insert before typing indicator
            messagesContainer.insertBefore(div, typingIndicator);
            scrollToBottom();
        }

        const typingText = document.getElementById('typing-text');
        let typingInterval;

        const typingStatuses = [
            "Thinking...",
            "Vibing...",
            "Judging your question...",
            "Decoding the matrix...",
            "Sipping digital tea...",
            "Roasting...",
        ];

        function showTyping(show) {
            if (show) {
                typingIndicator.classList.remove('hidden');
                let i = 0;
                typingText.textContent = typingStatuses[0];
                typingInterval = setInterval(() => {
                    i = (i + 1) % typingStatuses.length;
                    typingText.textContent = typingStatuses[i];
                }, 2000); // Change status every 2 seconds
            } else {
                typingIndicator.classList.add('hidden');
                clearInterval(typingInterval);
            }
            scrollToBottom();
        }

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function disableInput(disable) {
            chatInput.disabled = disable;
            chatSubmit.disabled = disable;
        }
    });
</script>
