<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php
$xsqlCommand = "UPDATE eloois SET listencounter=listencounter+1 WHERE ID=" . ATQ($_GET["ElooiID"]);
$log->lwrite("favorite: ".$xsqlCommand);
$debug = mysql_query($xsqlCommand);
?>