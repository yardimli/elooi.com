<?php $page="signin"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php

require 'facebook.php';

$facebook = new Facebook(array(
  'appId'  => '146170835459093',
  'secret' => '26338bd4a7850c2af95dd62a68ce5989',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
	exit();
  }
} else
{
	//echo "!";
	header( "Location: http://".$server_domain."/index.php?r=5" ) ;
	exit();
}


if ($user) { 
/*
	echo print_r($user);
	echo "---------";
	echo print_r($user_profile);
	echo "---------";
	echo print_r($user_profile["id"]);
	exit();
*/	
	$xsqlCommand = "SELECT * FROM users WHERE Facebook_uid = '".AddSlashes(Trim( $user_profile["id"] ))."' ORDER BY ID DESC LIMIT 1";
	//		echo $xsqlCommand;
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1)
	{
		$_SESSION['Elooi_User'] = true;
		$_SESSION['Elooi_AccountVerified'] = mysql_result($mysqlresult,0,"AccountVerified");
		$_SESSION['Elooi_UserID'] = mysql_result($mysqlresult,0,"ID");
		$_SESSION['Elooi_UserName'] = mysql_result($mysqlresult,0,"Username");
		$_SESSION['Elooi_FullName'] = mysql_result($mysqlresult,0,"FirstName");
		$_SESSION['Elooi_Picture'] = mysql_result($mysqlresult,0,"Picture");
		$_SESSION['Elooi_Location']   = mysql_result($mysqlresult,0,"Location");
		$_SESSION['Elooi_Email']   = mysql_result($mysqlresult,0,"Email");
		$_SESSION['Elooi_ILanguageID'] = mysql_result($mysqlresult,0,"ILanguageID");

		/*
		if (($server_domain=="tr.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="1")) { $_SESSION['Elooi_ILanguageID']="1"; } else
		if ( 
			(($server_domain=="en.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="2")) or
			(($server_domain=="tw.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="3")) or
			(($server_domain=="no.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="4")) )
			{ 
				if ($_SESSION['Elooi_ILanguageID']=="2") { $server_domain="en.elooi.com"; }
				if ($_SESSION['Elooi_ILanguageID']=="3") { $server_domain="tw.elooi.com"; }
				if ($_SESSION['Elooi_ILanguageID']=="4") { $server_domain="no.elooi.com"; }
			}
		*/
		$server_domain="elooi.com";

		$_SESSION['twitter_oauth_token']         = mysql_result($mysqlresult,0,"twitter_oauth_token");
		$_SESSION['twitter_oauth_token_secret']  = mysql_result($mysqlresult,0,"twitter_oauth_token_secret");

		$_SESSION['Facebook_uid']   = mysql_result($mysqlresult,0,"Facebook_uid");

		header( "Location: http://".$server_domain."/u/".$_SESSION['Elooi_UserName'] ) ;
		exit();
	} else 
	{
		header( "Location: http://".$server_domain."/signup-facebook.php" ) ;
		exit();
	}
}