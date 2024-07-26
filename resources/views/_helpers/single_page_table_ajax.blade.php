<script>
    const form = $("{{$formId}}");

    
    function resetForm() {
        $('.error-message').remove();
        form[0].reset();
        form.find('img').attr('src', '').hide();
    }

    
    function saveData() {
        $.ajax({
            type: 'POST',
            url: storeRoute,
            data: form.serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                $(document).trigger('fetchEvent',[response]);
                swalMessage('success', response.message);
                resetForm();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    displayErrors(errors);
                } else {
                    console.log(xhr.responseText);
                }
            }
        });
    }

    // function deleteData(modelId) {
    //     let deleteUrl = deleteRoute.replace(':id', modelId);

    //     $.ajax({
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         url: deleteUrl,
    //         type: 'DELETE',
    //         success: function (response) {
    //             $(document).trigger('fetchEvent');
    //         },
    //         error: function (xhr) {
    //             console.log(xhr.responseText);
    //         }
    //     });
    // }



    //----------------------------------------------------
    // HELPER FUNCTIONS
    //----------------------------------------------------

    function swalMessage(type, message) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            icon: type,
            title: message,
            showConfirmButton: false,
        });
    }

    function displayErrors(errors) {
        $('.error-message').remove();

        $.each(errors, function (field, messages) {
            const input = $('[name="' + field + '"]');

            const errorContainer = $('<span class="text-danger small error-message"></span>');

            $.each(messages, function (index, message) {
                errorContainer.append('<p>' + message + '</p>');
            });

            input.after(errorContainer);
        });
    }


</script>
