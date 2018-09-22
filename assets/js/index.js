var USER_DATA = 'user_data';

var user = localStorage.getItem(USER_DATA);
if(user!=null){
    user=JSON.parse(user);
    if(!user.hasOwnProperty('lat')) user.lat=null;
    if(!user.hasOwnProperty('lng')) user.lng=null;
    if(!user.hasOwnProperty('phone')) user.phone=null;
    user.lat=user.lat*1;
    user.lng=user.lng*1;
    console.log(user);
    document.getElementById('account_fullname').innerHTML='<i class="fa fa-user-alt"></i> Welcome, '+user.fullname;
}

function enkripsi(text){
    return sha1(text);
    // var hash = sha1.create();
    // hash.update(text);
    // hash.hex();
    // return hash;
}

function signout(){
    localStorage.removeItem(USER_DATA);
    window.location.replace('index.html');
}