<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta tags -->
	<title>Login</title>
	<meta name="keywords" content="" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- stylesheets -->
	<link rel="stylesheet" href="<?php echo base_url('assets/login/'); ?>css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/login/'); ?>css/style.css">
	<!-- google fonts  -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
</head>
<body>
	<div class="agile-login">
		<h1>Login</h1>
		<div class="wrapper">
			<h2>Sign In</h2>
			<div class="w3ls-form">
				<form action="<?php echo site_url('auth/login_proses'); ?>" method="post">
					<label>Username</label>
					<input type="text" name="username" placeholder="Username" required/>
					<label>Password</label>
					<input type="password" name="password" placeholder="Password" required />
					<a href="<?php echo site_url('auth/forgot_password'); ?>" class="pass">Forgot Password ?</a>
					<input type="submit" name="submit" value="Log In" />
				</form>
			</div>
			
			<div class="agile-icons">
				<a href="#"><span class="fa fa-twitter" aria-hidden="true"></span></a>
				<a href="#"><span class="fa fa-facebook"></span></a>
				<a href="#"><span class="fa fa-pinterest-p"></span></a>
			</div>
		</div>
		<br>
		<div class="copyright">
		<p>© 2018 WeMo. All rights reserved.</a></p> 
	</div>
	</div>
	
</body>
</html>