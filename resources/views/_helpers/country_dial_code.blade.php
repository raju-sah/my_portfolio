<script>
    const phoneInputField = document.querySelector("#{{$id}}");

    const phoneInput = window.intlTelInput(phoneInputField, {
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    function updatePhoneNumber() {
      const selectedCountryData = phoneInput.getSelectedCountryData();
      const countryCode = selectedCountryData.dialCode; 

      phoneInputField.value = '+' + countryCode + ' ';
    }
    phoneInputField.addEventListener("countrychange", updatePhoneNumber);

    updatePhoneNumber();
  </script>