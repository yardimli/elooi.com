<?php require_once("/server-settings.php"); ?>
<?php
// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
if (isset($_POST["PHPSESSID"])) { session_id($_POST["PHPSESSID"]); }
?><?php include("/php-functions.php"); ?>
<?php
	// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
	ini_set("html_errors", "0");

	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
//		echo "ERROR:invalid upload";
		exit(0);
	}

	$fileExt1     = pathinfo($_FILES["Filedata"]["name"], PATHINFO_EXTENSION);
	$save_path = "c:/wamp/www/site_veri/temp_bg/";
	$file_name = sprintf( '%012d',$_SESSION['Elooi_UserID'])."-".time() .".".$fileExt1;
	if (!@move_uploaded_file($_FILES["Filedata"]["tmp_name"], $save_path . $file_name)) {
		echo "File could not be saved.";
		exit(0);
	}

	echo "PROBKG:OK:".$file_name;

//	$img = imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
?>