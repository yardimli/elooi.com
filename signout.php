<?php require_once("/server-settings.php"); ?>
<br><br><br><br><br><br><br>
<center>
Signing Out
</center>
<?php
			setcookie("userID", "", time()-(3600*24));
			setcookie("remember_me", "", time()-(3600*24));

			$_SESSION['Elooi_User'] = false;
			$_SESSION['Elooi_UserID'] = "";
			$_SESSION['Elooi_UserName'] = "";
			$_SESSION['Elooi_FullName'] = "";
			$_SESSION['Elooi_Picture'] = "";

			$_SESSION['twitter_oauth_token']         = "";
			$_SESSION['twitter_oauth_token_secret']  = "";
			$_SESSION['PulseCounter'] = 0;

			header( "Location: http://".$server_domain."/index.php" ) ;
			exit();


?>