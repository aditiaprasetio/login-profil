$(document).ready(function(){
    // get reset token
    let urlParams = new URLSearchParams(window.location.search);
    var reset_token = urlParams.get('reset_token');

    $.ajax({
        type: "POST",
        url: 'api/v1/user/changepassword',
        data: { check_only:true, reset_token:reset_token },
        dataType: "json",
        beforeSend:  function(xhr){
            $('#forgot-password-form').hide();
            $('#message-form').html('<div class="alert alert-warning">Sedang melakukan pengecekan.</div>');
        },
        success: function(data) {
            if(data.status){
                // success
                $('#message-form').html('<div class="alert alert-info">You can change your password.</div>');
                $('#forgot-password-form').show();
            }else{
                // failed
                $('#message-form').html('<div class="alert alert-danger">Your token was expired.</div>');
                $('#forgot-password-form').hide();
            }
        },
        error: function(xhr) {
            $('#message-form').html('<div class="alert alert-danger">There is a problem. Please try again.</div>');
            $('#forgot-password-form').hide();
        }
    });


    $( "#forgot-form" ).submit(function( event ) {
        event.preventDefault();
        var _password = $('#password').val();
        var _repassword = $('#repassword').val();
        var password=enkripsi(_password);
        var repassword=enkripsi(_repassword);

        if(password=='' || repassword==''){
            $('#message-password').html('<div class="alert alert-danger">Semua isian password tidak boleh kosong.</div>');
        }else if(password!=repassword){
            $('#message-password').html('<div class="alert alert-danger">Password baru dan retype password tidak sama.</div>');
        }else{
            $.ajax({
                type: "POST",
                url: 'api/v1/user/changepassword',
                data: { password: password, repassword:repassword, reset_token:reset_token },
                dataType: "json",
                beforeSend:  function(xhr){
                    $('#message-form').html();
                    $('#change-password-button').prop('disabled', true).val('..processing..');
                },
                success: function(data) {
                    if(data.status){
                        // success
                        $('#message-password').html('<div class="alert alert-success">Berhasil mengubah password.</div>');
                        $('#change-password-button').prop('disabled', false).val('Update Password');
                    }else{
                        // failed
                        $('#message-password').html('<div class="alert alert-danger">'+data.message+'</div>');
                        $('#change-password-button').prop('disabled', false).val('Update Password');
                    }
                    console.log(data);
                },
                error: function(xhr) {
                    $('#message-password').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                    $('#change-password-button').prop('disabled', false).val('Update Password');
                }
            });
        }
    });
});