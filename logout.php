<?php 
if ( isset($_COOKIE['islavistahousing-id']) )
{
	setcookie("islavistahousing-id", $_COOKIE['islavistahousing-id'], time()-3600); 
	setcookie("islavistahousing-key", $_COOKIE['islavistahousing-key'], time()-3600); 
}

header("Location: http://www.islavistahousing.com/");

?>