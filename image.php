<?php
if(isset($_GET['propid'])) 
{
	include('std_connect.php');
	
	$id    = $_GET['propid'];
	$query = "SELECT propImage, propImageSize, propImageType " .
			 "FROM tbl_properties WHERE propId = '$id'";
	
	$result = mysql_query($query) or die('Error, query failed');
	list($content, $size, $type) = mysql_fetch_array($result);
	
	header("Content-length: $size");
	header("Content-type: $type");
	header("Content-Disposition: attachment; filename=$id");
	echo $content;
	
	mysql_close($cnxn);
	
	exit;
}
?>