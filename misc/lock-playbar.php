<?php require_once("/server-settings.php"); ?>
<?php 
if ($_GET["op"]=="lock") { $_SESSION['lockPlaybar']="1"; }
if ($_GET["op"]=="unlock") { $_SESSION['lockPlaybar']="0"; }
?>