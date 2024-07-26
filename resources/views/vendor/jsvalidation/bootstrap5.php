<script>
    jQuery(document).ready(function () {

        $("<?= $validator['selector']; ?>").each(function () {
            $(this).validate({
                errorElement: 'div',
                errorClass: 'invalid-feedback',

                errorPlacement: function (error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.appendTo(element.closest('.col-md-6'));
                        error.appendTo(element.closest('.col-md-12'));
                    }  else {
                        error.insertAfter(element);
                    }

                    if (element[0].type === "textarea") {
                        error.insertAfter(".ck-editor__editable");
                        return false
                    }
                },
                highlight: function (element) {
                    $(element).removeClass('is-valid').addClass('is-invalid'); // add the Bootstrap error class to the control group

                    if (element.type === "textarea") {
                        $(".ck-editor__editable").removeClass('is-valid').addClass('is-invalid');
                        return false
                    }
                },

                <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>

                ignore: "<?= $validator['ignore']; ?>",
                <?php endif; ?>


                unhighlight: function (element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');

                    if (element.type === "textarea") {
                        $(".ck-editor__editable").removeClass('is-invalid').addClass('is-valid');
                        return false
                    }
                },

                success: function (element) {
                    $(element).removeClass('is-invalid').addClass('is-valid'); // remove the Boostrap error class from the control group

                    if (element.type === "textarea") {
                        $(".ck-editor__editable").removeClass('is-invalid').addClass('is-valid');
                        return false
                    }
                },

                focusInvalid: true,
                <?php if (Config::get('jsvalidation.focus_on_error')): ?>
                invalidHandler: function (form, validator) {

                    if (!validator.numberOfInvalids())
                        return;

                    $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top
                    }, <?= Config::get('jsvalidation.duration_animate') ?>);

                },
                <?php endif; ?>

                rules: <?= json_encode($validator['rules']); ?>
            });
        });
    });
</script>
