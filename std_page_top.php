<!-- Begin Std Top -->
<div id=top_bar></div>

<a href="./home.php"><div id=title>IslaVistaHousing.com</div></a>

<?php if ( mysql_result($result,0,'userType') == 'landlord' || mysql_result($result,0,'userType') == 'admin' )
{ ?>
	<div id=left_menu>
	<a href="map.php?view=all"><div class="item"><span style="font-weight:bold;">Map All Properties</span></div></a>
	<a href="list.php?view=all"><div class="item"><span style="font-weight:bold;">List All Properties</span></div></a>
    <a href="account.php"><div class="item mystuff">My Profile</div></a>
	<a href="manage_properties.php"><div class="item mystuff">Manage My Properties</div></a>
	<a href="map.php?view=mine"><div class="item mystuff">Map My Properties</div></a>
	
<?php } else { ?>
	<div id=left_menu>
	<a href="map.php?view=all"><div class="item"><span style="font-weight:bold;">Map All Properties</span></div></a>
    <a href="list.php?view=all"><div class="item"><span style="font-weight:bold;">List All Properties</span></div></a>
    <?php if ( mysql_result($result,0,'userLogin') != 'guest' )
	{  ?>
	
	<a href="account.php"><div class="item mystuff">My Profile</div></a>
	<?php } ?>
    
<?php } ?>

<div style="margin-left:22px;margin-top:22px;width:120px;">
<script type="text/javascript"><!--
google_ad_client = "pub-9365488259677498";
google_ad_width = 120;
google_ad_height = 240;
google_ad_format = "120x240_as";
google_ad_type = "text";
//2007-08-26: IVHousing
google_ad_channel = "9077101152";
google_color_border = "000000";
google_color_bg = "22ad46";
google_color_link = "000000";
google_color_text = "000000";
google_color_url = "AECCEB";
google_ui_features = "rc:0";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

</div>

<div style="text-align: center;">
<div id="content_main">
<!-- End Std Top -->