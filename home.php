<?php include('checkcookie.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IslaVistaHousing - Home</title>

<style type="text/css">
<!--

@import url("std_page.css");

-->
</style>
</head>

<body>

<?php include('userbar.php'); ?>

<?php include('std_page_top.php'); ?>

<h2>Welcome home, <?php echo mysql_result($result,0,'userLogin'); ?>!</h2>


<?php if ( mysql_result($result,0,'userType') == 'admin' )
{ ?>
	<p>
	You are logged in as an administrator.
    </p>
<?php } else if ( mysql_result($result,0,'userType') == 'landlord' ) { ?>
    <p>
    This is your homepage. From here you can manage the properties that you're listing on IslaVistaHousing.
    </p>
	<div class="item">
    <a href="map.php?view=all"><span style="font-weight:bold;">Map All Properties</span></a> - Check out all the properties in the IslaVistaHousing network from ovehead using Google Maps
    </div>
    
    <div class="item">
    <a href="list.php?view=all"><span style="font-weight:bold;">List All Properties</span></a> - View a list of all properties. You can view properties for 2 or 6 tenants, with monthly rent between $2500 and $3000, or just from your favorite rental company--Whatever you want!
    
    </div>
    <div class="item">
    <a href="account.php"><span style="font-weight:bold;">My Profile</span></a> - Control your preferences and information. You'll want to set your "real name" to be what you'll want prospective tenants to see as your official name--it will appear in everyone of your properties' information.
    
    </div>
	<div class="item">
    <a href="manage_properties.php"><span style="font-weight:bold;">Manage My Properties</span></a>
     - Upload, edit, delete, and otherwise maintain all the information on all the properties in the IslaVistaHousing system. If you are just starting out you'll want to go here to enter new properties.
    
    </div>
    <div class="item">
	<a href="map.php?view=mine"><span style="font-weight:bold;">Map My Properties</span></a>
     - Display all of your properties on the map.
    
    </div>

<?php } else if ( mysql_result($result,0,'userLogin') == 'guest') { ?>
	<p>
    This is your homepage. You're logged in as a guest user right now so you can't do everything you could do as a registered user.</p>
    <h3>If you were cool you would <a href="register.php">register</a>, and you are cool, right?</h3>
    
	<div class="item">
    <a href="map.php?view=all"><span style="font-weight:bold;">Map All Properties</span></a> - Check out all the properties in the IslaVistaHousing network from ovehead using Google Maps
    </div>
    
    <div class="item">
    <a href="list.php?view=all"><span style="font-weight:bold;">List All Properties</span></a> - View a list of all properties. You can view properties for 2 or 6 tenants, with monthly rent between $2500 and $3000, or just from your favorite rental company--Whatever you want!
    </div>
    

<?php } else { ?>
	<p>
    This is your homepage. From here you can manage the properties on your watch list and start searching for housing.
    </p>
	<div class="item">
    <a href="map.php?view=all"><span style="font-weight:bold;">Map All Properties</span></a> - Check out all the properties in the IslaVistaHousing network from ovehead using Google Maps
    </div>
    
    <div class="item">
    <a href="list.php?view=all"><span style="font-weight:bold;">List All Properties</span></a> - View a list of all properties. You can view properties for 2 or 6 tenants, with monthly rent between $2500 and $3000, or just from your favorite rental company--Whatever you want!
    
    </div>
    
    <div class="item">
    <a href="account.php"><span style="font-weight:bold;">My Profile</span></a> - Control your preferences and personal information.
    
    </div>

<?php } ?>

<?php include('std_page_bottom.php'); ?>

<?php mysql_close($cnxn); ?>

</body>
</html>
