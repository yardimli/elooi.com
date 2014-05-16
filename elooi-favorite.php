<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php
$ErrorMessage="";
$HasError = 0;

$ElooiID  = "'".AddSlashes(Trim($_GET["ElooiID"]))."'";
if ($_GET["op"] == "remove") {
	//remove favorite
	$xsqlCommand = "DELETE FROM favorites WHERE userID='".$_SESSION['Elooi_UserID'] . "' AND elooiID=" . $ElooiID ."";
	$log->lwrite("favorite: ".$xsqlCommand);
	$debug = mysql_query($xsqlCommand);

	$xsqlCommand = "UPDATE userinbox SET IsFavorite=0 WHERE userID='".$_SESSION['Elooi_UserID'] . "' AND elooiID=" . $ElooiID ."";
	$debug = mysql_query($xsqlCommand);

} else 
if ($_GET["op"] == "add") {
	//remove favorite
	$xsqlCommand = "INSERT INTO favorites (userID,elooiID) VALUES ('".$_SESSION['Elooi_UserID'] . "'," . $ElooiID .")";
	$log->lwrite("favorite: ".$xsqlCommand);
	$debug = mysql_query($xsqlCommand);

	$xsqlCommand = "UPDATE userinbox SET IsFavorite=1 WHERE userID='".$_SESSION['Elooi_UserID'] . "' AND elooiID=" . $ElooiID ."";
	$debug = mysql_query($xsqlCommand);

}

?>