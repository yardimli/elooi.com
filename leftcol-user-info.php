<?php require_once("/server-settings.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php require_once('/php-functions.php'); ?>
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

		$UserBio  = substr(mysql_result($mysqlresult,$i,"UserBio"),0,200);
		$HomePage  = mysql_result($mysqlresult,$i,"HomePage");

		$GeneralRepPoints = mysql_result($mysqlresult,$i,"GeneralRepPoints");
		$SocialRepPoints = mysql_result($mysqlresult,$i,"SocialRepPoints");
	}

	$xsqlCommand = "SELECT * FROM listeners WHERE userID='".$_SESSION['Elooi_UserID'] . "' AND ListeningToID=" . $UserID ."";
	$res = mysql_query($xsqlCommand);
	if (mysql_num_rows($res)>=1)  { $ListenToButton = "2"; } else { $ListenToButton = "1"; }

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
	var ListenToButtonType = <?php echo $ListenToButton; ?>;
</script>
<div style="margin-top:0px; margin-bottom:10px; width:180px; margin-left:0px;"><a href="/u/<?php echo $UserName;?>/profil"><img src="<?php echo $Picture; ?>" width="180" border=0></a></div>

<span style="line-height:175%; font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif; ">

<span class="headerstyle" style="font-size:150%"><?php echo $FullName;?></span><br>

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
</a><a href="/u/<?php echo $UserName;?>/listeners" class="counter_number_base" style="margin-right:0px; padding-left:10px; width:50px; border-left: 1px solid rgba(255, 255, 255, 0.3); " onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $u_listeners; ?></span>
	<br>
	<span class="counter_text"><?php echo $me_leftcol_user_info_listeners; ?></span>
</a></span>

</div>


<?php
if ( ($_SESSION['Elooi_UserID']!="") && ($_SESSION['Elooi_UserID']!=$UserID) ) {
?>
	<div style="margin-top:20px;">
	<?php 
	if ($ListenToButton == "1") {
	?>
		<span id="ListenToButton" class="listen-button" onmouseover="Become_Listener_MouseOver(event)"  onmouseout="Become_Listener_MouseOut(event)" onmousedown="Become_Listener_MouseDown(event)" onClick="Become_Listener(event,'<?php echo $UserID?>')"><span id="ListenToButtonIcon" class="plus"></span> <b><?php echo $me_become_listener; ?></b></span>
	<?php } else if ($ListenToButton == "2") { ?>
		<span id="ListenToButton" class="listen-button subscribed-button" onmouseover="Become_Listener_MouseOver(event)"  onmouseout="Become_Listener_MouseOut(event)" onmousedown="Become_Listener_MouseDown(event)" onClick="Become_Listener(event,'<?php echo $UserID?>')"><span id="ListenToButtonIcon" class="ischeck"></span> <b><?php echo $me_listening; ?></b></span>
	<?php } ?>
	</div>
<?php
}
?>
<br>

<?php
$q1 = mysql_query("SELECT count(*) as Toplam FROM badges JOIN userBadges ON badges.badgeID=userBadges.badgeID WHERE userBadges.userID=".$UserID." AND LanguageID=".$_SESSION['Elooi_ILanguageID']." AND badgeValue=1");
$num_rows = mysql_num_rows($q1);
$BronzRozet = mysql_result($q1,0,"Toplam");

$q1 = mysql_query("SELECT count(*) as Toplam FROM badges JOIN userBadges ON badges.badgeID=userBadges.badgeID WHERE userBadges.userID=".$UserID." AND LanguageID=".$_SESSION['Elooi_ILanguageID']." AND badgeValue=2");
$num_rows = mysql_num_rows($q1);
$GumusRozet = mysql_result($q1,0,"Toplam");

$q1 = mysql_query("SELECT count(*) as Toplam FROM badges JOIN userBadges ON badges.badgeID=userBadges.badgeID WHERE userBadges.userID=".$UserID." AND LanguageID=".$_SESSION['Elooi_ILanguageID']." AND badgeValue=3");
$num_rows = mysql_num_rows($q1);
$AltinRozet = mysql_result($q1,0,"Toplam");

if (($AltinRozet>0) or ($GumusRozet>0) or ($BronzRozet>0)) {
?>
<div style="margin-top:10px;">
<a href="http://<?php echo $server_domain; ?>/<?php echo $Footer_Badges_Link; ?>" style="display:inline-block; font-size:14px; color:black;"><?php echo $Footer_Badges; ?></a>
<div style="margin-top:10px;">
<a href="/u/<?php echo $UserName;?>/badges" span class="counter_number_base" style="margin-right:0px; padding-right:0px; width:36px; border-right: 1px solid rgba(0, 0, 0, 0.1); " onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $BronzRozet; ?></span>
	<br>
	<span class="counter_text"><?php echo $Badges_Bronze_name; ?></span>
</a><a href="/u/<?php echo $UserName;?>/badges" class="counter_number_base" style="margin-right:0px; padding-left:10px; width:50px; border-left: 1px solid rgba(255, 255, 255, 0.3); border-right: 1px solid rgba(0, 0, 0, 0.1);" onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $GumusRozet; ?></span>
	<br>
	<span class="counter_text"><?php echo $Badges_Silver_name; ?></span>
</a><a href="/u/<?php echo $UserName;?>/badges" class="counter_number_base" style="margin-right:0px; padding-left:10px; width:50px; border-left: 1px solid rgba(255, 255, 255, 0.3); " onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $AltinRozet; ?></span>
	<br>
	<span class="counter_text"><?php echo $Badges_Gold_name; ?></span>
</a></span>

</div>
<?php
}
?>

<?php
if (1==2) {
$q1 = mysql_query("SELECT * FROM badges JOIN userBadges ON badges.badgeID=userBadges.badgeID WHERE userBadges.userID=".$UserID." AND LanguageID=".$_SESSION['Elooi_ILanguageID']);
$num_rows = mysql_num_rows($q1);
for ($i=0; $i<$num_rows; $i++) {
?>

<a class="badge" title="<?php 
	if (mysql_result($q1,$i,"badgeValue")=="1") { echo "bronze badge"; }
	if (mysql_result($q1,$i,"badgeValue")=="2") { echo "silver badge"; }
	if (mysql_result($q1,$i,"badgeValue")=="3") { echo "gold badge"; }

?>: <?php echo strip_tags(mysql_result($q1,$i,"badgeText")); ?>" href="#"><span class="<?php 
	if (mysql_result($q1,$i,"badgeValue")=="1") { echo "badge3"; }
	if (mysql_result($q1,$i,"badgeValue")=="2") { echo "badge2"; }
	if (mysql_result($q1,$i,"badgeValue")=="3") { echo "badge1"; }

?>"></span>&nbsp;<?php echo mysql_result($q1,$i,"badgeName"); ?></a>
<?php
}
}

if ($_GET["bg"]!="no") {
?>

<script type="text/javascript">
	$(document).ready(function(){ 
		setBackgroundValues("<?php 
		if ($_SESSION['tileBackground']=="1") { echo "repeat"; } else { echo "no-repeat"; } ?>","<?php echo $_SESSION['backgroundColor']; ?>","<?php echo $_SESSION['backgroundImage']; ?>","", "<?php echo $_SESSION['textColor']; ?>", "<?php echo $_SESSION['headerColor']; ?>", "<?php echo $_SESSION['linkColor']; ?>", "<?php echo $_SESSION['textBackgroundColor']; ?>");
	});
</script>

<?php
	}	
}
?>
<?php include("/ortak-fotter-mini.php");?>