<?php

include ('std_connect.php');

$loggedin = 0;
$baduser = 0;
$badpass = 0;
$badcookie = 0;


$loggedin = 1;
setcookie("islavistahousing-id", 'guest', time()+3600);
setcookie("islavistahousing-key", hash('md5', 'guest' . 'zonker1'), time()+3600);
$loginquery = "UPDATE tbl_users SET userLastLogin = '" . date('Y-m-d') . " 00:00:00' WHERE userLogin = '${_POST['user']}';";
#echo time();
mysql_query($loginquery);

if ( $redir )
{
	header( "Location: http://www.islavistahousing.com/$redir" ) ;
}
else 
{
	header( "Location: http://www.islavistahousing.com/home.php" ) ;
}

?>
