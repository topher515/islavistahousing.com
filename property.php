<?php include('checkcookie.php'); 
if ( mysql_result($result,0,'userType') == 'renter' && !$_GET['propid'] )
{
	header("Location: ./home.php");
}

if ( $_GET['propid'] && $_GET['lat'] && $_GET['lon'] )
{
	mysql_query("UPDATE tbl_properties SET propLat = '${_GET['lat']}', propLon = '${_GET['lon']}' WHERE propId = '${_GET['propid']}';");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing - Property Details</title>
<style type="text/css">
<!--

@import url("std_page.css");
@import url("property.css");

-->
</style>

</head>

<body>

<?php include('userbar.php'); ?>
<?php include('std_page_top.php'); ?>

<?php 
if ( $_GET['propid'] )  
/*************************** PRE-EXISTING PROPERTY *********************************/
{
	$prop_query = "SELECT * FROM `tbl_properties` WHERE `propId` = '${_GET['propid']}'";
	$prop_result = mysql_query($prop_query);
	
	if ( ( mysql_result($result,0,'userType') == 'landlord' && mysql_result($result,0,'userLogin') == mysql_result($prop_result,0,'propOwner') ) 
		|| mysql_result($result,0,'userType') == 'admin'  )
	{
		if ( $_GET['new'] ) { # note that we assumed that it worked!
			?>
			<h3>You successfully uploaded your new property!</h3>
			<?php
		}
		else if ( $_GET['old'] ) {
			?>
			<h3>You successfully edited your property!</h3>
			<?php
		}
		else if ( $_GET['bad'] ) {
			?>
			<h3>You're property was added but we couldn't find the address.<br />Did you mis-type it?</h3>
			<?php
		}
		?>
	
		<p>You may edit the details of your property.</p>
	
		<div id=property_box>
		<form action="<?php echo 'property_db.php?propid=' . $_GET['propid']; ?>" method="post" ENCTYPE="multipart/form-data">
		<table border=0 cellpadding=5>
			<input type="hidden" name="propid" value="<?php echo mysql_result($prop_result,0,'propId'); ?>" />
		<tr>
			<td class=left>Address:</td>
			<td class=right>
				<input type="text" name="propaddressnum" size="6" class="textarea" 
					value="<?php echo mysql_result($prop_result,0,'propAddressNum'); ?>"/>
				<input type="text" name="propaddressstreet" size="29" class="textarea" 
					value="<?php echo mysql_result($prop_result,0,'propAddressStreet'); ?>" />
				<input type="text" name="propaptnum" size="3" class="textarea" 
					value="<?php echo mysql_result($prop_result,0,'propAptNum'); ?>" /><br /> (Leave apt blank if none.)
			 </td>
		</tr>
		<tr>
			<td class=left>Rent:</td>
			<td class=right>
				 <input type="text" name="proprent" size="20" class="textarea" 
					value="<?php echo mysql_result($prop_result,0,'propRent'); ?>" />
			</td>
		</tr>
		<tr>
			<td class=left>Rooms:</td>
			<td class=right>
				<table border=0 cellpadding=0 cellpadding=0>
					<tr>
						<td>How many?</td>
						<?php 
						$numrooms = mysql_result($prop_result,0,'propBedroomNum'); 
						for( $i=1; $i <= 7; $i++ ) {
						?>
						<td><?php echo $i; ?><INPUT type="radio" name="propbedroomnum" 
							value="<?php echo $i; ?>" class="room_radio" 
							<?php if ($i == $numrooms) { echo 'CHECKED'; } ?> /></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>How many people per?</td>
						<?php 
						
						$layout = mysql_result($prop_result,0,'propBedroomLayout');
						
						for( $i=1; $i <= 7; $i++ ) {
							if ( !empty($layout) )
							{
								$thisroomsize = substr($layout,0,1);
								$layout = substr($layout,2);
							}
							else {
								$thisroomsize = 0;
							}
						
							?>
							<td><INPUT type="text" name="br<?php echo $i; ?>" size="3"
								value="<?php echo $thisroomsize; ?>" class="textarea" /></td>
						<?php } ?>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class=left>Occupancy:</td>
			<td class=right>
				 Max Occupants:<input type="text" name="propmaxoccupants" size="12" class="textarea" 
					value="<?php echo mysql_result($prop_result,0,'propMaxOccupants') ?>" />
			</td>
		</tr>
		<tr>
			<td class=left>Bathrooms:</td>
			<td class=right>
				 Full Baths:<input type="text" name="propbathroomnum" size="12" class="textarea" 
					value="<?php echo mysql_result($prop_result,0,'propBathroomNum') ?>" />
				 Half Baths:<input type="text" name="prophalfbathnum" size="12" class="textarea" 
					value="<?php echo mysql_result($prop_result,0,'propHalfbathNum') ?>" />
			</td>
		</tr>
		<tr>
			<td class=left>Description:</td>
			<td class=right>
				 <textarea cols=35 rows=5 name="propdescription" ><?php echo mysql_result($prop_result,0,'propDescription') ?>
				 </textarea>
			</td>
		</tr>
		<tr>
			<td class=left>Parking:</td>
			<td class=right>
				 <input type="checkbox" name="propparking" 
				 <?php if ( mysql_result($prop_result,0,'propHasParking') ) { echo "CHECKED"; } ?>
				 /> Yes, there is a off-street parking. (e.g. driveway)
			</td>
		</tr>
		<tr>
			<td class=left>Laundry:</td>
			<td class=right>
				 <input type="checkbox" name="proplaundry" 
				 <?php if ( mysql_result($prop_result,0,'propHasLaundry') ) { echo "CHECKED"; } ?>
				 /> Yes, there are laundry facilities.
			</td>
		</tr>
		<tr>
			<td class=left>Availability:</td>
			<td class=right>
				 <input type="checkbox" name="propavailable" 
				 <?php if ( mysql_result($prop_result,0,'propIsAvailable') ) { echo "CHECKED"; } ?>
				 /> Available for rental / currently looking for tentants.
			</td>
		</tr>
		<tr>
			<td class=left>Image:</td>
			<td class=right>
            	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
				 <input type="file" name="userfile" size="35" class="textarea" />
                 
			</td>
		</tr>
		<tr>
			<td class=left></td>
			<td class=right>
				 <input type="submit" value="Submit Property Info" class="button" />
			</td>
		</tr>
		</table>
		
		<input type="hidden" name="submitted" value="1" />
		</form>
		</div>
        
 	
	<?php } else { ?>
        <?php if ( mysql_result($prop_result,0,'propImageSize') != 0 ) { ?>
        <img style="float:right;" src="image.php?propid=<?php echo $_GET['propid'] ?>"  height="250px" border=0 />
        <?php } ?>
		
    	<div id="top_stuff" <?php if ( mysql_result($prop_result,0,'propImageSize') != 0 ) { ?> style="margin-bottom:100px;" <?php } ?>>
    	  	<h2><?php echo mysql_result($prop_result,0,'propAddressNum'); ?>
                <?php echo mysql_result($prop_result,0,'propAddressStreet'); ?>
                <?php if ( mysql_result($prop_result,0,'propAptNum') ) {
                    echo " #" . mysql_result($prop_result,0,'propAptNum');
                } ?>
        	</h2>
        	(<a href="map.php?propid=<?php echo mysql_result($prop_result,0,'propId'); ?>">Map it!</a>)
            
            <p>
            The <?php echo mysql_result($prop_result,0,'propAddressNum'); ?>
            <?php echo mysql_result($prop_result,0,'propAddressStreet'); ?>
            property is managed by <?php 
            $owner = mysql_result($prop_result,0,'propOwner');
            $realownerresult = mysql_query("SELECT * FROM tbl_users WHERE userLogin = '$owner';" );
            echo mysql_result($realownerresult,0,'userRealName');
            ?>. 
            <?php 
            if (  mysql_result($prop_result,0,'propWebsite') ) {
                ?>You can read more about this property on the management company website at <a href="http://<?php
                echo mysql_result($prop_result,0,'propWebsite');?>" target="_blank" ><?php
                echo mysql_result($prop_result,0,'propWebsite');?></a>.
                <?php
            } 
            else if ( mysql_result($realownerresult,0,'userWebsite') )
            {
                ?>Check out the management company website at <a href="http://<?php
                echo mysql_result($realownerresult,0,'userWebsite');?>" target="_blank" ><?php
                echo mysql_result($realownerresult,0,'userWebsite');?></a>.<?php
            
            }
            ?>
    		</p>
        </div>
        
  
        <div id=property_box>
        <table border=0 cellpadding=5>
        <tr>
            <td class=left>Rent:</td>
            <td class=right>
                    $<?php echo mysql_result($prop_result,0,'propRent'); ?>
            </td>
        </tr>
        <tr>
            <td class=left>Rooms:</td>
            <td class=right>
                <?php echo mysql_result($prop_result,0,'propBedroomNum'); ?> rooms. 
                Tenants per room: <?php echo mysql_result($prop_result,0,'propBedroomLayout'); ?>		
            </td>
        </tr>
        <tr>
            <td class=left>Max Occupancy:</td>
            <td class=right>
                 <?php echo mysql_result($prop_result,0,'propMaxOccupants'); ?>
            </td>
        </tr>
        <tr>
            <td class=left>Bathrooms:</td>
            <td class=right>
                 Full Baths: <?php echo mysql_result($prop_result,0,'propBathroomNum'); ?>
                 Half Baths: <?php echo mysql_result($prop_result,0,'propHalfbathNum'); ?>
            </td>
        </tr>
        <tr>
            <td class=left>Description:</td>
            <td class=right>
                 <?php echo mysql_result($prop_result,0,'propDescription') ?>
            </td>
        </tr>
        <tr>
            <td class=left>Parking:</td>
            <td class=right>
                 <input type="checkbox" name="propparking" 
                 <?php if ( mysql_result($prop_result,0,'propHasParking') ) { echo "CHECKED"; } ?>
                 /> Yes, there is a off-street parking. (e.g. driveway)
            </td>
        </tr>
        <tr>
            <td class=left>Laundry:</td>
            <td class=right>
                 <input type="checkbox" name="proplaundry" 
                 <?php if ( mysql_result($prop_result,0,'propHasLaundry') ) { echo "CHECKED"; } ?>
                 /> Yes, there are laundry facilities.
            </td>
        </tr>
        <tr>
            <td class=left>Availability:</td>
            <td class=right>
                 <input type="checkbox" name="propavailable" 
                 <?php if ( mysql_result($prop_result,0,'propIsAvailable') ) { echo "CHECKED"; } ?>
                 /> Available for rental / currently looking for tentants.
            </td>
        </tr>
        </table>
        
        </div>
        
        
        
        <h6>The information on this page is copyright <?php echo mysql_result($realownerresult,0,'userRealName'); ?></h6>
        
    <?php } 

} else { 
/*************************** NEW PROPERTY *********************************/

	if ( ( mysql_result($result,0,'userType') == 'landlord' ) 
		|| mysql_result($result,0,'userType') == 'admin'  )
	{
	

        
        srand(time());
        $propid = rand();
    
        ?>
    
        <p>Please enter the details of the new property.</p>
    
        <div id=property_box>
        <form action="<?php echo 'property_db.php?propid=' . $propid; ?>?" method="post" ENCTYPE="multipart/form-data">
        <table border=0 cellpadding=5>
            <input type="hidden" name="propid" value="<?php echo $propid; ?>" />
            <input type="hidden" name="propowner" value="<?php echo $_COOKIE['islavistahousing-id']; ?>" />
        <tr>
            <td class=left>Address:</td>
            <td class=right>
                <input type="text" name="propaddressnum" size="6" class="textarea" value="Num"/>
                <input type="text" name="propaddressstreet" size="29" class="textarea" value="Street Name" />
                <input type="text" name="propaptnum" size="3" class="textarea" value="Apt" /><br /> (Leave apt blank if none.)
             </td>
        </tr>
        <tr>
            <td class=left>Rent:</td>
            <td class=right>
                 $<input type="text" name="proprent" size="20" class="textarea" value="In Dollars (Ex:2400.00)" />
            </td>
        </tr>
        <tr>
            <td class=left>Rooms:</td>
            <td class=right>
                <table border=0 cellpadding=0 cellpadding=0>
                    <tr>
                        <td>How many?</td>
                        <td>1<INPUT type="radio" name="propbedroomnum" value="1" class="room_radio" CHECKED ></td>
                        <td>2<INPUT type="radio" name="propbedroomnum" value="2" class="room_radio"></td>
                        <td>3<INPUT type="radio" name="propbedroomnum" value="3" class="room_radio"></td>
                        <td>4<INPUT type="radio" name="propbedroomnum" value="4" class="room_radio"></td>
                        <td>5<INPUT type="radio" name="propbedroomnum" value="5" class="room_radio"></td>
                        <td>6<INPUT type="radio" name="propbedroomnum" value="6" class="room_radio"></td>
                        <td>7<INPUT type="radio" name="propbedroomnum" value="7" class="room_radio"></td>
                    </tr>
                    <tr>
                        <td>How many people per?</td>
                        <td><input type="text" name="br1" size="3" class="room_text" /></td>
                        <td><input type="text" name="br2" size="3" class="room_text" /></td>
                        <td><input type="text" name="br3" size="3" class="room_text" /></td>
                        <td><input type="text" name="br4" size="3" class="room_text" /></td>
                        <td><input type="text" name="br5" size="3" class="room_text" /></td>
                        <td><input type="text" name="br6" size="3" class="room_text" /></td>
                        <td><input type="text" name="br7" size="3" class="room_text" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class=left>Occupancy:</td>
            <td class=right>
                 Max Occupants:<input type="text" name="propmaxoccupants" size="8" class="textarea" value="Max Occupancy" />
            </td>
        </tr>
        <tr>
            <td class=left>Bathrooms:</td>
            <td class=right>
                 Full Baths:<input type="text" name="propbathroomnum" size="8" class="textarea" value="# Full Baths" />
                 Half Baths: <input type="text" name="prophalfbathnum" size="8" class="textarea" value="# Half Baths" />
            </td>
        </tr>
        <tr>
            <td class=left>Description:</td>
            <td class=right>
                 <textarea cols=35 rows=5 name="propdescription" >Enter a description of your property here. Try to keep it simple and eloquent. This is probably a good spot for special information too.
                 </textarea>
            </td>
        </tr>
        <tr>
            <td class=left>Parking:</td>
            <td class=right>
                 <input type="checkbox" name="propparking" /> Yes, there is a place to park. (e.g. driveway)
            </td>
        </tr>
        <tr>
            <td class=left>Laundry:</td>
            <td class=right>
                 <input type="checkbox" name="proplaundry" /> Yes, there are laundry facilities.
            </td>
        </tr>
        <tr>
            <td class=left>Availability:</td>
            <td class=right>
                 <input type="checkbox" name="propavailable" /> Available for rental / currently looking for tentants.
            </td>
        </tr>
        <tr>
            <td class=left>Image:</td>
            <td class=right>
                 <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
				 <input type="file" name="userfile" size="35" class="textarea" />
            </td>
        </tr>
        <tr>
            <td class=left></td>
            <td class=right>
                 <input type="submit" value="Submit Property Info" class="button" />
            </td>
        </tr>
        </table>
        
        <input type="hidden" name="submitted" value="1" />
        <input type="hidden" name="new" value="1" />
        </form>
        </div>
        

	<?php } else { ?>
    	
        <p> Something went wrong: Renters can't enter new property information. </p>
    	
    <?php } ?>

<?php } # End?>



<?php include('std_page_bottom.php'); ?>

</body>
</html>