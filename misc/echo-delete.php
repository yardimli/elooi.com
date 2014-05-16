<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php
$ErrorMessage="";
$HasError = 0;

$ElooiID  = "'".AddSlashes(Trim($_GET["ElooiID"]))."'";

$xsqlCommand = "UPDATE eloois SET Deleted=1 WHERE EchoUserID='" . $_SESSION['Elooi_UserID'] . "' AND ID=" . $ElooiID ."";
$log->lwrite("delete: ".$xsqlCommand);
$debug = mysql_query($xsqlCommand);

$xsqlCommand = "UPDATE eloois SET Deleted=1 WHERE EchoUserID='" . $_SESSION['Elooi_UserID'] . "' AND EchoElooiID=" . $ElooiID ."";
$log->lwrite("delete: ".$xsqlCommand);
$debug = mysql_query($xsqlCommand);
?>