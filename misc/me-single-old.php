<?php require_once("/server-settings.php"); ?>
<?php
$SingleElooiID = 0;
$UserName = "";
$UseMyInbox = 0;
if ( ($_SESSION['SingleElooiID']!="") && (intval($_SESSION['SingleElooiID']) >0) )
{
	$SingleElooiID = $_SESSION['SingleElooiID'];

	$xsqlCommand = "SELECT * FROM eloois WHERE Deleted=0 AND ID=".$SingleElooiID;
	$mysqlresult = mysql_query($xsqlCommand);
	if (mysql_num_rows($mysqlresult)==1) { 
		$UserID = mysql_result($mysqlresult,0,"UserID");
	} else
	{
		header( "Location: http://".$server_domain."/" ) ;
		exit();
	}

	if (($UserID=="") or ($UserID=="0")) {
		$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=43"; } else
	{	$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=".$UserID; }
	$mysqlresult3 = mysql_query($xsqlCommand3);

	$_SESSION['tileBackground']   = mysql_result($mysqlresult3,0,"tileBackground");
	$_SESSION['backgroundImage']  = mysql_result($mysqlresult3,0,"backgroundImage");
	$_SESSION['backgroundColor']  = mysql_result($mysqlresult3,0,"backgroundColor");
	$_SESSION['textColor']        = mysql_result($mysqlresult3,0,"textColor");
	$_SESSION['linkColor']        = mysql_result($mysqlresult3,0,"linkColor");
	$_SESSION['headerColor']      = mysql_result($mysqlresult3,0,"headerColor");
	$_SESSION['textBackgroundColor']   = mysql_result($mysqlresult3,0,"textBackgroundColor");

	$col = hex2RGB(mysql_result($mysqlresult3,0,"textBackgroundColor"));
	$_SESSION['textBackgroundColorR']   = $col['red'];
	$_SESSION['textBackgroundColorG']   = $col['green'];
	$_SESSION['textBackgroundColorB']   = $col['blue'];


	$page="sinlge-elooi"; 
} ?>
<?php include("/ortak-header.php"); ?>

<link rel="stylesheet" href="/circle-skin/css/not.the.skin.css">
<link rel="stylesheet" href="/circle-skin/circle.skin/circle.player.css">

<script type="text/javascript" src="/scrollintoview.js"></script>
<script type="text/javascript" src="/circle-skin/js/jquery.transform.js"></script>
<?php // script type="text/javascript" src="/circle-skin/js/jquery.grab.js"></script ?>
<script type="text/javascript" src="/circle-skin/js/jquery.jplayer.js"></script>
<script type="text/javascript" src="/circle-skin/js/mod.csstransforms.min.js"></script>
<script type="text/javascript" src="/circle-skin/js/circle.player.js"></script>

<?php include("/me-js.php"); ?>

<div id="jquery_jplayer_1" class="cp-jplayer"></div>
<div id="jquery_jplayer_2" class="cp-jplayer"></div>

<div style="width:1000px; margin:0 auto; padding:0px; overflow:hidden;" id="main_grid">

<div id="grid_leftcol" class="elooi-page-leftcol" style="float:left; position:fixed;  z-index:5; background:<?php echo $_SESSION['textBackgroundColor']; ?>; background:rgba(<?php echo $_SESSION['textBackgroundColorR'] ?>,<?php echo $_SESSION['textBackgroundColorG'] ?>,<?php echo $_SESSION['textBackgroundColorB'] ?>,0.75); ">
	<div id="leftcol_user_info" style="width:180px;">
	</div>
</div>

<div id="grid_rightcol" class="elooi-page-rightcol" style="float:left; position:fixed; z-index:5; background:<?php echo $_SESSION['textBackgroundColor']; ?>;  background:<?php echo $_SESSION['textBackgroundColor']; ?>; background:rgba(<?php echo $_SESSION['textBackgroundColorR'] ?>,<?php echo $_SESSION['textBackgroundColorG'] ?>,<?php echo $_SESSION['textBackgroundColorB'] ?>,0.75); "" >
	<div id="rightcol_user_info" style="width:230px;">
	</div>
</div>


<div style="margin-left:200px; z-index:0; width:550px; background:#ffffff; " id="grid_centercol">
<?php
if ($UserID>0)
{
	$xsqlCommand = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois JOIN users ON eloois.userID=users.ID WHERE eloois.ID=". $SingleElooiID;
	$mysqlresult = mysql_query($xsqlCommand);
}
$num_rows = mysql_num_rows($mysqlresult);

if ($num_rows==0) { //no results
?>
	<center><br><br>@<?php echo $UserName; ?> <?php echo $me_single_broken_link; ?>
	</center>
	<?php 
}

//build data arrays
echo "<script type=\"text/javascript\">\nvar ElooiCount = ". $num_rows .";\n";
$arraycounter = 0;
$i = 0;
while ($i<$num_rows) {
	$arraycounter++;
	if (mysql_result($mysqlresult,$i,"EchoElooiID")!="0")
	{
		echo "ElooiStream[" . $arraycounter . "] = \"http://".$server_domain."/audio-elooi/" . mysql_result($mysqlresult,$i,"eloois.EchoElooiID") . "-" . mysql_result($mysqlresult,$i,"eloois.userID") . ".mp3\"; ";
	} else
	{
		echo "ElooiStream[" . $arraycounter . "] = \"http://".$server_domain."/audio-elooi/" . mysql_result($mysqlresult,$i,"eloois.ID") . "-" . mysql_result($mysqlresult,$i,"eloois.userID") . ".mp3\"; ";
	}
	echo "ElooiIDArray[" . $arraycounter . "] = \"".mysql_result($mysqlresult,$i,"eloois.ID") . "\"; ";
	echo "UserList[" . $arraycounter . "] = \"" . mysql_result($mysqlresult,$i,"eloois.userID") . "\"; \n";
	$i++;
}
echo "</script>";


//show list
$arraycounter = 0;
$i = 0;
while ($i<$num_rows) {
		$arraycounter++;
?>
<a name="elooiname_<?php echo $arraycounter; ?>">
<div id="elooi_<?php echo $arraycounter; ?>" class="elooi_row" onMouseOver="javascript:selectRow('<?php echo $arraycounter; ?>');" onMouseOut="javascript:deselectRow('<?php echo $arraycounter; ?>')" onClick="javascript:RowClick('<?php echo $arraycounter; ?>');" <?php   if ($arraycounter % 2 == 0) { echo "style=\"background:#F1F1F5;\""; } ?> >
	<div id="dogear_<?php echo $arraycounter; ?>" class="tweet-dogear <?php
		
		//add favorited and/or echo dogtag 
		$favunlink = 0;
		$unecho    = 0;
		if ($_SESSION['Elooi_UserID']!="") { //if user has logged in start check

			//check if query is using inbox to grab echos from inbox or if we have to check the persons eloois if current elooi is an echo actually
			if ($UseMyInbox == 0) {
				$echoCmd = "SELECT ID FROM eloois WHERE Deleted=0 AND EchoElooiID=".mysql_result($mysqlresult,$i,"EchoElooiID")." AND EchoUserID=".$_SESSION['Elooi_UserID'];
				$echoRes = mysql_query($echoCmd);
				if (mysql_num_rows($echoRes)==1) { $unecho = 1; }
			} else
			{
				if (mysql_result($mysqlresult,$i,"EchoUserID")==$_SESSION['Elooi_UserID'])	{ $unecho = 1; }
			}

			//check if query is using inbox to grab favorites from inbox or favorites table
			if ($UseMyInbox == 0) {
				$favCmd = "SELECT * FROM favorites WHERE elooiID=".mysql_result($mysqlresult,$i,"ID")." AND userID=".$_SESSION['Elooi_UserID'];
				$favRes = mysql_query($favCmd);
				
				if (mysql_num_rows($favRes)==1) { $favunlink=1; $log->lwrite($favCmd." --> ".mysql_num_rows($favRes)); }
			} else
			{
				if (mysql_result($mysqlresult,$i,"IsFavorite")==1) { $favunlink=1; }
			}
		}
		
		if (($favunlink==1) && ($unecho==1)) { echo " reechoed-favorited "; } else
		if ($favunlink==1)  { echo " favorited "; } else
		if ($unecho==1) { echo " reechoed "; }

		?>"></div>
	<?php
	// -------- reply icon
	if (mysql_result($mysqlresult,$i,"ResponseToElooiID")!="0")	{ ?>
	<div id="reply_<?php echo $arraycounter; ?>" class="eloo-reply-icon"></div>
	<?php }	?>

	<div style="width:52px; float:left; margin-top:3px; overflow:hidden; height:52px; margin-left:5px; margin-right:8px;">
	<img src="/slir/w52-h52-c1.1/<?php echo mysql_result($mysqlresult,$i,"upicture"); ?>">
	</div>
	<div style="margin-left:60px; min-height:52px;">

		<div style="display:block; margint-top:0px; height:20px; margin-left:4px; ">
			<b><a href="/u/<?php echo mysql_result($mysqlresult,$i,"username");?>/profil" onclick="javascript:event.stopPropagation();" id="span_username_<?php echo $arraycounter; ?>" style="font-size:12px; color:#444444;"><?php echo mysql_result($mysqlresult,$i,"username");?></a></b> <span style="font-size:11px; color:#777777;"><?php echo mysql_result($mysqlresult,$i,"firstname");?></span>
			<?php
			if (mysql_result($mysqlresult,$i,"EchoUserID")!=0) { 
				$sql_com = "select users.username FROM users WHERE ID=".mysql_result($mysqlresult,$i,"EchoUserID");
				$res_com = mysql_query($sql_com);
				if (mysql_num_rows($res_com)==1) { $EchoPerson = mysql_result($res_com,0,"username"); }

				echo "<span class=\"elooi-actions echo-user\"><span><i></i><b><a href=\"/u/".$EchoPerson."\" onclick=\"javascript:event.stopPropagation();\">". echo_by($EchoPerson)."</a></b></span>";
			}
			?>
		</div>


		<div style="display:block; margin-top:0px; margin-left:4px; ">
			<span title="<?php 
	if (mysql_result($mysqlresult,$i,"EchoElooiID")!="0") {
		echo mysql_result($mysqlresult,$i,"eloois.ID") ." - ". mysql_result($mysqlresult,$i,"eloois.EchoElooiID") . "-" . mysql_result($mysqlresult,$i,"eloois.userID") . ".mp3";
	} else {
		echo mysql_result($mysqlresult,$i,"eloois.ID") . "-" . mysql_result($mysqlresult,$i,"eloois.userID") . ".mp3";
	}
			 ?>" class="tag-box-icon" style=" cursor:default;" onclick="javascript:event.stopPropagation();" ><span class="ui-icon ui-icon-clock tag-box-icon-p"></span><?php echo mysql_result($mysqlresult,$i,"TrackLength"); ?> <?php echo $me_elooi_seconds; ?></span>
			<span class="tag-box-icon" style=" cursor:default;" onclick="javascript:event.stopPropagation();" ><span class="ui-icon ui-icon-flag  tag-box-icon-p"></span><?php echo mysql_result($mysqlresult,$i,"Location"); ?></span><?php

			$tag_icon="ui-icon ui-icon-tag tag-box-icon-p";
			if (mysql_result($mysqlresult,$i,"EchoElooiID")!=0) { 
				$xsqlCommand_tags = "select alltags.tag from tagcloud JOIN alltags on alltags.ID=tagcloud.TagID where elooiID = ".mysql_result($mysqlresult,$i,"EchoElooiID");
				$mysqlresult_tags = mysql_query($xsqlCommand_tags);
				$num_rows_tags = mysql_num_rows($mysqlresult_tags);
				$i_tags = 0;
				while ($i_tags<$num_rows_tags)
				{
					$atag = mysql_result($mysqlresult_tags,$i_tags,"alltags.tag");
					?><span class="tag-box-front" onClick="javascript:event.stopPropagation(); window.location='/etiket/<?php echo $atag; ?>'"><span class="<?php 
						if (substr($atag,0,1)=="@") {echo "ui-icon ui-icon-person tag-box-icon-p"; } else { echo $tag_icon; } ?>"></span><a onClick="javascript:event.stopPropagation();" href="/etiket/<?php echo $atag; ?>"><?php echo $atag; ?></a></span><?php
					$i_tags++;
				}
				$tag_icon="echo-icon";
			}

			$xsqlCommand_tags = "select alltags.tag from tagcloud JOIN alltags on alltags.ID=tagcloud.TagID where elooiID = ".mysql_result($mysqlresult,$i,"ID");
			$mysqlresult_tags = mysql_query($xsqlCommand_tags);
			$num_rows_tags = mysql_num_rows($mysqlresult_tags);
			$i_tags = 0;
			while ($i_tags<$num_rows_tags)
			{
				$atag = mysql_result($mysqlresult_tags,$i_tags,"alltags.tag");
				?><span class="tag-box-front" onClick="javascript:event.stopPropagation(); window.location='/etiket/<?php echo $atag; ?>'"><span class="<?php 
					if (substr($atag,0,1)=="@") {echo "ui-icon ui-icon-person tag-box-icon-p"; } else { echo $tag_icon; } ?>"></span><a onClick="javascript:event.stopPropagation();" href="/etiket/<?php echo $atag; ?>"><?php echo $atag; ?></a></span><?php
				$i_tags++;
			}

			?><?php if (mysql_result($mysqlresult,$i,"MusicCredit")!="") {?><span class="tag-box-icon" style=" cursor:default;" onclick="javascript:event.stopPropagation();" ><span class="ui-icon ui-icon-volume-on tag-box-icon-p"></span><?php echo mysql_result($mysqlresult,$i,"MusicCredit"); ?></span><?php } ?><?php 
			if (mysql_result($mysqlresult,$i,"Picture")!="") {?><span class="tag-box-icon"><span class="ui-icon ui-icon-image  tag-box-icon-p"></span><a onClick="javascript:show_photo('/audio-picture/<?php echo mysql_result($mysqlresult,$i,"Picture"); ?>',event);  return false;" href="/audio-picture/<?php echo mysql_result($mysqlresult,$i,"Picture"); ?>"><?php echo $me_elooi_photo_link; ?></a></span><?php } ?><?php
				if (mysql_result($mysqlresult,$i,"LinkURL")!="")
				{
					echo "<span class=\"tag-box-icon\"><span class=\"ui-icon ui-icon-extlink tag-box-icon-p\"></span><a  onClick=\"javascript:event.stopPropagation();\" target=\"_blank\" rel=\"nofollow\" title=\"". mysql_result($mysqlresult,$i,"LinkURL") ."\" href=\"". mysql_result($mysqlresult,$i,"ShortURL") . "\">";
					if (mysql_result($mysqlresult,$i,"ShortURL")!="")
					{ echo mysql_result($mysqlresult,$i,"ShortURL"); } else { echo substr(mysql_result($mysqlresult,$i,"LinkURL"),0,20)."..."; }
					echo "</a></span>";
				}
				?>
		</div>

		<div style="display:block; margin-top:8px; margin-left:4px; margin-bottom:0px; height:8px; font-size:11px; ">
			<span id="span_adddate_<?php echo $arraycounter; ?>" style="color:#555555;"><a href="/u/<?php if ($UserName!="") { echo $UserName; } else { echo mysql_result($mysqlresult,$i,"username"); }
			echo "/elooi/" . mysql_result($mysqlresult,$i,"ID"); ?>" onClick="javascript:event.stopPropagation();"><?php 
			echo datetotext( mysql_result($mysqlresult,$i,"ElooiTime") ); ?></a>&nbsp;&nbsp;</span>
			<?php
			if ($_SESSION['Elooi_UserID']!="") { ?>
			<span id="action_barn_<?php echo $arraycounter; ?>" style="display:none">
				<span class="elooi-actions">
					<?php if ($_SESSION['Elooi_UserID']!=mysql_result($mysqlresult,$i,"userID")) { 
					//dont allow for user to echo, reply or favorite their own eloois
					?>
					
					<?php
					//dont allow users to add their own echos to favorites
					if ($_SESSION['Elooi_UserID']!=mysql_result($mysqlresult,$i,"EchoUserID")) { 
					?>
					<a class="<?php if ($favunlink==1) { echo "unfavorite-action"; } else { echo "favorite-action";} ?>" onclick="addtofavorite('<?php echo $arraycounter; ?>',event); return false;" href="#" id="favorite_<?php echo $arraycounter; ?>" >
						<span>
							<i></i><b><?php if ($favunlink==1) { echo $me_remove_favorite; } else { echo $me_add_favorite; } ?></b>
						</span>
					</a>
					<?php
					}
					?>

					<a class="<?php if ($unecho==1) { echo "unecho-action"; } else { echo "echo-action";} ?>" onclick="addtoecho('<?php echo $arraycounter; ?>',event); return false;" href="#" id="echo_<?php echo $arraycounter; ?>" >
						<span><i></i><b><?php if ($unecho==1) { echo $me_remove_echo; } else { echo $me_add_echo; } ?></b></span></a>
					<a class="reply-action" onclick="reply_elooi('<?php echo $arraycounter; ?>',event); return false;" href="#">
						<span><i></i><b><?php echo $me_reply; ?></b></span></a>
					<?php
					}
					if ($_SESSION['Elooi_UserID']==mysql_result($mysqlresult,$i,"userID")) { ?>
					<a class="delete-action" onclick="delete_elooi('<?php echo $arraycounter; ?>',event); return false;" href="#">
						<span><i></i><b><?php echo $me_delete; ?></b></span></a>

					<a class="retag-action" onclick="retag_elooi('<?php echo $arraycounter; ?>',event); return false;" href="#">
						<span><i></i><b><?php echo $me_retag; ?></b></span></a>

					<?php } ?>
				</span>
			<span>
			<?php } //toolbar for users who logged in
			?>
		</div>

	</div>
</div>


<?php
	$i++;
}
?>

</div>

<div style="height:20px"></div>

<div id="cp_container_1" class="cp-container" style="display:none;">
	<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
		<div class="cp-buffer-1"></div>
		<div class="cp-buffer-2"></div>
	</div>
	<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
		<div class="cp-progress-1"></div>
		<div class="cp-progress-2"></div>
	</div>
	<div class="cp-circle-control"></div>
	<ul class="cp-controls">
		<li><a href="#" class="cp-play" tabindex="1">play</a></li>
		<li><a href="#" class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
	</ul>
</div>

<div id="cp_container_2" class="cp-container" style="display:none;">
	<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
		<div class="cp-buffer-1"></div>
		<div class="cp-buffer-2"></div>
	</div>
	<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
		<div class="cp-progress-1"></div>
		<div class="cp-progress-2"></div>
	</div>
	<div class="cp-circle-control"></div>
	<ul class="cp-controls">
		<li><a href="#" class="cp-play" tabindex="1">play</a></li>
		<li><a href="#" class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
	</ul>
</div>


<div id="floatingplaybutton" class="cp-play-passive"></div>

  <fieldset id="location-popup">
	<input type="hidden" name="op" value="signin_popup">
      <label for="city"><?php echo $Footer_Location; ?></label>
      <input id="city" name="city" value="" tabindex="4" type="text">
      </p>
	  <a href="#" onClick="javascript: jQuery('#location-str').html('<?php echo $newelooi_Location; ?>: '); jQuery('#myLocation').val('none'); $('.location-menu').removeClass('menu-open'); $('fieldset#location-popup').hide(); return false;"><?php echo $Footer_No_Location; ?></a>
  </fieldset>
</body></html>