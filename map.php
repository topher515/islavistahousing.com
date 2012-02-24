<?php include('checkcookie.php'); ?>

<?php

if ( $_GET['propid'] )
{
	$prop_query = "SELECT * FROM tbl_properties WHERE `propId` = '${_GET['propid']}';";
}
if ( $_GET['submitted'] && $_GET['propowner'] )
{
	$prop_query = "SELECT * FROM `tbl_properties` WHERE propOwner = '${_GET['propowner']}' "
	."AND propRent >= '${_GET['rent1']}' AND propRent <= '${_GET['rent2']}' "
	."AND propMaxOccupants >= '${_GET['tenantnum1']}' AND propMaxOccupants <= '${_GET['tenantnum2']}';";
}
else if ( $_GET['submitted'] ) 
{
	$prop_query = "SELECT * FROM `tbl_properties` WHERE "
	."propRent >= '${_GET['rent1']}' AND propRent <= '${_GET['rent2']}' "
	."AND propMaxOccupants >= '${_GET['tenantnum1']}' AND propMaxOccupants <= '${_GET['tenantnum2']}';";
}
else if ( $_GET['view'] == 'all' || $_GET['view'] == "" )
{
	
	$prop_query = 'SELECT * FROM tbl_properties';
}
else if ( $_GET['view'] == 'mine' )
{
	$prop_query = "SELECT * FROM tbl_properties WHERE `propOwner` = '${_COOKIE['islavistahousing-id']}';";
	
}
else if ( $_GET['view'] == 'available' )
{
	$prop_query = "SELECT * FROM tbl_properties WHERE `propIsAvailable` = '1';";
	
}

$prop_result = mysql_query($prop_query);
$numprops = mysql_num_rows($prop_result);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing</title>

<style type="text/css">
<!--

@import url("std_page.css");
@import url("map.css");

-->
</style>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAoPiBsmpxwAZ0bOSVpdBUUhR55p2ZQUy3Eykb3bGLwPdmFyN0oxT9MYZAKDNJ_o8CdpGwuMwYRQl8WQ"
      type="text/javascript"></script>
<script type="text/javascript">

    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
		map.addControl(new GMapTypeControl());
		map.addControl(new GSmallMapControl());
        map.setCenter(new GLatLng(34.413,-119.86105), 15);
		
		
		var point;
		var marker;
		var iconGreen = new GIcon('house_green.png');
		iconGreen.image = 'house_green.png';
		iconGreen.shadow = 'house_green.png';
		iconGreen.iconSize = new GSize(19,19);
		iconGreen.shadowSize = new GSize(19,19);
		iconGreen.iconAnchor = new GPoint(6,20);
		iconGreen.infoWindowAnchor = new GPoint(5,1);
		var iconRed = new GIcon('house_red.png');
		iconRed.image = 'house_red.png';
		iconRed.shadow = 'house_red.png';
		iconRed.iconSize = new GSize(19,19);
		iconRed.shadowSize = new GSize(19,19);
		iconRed.iconAnchor = new GPoint(6,20);
		iconRed.infoWindowAnchor = new GPoint(5,1);
		
		<?php
		for ( $i = 0; $i < $numprops; $i++ )
		{
			$proplat = mysql_result($prop_result,$i,'propLat');
			$proplon = mysql_result($prop_result,$i,'propLon');
			if ( $proplat != 0 && $proplon != 0 )
			{ 
			?>
		point = new GLatLng(<?php echo $proplat; ?>,<?php echo $proplon; ?>);
				<?php if ( mysql_result($prop_result,$i,'propIsAvailable') ) { ?> 
		marker = new GMarker(point,{icon:iconGreen});
				<?php } else { ?>
		marker = new GMarker(point,{icon:iconRed});
				<?php } ?>
				
		GEvent.addListener(marker, "click", 
			function() {
    			window.location = "property.php?propid=<?php echo mysql_result($prop_result,$i,'propId'); ?>";
  			}
		);
		map.addOverlay(marker);
			<?php
			}
		}
		?>
      }
    }

    //]]>
</script>

