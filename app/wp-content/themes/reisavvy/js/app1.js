jQuery(document).ready(function($){

    $(function() {
        $('nav ul li > a:not(:only-child)').click(function(e) {
            $(this).siblings('.nav-dropdown').toggle();
            $('.nav-dropdown').not($(this).siblings()).hide();
            e.stopPropagation();
        });
        $('html').click(function() {
            $('.nav-dropdown').hide();
        });
        $('#nav-toggle').on('click', function() {
            this.classList.toggle('active');
        });
    
        $('#nav-toggle').click(function() {
            $('nav ul').toggle();
        });
    });
    // Wait for the DOM to be ready
    $(function() {
        // Initialize form validation on the registration form.
        // It has the name attribute "registration"
        $("form[name='registration']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                firstname: "required",
                lastname: "required",
                email: {
                    required: true,
                    // Specify that email should be validated
                    // by the built-in "email" rule
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                }
            },
            // Specify validation error messages
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                email: "Please enter a valid email address"
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });


        $("form[name='fastcashoffer']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                firstname: "required",
                lastname: "required",
                email: {
                    required: true,
                    // Specify that email should be validated
                    // by the built-in "email" rule
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                }
            },
            // Specify validation error messages
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                email: "Please enter a valid email address"
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });

    });





    function validateCaptcha(){
        if ($('input[name="valid"]')) return true;
        if ($('input[name="recaptcha_response_field"]').val() == "")
        {
            alert("Fill in the captcha field");
            return false
        }
        $.ajax({
            url: "verify.php",
            type: "POST",
            async:"false",
            data: {
                recaptcha_response_field: $('input[name="recaptcha_response_field"]').val(),
                recaptcha_challenge_field: $('input[name="recaptcha_challenge_field"]').val()
            },
            success: function(data){
                if (data == "OK")
                {
                    $('input[name="valid"]').val(1);
                    $('.form').submit();
                }
                else
                {
                    alert(data);
                }
            },
            error: function(){
                alert("An error occured, please try again later");
            }
        });
        return false;
    };
    
});

