<?php 
require_once("/server-settings.php"); 
include("/php-functions.php");

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`

$Location_ = "'".AddSlashes(Trim($_POST["s_Location"]))."'";

/* Validate the form on server side */
if (empty($_POST['urlID'])) { //Name cannot be empty
    $errors['name'] = 'No URL';
} else

if (empty($_POST['commentary'])) { //Name cannot be empty
    $errors['name'] = 'No Commentary';
} else

if ( (!isset($_SESSION['Elooi_UserID'])) or ($_SESSION['Elooi_UserID']=="") or ($_SESSION['Elooi_UserID']=="0") ) 
{
    $errors['name'] = 'Please login again.';
}

if (empty($errors)) { //If no errors yet
	$xsqlCommand = "SELECT * FROM eloois WHERE userID=".$_SESSION['Elooi_UserID']." and urlID='".mysql_real_escape_string($_POST['urlID'])."' AND Deleted=0";
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1)
	{
		$errors['name'] = 'You have already shared this article';
	}
}

if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
} else 
{ //If not, process the form, and return true on success

	$StreamID = "0";
	$xsqlCommand_AllStreams = "SELECT * FROM streams WHERE stream='".mysql_real_escape_string($_POST['stream'])."'";
	$mysqlresult_AllStreams = mysql_query($xsqlCommand_AllStreams);
	$num_rows_AllStreams = mysql_num_rows($mysqlresult_AllStreams);
	if ($num_rows_AllStreams==1) //tag found get ID and inc occurence 
	{
		$StreamID=mysql_result($mysqlresult_AllStreams,0,"ID");
//		$xsqlCommand_AllStreams = "UPDATE allStreams Set TagCount=TagCount+1 WHERE ID=".$TagToAddID;
//		$mysqlresult_AllStreams = mysql_query($xsqlCommand_AllStreams_update);

	} else //if tag isnt found then add and get tag ID
	{
		$xsqlCommand_AllStreams = "INSERT INTO streams (stream) VALUES ('".mysql_real_escape_string($_POST['stream'])."')";
		$mysqlresult_AllStreams = mysql_query($xsqlCommand_AllStreams);

		$xsqlCommand_AllStreams = "SELECT * FROM streams WHERE stream='".mysql_real_escape_string($_POST['stream'])."'";
		$mysqlresult_AllStreams = mysql_query($xsqlCommand_AllStreams);
		$num_rows_AllStreams = mysql_num_rows($mysqlresult_AllStreams);
		if ($num_rows_AllStreams==1) //tag found get ID and inc occurence 
		{
			$StreamID=mysql_result($mysqlresult_AllStreams,0,"ID");
		}
	}


    
	$xsqlCommand = "INSERT INTO eloois (userID,ElooiTime,senderIP,Location,commentary,urlID,ImageID,streamID) VALUES (" . $_SESSION['Elooi_UserID'] . ",now(),'" . getUserIpAddr() . "'," . $Location_ .",'".mysql_real_escape_string($_POST['commentary'])."','".mysql_real_escape_string($_POST['urlID'])."','".mysql_real_escape_string($_POST['imageID'])."','". $StreamID ."')";

	$log->lwrite("new elooi: ".$xsqlCommand);
	$mysqlresult = mysql_query($xsqlCommand);
	
	$form_data['success'] = true;
    $form_data['posted'] = 'Data Was Posted Successfully';
}

//Return the data back to form.php
echo json_encode($form_data);

?>