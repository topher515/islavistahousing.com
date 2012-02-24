<?php

# standard connection info
$db_user = 'ivhadmin';
$db_pass = 'mothba11';
$db_addr = 'topher515.fatcowmysql.com';
$db_name = 'islavistahousing';
 
$cnxn = mysql_connect($db_addr, $db_user, $db_pass);
mysql_select_db($db_name) or die("Unable to select DB.");

?>