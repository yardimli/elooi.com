<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php

if ( ($_POST["s_EchoElooiID"]!="") && (intval($_POST["s_EchoElooiID"])>0) ) {

	$ElooiID= $_POST["s_EchoElooiID"];

	//select elooi to clone
	$xcmd = "SELECT * FROM eloois WHERE ID=".$ElooiID;
	$cloneRes = mysql_query($xcmd);

	//insert clone into eloois table with echoUserID and original Elooi ID
	$xsqlCommand = "INSERT INTO eloois (userID,LanguageID,LinkURL,ShortURL,MusicCredit,ProfileElooi,ResponseToElooiID,ElooiTime,senderIP,Location,TrackLength,Picture,EchoElooiID,EchoUserID) VALUES (" . ATQ(mysql_result($cloneRes,0,"userID")) . "," . ATQ(mysql_result($cloneRes,0,"LanguageID")) . "," . ATQ(mysql_result($cloneRes,0,"LinkURL")) .",". ATQ(mysql_result($cloneRes,0,"ShortURL")) . "," . ATQ(mysql_result($cloneRes,0,"MusicCredit")) . ",0,". ATQ(mysql_result($cloneRes,0,"ResponseToElooiID")) .",now()," . ATQ(getUserIpAddr()) . "," . ATQ(mysql_result($cloneRes,0,"Location")) .",". ATQ(mysql_result($cloneRes,0,"TrackLength")) .",". ATQ(mysql_result($cloneRes,0,"Picture")) ."," . ATQ($ElooiID) ."," . ATQ($_SESSION['Elooi_UserID']) . ")";
	
	$log->lwrite($xsqlCommand);

	$mysqlresult = mysql_query($xsqlCommand);
}
?>

<script type="text/javascript">
	parent.jQuery("#process-sound").html("");
	$.colorbox({href:"/echo-saved.php"});
</script>