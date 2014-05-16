<?php require_once("/server-settings.php"); ?>
<?php 
if ($_GET["op"]=="backward") { $_SESSION['lockPlayDir']="0"; }
if ($_GET["op"]=="forward") { $_SESSION['lockPlayDir']="1"; }
?>