<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php
$ElooiUserID = "'".AddSlashes(Trim($_GET["s_ElooiUserID"]))."'";
if ($_GET["op"] == "remove") {
	//remove listen to
	$xsqlCommand = "DELETE FROM listeners WHERE userID='".$_SESSION['Elooi_UserID'] . "' AND ListeningToID=" . $ElooiUserID ."";
	$log->lwrite("listen to: ".$xsqlCommand);
	$debug = mysql_query($xsqlCommand);
} else 
if ($_GET["op"] == "add") {
	//add listen to
	$xsqlCommand = "INSERT INTO listeners (userID,ListeningToID) VALUES ('".$_SESSION['Elooi_UserID'] . "'," . $ElooiUserID .")";
	$log->lwrite("listen to: ".$xsqlCommand);
	$debug = mysql_query($xsqlCommand);
}
?>