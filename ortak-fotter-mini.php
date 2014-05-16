<?php
$shadow_color = "#" . dechex(round($_SESSION['textBackgroundColorR'] * 0.75)) . dechex(round($_SESSION['textBackgroundColorG'] * 0.75)) . dechex(round($_SESSION['textBackgroundColorB'] * 0.75));
?>
<div id="mini_footer_links" style="position:absolute; line-height:120%">
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_About_Link; ?>" style="display:inline-block; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_About; ?></a>
<!--<a href="http://blog.elooi.com" style="display:inline-block; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Blog; ?></a>-->
<!--<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Contact_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 0px 6px <?php echo $shadow_color; ?>;"><?php echo $Footer_Contact; ?></a>&nbsp;&nbsp;-->
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Help_Link; ?>" style="display:inline-block; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Help; ?></a>
<!--<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Developers_Link; ?>" style="font-size:11px; color:black; text-shadow: 0px 0px 6px <?php echo $shadow_color; ?>;"><?php echo $Footer_Developers; ?></a>&nbsp;&nbsp;-->
<!--<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Badges_Link; ?>" style="display:inline-block; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Badges; ?></a>-->
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Privacy_Link; ?>" style="display:inline-block; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_Privacy; ?></a>
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_TOS_Link; ?>" style="display:inline-block; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;"><?php echo $Footer_TOS; ?></a>

<span style="display:inline-block; font-size:11px; color:black; text-shadow: 0px 1px 2px <?php echo $shadow_color; ?>;">Elooi © 2014</span>


</span>

</span>
</div>

<div id="mini_footer" style="padding:0px; margin:0px; position:fixed">
</div>

<script type="text/javascript">

jQuery(document).ready(function(){ 
	var m_view_h = $("#grid_rightcol").height();
	var m_view_w = $("#mini_footer").width();

//	$("#mini_footer").css({"top":m_view_h+63}); 
//	$("#mini_footer").css({"left":1024-m_view_w-10}); 
	
	var m_view_h2 = $("#mini_footer_links").height();
	$("#mini_footer_links").css({"top":m_view_h-20}); 
});
</script>

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
<br><br>
<div class="fb-like" data-href="www.elooi.com" data-send="false" data-layout="button_count" data-width="180" data-show-faces="false"></div>
*/
?>