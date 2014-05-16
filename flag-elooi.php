<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php
$ElooiID = $_GET["s_ElooiID"];
if (($ElooiID!="") and (intval($ElooiID)>0))
{
	if ($_SESSION['Elooi_UserID']!="") { $UserID=$_SESSION['Elooi_UserID']; } else {$UserID="0"; }


	$xsqlCommand = "INSERT INTO BanReport (ElooiID,ReportIP,ReportDate,FlagUserID) VALUES (". ATQ($ElooiID) .",". ATQ( getUserIpAddr() ) .",now(),". ATQ($UserID) .")";

	$log->lwrite("flag: ".$xsqlCommand);
	$debug = mysql_query($xsqlCommand);
}
?>