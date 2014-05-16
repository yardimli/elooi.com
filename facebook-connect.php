<?php $page="signin"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php

$cookie = get_facebook_cookie('146170835459093', '26338bd4a7850c2af95dd62a68ce5989');
$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' . $cookie['access_token']));
$facebook_username = $user->username;

if ($user->username != "")
{
	$xsqlCommand = "UPDATE users SET Facebook_uid='". AddSlashes(Trim($user->id)) ."', Facebook_username='". AddSlashes(Trim($user->username)) ."', facebook_access_token='". AddSlashes(Trim($cookie['access_token'])) ."' WHERE ID=".$_SESSION['Elooi_UserID'];
	//		echo $xsqlCommand;
	$mysqlresult = mysql_query($xsqlCommand);

	$_SESSION['Facebook_uid']     = $user->id;
	header( "Location: http://".$server_domain."/my-elooi-settings-account.php?q=facebook-connect" ) ;
	exit();
}
else
{
	header( "Location: http://".$server_domain."/my-elooi-settings-account.php?q=facebook-connect-error" ) ;
	exit();
}
?>
</body>
</html>