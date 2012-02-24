<?php include('checkcookie.php'); 
if ( mysql_result($result,0,'userType') != 'landlord' && mysql_result($result,0,'userType') != 'admin' )
{
	header("Location: ./home.php");
}

if ( $_GET['del'] )
{
	$del_query = "DELETE FROM `tbl_properties` WHERE `propId` = '${_GET['propid']}' AND `propOwner` = '${_COOKIE['islavistahousing-id']}' LIMIT 1;";
	echo $del_query;
	mysql_query($del_query);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing - Property Manager</title>
<style type="text/css">
<!--

@import url("std_page.css");
@import url("manage_properties.css");

-->
</style>
</head>

<body>

<?php
 include('userbar.php'); 
 include('std_page_top.php');
?>

<h2>Property Manager</h2>

<?php 

$query = "SELECT * FROM `tbl_properties` WHERE `propOwner` = '${_COOKIE['islavistahousing-id']}';";
$result = mysql_query($query);

$numrows = mysql_num_rows($result);

if ( $numrows == 0 ) { 

?>

    <p>You don't have any properties! Why not <a href="property.php">add one</a>!</p>
    
    <div id=prop_manage_box>
    <form action="property.php" method="get">
    <table border=0 cellpadding=6 cellspacing=5>
    <tr>
        <td class=left></td>
        <td class=right>
            <input type="submit" value="Add New Property" />
         </td>
    </tr>
    </table>
    </form>
    </div>

<?php } else { ?>

    <div id=prop_manage_box>
    <form action="property.php" method="get">
    <table border=0 cellpadding=6 cellspacing=5>
    	<tr class=top_row>
            <td>
                Address
            </td>
            <td>
                Description
            </td>
            <td>
                Edit
            </td>
            <td>
                Delete
            </td>
        </tr>
    <?php for ($i = 0; $i < $numrows; $i++) { ?>
        <tr>
            <td class=left>
                <?php echo mysql_result($result,$i,'propAddressNum') . " " . 
                            mysql_result($result,$i,'propAddressStreet') . " " .
                            mysql_result($result,$i,'propAptNum'); ?>
            </td>
            <td class=right>
                <?php echo substr(mysql_result($result,$i,'propDescription'),0,200) . "..."; ?>
            </td>
            <td>
                <a href="property.php?propid=<?php echo mysql_result($result,$i,'propId'); ?>"><img src="edit.gif" border=0 /></a>
            </td>
            <td>
                <a href="manage_properties.php?propid=<?php echo mysql_result($result,$i,'propId') . "&del=1"; ?>">
                <img src="delete.png" border=0 /></a>
            </td>
        </tr>
	<?php } ?>
    
        <tr>
            <td class=left>
                <input type="submit" value="Add New Property" />
            </td>
        </tr>
    
    </table>
    </form>
    </div>
    

<?php } ?>


<?php mysql_close($cnxn); ?>
<?php include('std_page_bottom.php'); ?>

</body>
</html>
