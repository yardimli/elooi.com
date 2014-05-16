<?php
	/* Note: This thumbnail creation script requires the GD PHP Extension.  
		If GD is not installed correctly PHP does not render this page correctly
		and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
	 */

	// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	session_start();
	ini_set("html_errors", "0");

	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
//		echo "ERROR:invalid upload";
		exit(0);
	}

	$save_path = "c:/wamp/www/site_veri/profile_temp/";
	$file_name = $_FILES["Filedata"]["name"];
	if (!@move_uploaded_file($_FILES["Filedata"]["tmp_name"], $save_path . $file_name)) {
		echo "File could not be saved.";
		exit(0);
	}

	echo "UPLOAD:OK";

//	$img = imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
?>