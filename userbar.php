
<div id="userbar">

Welcome,

<a href="account.php">
<?php 
$result = mysql_query("SELECT * FROM tbl_users WHERE userLogin = '${_COOKIE['islavistahousing-id']}'");
?>

<?php 
if ( mysql_result($result,0,'userRealName') )
{
	echo mysql_result($result,0,'userRealName');
}
else
{
	echo mysql_result($result,0,'userLogin');
}
?>
</a>

| <a href="help.php">Help</a> | <a href="logout.php">Logout</a>

</div>