<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php include("/check-user-login.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<center>
<br><br><br><br>
<?php echo $save_Elooi_Done; ?><br><br>
<?php
	$mysqlresult = mysql_query("SELECT * FROM users WHERE ID=".$_SESSION['Elooi_UserID']);
	$num_rows = mysql_num_rows($mysqlresult);
	$i=0;
	$facebook_token = mysql_result($mysqlresult,$i,"facebook_access_token");
	$twitter_token  = mysql_result($mysqlresult,$i,"twitter_oauth_token_secret");

	$mysqlresult = mysql_query("SELECT * FROM usersettings WHERE userID=".$_SESSION['Elooi_UserID']);
	$num_rows = mysql_num_rows($mysqlresult);
	$i=0;
	$sharing_eloois_facebook       = mysql_result($mysqlresult,$i,"sharing_eloois_facebook");
	$sharing_eloois_twitter        = mysql_result($mysqlresult,$i,"sharing_eloois_twitter");
	$PostButtonTxt = "";
	if (($sharing_eloois_facebook=="1") && ($facebook_token!="")) { 
		$PostButtonTxt = $PostonFacebook; 
?>
<?php require_once('/fb-connect-code.php'); ?>

<script type="text/javascript">
<?php
$fbmessage=$FaceBookPostDescription;
$fbmessage=str_replace("##TAGS", str_replace(",",", ",$_SESSION['LastSaveTags']), $fbmessage);
$fbmessage=str_replace("##SECNODS", $_SESSION['LastSaveElooiLength'], $fbmessage);
$fbpicture = "http://".$server_domain."/elooi-logo-75.png";
if ($_SESSION['LastSavePicture'] != "")
{
	$fbpicture = "http://".$server_domain."/slir/w75-h75-c1.1/audio-picture/".$_SESSION['LastSavePicture'];
}

?>
function fbwallMsg() {
	console.log("fb post begin");
	publishPost('<?php echo $FaceBookPostMessage; ?>','<?php echo $FaceBookPostListenText; ?>','http://<?php echo $server_domain; ?>/u/<?php echo $_SESSION['Elooi_UserName']; ?>/elooi/<?php echo $_SESSION['LastSaveElooiID']; ?>/','<?php echo $fbmessage; ?>','<?php echo $fbpicture; ?>');
	console.log("fb post end");
//	window.location.reload();
}
</script>

<div style="margin-left:15px;">
<input class="submitbutton" value="<?php echo $PostButtonTxt; ?>" type="button" onClick="fbwallMsg();">
</div>

<?php
}

if ( ($twitter_token!="") && ($sharing_eloois_twitter=="1")) { 
	$message=$TwitterPostMessage;
	$message=str_replace("##TAGS", str_replace(",",", ",$_SESSION['LastSaveTags']), $message);
	$message=str_replace("##LISTENURL", "http://".$server_domain."/u/". $_SESSION['Elooi_UserName'] ."/elooi/". $_SESSION['LastSaveElooiID'], $message);

	$twitterObj = new EpiTwitter($twitter_consumer_key, $twitter_consumer_secret, $_SESSION['twitter_oauth_token'],$_SESSION['twitter_oauth_token_secret']);
	$twitterObjUnAuth = new EpiTwitter($twitter_consumer_key, $twitter_consumer_secret);
	$status = $twitterObj->post('/statuses/update.json', array('status' => $message));
}
?>

<br><br><br>
</center>

</body>

</html>