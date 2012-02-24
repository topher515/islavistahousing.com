<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PHP Tester</title>
</head>

<body>

<?php include ('utilities.php'); ?>

<?php 

$success = checkLogin($_POST['user']);
if ( $success )
	echo "User success <br>";

$success = checkPassword($_POST['pass']);
if ( $success )
	echo "Password success <br>";

$success = checkEmail($_POST['email']);
if ( $success )
	echo "Email success <br>";

?>

<div id=register_box>
<form action="php_tester.php" method="post" ENCTYPE="multipart/form-data">
Username <input type="text" name="user" value="<?php $_POST['user']?>" size="15"><br />
Password <input type="password" name="pass" size="15"><br />
Confirm <input type="password" name="confirm"  size="15"><br />
Email <input type="text" name="email" value="<?php $_POST['email']?>" size="15"><br />
<input type="hidden" name="submitted" value="1">
<input type="submit" value="Let's try again!">
</form>
</div>



</body>
</html>
