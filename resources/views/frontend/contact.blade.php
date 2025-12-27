<div class="container-fluid" id="contact">
    <br>
    <br>
    <h4 class="mx-5">Contact Me</h4>
    <hr>
    <div>
        <div>
            <div class="row">
                <div class="contact-left p-3">
                    <h3 class="sub-title">Get in Touch:</h3>

                    @foreach ($social_links as $social_link)
                        <div class="contact-details">
                            @php
                                $emails = explode(',', $social_link->email);
                            @endphp

                            <a class="d-flex" href="mailto:{{ $emails[0] ?? '' }}">
                                <p> <i class="fa-solid fa-envelope"></i>{{ $emails[0] ?? '' }}</p>
                            </a>
                            @php
                                $phones = explode(',', $social_link->phone);
                            @endphp
                            <a class="d-flex" href="tel:{{ $phones[0] ?? '' }}">
                                <p> <i class="fa-solid fa-square-phone"></i>{{ $phones[0] ?? '' }}</p>
                            </a>
                            @php
                                $address = explode(',', $social_link->address);
                            @endphp
                            <a class="d-flex" href="https://maps.app.goo.gl/E6ku8RzFvSMuz12cA">
                                <p> <i class="fa-solid fa-location-dot"></i>{{ $address[0] ?? '' }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="contact-right">
                    <form id="contact_form" action="{{ route('sendWithCCandBCC') }}" method="GET"
                        name="submit-to-google-sheet">
                        @csrf
                        <input type="text" id="pri_min" name="pri_min" style="opacity: 0; height: 0"
                            value="">

                        <x-form.input type="text" col="10" :req="true" label="Name" id="name"
                            name="name" value="{{ old('name') }}" />
                        <x-form.input type="text" col="10" :req="true" label="email" id="email"
                            name="email" value="{{ old('email') }}" />
                        <x-form.input type="text" col="10" :req="true" label="phone" id="phone"
                            name="phone" value="{{ old('phone') }}" />
                        <x-form.textarea label="Message" col="10" :req="true" id="message" name="message"
                            value="{{ old('message') }}" rows="5" cols="5" />

                        <div class="g-recaptcha mt-3" id="feedback-recaptcha"
                            data-sitekey="{{ config('services.recaptcha.site_key') }}">
                        </div>

                        <div class="button-click mt-5 d-flex justify-content-start ">
                            <button type="submit" class="title-btn btn_submit">
                                <span>Submit</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .iti__selected-flag {
        height: 1% !important;
        top: 19px !important;

    }

    .iti--allow-dropdown {
        width: 100% !important;
    }
</style>

