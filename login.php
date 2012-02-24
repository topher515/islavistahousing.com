<?php

include ('std_connect.php');

$loggedin = 0;
$baduser = 0;
$badpass = 0;
$badcookie = 0;


# CHECK COOKIE
if(isset($_COOKIE['islavistahousing-id']) &&
	isset($_COOKIE['islavistahousing-key'])
	) 
{ 

	$query = "SELECT * FROM tbl_users WHERE userLogin = '${_COOKIE['islavistahousing-id']}'";
	//echo $query;
	$result = mysql_query($query);

	if ( mysql_numrows($result) == 0 )
	{
		$badcookie = 1;
	}
	else {
		$hashedKey = hash('md5', mysql_result($result,0,'userPass') . 'zonker1');

		if ( $_COOKIE['islavistahousing-key'] == $hashedKey )
		{
			$loggedin = 1;
		}
		else
		{
			$badcookie = 1;
		}
	}
}

# MAKE COOKIE (only applicable for login page)
else if ( $_POST['submitted'] )
{ 
	$query = "SELECT * FROM tbl_users WHERE userLogin = '${_POST['user']}'";
	$result = mysql_query($query);
	//echo $query;
	
	if ( mysql_numrows($result) == 0 )
	{
		$baduser = 1;
	}
	else {
	
		if ( $_POST['pass'] == mysql_result($result,0,'userPass') )
		{
			$loggedin = 1;
			setcookie("islavistahousing-id", $_POST['user'], time()+3600);
			setcookie("islavistahousing-key", hash('md5', $_POST['pass'] . 'zonker1'), time()+3600);
			$loginquery = "UPDATE tbl_users SET userLastLogin = '" . date('Y-m-d') . " 00:00:00' WHERE userLogin = '${_POST['user']}';";
			#echo time();
			mysql_query($loginquery);
			
		}
		else 
		{
			$badpass = 1;
		}
	}

}

if ( $loggedin )
{
	if ( $redir )
	{
		header( "Location: http://www.islavistahousing.com/$redir" ) ;
	}
	else 
	{
		header( "Location: http://www.islavistahousing.com/home.php" ) ;
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login</title>
<style type="text/css">
<!--

@import url("std_page.css");

-->
</style>
</head>

<body>

<?php include('std_page_top_nomenu.php'); ?>

<?php if ( $baduser || $badpass ) { ?>

<h2>Bad Username or Password</h2>
<p>You entered a bad 'username' or 'password'. Double check and try again.<br />
Be sure to check if your caps-lock key is on.<br />
Did you <a href="#">forget your password</a>? Do you still need to <a href="register.php">register</a>?
</p>

<?php } else if ( $badcookie ) { ?>

<h2>Bad Cookie</h2>
<p>There's something wrong with your cookie.</p>
<p>You should <a href="logout.php">logout</a> and log back in.</p>

<?php } ?>

<h2>Login</h2>

<div id=login_box>
<form action="login.php?redir=home.php" method="post" ENCTYPE="multipart/form-data">
Username <input type="text" name="user" size="15" class="textarea"><br />
Password <input type="password" name="pass" size="15" class="textarea"><br />
<input type="hidden" name="submitted" value="1">
<input type="submit" value="Log Me In, Scotty!" class="button">
</form>
</div>

<p>
Did you <a href="#">forget your password</a>? Do you still need to <a href="register.php">register</a>?
</p>


<?php include('std_page_bottom.php'); mysql_close($cnxn); ?>

</body>
</html>
