<?php $page="signin"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php

$Twitter = new EpiTwitter($twitter_consumer_key, $twitter_consumer_secret);

if(isset($_GET['oauth_token']) || (isset($_COOKIE['oauth_token']) && isset($_COOKIE['oauth_token_secret'])))
{
// user accepted access
	if( !isset($_COOKIE['oauth_token']) || !isset($_COOKIE['oauth_token_secret']) )
	{
		// user comes from twitter
	    $Twitter->setToken($_GET['oauth_token']);
		$token = $Twitter->getAccessToken();
		setcookie('oauth_token', $token->oauth_token);
		setcookie('oauth_token_secret', $token->oauth_token_secret);
		$Twitter->setToken($token->oauth_token, $token->oauth_token_secret);
	}
	else
	{
	 // user switched pages and came back or got here directly, stilled logged in
	 
	 $Twitter->setToken($_COOKIE['oauth_token'],$_COOKIE['oauth_token_secret']);
	 $user= $Twitter->get_accountVerify_credentials();
	
	$oauth_token=$_COOKIE['oauth_token'];
	$oauth_token_secret=$_COOKIE['oauth_token_secret'];
	// Storing token keys


	$xsqlCommand = "UPDATE users SET twitter_oauth_token='". AddSlashes(Trim($oauth_token)) ."', twitter_oauth_token_secret='". AddSlashes(Trim($oauth_token_secret)) ."' WHERE ID=".$_SESSION['Elooi_UserID'];
	//		echo $xsqlCommand;
	$mysqlresult = mysql_query($xsqlCommand);

	$_SESSION['twitter_oauth_token']         = $oauth_token;
	$_SESSION['twitter_oauth_token_secret']  = $oauth_token_secret;
	/*
	$message= "I've connected my twitter to Elooi! Come listen to me @ http://elooi.com/". $_SESSION['Elooi_UserName'];
	//$Twitter = new EpiTwitter($twitter_consumerKey, $twitter_consumerSecret);
	$Twitter->setToken($oauth_token,$oauth_token_secret);
	//$message Status update
	$status=$Twitter->post_statusesUpdate(array('status' => $message));
	//$status->response;
	*/

	header( "Location: http://".$server_domain."/my-elooi-settings-account.php?q=twitter-connect" ) ;
	exit();
	}
}
elseif(isset($_GET['denied']))
{
	// user denied access
	header( "Location: http://".$server_domain."/my-elooi-settings-account.php?q=twitter-denied" ) ;
	exit();
}
else
{
	// user not logged in
	header( "Location: http://".$server_domain."/my-elooi-settings-account.php?q=twitter-not-logged-in" ) ;
	exit();
}

?>


</body>
</html>

