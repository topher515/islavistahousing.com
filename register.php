<?php
include ('std_connect.php');
include ( 'utilities.php' );

/************* process registration *************/

if ( $_POST['submitted'] )
{
	
	srand(time());
	
	$valid_user_login = checkLogin($_POST['user']);
	
	#check in database
	$result = mysql_query("SELECT * FROM tbl_users WHERE userLogin = '" . $temp_user . "'");
	if ( mysql_num_rows($result) > 0 ) {
		$in_use = 1;
	}
	else {
		$in_use = 0;
	}
	
	$pass_confirmed = 0;
	if ( $_POST['pass'] == $_POST['confirm'] )
	{
		$pass_confirmed = 1;
		$valid_user_password = checkPassword($_POST['pass']);
	}
	
	$valid_user_email = checkEmail($_POST['email']);
	
	$conf_code = 0;
	
	if ( $valid_user_login && !$in_use && $valid_user_password && $valid_user_email )
	{
		$conf_code = rand();
	
		# register in database
		$query ="INSERT INTO `tbl_users` ( `userLogin`, `userPass`, `userEmail`, `userEmailList`, `userRegister`, `userLastLogin`, `userConfirmCode`, `userConfirmed` ) 
					 VALUES ( '" . $_POST['user'] . "', '" . $_POST['pass'] . "', '" . $_POST['email'] . "', '0', '"
								 . date('Y-m-d') . " 00:00:00', '0000-00-00 00:00:00', '" . $conf_code . "', '0');"; 
		$success = mysql_query($query);
		//echo $success;
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing - Registration</title>
<style type="text/css">
<!--

@import url("std_page.css");

-->
</style>
</head>

<body>


<?php include('std_page_top_nomenu.php'); ?>


<?php 
if ( $_POST['submitted'] ) {

	if ( $success )  { 
	?>
        
        <?php 
		# SEND THE EMAIL
		
		mail($_POST['email'], 'Welcome to IslaVistaHousing',
        'Someone registered for an account at IslaVistaHousing.com with this email address!
		
		Use this code to confirm that you are registered: '.$conf_code.'
        
        Or just goto: http://www.islavistahousing.com/confirm.php?code='.$conf_code.'
        
        If you have no idea what this is, just ignore it and it will all go away!
        
        -The I.V. Housing Master Registrar');
         ?>
        
        <?php
		# LOG THEM IN
		# MAKE COOKIE (only applicable for login page)
		/*
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
				mysql_query("UPDATE tbl_users SET userLastLogin = '" . date(Y-m-d) . " 00:00:00' WHERE userLogin = '${_POST['user']}'");
				
			}
			else 
			{
				$badpass = 1;
			}
		}
	
		*/
		?>
        
        
        <h2>An email has be sent to <?php echo $_POST['email'] ?>.</h2>
        <p>Please goto the <a href="confirm.php">confirmation</a> page or click on the link in the email to confirm your email address.</p>
        
	<?php } else { ?>
        
        <h2>Registration failed!</h2>
            
        <?php if ( !$valid_user_login ) { ?>
            
            <p>The username you're trying to use is invalid!</p>
            <p>Please just use alphanumerics (numbers and letters to the rest of us), hyphens, and underscores.
            Also it can't be crazy-long. Thirty-two characters is the max.</p>
        
        <?php } else if ( $in_use ) { ?>
        
            <p>The username you're trying to use is already in use!</p>
            <p>Sorry! Try a different one. Don't give up!</p>
        
        <?php } else if ( !$valid_user_email ) { ?>
        
     	   <p>That doesn't seem to be a valid email address, try again!</p>
        
        <?php } else if ( !$pass_confirmed ) { ?>
        
     	   <p>Your password and confirmation don't match!</p>
        
        <?php } else if ( !$valid_user_password ) { ?>
        
     	   <p>Your password and confirmation don't match!</p>
        
        
        <?php } else { ?>
        
            <p>Something went horribly wrong!</p>
            <p>So sorry, please send us an <a href="mailto:sysadmin@islavistahousing.com">email!</a></p>
        
        <?php } ?>

		<h2>Registration</h2>

        <div id=register_box>
        <form action="register.php" method="post" ENCTYPE="multipart/form-data">
        Username <input type="text" name="user" value="<?php $_POST['user']?>" size="15" class="textarea"><br />
        Password <input type="password" name="pass" size="15" class="textarea"><br />
        Confirm <input type="password" name="confirm"  size="15" class="textarea"><br />
        Email <input type="text" name="email" value="<?php $_POST['email']?>" size="15" class="textarea">
        (We promise not to spam you! <a href="privacy_policy.php">Privacy Policy</a>)<br />
        <input type="hidden" name="submitted" value="1">
        <input type="submit" value="Let's try again!" class="button">
        </form>
        </div>

	<?php } # END - Success Else
	
}
else { # if not submitted ?>
	
    <h2>Registration</h2>
    
    <div id=register_box>
    <form action="register.php" method="post" ENCTYPE="multipart/form-data">
    Username <input type="text" name="user" value="<?php $_POST['user']?>" size="15" class="textarea"><br />
    Password <input type="password" name="pass" size="15" class="textarea"><br />
    Confirm <input type="password" name="confirm"  size="15" class="textarea"><br />
    Email <input type="text" name="email" value="<?php $_POST['email']?>" size="15" class="textarea">
    (We promise not to spam you! <a href="privacy_policy.php">Privacy Policy</a>)<br />
    <input type="hidden" name="submitted" value="1">
    <input type="submit" value="Set me up!" class="button">
    </form>
    </div>
<? }

mysql_close($cnxn);

?>

<?php include('std_page_bottom.php'); ?>

</body>
</html>
