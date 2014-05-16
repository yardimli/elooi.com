			<div class="clear"></div>
		</div>
	</div>
<?php
/*
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=146170835459093";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
*/
?>
<div id="page2" style=" left:0;
    right:0;
    margin-left:auto;
    margin-right:auto;">
<?php
$col = hex2RGB("#DDF3FC");
$shadow_color = "#" . dechex(round($col['red'] * 0.75)) . dechex(round($col['green'] * 0.75)) . dechex(round($col['blue'] * 0.75));
?>

<div id="mini_footer_links" style="line-height:140%; margin-top:0px; padding:5px; ">

<div style="float:left; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;">Elooi © 2014
</div>

<div class="fb-like" style="float:left" data-href="elooi.com" data-send="false" data-layout="button_count" data-width="180" data-show-faces="false"></div>

<div style="float:right; ">
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_About_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_About; ?></a>&nbsp;&nbsp;
<a href="http://blog.elooi.com" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Blog; ?></a>&nbsp;&nbsp;
<!--<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Contact_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Contact; ?></a>&nbsp;&nbsp;-->
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Help_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Help; ?></a>&nbsp;&nbsp;
<!--<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Developers_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Developers; ?></a>&nbsp;&nbsp;-->
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Badges_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Badges; ?></a>&nbsp;&nbsp;
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Privacy_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Privacy; ?></a>&nbsp;&nbsp;
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_TOS_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_TOS; ?></a>
</div>
</div>
</div>
<br>

  <fieldset id="location-popup">
	<input type="hidden" name="op" value="signin_popup">
      <label for="city"><?php echo $Footer_Location; ?></label>
      <input id="city" name="city" value="" tabindex="4" type="text">
      </p>
	  <a href="#" onClick="javascript: jQuery('#location-str').html('<?php echo $newelooi_Location; ?>: '); jQuery('#myLocation').val('none'); $('.location-menu').removeClass('menu-open'); $('fieldset#location-popup').hide(); return false;"><?php echo $Footer_No_Location; ?></a>
  </fieldset>

<?php
/*
<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/3UDrNAqp3VpEaVvlteV2iw.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>
*/
?>
<?php
if ($subpage!="settings-design") {
?>
<script type="text/javascript">
jQuery(document).ready(function(){ 
	setBackgroundValues("no-repeat","#DDF3FC","/bg/theme_default_modify.jpg","", "#272323", "#000000", "#333333","#B2BDCD");
});
</script>
<?php
}

?>
<br><br><br>
</body></html>