</head>
<body onload="load()" onunload="GUnload()">

<?php include('userbar.php'); ?>

<?php include('std_page_top.php'); ?>

<h2>Mapping <?php 

if ( $_GET['propid'] )
{
	echo mysql_result($prop_result,0,'propAddressNum') . " " . 
                            mysql_result($prop_result,0,'propAddressStreet');
	if ( mysql_result($prop_result,0,'propAptNum') ) {
		echo " #" . mysql_result($prop_result,0,'propAptNum');
	}
}
else {
	if ( $_GET['view'] == all )
	{
		?>All Properties<?php
	}
	else if ( $_GET['view'] == all )
	{
		?>All Your Properties<?php
	}
	else if ( $_GET['view'] == available )
	{
		?>All Available Properties<?php
	}
}


 ?></h2>
<div id="map" style="width: 630px; height: 450px"></div>
<h6>Please note that the property positioning on the map is entirely automated by Google 
and, as such, there may be inaccuracies. This map should only be used as a guide.</h6>

<?php if ( $_GET['submitted'] ) { ?>
    	<form action="<?php echo $_SERVER['php self']; ?>" method="get" >
        Refine your listing:<br />
        <ul>
        <li>
        <select name="propowner">
        <option value="">Landlord</option>
        <?php 
        $landlords = mysql_query("SELECT * FROM tbl_users WHERE `userType` = 'landlord';");
        $numlandlords = mysql_num_rows($landlords);
        for ( $i=0; $i<$numlandlords; $i++ )
        {
            ?><option value="<?php echo mysql_result($landlords,$i,'userLogin'); ?>"
			<?php	if ( mysql_result($landlords,$i,'userLogin') == $_GET['propowner'] ) { echo " selected=yes "; } ?> >
			<?php echo mysql_result($landlords,$i,'userRealName'); ?></option>
        	<?php 
        } ?>
        </select>
        </li>
        <li>
        Tenant # Range:
        <input type="text" name="tenantnum1" value="<?php echo $_GET['tenantnum1']; ?>" size=3 /> - <input type="text" name="tenantnum2" value=<?php echo $_GET['tenantnum2']; ?> size=3 /><br />
        </li>
        <li>
        Rent Range: 
        $<input type="text" name="rent1" value="<?php echo $_GET['rent1']; ?>" size=6 /> - $<input type="text" name="rent2" value="<?php echo $_GET['rent2']; ?>" size=6 /><br />
        </li>
        <li>
        <input type="submit" value="Refine" />
        </li>
        <input type="hidden" name="submitted" value=1 />
        </ul>
        </form>
    
    <?php } else { ?>
        <form action="<?php echo $_SERVER['php self']; ?>" method="get" >
        Refine your listing:<br />
        <ul>
        <li>
        <select name="propowner">
        <option value="">Landlord</option>
        <?php 
        $landlords = mysql_query("SELECT * FROM tbl_users WHERE `userType` = 'landlord';");
        $numlandlords = mysql_num_rows($landlords);
        for ( $i=0; $i<$numlandlords; $i++ )
        {
            ?><option value="<?php echo mysql_result($landlords,$i,'userLogin'); ?>"><?php echo mysql_result($landlords,$i,'userRealName'); ?></option>
        <?php 
        } ?>
        </select>
        </li>
        <li>
        Tenant # Range:
        <input type="text" name="tenantnum1" value=0 size=3 /> - <input type="text" name="tenantnum2" value=99 size=3 /><br />
        </li>
        <li>
        Rent Range: 
        $<input type="text" name="rent1" value=0 size=6 /> - $<input type="text" name="rent2" value=99999 size=6 /><br />
        </li>
        <li>
        <input type="submit" value="Refine" />
        </li>
        <input type="hidden" name="submitted" value=1 />
        </ul>
        </form>
    <?php } ?>

<a href="<?php $_SERVER['php self'] ?>?view=all" >View All</a> | 
<a href="<?php $_SERVER['php self'] ?>?view=available" >View Available for Rental</a>

<?php include('std_page_bottom.php'); ?>

</body>
</html>
