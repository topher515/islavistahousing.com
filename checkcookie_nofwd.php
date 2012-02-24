<?php

include('std_connect.php');

$loggedin = 0;
$baduser = 0;
$badpass = 0;
$badcookie = 0;
$confirmed = 0;


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
			$confirmed = mysql_result($result,0,'userConfirmed');
		}
		else
		{
			$badcookie = 1;
		}
	}
}

?>