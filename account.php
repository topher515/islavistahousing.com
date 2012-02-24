<?php include('checkcookie.php'); 

if ( $_POST['submitted'] )
{
	$result = mysql_query("UPDATE tbl_users SET userRealName = '${_POST['realname']}', userWebsite = '${_POST['website']}'
							WHERE userLogin = '${_COOKIE['islavistahousing-id']}'");
}

if ( $_COOKIE['islavistahousing-id'] == 'guest' )
{
	header("Location: ./home.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing - Account</title>
<style type="text/css">
<!--

@import url("std_page.css");

-->
</style>
</head>

<body>

<?php include('userbar.php'); ?>

<?php include('std_page_top.php'); ?>

<h2>Account Management</h2>

<div id=account_box>
<form action="account.php" method="post" ENCTYPE="multipart/form-data">
<table border=0 cellpadding=5>
<tr>
	<td class=left>Username:</td><td class=right><?php echo mysql_result($result,0,'userLogin'); ?></td>
</tr>
<tr>
	<td class=left>Real Name:</td>
    <td class=right>
	<input type="text" name="realname" size="30" class="textarea" 
    	value="<?php echo mysql_result($result,0,'userRealName'); ?>" />
    </td>
</tr>
<tr>
	<td class=left>E-Mail:</td>
    <td class=right>
	<?php echo mysql_result($result,0,'userEmail'); ?>
    </td>
</tr>
<tr>
	<td class=left>Website:</td>
    <td class=right>
    http://<input type="text" name="website" size="40" class="textarea" 
    	value="<?php echo mysql_result($result,0,'userWebsite'); ?>" />
    </td>
</tr>
<tr>
	<td class=left>User Type:</td>
    <td class=right>
    <?php 
		if ( mysql_result($result,0,'userType') == 'admin')
		{
			echo "Website Administrator";
		}
		else if ( mysql_result($result,0,'userType') == 'landlord')
		{
			echo "Landlord";
		}
		else
		{
			echo "Renter";
		}
	?>
    </td>
</tr>
<tr>
	<td class=left><input type="hidden" name="submitted" value="1"></td>
    <td class=right>
	<input type="submit" value="Update My Info" class="button">
    </td>
</tr>
</table>
</form>
</div>

<?php include('std_page_bottom.php'); ?>

</body>
</html>
