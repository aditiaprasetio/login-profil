$(document).ready(function(){
    // set input value with user data
    $('#fullname').val(user.fullname);
    $('#email').val(user.email);
    $('#address').val(user.address);
    $('#latlng').val(user.lat+','+user.lng);
    $('#phone').val(user.phone);
    // when address change, convert address to location (lat & lng)
    $('#address').change(function(event){
        $('#loading-address').html('<span class="badge badge-warning">..search your location..</span>');
        addressToLoc();
    });
    // token for authorization
    var token=$.base64.encode(user.id_user+':'+user.token);
    // when change password form submit
    $( "#password-form" ).submit(function( event ) {
        event.preventDefault();
        // get form value
        var _oldPassword = $('#oldPassword').val();
        var _password = $('#password').val();
        var _repassword = $('#repassword').val();
        var oldPassword=enkripsi(_oldPassword);
        var password=enkripsi(_password);
        var repassword=enkripsi(_repassword);
        // isValid
        if(oldPassword=='' || password=='' || repassword==''){
            $('#message-password').html('<div class="alert alert-danger">Semua isian password tidak boleh kosong.</div>');
        }else if(oldPassword==password){
            $('#message-password').html('<div class="alert alert-danger">Password lama dan baru tidak boleh sama.</div>');
        }else if(password!=repassword){
            $('#message-password').html('<div class="alert alert-danger">Password baru dan retype password tidak sama.</div>');
        }else{
            $.ajax({
                type: "POST",
                url: 'api/v1/user/changepassword',
                data: { oldPassword : oldPassword, password: password, repassword:repassword },
                headers:{
                    'Authorization':'Basic '+token
                },
                dataType: "json",
                beforeSend:  function(xhr){
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
    // when profil form submitted 
    $( "#profil-form" ).submit(function( event ) {
        event.preventDefault();
        // get value
        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var latlng = $('#latlng').val();
        // isValid
        if(fullname=='' || email==''){
            $('#message-profil').html('<div class="alert alert-danger">Full name dan email tidak boleh kosong.</div>');
        }else{
            $.ajax({
                type: "POST",
                url: 'api/v1/user/profil',
                data: { fullname : fullname, email: email, address:address, latlng:latlng, phone:phone },
                headers:{
                    'Authorization':'Basic '+token
                },
                dataType: "json",
                beforeSend:  function(xhr){
                    $('#profil-button').prop('disabled', true).val('..processing..');
                },
                success: function(data) {
                    if(data.status){
                        // success
                        $('#message-profil').html('<div class="alert alert-success">Berhasil mengupdate profil.</div>');
                        $('#profil-button').prop('disabled', false).val('Submit');
                        var latlngStr = latlng.split(',', 2);
                        var lat = parseFloat(latlngStr[0])
                        var lng = parseFloat(latlngStr[1]);
                        user.fullname=fullname;
                        user.email=email;
                        user.phone=phone;
                        user.address=address;
                        user.lat=lat;
                        user.lng=lng;

                        localStorage.setItem(USER_DATA, JSON.stringify(user));
                    }else{
                        // failed
                        $('#message-profil').html('<div class="alert alert-danger">'+data.message+'</div>');
                        $('#profil-button').prop('disabled', false).val('Submit');
                    }
                    console.log(data);
                },
                error: function(xhr) {
                    $('#message-profil').html('<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>');
                    $('#profil-button').prop('disabled', false).val('Submit');
                }
            });
        }
    });

    // check warning
    $.ajax({
        type: "GET",
        url: 'api/v1/user/getWarning',
        headers:{
            'Authorization':'Basic '+token
        },
        dataType: "json",
        beforeSend:  function(xhr){
            
        },
        success: function(data) {
            if(data.status){
                // success
                var warning='';
                for(var i=0; i<data.warning.length; i++){
                    if(data.warning[i]=='password default'){
                        data.warning[i]='You are login with Google Account. Please create password for LOGPRO account!'; 
                        $('#oldPassword').val('dp');
                        $('#form-oldPassword').hide();
                        $('#message-password').html('<div class="alert alert-warning">Please create your password!</div>');
                    }
                    warning+='<div class="alert alert-danger alert-dismissible fade show">'+data.warning[i]+'</div>';
                }
                $('#warning').html(warning);
            }else{
                // failed
                $('#warning').html('<div class="alert alert-danger alert-dismissible fade show">'+data.message+'</div>');
            }
            console.log(data);
        },
        error: function(xhr) {
            console.log('There is a problem.')
        }
    });
});