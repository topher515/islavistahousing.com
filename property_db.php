<?php
 
include('checkcookie.php'); 

if ( mysql_result($result,0,'userType') != 'landlord' && mysql_result($result,0,'userType') != 'admin' )
{
	header("Location: ./home.php");
}

if ( $_POST['submitted'] )
{
	/* image file upload code burrows heavily from http://www.php-mysql-tutorial.com/php-mysql-upload.php */
	if( $_FILES['userfile']['size'] > 0)
	{
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		
		if(!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
		}
		
		#echo $fileSize;
		#echo $fileType;
	} 
	
	
	$propbedroomlayout = "";
	$i = 0;
	while ( $i < $_POST['propbedroomnum'] )
	{
		$propbedroomlayout = $propbedroomlayout . $_POST[('br' . ($i+1))];
		if ( $i+1 < $_POST['propbedroomnum'] )
		{
			$propbedroomlayout = $propbedroomlayout . ',';
		}
		$i++;
	}
	
	$prophasparking = 0;
	if ( $_POST['propparking'] == 'on' )
	{
		$prophasparking = 1;
	}
		
	$prophaslaundry = 0;
	if ( $_POST['proplaundry'] == 'on' )
	{
		$prophaslaundry = 1;
	}
	
	$propisavailable = 0;
	if ( $_POST['propavailable'] == 'on' )
	{
		$propisavailable = 1;
	}
		
	if ( $_POST['new'] )
	{	
		
		$query =
		"INSERT INTO `tbl_properties` (
			`propId` ,
			`propOwner` ,
			`propAddressNum` ,
			`propAddressStreet` ,
			`propAptNum` ,
			`propRent` ,
			`propBedroomNum` ,
			`propBathroomNum` ,
			`propHalfBathNum` ,
			`propMaxOccupants` ,
			`propBedroomLayout` ,
			`propDescription` ,
			`propHasParking` ,
			`propHasLaundry`,
			`propIsAvailable`,
			`propImage`,
			`propImageSize`,
			`propImageType`
		)
			VALUES (
			'${_POST['propid']}',  
			'${_POST['propowner']}',  
			'${_POST['propaddressnum']}',  
			'${_POST['propaddressstreet']}',  
			'${_POST['propaptnum']}',  
			'${_POST['proprent']}',  
			'${_POST['propbedroomnum']}',  
			'${_POST['propbathroomnum']}',  
			'${_POST['prophalfbathnum']}',  
			'${_POST['propmaxoccupants']}',  
			'$propbedroomlayout', 
			'${_POST['propdescription']}', 
			'$prophasparking',
			'$prophaslaundry',
			'$propisavailable',
			'$content',
			'$fileSize',
			'$fileType'
		);";
		
	}
	else {
		$query =
		"UPDATE `tbl_properties` SET
			`propAddressNum` = '${_POST['propaddressnum']}',
			`propAddressStreet` = '${_POST['propaddressstreet']}',
			`propAptNum` = '${_POST['propaptnum']}',
			`propRent` = '${_POST['proprent']}',
			`propBedroomNum` = '${_POST['propbedroomnum']}',
			`propBathroomNum` ='${_POST['propbathroomnum']}',
			`propHalfBathNum` ='${_POST['prophalfbathnum']}',
			`propMaxOccupants` = '${_POST['propmaxoccupants']}',
			`propBedroomLayout` = '$propbedroomlayout',
			`propDescription` = '${_POST['propdescription']}',
			`propHasParking` = '$prophasparking',
			`propHasLaundry` = '$prophaslaundry',
			`propIsAvailable` = '$propisavailable',
			`propImage` = '$content',
			`propImageSize` = '$fileSize',
			`propImageType` = '$fileType'
			WHERE `propId` = '${_POST['propid']}' AND `propOwner` = '${_COOKIE['islavistahousing-id']}';";
	
	}
	#echo $query;
	
	$result = mysql_query($query) or die('Error, query failed'); 
} 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing - Property Details</title>


</head>

<?php if ( $_POST['submitted'] ) { ?>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAoPiBsmpxwAZ0bOSVpdBUUhR55p2ZQUy3Eykb3bGLwPdmFyN0oxT9MYZAKDNJ_o8CdpGwuMwYRQl8WQ"
      type="text/javascript"></script>
      
<script type="text/javascript">
<!--

    function load() {
		
		var address = '<?php echo $_POST['propaddressnum'] . " " . $_POST['propaddressstreet'] . ", Goleta, CA, 93117"; ?>';
		
		var geocoder = new GClientGeocoder();
		
		geocoder.getLatLng(
			address,
			function(point) {
				if (!point) {
				  	//alert(address + " not found");
					window.location = "./property.php?propid=<?php echo $_POST['propid']; ?>&bad=1";
				} else {
					//alert(address + " FOUND!");
					window.location = "./property.php?propid=<?php echo $_POST['propid']; 
						if ( $_POST['new'] ) { echo "&new=1"; } else { echo "&old=1"; }
					?>&lat=" + point.lat() + "&lon=" + point.lng();
				}
			}
		);
		
    }

-->
</script>

<?php } ?>

<body onload="load();">

</body>
</html>


