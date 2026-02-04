<div class="scroll-section relative py-20" id="contact" 
     data-bg="rgb(74, 44, 42)" data-text="rgb(248, 226, 226)"
     data-bg-light="rgb(250, 235, 235)" data-text-light="rgb(85, 45, 45)">
    <div class="scroll-reveal-text">Contact</div>
    <div class="container mx-auto px-6 relative z-10">
        <h4 class="text-3xl font-bold text-heading mb-12 border-b border-heading/20 pb-4 inline-block">Contact Me</h4>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-card/30 backdrop-blur-md border border-white/5 rounded-3xl p-8 lg:p-12 shadow-2xl shadow-black/30">
            <!-- Left: Info -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-2xl font-bold text-heading mb-2">Get in Touch</h3>
                    <p class="text-body/70">I'm always open to discussing new projects, creative ideas or opportunities to be part of your visions.</p>
                </div>

                @foreach ($social_links as $social_link)
                    <div class="space-y-6">
                        @php $emails = explode(',', $social_link->email); @endphp
                        <a href="mailto:{{ $emails[0] ?? '' }}" class="flex items-center gap-4 group p-4 rounded-xl hover:bg-white/5 transition-colors border border-transparent hover:border-white/10">
                            <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent text-xl group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-body/50 uppercase tracking-widest">Email</span>
                                <span class="text-lg font-medium text-heading group-hover:text-accent transition-colors">{{ $emails[0] ?? '' }}</span>
                            </div>
                        </a>

                        @php $phones = explode(',', $social_link->phone); @endphp
                        <a href="tel:{{ $phones[0] ?? '' }}" class="flex items-center gap-4 group p-4 rounded-xl hover:bg-white/5 transition-colors border border-transparent hover:border-white/10">
                            <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent text-xl group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-square-phone"></i>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-body/50 uppercase tracking-widest">Phone</span>
                                <span class="text-lg font-medium text-heading group-hover:text-accent transition-colors">{{ $phones[0] ?? '' }}</span>
                            </div>
                        </a>

                        @php $address = explode(',', $social_link->address); @endphp
                        <a href="https://maps.app.goo.gl/E6ku8RzFvSMuz12cA" target="_blank" class="flex items-center gap-4 group p-4 rounded-xl hover:bg-white/5 transition-colors border border-transparent hover:border-white/10">
                            <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent text-xl group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-body/50 uppercase tracking-widest">Location</span>
                                <span class="text-lg font-medium text-heading group-hover:text-accent transition-colors">{{ $address[0] ?? '' }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Right: Form -->
            <div class="bg-black/20 p-6 rounded-2xl border border-white/5">
                <form id="contact_form" action="{{ route('sendWithCCandBCC') }}" method="GET" name="submit-to-google-sheet" class="space-y-6">
                    @csrf
                    <!-- Honeypot -->
                    <input type="text" id="pri_min" name="pri_min" class="opacity-0 h-0 absolute pointer-events-none" value="">

                    <!-- Custom Outlined Inputs with Sarcastic Placeholders -->
                    <div class="space-y-5">
                        <!-- Name Input -->
                        <div class="floating-input-group">
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                                   placeholder="John Doe... just kidding, your actual name please" 
                                   class="floating-input peer" autocomplete="name">
                            <label for="name" class="floating-label">Name *</label>
                        </div>

                        <!-- Email Input -->
                        <div class="floating-input-group">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                   placeholder="definitely_not_spam@trustme.com" 
                                   class="floating-input peer" autocomplete="email">
                            <label for="email" class="floating-label">Email *</label>
                        </div>

                        <!-- Phone Input -->
                        <div class="floating-input-group">
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required 
                                   placeholder="+1 (555) DON'T-CALL-AT-3AM" 
                                   class="floating-input peer" autocomplete="tel">
                            <label for="phone" class="floating-label">Phone *</label>
                        </div>

                        <!-- Message Textarea -->
                        <div class="floating-input-group">
                            <textarea id="message" name="message" required rows="4" 
                                      placeholder="Tell me about your million-dollar idea... or just say hi, that works too" 
                                      class="floating-input floating-textarea peer">{{ old('message') }}</textarea>
                            <label for="message" class="floating-label floating-label-textarea">Message *</label>
                        </div>
                    </div>

                    <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                    <button type="submit" class="w-full py-4 rounded-xl bg-accent text-white font-bold tracking-widest uppercase hover:bg-red-600 transition-all hover:shadow-lg hover:shadow-accent/40 flex items-center justify-center gap-2 group">
                        <span>Send Message</span>
                        <i class="fa-solid fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Floating Input Styles */
    .floating-input-group {
        position: relative;
    }

    .floating-input {
        width: 100%;
        padding: 1rem 1rem 0.75rem;
        background: transparent !important;
        border: 2px solid color-mix(in srgb, var(--text-body) 30%, transparent) !important;
        border-radius: 0.75rem !important;
        color: var(--text-heading) !important;
        font-size: 1rem;
        transition: all 0.3s ease;
        outline: none;
    }

    .floating-input::placeholder {
        color: transparent;
        transition: color 0.3s ease;
    }

    .floating-input:focus::placeholder {
        color: color-mix(in srgb, var(--text-body) 50%, transparent);
    }

    .floating-input:focus,
    .floating-input:not(:placeholder-shown) {
        border-color: var(--accent-color) !important;
    }

    .floating-label {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        padding: 0 0.25rem;
        background: transparent;
        color: var(--text-body);
        font-size: 0.95rem;
        font-weight: 500;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .floating-label-textarea {
        top: 1.25rem;
    }

    .floating-input:focus ~ .floating-label,
    .floating-input:not(:placeholder-shown) ~ .floating-label {
        top: 0;
        left: 0.5rem;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--accent-color);
        background: var(--bg-card);
        padding: 0.125rem 0.5rem;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .floating-textarea {
        resize: none;
        min-height: 120px;
    }

    /* Phone input override */
    .iti__selected-flag {
        height: 1% !important;
        top: 19px !important;
    }

    .iti--allow-dropdown {
        width: 100% !important;
    }
</style>

