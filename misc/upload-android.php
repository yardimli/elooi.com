<?php

// Check the upload
if (!isset($_FILES["uploadedfile"]) || !is_uploaded_file($_FILES["uploadedfile"]["tmp_name"]) || $_FILES["uploadedfile"]["error"] != 0) {
	echo "ERROR:invalid upload";
	exit(0);
}

$file_name    = $_FILES["uploadedfile"]["name"];
$save_path    = "c:/wamp/www/upload-android/";

if (!@move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], $save_path . $file_name)) {
	echo "File could not be saved.";
	exit(0);
}

echo "FILE SAVE COMPLETE";
?>
