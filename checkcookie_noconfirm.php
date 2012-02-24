<?php

include('checkcookie_nofwd.php');

if ( !$loggedin )
{
	header( "Location: http://www.islavistahousing.com/" ) ;
}

?>