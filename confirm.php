<?php

include('checkcookie_nofwd.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Confirm Email Address</title>
<style type="text/css">
<!--

@import url("std_page.css");

-->
</style>
</head>

<body>


<?php include('std_page_top_nomenu.php'); ?>


<?php 
$query = "SELECT * FROM tbl_users WHERE userLogin = '${_COOKIE['islavistahousing-id']}'";
$result = mysql_query($query); 
?>

<?php if ( !$loggedin ) { ?>
	
    <p> Please login before confirming!</p>
    
    <div id=login_box>
    <form action="login.php?redir=confirm.php" method="post" ENCTYPE="multipart/form-data">
    Username <input type="text" name="user" size="15" class="textarea"><br />
    Password <input type="password" name="pass" size="15" class="textarea"><br />
    <input type="hidden" name="submitted" value="1" ><br />
    <input type="submit" value="Log me in!" class="button">
    </form>
    </div>
    

<?php } else { # are logged in ?>

	<?php include('userbar.php'); ?>


	<?php if ( mysql_result($result,0,'userConfirmed' ) ) { ?>
		<h2> Already confirmed! </h2>
        
        <p>You don't need to confirm anything!</p>
		<p>Why not goto your <a href="home.php">homepage</a>!</p>

	<?php } else if ( !$_GET['code'] ) { ?>
    
        <h2> Confirm Your Email Address </h2>
        
        <p> Hi, <?php echo mysql_result($result,0,'userLogin') ?>, thanks for registering with IslaVistaHousing! Please enter your confirmation code which was sent to the email address <?php echo mysql_result($result,0,'userEmail') ?>.</p>
        
        <div id=confirm_box>
        <form action="confirm.php" method="get">
        Confirmation code: <input type="text" name="code" size="15" class="textarea"><br />
        <input type="submit" value="Confirm me please!" class="button">
        </form>
        </div>
        
        <p>If you never received your confirmation email check your spam mailbox and you can try <a href="#">resending</a> it.</p>
    
    <?php } else { # we have the code lets check it! ?>
    
        <?php if ( $_GET['code'] == mysql_result($result,0,'userConfirmCode') ) { ?>
    
            <?php mysql_query("UPDATE tbl_users SET userConfirmed='1' WHERE userLogin = '${_COOKIE['islavistahousing-id']}'"); ?>
    
            <h2> You're Confirmed! </h2>
            
            <p>You have successfully confirmed your email address. Thanks!</p>
            <p>Why don't you check out your <a href="home.php" >homepage</a>!</p>
            
        <?php } else { ?>
        
            <h2> Bad Confirm Code </h2>
            
            <p>Whoops! The confirmation code you provided doesn't match our records!</p>
            <p>Check the email we sent and try again!</p>
            
        <?php } ?>
        
    <?php } ?>

<?php } ?>



<?php mysql_close($cnxn); ?>

<?php include('std_page_bottom.php'); ?>

</body>
</html>
