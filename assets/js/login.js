if(user!=null){
    window.location.replace('profil.html');
}

$(document).ready(function(){
    // show and hide form based on what is needed
    $('#register-form').hide();
    $('#forgot-form').hide();
    
    $('#open-login').click(function(event){
        $('#login-form').show();
        $('#forgot-form').hide();
        $('#register-form').hide();
    });
    $('#open-login1').click(function(event){
        $('#login-form').show();
        $('#forgot-form').hide();
        $('#register-form').hide();
    });
    $('#open-register').click(function(event){
        $('#login-form').hide();
        $('#forgot-form').hide();
        $('#register-form').show();
    });
    $('#open-register1').click(function(event){
        $('#login-form').hide();
        $('#forgot-form').hide();
        $('#register-form').show();
    });
    $('#open-forgot').click(function(event){
        $('#login-form').hide();
        $('#register-form').hide();
        $('#forgot-form').show();
    });

    // SIGN IN FORM
    $('#signin-button').prop('disabled', true);
    // when user type email (enable button if email and password are not empty)
    $('#email').keyup(function(event){
        var email = $('#email').val();
        var pass = $('#password').val();
        if(email!='' && pass!='')  $('#signin-button').prop('disabled', false);
        else $('#signin-button').prop('disabled', true);
    });
    // when user type password (enable button if email and password are not empty)
    $('#password').keyup(function(event){
        var email = $('#email').val();
        var pass = $('#password').val();
        if(email!='' && pass!='')  $('#signin-button').prop('disabled', false);
        else $('#signin-button').prop('disabled', true);
    });
    // when user submit form (id=login-form)
    $( "#login-form" ).submit(function( event ) {
        event.preventDefault();
        var email = $('#email').val();
        var pass = $('#password').val();
        password=enkripsi(pass);

        $.ajax({
            type: "POST",
            url: 'api/v1/user/login',
            data: { email : email, password: password },
            dataType: "json",
            beforeSend:  function(xhr){
                $('#signin-button').prop('disabled', true).val('..processing..');
                $('#message-form').html();
            },
            success: function(data) {
                if(data.status){
                    // success
                    $('#message-form').html('<div class="alert alert-success">Berhasil login.</div>');
                    var user = data.result;
                    localStorage.setItem(USER_DATA, JSON.stringify(user));
                    window.location.replace('profil.html');
                }else{
                    // failed
                    $('#message-form').html('<div class="alert alert-danger">'+data.message+'</div>');
                    $('#signin-button').prop('disabled', false).val('Sign In');
                }
                console.log(data);
            },
            error: function() {
                $('#message-form').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                $('#signin-button').prop('disabled', false).val('Sign In');
            }
        });

    });
    // SIGN UP FORM
    $('#signup-button').prop('disabled', true);
    // when user type email
    $('#emailReg').keyup(function(event){
        var email = $('#emailReg').val();
        var pass = $('#passwordReg').val();
        if(email!='' && pass!='')  $('#signup-button').prop('disabled', false);
        else $('#signup-button').prop('disabled', true);
    });
    // when user type password
    $('#passwordReg').keyup(function(event){
        var email = $('#emailReg').val();
        var pass = $('#passwordReg').val();
        if(email!='' && pass!='')  $('#signup-button').prop('disabled', false);
        else $('#signup-button').prop('disabled', true);
    });
    // when user submit form (id=register-form)
    $( "#register-form" ).submit(function( event ) {
        event.preventDefault();
        var fullname = $('#fullname').val();
        var email = $('#emailReg').val();
        var pass = $('#passwordReg').val();
        password=enkripsi(pass);

        $.ajax({
            type: "POST",
            url: 'api/v1/user/register',
            data: { fullname:fullname, email : email, password: password },
            dataType: "json",
            beforeSend:  function(xhr){
                $('#signup-button').prop('disabled', true).val('..processing..');
                $('#message-form').html();
                $('#message-form-register').html();
            },
            success: function(data) {
                if(data.status){
                    // success
                    $('#message-form').html('<div class="alert alert-success">Berhasil terdaftar.</div>');
                    $('#login-form').show();
                    $('#register-form').hide();
                }else{
                    // failed
                    $('#message-form-register').html('<div class="alert alert-danger">'+data.message+'</div>');
                    $('#signup-button').prop('disabled', false).val('Sign Up');
                }
                console.log(data);
            },
            error: function() {
                $('#message-form-register').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                $('#signup-button').prop('disabled', false).val('Sign Up');
            }
        });

    });
    // FORGOT FORM
    $('#forgot-button').prop('disabled', true);
    $('#emailForgot').keyup(function(event){
        var email = $('#emailForgot').val();
        if(email!='')  $('#forgot-button').prop('disabled', false);
        else $('#forgot-button').prop('disabled', true);
    });
    $( "#forgot-form" ).submit(function( event ) {
        event.preventDefault();
        var email = $('#emailForgot').val();
        
        $.ajax({
            type: "POST",
            url: 'api/v1/user/resetpassword',
            data: { email : email },
            dataType: "json",
            beforeSend:  function(xhr){
                $('#forgot-button').prop('disabled', true).val('..processing..');
                $('#message-form-forgot').html('');
            },
            success: function(data) {
                if(data.status){
                    // success
                    $('#message-form-forgot').html('<div class="alert alert-success">We have sent an email to you. Please check your inbox or spam!</div>');
                    $('#forgot-button').prop('disabled', false).val('Reset Password');
                }else{
                    // failed
                    $('#message-form-forgot').html('<div class="alert alert-danger">'+data.message+'</div>');
                    $('#forgot-button').prop('disabled', false).val('Reset Password');
                }
                console.log(data);
            },
            error: function(xhr) {
                $('#message-form-forgot').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                console.log(xhr);
                $('#forgot-button').prop('disabled', false).val('Reset Password');
            }
        });

    });
});

function onSignIn(googleUser) {
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    console.log("ID: " + profile.getId()); // Don't send this directly to your server!
    console.log('Full Name: ' + profile.getName());
    console.log('Given Name: ' + profile.getGivenName());
    console.log('Family Name: ' + profile.getFamilyName());
    console.log("Image URL: " + profile.getImageUrl());
    console.log("Email: " + profile.getEmail());

    var fullname = profile.getName();
    var email = profile.getEmail();

    // The ID token you need to pass to your backend:
    var google_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + google_token);

    // Register data user into database in server
    $.ajax({
        type: "POST",
        url: 'api/v1/user/loginByApps',
        data: { fullname:fullname, email : email, google_token: google_token },
        dataType: "json",
        beforeSend:  function(xhr){
            $('#signup-button').prop('disabled', true).val('..processing..');
        },
        success: function(data) {
            if(data.status){
                // success
                $('#message-form').html('<div class="alert alert-success">Berhasil login via Google.</div>');

                var user = data.result;
                localStorage.setItem(USER_DATA, JSON.stringify(user));
                
                window.location.replace('profil.html');
            }else{
                // failed
                $('#message-form-register').html('<div class="alert alert-danger">'+data.message+'</div>');
                $('#signup-button').prop('disabled', false).val('Sign In');
            }
            console.log(data);
        },
        error: function(xhr) {
            $('#message-form-register').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
            console.log(xhr);
            $('#signup-button').prop('disabled', false).val('Sign In');
        }
    });
    
};