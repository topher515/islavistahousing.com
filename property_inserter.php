<?php
 
include('checkcookie.php'); 

if ( mysql_result($result,0,'userType') != 'landlord' && mysql_result($result,0,'userType') != 'admin' )
{
	header("Location: ./home.php");
}

if ( $_POST['submitted'] )
{
	
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
			`propImageData`
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
			''
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
			`propHasParking` = '$prophasparking'
			WHERE `propId` = '${_POST['propid']}' AND `propOwner` = '${_COOKIE['islavistahousing-id']}';";
	
	}
		
	$result = mysql_query($query);
} 


?>