<?php require_once("/server-settings.php"); ?>
<?php require_once('/elooi-translation.php'); ?>

<?php
mysql_connect($MysqlIP,"root","Mantik77"); //B123456a
mysql_select_db("cloudofvoice");
$mysqlresult = mysql_query("SET NAMES utf8");
$mysqlresult = mysql_query("SET CHARACTER_SET utf8");

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
	$(document).ready(function(){
		 $('.userCircle').tipsy({trigger: 'hover', fade:false, gravity: 's'});

		setBackgroundValues("<?php 
		if ($_SESSION['tileBackground']=="1") { echo "repeat"; } else { echo "no-repeat"; } ?>","<?php echo $_SESSION['backgroundColor']; ?>","<?php echo $_SESSION['backgroundImage']; ?>","", "<?php echo $_SESSION['textColor']; ?>", "<?php echo $_SESSION['headerColor']; ?>", "<?php echo $_SESSION['linkColor']; ?>", "<?php echo $_SESSION['textBackgroundColor']; ?>");
	});
	var ListenToButtonType = <?php echo $ListenToButton; ?>;
</script>

<a href="/u/<?php echo $UserName;?>/profil"><img src="<?php echo $Picture; ?>" style="margin-top:0px; margin-right:10px; width:90px; margin-left:0px;" border=0 align=left></a>

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
<a href="/u/<?php echo $UserName;?>/profil" span class="counter_number_base" style="margin-right:0px; padding-left:10px; padding-right:0px; width:60px; border-left: 1px solid rgba(255, 255, 255, 0.3); border-right: 1px solid rgba(0, 0, 0, 0.1); " onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $GeneralRepPoints; ?></span>
	<br>
	<span class="counter_text"><?php echo $me_general_rep_points; ?></span>
</a><a href="/u/<?php echo $UserName;?>/profil" class="counter_number_base" style="margin-right:0px; padding-left:10px; width:60px; border-left: 1px solid rgba(255, 255, 255, 0.3); " onmouseover="javascript:$(this).children('.counter_text').css({'text-decoration':'underline' });" onmouseout="javascript:$(this).children('.counter_text').css({'text-decoration':'none' });">
	<span class="counter_number"><?php echo $SocialRepPoints; ?></span>
	<br>
	<span class="counter_text"><?php echo $me_social_rep_points; ?></span>
</a></span>
</div>


<?php
if ( ($_SESSION['Elooi_UserID']!="") && ($_SESSION['Elooi_UserID']!=$UserID) ) {
?>
	<div style="margin-top:10px;">
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
//***************************
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
		$GeneralRepPoints = mysql_result($mysqlresult,$i,"GeneralRepPoints");
		$SocialRepPoints = mysql_result($mysqlresult,$i,"SocialRepPoints");
	}
	?>
	<!--<span class="headerstyle" style="font-size:16px; display:block; margin-bottom:20px;"><?php echo lang_aboutme($UserName,$UserID); ?></span>-->
	<br>

	<?php
	$query = mysql_query("SELECT DISTINCT alltags.ID, alltags.nocasetag, count(*) as xCount FROM allTags
	JOIN tagCloud ON tagCloud.TagID = allTags.ID
	JOIN Eloois ON Eloois.ID = tagCloud.ElooiID
	WHERE (Eloois.UserID=". $UserID ." or Eloois.EchoUserID=". $UserID .") and eloois.deleted=0 and (alltags.nocasetag like \"%/%\")
	group by alltags.ID
	ORDER BY count(*) DESC LIMIT 10");

	if (mysql_num_rows($query)>0) {
	?>
	<span class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px;"><?php if ($UserID==$_SESSION['Elooi_UserID']) { echo $me_rightcol_user_info_me_freq_tags; } else {echo $me_rightcol_user_info_freq_tags; }?></span>
	<?php
	}
	for ($x = 0; $x < mysql_num_rows($query); $x++) {  
	?>
	<a href="/etiket/<?php echo mysql_result($query,$x,"nocasetag"); ?>"><?php echo $atag; ?></a>
	<?php
	}


	$query = mysql_query("SELECT users.*,userprofiles.* FROM listeners
			JOIN users ON listeners.ListeningToID=users.ID
			JOIN userprofiles ON listeners.ListeningToID=userprofiles.userID
			WHERE listeners.UserID=".$UserID." ORDER BY listeners.ID DESC LIMIT 7");
	if (mysql_num_rows($query)>0)
	{ ?>
		<span  class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px; margin-top:20px;"><?php if ($UserID==$_SESSION['Elooi_UserID']) { echo $me_rightcol_user_info_me_listen_to; } else {echo $me_rightcol_user_info_listen_to; }?> - <a style="font-size:13px" href="/u/<?php echo $UserName ?>/listento"><?php echo $me_rightcol_user_info_show_all; ?></a></span>
		
		<?php
		for ($x = 0; $x < mysql_num_rows($query); $x++) {  ?>
			<a href="/u/<?php echo mysql_result($query,$x,"username");?>/profil" onclick="javascript:event.stopPropagation();"><img class="userCircle" src="/slir/w28-h28-c1.1/<?php echo mysql_result($query,$x,"picture"); ?>" style="opacity:0.8;" onmouseover="this.style.opacity=1;"		onmouseout="this.style.opacity=0.8;" title="<?php echo mysql_result($query,$x,"username");?>" /></a>
		<?php 
		}
		?>
	<?php
	}

	$query = mysql_query("SELECT users.*,userprofiles.* FROM listeners
			JOIN users ON listeners.UserID=users.ID
			JOIN userprofiles ON listeners.UserID=userprofiles.userID
			WHERE listeners.ListeningToID=".$UserID." ORDER BY listeners.ID DESC LIMIT 7");
	if (mysql_num_rows($query)>0)
	{ ?>
		<span  class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px; margin-top:15px;"><?php if ($UserID==$_SESSION['Elooi_UserID']) { echo $me_rightcol_user_info_me_listeners; } else {echo $me_rightcol_user_info_listeners; }?> - <a style="font-size:13px" href="/u/<?php echo $UserName ?>/listeners"><?php echo $me_rightcol_user_info_show_all; ?></a></span>
		
		<?php
		for ($x = 0; $x < mysql_num_rows($query); $x++) {  ?>
			<a href="/u/<?php echo mysql_result($query,$x,"username");?>/profil" onclick="javascript:event.stopPropagation();"><img class="userCircle" src="/slir/w28-h28-c1.1/<?php echo mysql_result($query,$x,"picture"); ?>" style="opacity:0.8;" onmouseover="this.style.opacity=1;"		onmouseout="this.style.opacity=0.8;" title="<?php echo mysql_result($query,$x,"username");?>" /></a>
		<?php 
		}
		?>
	<?php
	}
?>


<?php
}
?>

<span   class="headerstyle" style="font-size:16px; display:block; margin-bottom:5px; margin-top:15px;"><?php //echo $me_rightcol_user_info_trends; ?></span>

<?php
//query the database  
$query = mysql_query("SELECT * FROM allTags WHERE tagCount>1 ORDER BY tagCount DESC LIMIT 14");
for ($x = 0; $x < mysql_num_rows($query); $x++) { ?>
<!--	<a href="/etiket/<?php echo mysql_result($query,$x,"tag"); ?>"><?php echo mysql_result($query,$x,"tag"); ?></a>&nbsp; -->
<?php }	?>

<!--
*******************************************************
-->

<?php include("/ortak-fotter-mini.php");?>
