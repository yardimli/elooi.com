<?php require_once("/server-settings.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php include("/php-functions.php"); ?>
<?php

$UserID=-200;

if ( ( ($_GET["uid"]!="") && (intval($_GET["uid"])>0) ) or ($_SESSION['uid']!="") )
{
	$UserID =$_GET["uid"];
}

$ElooiID = 0;
$EchoElooiID = 0;
$ElooiPicture = "";
if ( ($_GET["elooiid"]!="") && (intval($_GET["elooiid"])>0)  )
{
	$ElooiID =$_GET["elooiid"];
	$xsqlCommand = "SELECT EchoElooiID,ResponseToElooiID,Picture FROM Eloois WHERE ID=".$ElooiID;
	$mysqlresult = mysql_query($xsqlCommand);
	$EchoElooiID = mysql_result($mysqlresult,0,"EchoElooiID");
	$ElooiPicture = mysql_result($mysqlresult,0,"Picture");
	$ResponseToElooiID = mysql_result($mysqlresult,0,"ResponseToElooiID");

	//check to see if this elooi is the begining of a discussion
	if ($ResponseToElooiID=="0") {
		$xsqlCommand2 = "SELECT ID,ResponseToElooiID FROM Eloois WHERE ResponseToElooiID=".$ElooiID;
		$mysqlresult2 = mysql_query($xsqlCommand2);
		if (mysql_num_rows($mysqlresult2)>=1) { $ResponseToElooiID = $ElooiID; }
	}
}

if (($UserID!=-100) && ($UserID!=-200)) {
	$xsqlCommand = "SELECT * FROM users WHERE ID=".$UserID;
	$mysqlresult = mysql_query($xsqlCommand);

	$FullName   = mysql_result($mysqlresult,0,"FirstName");
	$Location   = mysql_result($mysqlresult,0,"Location");
	$Picture    = mysql_result($mysqlresult,0,"Picture");
	$UserName   = mysql_result($mysqlresult,0,"UserName");

	$xsqlCommand = "SELECT * FROM userprofiles WHERE UserID=".$UserID;
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1) {
		$i=0;
		$HomePage  = mysql_result($mysqlresult,$i,"HomePage");
	}


	$xsqlCommand = "SELECT * FROM listeners WHERE userID='".$_SESSION['Elooi_UserID'] . "' AND ListeningToID=" . $UserID ."";
	$res = mysql_query($xsqlCommand);
	if (mysql_num_rows($res)>=1)  { $ListenToButton_right = "2"; } else { $ListenToButton_right = "1"; }

	$xsqlCommand = "SELECT count(*) as toplam FROM eloois WHERE ProfileElooi=0 AND deleted=0 AND ( (UserID=".$UserID." AND EchoUserID=0) OR (EchoUserID=".$UserID.") )";
	//echo $xsqlCommand;
	$res = mysql_query($xsqlCommand);
	if (mysql_num_rows($res)==1)  { $u_eloois = mysql_result($res,0,"toplam"); } else { $u_eloois = "0"; }

	$xsqlCommand = "SELECT count(*) as toplam FROM listeners WHERE ListeningToID='".$UserID."'";
	$res = mysql_query($xsqlCommand);
	if (mysql_num_rows($res)==1)  { $u_listeners = mysql_result($res,0,"toplam"); } else { $u_listeners = "0"; }

	$xsqlCommand = "SELECT count(*) as toplam FROM listeners WHERE UserID='".$UserID."'";
	$res = mysql_query($xsqlCommand);
	if (mysql_num_rows($res)==1)  { $u_listening = mysql_result($res,0,"toplam"); } else { $u_listening = "0"; }
?>
<script type="text/javascript">
var ListenToButtonType_right = <?php echo $ListenToButton_right; ?>;
$(document).ready(function(){
	 $('.userCircle').tipsy({trigger: 'hover', fade:false, gravity: 's'});
	 $('#FlagElooiLink').tipsy({trigger: 'hover', fade:false, gravity: 's'});
});
</script> 


<div style="margin-top:0px; margin-bottom:10px; width:65px; margin-left:0px; margin-right:5px; float:left"><a href="/u/<?php echo $UserName;?>/profil"><img src="/slir/w65-h65-c1.1/<?php echo $Picture; ?>" width="65" height="65" border=0></a></div>


<div style="line-height:1.4em; font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif; display:inline-block; margin-bottom:10px; min-height:60px">
<a href="/u/<?php echo $UserName;?>/profil">@<?php echo $UserName;?></a> <br>

<span style="font-size:90%;"><?php echo $Location;?></span>
<br>
<?php
if ( ($_SESSION['Elooi_UserID']!="") && ($_SESSION['Elooi_UserID']!=$UserID) && (1==1) ) {
?>
	<div style="height:32px; display:inline-block; vertical-align: top;">
	<?php 
	if ($ListenToButton_right == "1") {
	?>
		<a href="#" id="listento_txt"  onClick="Become_Listener_txt(event,'<?php echo $UserID?>'); return false"><?php echo $me_become_listener; ?></a>
	<?php } else if ($ListenToButton_right == "2") { ?>
		<a href="#" id="listento_txt" onClick="Become_Listener_txt(event,'<?php echo $UserID?>'); return false"><?php echo $me_unbecome_listener; ?></a>
	<?php } ?>
	</div>

<?php
} else { ?>
<span style="height:32px; display:inline-block;"></span>
<?php } ?>

</div>

<div style="margin-top:0px;">
<a href="/u/<?php echo $UserName;?>/profil" span class="counter_number_base" style="margin-right:0px; padding-right:0px; width:36px; border-right: 1px solid rgba(0, 0, 0, 0.1); " onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $u_eloois; ?></span>
	<br>
	<span class="counter_text">Elooi</span>
</a><a href="/u/<?php echo $UserName;?>/listento" class="counter_number_base" style="margin-right:0px; padding-left:10px; width:50px; border-left: 1px solid rgba(255, 255, 255, 0.3); border-right: 1px solid rgba(0, 0, 0, 0.1);" onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $u_listening; ?></span>
	<br>
	<span class="counter_text"><?php echo $me_leftcol_user_info_listen_to; ?></span>
</a><a href="/u/<?php echo $UserName;?>/listeners" class="counter_number_base" style="margin-right:0px; padding-left:10px; width:50px; border-left: 1px solid rgba(255, 255, 255, 0.3);" onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $u_listeners; ?></span>
	<br>
	<span class="counter_text"><?php echo $me_leftcol_user_info_listeners; ?></span>
</a></span>
</div>
<span style="display:block; height:8px;"></span>
<div id="FlagElooi" style="font-size:11px;"  ><a href="#" id="FlagElooiLink" style="font-size:11px;"  onClick="FlagElooi(event,'<?php echo $ElooiID?>'); return false" title="<?php echo $me_right_col_elooi_info_flag_elooi_tip; ?>"><?php echo $me_right_col_elooi_info_flag_elooi; ?></a></div>

<?php  if ($ElooiPicture!="") {   ?>
<a onClick="javascript:show_photo('/audio-picture/<?php echo $ElooiPicture; ?>',event);  return false;" href="/audio-picture/<?php echo $ElooiPicture; ?>"><img src="/slir/w210/audio-picture/<?php echo $ElooiPicture; ?>" class="picture-thumb-frame"></a>
<?php }  ?>

<?php
	$HasEcho = 0;
	if ($EchoElooiID==0) {
		$echoq = mysql_query("select distinct users.username,users.picture FROM eloois JOIN users ON users.ID=eloois.EchoUserID WHERE Deleted=0 AND EchoElooiID = ".$ElooiID. " LIMIT 6" );
		$echor = mysql_num_rows($echoq);
		if ($echor>0) {$HasEcho = 1; }
	} else
	{
		$echoq = mysql_query("select distinct users.username,users.picture FROM eloois JOIN users ON users.ID=eloois.EchoUserID WHERE Deleted=0 AND EchoElooiID = ".$EchoElooiID. " LIMIT 6" );
		$echor = mysql_num_rows($echoq);
	}

	if (($EchoElooiID!=0) or ($HasEcho==1))
	{
		$found = 0;

		for ($i=0; $i<$echor; $i++)
		{ 	
			if ($found==0) { $found=1; ?><span class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px; margin-top:20px;"><?php echo $me_right_col_elooi_info_echos; ?></span><?php } ?>

			<a href="/u/<?php echo mysql_result($echoq,$i,"username");?>/profil" onclick="javascript:event.stopPropagation();"><img class="userCircle" src="/slir/w28-h28-c1.1/<?php echo mysql_result($echoq,$i,"picture"); ?>" style="opacity:0.8;" onmouseover="this.style.opacity=1;" 		onmouseout="this.style.opacity=0.8;" title="<?php echo mysql_result($echoq,$i,"username");?>" /></a>
<?php
		}
	}
?>
<span style="display:block; height:2px;"></span>
<?php
	if ($found==1) //is echo or has echos
	{
		if ($HasEcho==1) {
			$echoq = mysql_query("select * FROM eloois WHERE Deleted=0 AND EchoElooiID = ".$ElooiID );
			$echor = mysql_num_rows($echoq);
		} else
		{
			$echoq = mysql_query("select * FROM eloois WHERE Deleted=0 AND EchoElooiID = ".$EchoElooiID );
			$echor = mysql_num_rows($echoq);
		}

		for ($i=0; $i<$echor; $i++)
		{ 	
			$userq = mysql_query( "SELECT * FROM users WHERE ID=" . mysql_result($echoq,$i,"EchoUserID") );
			$userr = mysql_num_rows($userq);
			if ($userr == 1) { ?>
				<a href="/u/<?php echo mysql_result($userq,0,"username");?>/profil" onclick="javascript:event.stopPropagation();" id="span_username_<?php echo $arraycounter; ?>" style="font-size:12px;">@<?php echo mysql_result($userq,0,"username");?></a>

				<?php
				$xsqlCommand_tags = "select alltags.tag from tagcloud JOIN alltags on alltags.ID=tagcloud.TagID where elooiID = ".mysql_result($echoq,$i,"ID");
				$mysqlresult_tags = mysql_query($xsqlCommand_tags);
				$num_rows_tags = mysql_num_rows($mysqlresult_tags);
				for ($i_tags=0; $i_tags<$num_rows_tags; $i_tags++) { echo "<a href=\"/etiket/" . mysql_result($mysqlresult_tags,$i_tags,"alltags.tag") ."\" style=\"font-size:12px; \">".mysql_result($mysqlresult_tags,$i_tags,"alltags.tag")."</a> ";  }
			}
		}
	}
?>



<?php
	if (1==2) { //dont use mentinos for now add this feature later like adding picture or link
	$found = 0;
	$mentionsq = mysql_query("select alltags.tag from tagcloud JOIN alltags on alltags.ID=tagcloud.TagID where tag like '@%' AND (ElooiID = ".$ElooiID." OR ElooiID=".$EchoElooiID.")");

	$mentionsr = mysql_num_rows($mentionsq);
	for ($i=0; $i<$mentionsr; $i++)
	{ 	

		$userq = mysql_query( "SELECT users.*,userprofiles.* FROM users JOIN userprofiles ON users.ID=userprofiles.userID WHERE users.Username=" . ATQ(substr(mysql_result($mentionsq,$i,"tag"),1)) );
		$userr = mysql_num_rows($userq);
		if ($userr == 1) { 
			if ($found==0) { $found=1; ?><span class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px; margin-top:25px;"><?php echo $me_right_col_elooi_info_mentions; ?></span><?php } ?>

			<div style="display:block; min-height:50px; ">
				<div style="width:42px; float:left; margin-top:3px; overflow:hidden; height:42px; margin-left:5px; margin-right:8px;">
					<a href="/u/<?php echo mysql_result($userq,0,"username");?>/profil" onclick="javascript:event.stopPropagation();"><img src="/slir/w42-h42-c1.1/<?php echo mysql_result($userq,0,"picture"); ?>"></a>
				</div>

				<div style="display:block; margint-top:0px; min-height:20px; margin-left:4px; line-height:130%; ">
					<b><a href="/u/<?php echo mysql_result($userq,0,"username");?>/profil" onclick="javascript:event.stopPropagation();" id="span_username_<?php echo $arraycounter; ?>" style="font-size:12px;">@<?php echo mysql_result($userq,0,"username");?></a></b>
					<span style="font-size:12px;"><?php echo mysql_result($userq,0,"firstname");?></span>,
					<span style="font-size:12px;"><?php echo substr(mysql_result($userq,0,"userbio"),0,128);?>...</span>
				</div>

			</div>

			<?php
		}
	}
}
}
?>

<?php
if ($ResponseToElooiID>0)
{
	?>
	<span class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px; margin-top:25px;"><?php echo $me_right_col_elooi_info_replies; ?> - <span style="font-size:13px"><a href="/d/<?php echo $ResponseToElooiID; ?>"><?php echo $me_right_col_elooi_info_show_conversation; ?></a></span> </span>
	<span style="font-size:13px; display:block; margin-bottom:5px; margin-top:5px; line-height:120%">
	<?php
	$userq = mysql_query("select distinct username,firstname from eloois LEFT JOIN users ON users.ID=eloois.userID WHERE eloois.ID=".$ResponseToElooiID." OR ResponseToElooiID=".$ResponseToElooiID);
	$userr = mysql_num_rows($userq);
	for ($i=0; $i<$userr; $i++)
	{ 	 ?>
		<b><a href="/u/<?php echo mysql_result($userq,$i,"username");?>/profil" onclick="javascript:event.stopPropagation();" style="font-size:12px;">@<?php echo mysql_result($userq,$i,"username");?></a></b> <span style="font-size:12px;"><?php echo mysql_result($userq,$i,"firstname");?></span>
		<?php
	}
	?>
	</span>
	<span style="font-size:13px; display:block; margin-bottom:5px; margin-top:5px; line-height:120%"><?php echo $me_right_col_elooi_info_in_conversation; ?></span>
	<?php
}
?>


<?php
	if (1==1) {
	$HasPopTags = 0;
	$echoq = mysql_query(
		"SELECT alltags.* FROM allTags 
		JOIN tagCloud on tagCloud.tagID=allTags.ID
		WHERE tagCount>1 AND (elooiID=".$ElooiID." or elooiID=".$EchoElooiID.") AND (alltags.tag not like '@%') ORDER BY tagCount DESC LIMIT 8");
	$echor = mysql_num_rows($echoq);

	if ($echor>0)
	{
		$found = 0;

		for ($i=0; $i<$echor; $i++)
		{ 	
			if ($found==0) { $found=1; ?><span class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px; margin-top:20px;"><?php echo $me_right_col_elooi_info_trending_tags; ?></span><span style="line-height:125%"><?php } ?>
			<a href="/etiket/<?php echo mysql_result($echoq,$i,"tag"); ?>"><?php echo mysql_result($echoq,$i,"tag"); ?></a><br>
<?php
		}
		echo "</span>";
	}
}
?>
<span style="display:block; height:2px;"></span>

<?php
if ( ($_SESSION['Elooi_UserID']!="") && ($_SESSION['Elooi_UserID']==$UserID) && (1==2)) { ?>
<span class="elooi-actions">
<a class="delete-action" onclick="delete_elooi_by_ID('<?php echo $ElooiID; ?>',event); return false;" href="#"><span><i></i><b><?php echo $me_delete; ?></b></span></a>
<br>
<a class="retag-action" onclick="retag_elooi_by_ID('<?php echo $ElooiID; ?>',event); return false;" href="#"><span><i></i><b><?php echo $me_retag; ?></b></span></a>
<br>
<a class="add-picture-action" onclick="retag_elooi_by_ID('<?php echo $ElooiID; ?>',event); return false;" href="#"><span><i></i><b><?php echo $newelooi_picture_add; ?></b></span></a>
<br>
<a class="add-url-action" onclick="retag_elooi_by_ID('<?php echo $ElooiID; ?>',event); return false;" href="#"><span><i></i><b><?php echo $newelooi_link_add; ?></b></span></a>
</span>

<?php } ?>


<script type="text/javascript">
	$(document).ready(function(){ 
		setBackgroundValues("<?php 
		if ($_SESSION['tileBackground']=="1") { echo "repeat"; } else { echo "no-repeat"; } ?>","<?php echo $_SESSION['backgroundColor']; ?>","<?php echo $_SESSION['backgroundImage']; ?>","", "<?php echo $_SESSION['textColor']; ?>", "<?php echo $_SESSION['headerColor']; ?>", "<?php echo $_SESSION['linkColor']; ?>", "<?php echo $_SESSION['textBackgroundColor']; ?>");
	});
</script>

<?php include("/ortak-fotter-mini.php");?>
