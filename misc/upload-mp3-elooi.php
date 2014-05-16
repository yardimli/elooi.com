<?php require_once("/server-settings.php"); ?>
<?php
// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
if (isset($_POST["PHPSESSID"])) { session_id($_POST["PHPSESSID"]); }
?><?php include("/php-functions.php"); ?><?php
	$log->lwrite('elooi-mp3 upload begin');
	ini_set("html_errors", "0");

	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
	$log->lwrite('elooi-mp3 upload error');
//		echo "ERROR:invalid upload";
		exit(0);
	}

	$fileExt1     = pathinfo($_FILES["Filedata"]["name"], PATHINFO_EXTENSION);
	$save_path    = "c:/wamp/www/site_veri/mp3_temp/";
	$file_name    = sprintf( '%012d',$_SESSION['Elooi_UserID'])."-".time().".".$fileExt1;
	if (!@move_uploaded_file($_FILES["Filedata"]["tmp_name"], $save_path . $file_name)) {
		$log->lwrite('elooi-mp3 move problem');
		echo "File could not be saved.";
		exit(0);
	}

	echo "PROMP3:OK:".$file_name;
	$log->lwrite('elooi-mp3 upload done:'.$file_name);

?>