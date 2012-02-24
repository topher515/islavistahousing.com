<?php include('checkcookie.php'); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing - Property Manager</title>
<style type="text/css">
<!--

@import url("std_page.css");
@import url("list.css");

-->
</style>
</head>

<body>

<?php
 include('userbar.php'); 
 include('std_page_top.php');
?>

<h2>Property Listings</h2>

<?php 

$page = 0;
if ( $_GET['page'] )
{
	$page = $_GET['page'];
}

$pagestart = $page*15;
$pageend = $page*15+14;

if ( $_GET['submitted'] && $_GET['propowner'] )
{
	$query = "SELECT * FROM `tbl_properties` WHERE propOwner = '${_GET['propowner']}' "
	."AND propRent >= '${_GET['rent1']}' AND propRent <= '${_GET['rent2']}' "
	."AND propMaxOccupants >= '${_GET['tenantnum1']}' AND propMaxOccupants <= '${_GET['tenantnum2']}' "
	."ORDER BY propAddressStreet ASC, propAddressNum DESC LIMIT $pagestart, $pageend;";
}
else if ( $_GET['submitted'] ) {
	$query = "SELECT * FROM `tbl_properties` WHERE "
	."propRent >= '${_GET['rent1']}' AND propRent <= '${_GET['rent2']}' "
	."AND propMaxOccupants >= '${_GET['tenantnum1']}' AND propMaxOccupants <= '${_GET['tenantnum2']}' "
	."ORDER BY propAddressStreet ASC, propAddressNum DESC LIMIT $pagestart, $pageend;";
}
else { # display all
	$query = "SELECT * FROM `tbl_properties` ORDER BY propAddressStreet ASC, propAddressNum DESC LIMIT $pagestart, $pageend;";
}

#echo $query;

$result = mysql_query($query);

$numrows = mysql_num_rows($result);

if ( $numrows == 0 ) { 
?>

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
    
    <p>Sorry, couldn't find any properties with those parameters.</p>


<?php } else { ?>

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
    
    

<div id=prop_manage_box>
    <table border=0 cellpadding=6 cellspacing=5>
    
    	<tr class="top_row">
            <td>
                Address
            </td>
            <td>
                #Tenants
            </td>
            <td>
                #Rooms
            </td>
            <td>
                Rent
            </td>
            <td>
            	View
            </td>
            <td>
            	Map
            </td>
        </tr>
    
    <?php for ($i = 0; $i < $numrows; $i++) { ?>
        <tr>
            <td>
                <?php echo mysql_result($result,$i,'propAddressNum') . " " . 
                            mysql_result($result,$i,'propAddressStreet') ;
				if ( mysql_result($result,$i,'propAptNum') ) {
					echo " #" . mysql_result($result,$i,'propAptNum');
				} ?>

            </td>
            <td>
                <?php echo mysql_result($result,$i,'propMaxOccupants'); ?> tenants
            </td>
            <td>
                <?php echo mysql_result($result,$i,'propBedroomNum'); ?> rooms
            </td>
            <td>
                $<?php echo mysql_result($result,$i,'propRent'); ?> per month
            </td>
            <td>
            	<a href="property.php?propid=<?php echo mysql_result($result,$i,'propId'); ?>">
                <img src="view.gif" border=0 /></a>
            </td>
            <td>
            	<a href="map.php?propid=<?php echo mysql_result($result,$i,'propId'); ?>">
                <img src="map.gif" border=0 /></a>
            </td>
        </tr>
	<?php } ?>

    
    </table>
    
    <?php if ( $page != 0 ) { ?>
   	  <a href="<?php $_SERVER['php self'] ?>?<?php
        	if ( $_GET['view'] ) { ?>view=<?php echo $_GET['view']; } 
			?>&page=<?php echo ( $_GET['page'] - 1) ?>">prev page</a> | 
    <?php } ?>
    <a href="<?php $_SERVER['php self'] ?>?<?php
        if ( $_GET['view'] ) { ?>view=<?php echo $_GET['view']; } 
        ?>&page=<?php echo ( $_GET['page'] + 1) ?>">next page</a>
</div>
    

	<?php } ?>


<?php mysql_close($cnxn); ?>
<?php include('std_page_bottom.php'); ?>

</body>
</html>
