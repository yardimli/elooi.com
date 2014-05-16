<?php require_once("/server-settings.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php include("/php-functions.php"); ?>
<?php

$UserID=-200;

if ( ( ($_GET["uid"]!="") && (intval($_GET["uid"])>0) ) or ($_SESSION['uid']!="") )
{
	$UserID =$_GET["uid"];
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
	if ($num_rows==1)
	{
		$i=0;

		$UserBio  = mysql_result($mysqlresult,$i,"UserBio");
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
</script>
<div style="margin-top:0px; margin-bottom:10px; width:180px; margin-left:0px;"><a href="/u/<?php echo $UserName;?>/profil"><img src="<?php echo $Picture; ?>" border=0 style="width:180px; margin-right:10px"></a></div>

<span style="line-height:1.4em; font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif; ">
<span style="font-size:150%"><?php echo $FullName;?></span><br>

<a href="/u/<?php echo $UserName;?>/profil">@<?php echo $UserName;?></a> <br>

<span style="font-size:90%;"><?php echo $Location;?></span>
<br>
<span style="font-size:13px; line-height:18px; ">
<?php echo $UserBio;?>
<br>
</span>
<a href="<?php echo $HomePage;?>" target="_blank" style="font-size:90%; line-height:17px;"><?php echo $HomePage;?></a>
</span>

<div style="margin-top:10px;">
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

<?php
if ( ($_SESSION['Elooi_UserID']!="") && ($_SESSION['Elooi_UserID']!=$UserID) ) {
?>
	<div style="text-align:center; margin-top:20px;">
	<?php 
	if ($ListenToButton_right == "1") {
	?>
		<span id="ListenToButton_right" class="listen-button" onmouseover="Become_Listener_MouseOver_right(event)"  onmouseout="Become_Listener_MouseOut_right(event)" onmousedown="Become_Listener_MouseDown_right(event)" onClick="Become_Listener_right(event,'<?php echo $UserID?>')"><span id="ListenToButtonIcon_right" class="plus"></span> <b><?php echo $me_become_listener; ?></b></span>
	<?php } else if ($ListenToButton_right == "2") { ?>
		<span id="ListenToButton_right" class="listen-button subscribed-button" onmouseover="Become_Listener_MouseOver_right(event)"  onmouseout="Become_Listener_MouseOut_right(event)" onmousedown="Become_Listener_MouseDown_right(event)" onClick="Become_Listener_right(event,'<?php echo $UserID?>')"><span id="ListenToButtonIcon_right" class="ischeck"></span> <b><?php echo $me_listening; ?></b></span>
	<?php } ?>
	</div>

<?php
	}
}
?>
<br>

<script type="text/javascript">
	$(document).ready(function(){ 
		setBackgroundValues("<?php 
		if ($_SESSION['tileBackground']=="1") { echo "repeat"; } else { echo "no-repeat"; } ?>","<?php echo $_SESSION['backgroundColor']; ?>","<?php echo $_SESSION['backgroundImage']; ?>","", "<?php echo $_SESSION['textColor']; ?>", "<?php echo $_SESSION['headerColor']; ?>", "<?php echo $_SESSION['linkColor']; ?>", "<?php echo $_SESSION['textBackgroundColor']; ?>");
	});
</script>
