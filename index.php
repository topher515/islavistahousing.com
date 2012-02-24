<?php include('checkcookie_nofwd.php'); 

if ( $loggedin ) { header("Location: ./home.php"); } ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Isla Vista Housing</title>
<style type="text/css">
<!--


body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color:#22cd46;
	
	font-family:"Verdana";
}

.ur {
	position:absolute;
	top:10px;
	right:10px;
}

.ur a {
	padding:8px;
	text-decoration:none;
	color:#002D00;
	font-size:12px;
	text-transform:uppercase;
}

#gradient  {
	position:absolute;
	left:0px;
	top:0px;
}

#title  {
	text-align:right;
	position:relative;
	margin-top:70px;
	margin-right:80px;
	margin-bottom:30px;
}

#slick_bar {
	background-image:url(slick_bar2.png);
	background-repeat:repeat-x;
	height:50px;
	width:100%;
	
	padding-top:13px;
}

#slick_bar a {
	color:#002D00;
	font-size:22px;
	font-weight:800;
	
	margin-left:40px;
	
	text-decoration:none;
}

#login_box {
	margin-left:40px;
	width:200px;
	color:#002D00;
	text-align:right;
	text-transform:uppercase;
	font-size:12px;
	float:left;
}

#register_box {
	margin-left:40px;
	width:200px;
	color:#002D00;
	text-align:right;
	text-transform:uppercase;
	font-size:12px;
	float:left;
}

#try {
	padding:15px;
	float:left;
	margin-left:50px;
	margin-bottom:50px;
	margin-top:40px;
	width:300px;
	color:#002D00;
	font-size:15px;
	border:1px dashed #333;
	background-color:#33CC33;
	text-decoration:none;
}

a div {
	text-decoration:none;
}

#try a {
	text-decoration:none;
	color:#002D00;
}

#explain_box {
	padding:15px;
	margin-left:50px;
	width:260px;
	color:#002D00;
	text-align:justify;
	font-size:15px;
	float:right;
	border:1px dashed #333;
	background-color:#33CC33;
}

input {
	font-family:"Verdana";
}

input.textarea {
	height:21px;
	background-color:#CCFFCC;
	padding:3px;
	font-size:17px;
}

input.button {
	margin-top:5px;
	height:25px;
	font-size:13px;
}

-->
</style>

<!--[if lt IE 7]>
<script defer type="text/javascript" src="pngfix.js"></script>
<![endif]-->

</head>

<body>

<div id=gradient><img src=gradient.png /></div>

<div class=ur>
<a href="login.php">Login</a> | 
<a href="register.php">Register</a>
</div>

<div id=title><img src=title.png /></div>

<div id=slick_bar>
<a href="#">Already a user?</a>
<a href="#">New to IV Housing?</a>
</div>

<div id=login_box>
<form action="login.php?redir=home.php" method="post" ENCTYPE="multipart/form-data">
Username <br /><input type="text" name="user" size="15" class="textarea"><br />
Password <br /><input type="password" name="pass" size="15" class="textarea"><br />
<input type="hidden" name="submitted" value="1">
<input type="submit" value="Log Me In!" class="button">
</form>
</div>

<div id=register_box>
<form action="register.php" method="post" ENCTYPE="multipart/form-data">
Username <br /><input type="text" name="user" size="15" class="textarea"><br />
Password <br /><input type="password" name="pass" size="15" class="textarea"><br />
Confirm <br /><input type="password" name="confirm" size="15" class="textarea"><br />
Email <br /><input type="text" name="email" size="15" class="textarea"><br />
<input type="hidden" name="submitted" value="1">
<input type="submit" value="Sign Me Up!" class="button">
</form>
</div>

<a href="guest_login.php">
<div id=try>
Give it a try and start looking at Isla Vista properties now.
<h2><a href="guest_login.php">Login as a guest.</a></h2>
</div>
</a>



</body>
</html>
