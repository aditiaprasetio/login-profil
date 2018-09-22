// key for locaStorage
var USER_DATA = 'user_data';

// get data user
var user = localStorage.getItem(USER_DATA);
if(user!=null){
    // parsing
    user=JSON.parse(user);
    // if there is not lat, lng, or phone value
    if(!user.hasOwnProperty('lat')) user.lat=null;
    if(!user.hasOwnProperty('lng')) user.lng=null;
    if(!user.hasOwnProperty('phone')) user.phone=null;
    // to ensure that lat and lng is number, not string
    user.lat=user.lat*1;
    user.lng=user.lng*1;
    // show welcome message in user panel
    document.getElementById('account_fullname').innerHTML='<i class="fa fa-user-alt"></i> Welcome, '+user.fullname;
}

// encrypt text with sha1
function enkripsi(text){
    return sha1(text);
    // var hash = sha1.create();
    // hash.update(text);
    // hash.hex();
    // return hash;
}

function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();

	auth2.signOut().then(function () {

		console.log('User signed out.');

	});
	
	/* redirect to homepage (login page) */
	window.location.replace('index.html');
	
	/* remove data user */
	localStorage.removeItem(USER_DATA);
}