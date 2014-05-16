<?php require_once("/server-settings.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php include("/php-functions.php"); ?>
<?php
$ErrorMessage="";
$HasError = 0;

$s_Url = $_POST["s_Url"];
if ($s_Url!="")
{
    if (stripos($s_Url,"http://")===false) { $s_Url = "http://".$s_Url; }
	if (filter_var($s_Url, FILTER_VALIDATE_URL)===false)
		{ $ErrorMessage = $Settings_Profile_Error_Url; $HasError = 1; } //Please check your homepage address. It must start with http:// and be a valid url.
}

if ($HasError == 0)
{
	require_once('/getid3/getid3.php');
	define('GETID3_HELPERAPPSDIR', 'C:/helperapps/');
	$getID3 = new getID3;
	$ThisFileInfo = $getID3->analyze("c:\\wamp\\www\\audio-temp\\".$_POST["s_mp3_file"]);
	$PlayTime = $ThisFileInfo['playtime_seconds'];

	if (Round($PlayTime)<2)
		{ $ErrorMessage = min_rec_time($PlayTime); $HasError = 1; }

	if ($HasError == 0)
	{
		$Location_             = "'".AddSlashes(Trim($_POST["s_Location"]))."'";
		$ResponseToElooiID_    = "'".AddSlashes(Trim($_POST["s_reply_to_id"]))."'";
		
		//add elooi
		$xsqlCommand = "INSERT INTO eloois (userID,ShortURL,ElooiTime,senderIP,Location,TrackLength,ResponseToElooiID) VALUES (" . $_SESSION['Elooi_UserID'] . ",'',now(),'" . getUserIpAddr() . "'," . $Location_ .",". round($PlayTime) .",". $ResponseToElooiID_ .")";
		//echo $xsqlCommand;

		$log->lwrite("new elooi: ".$xsqlCommand);

		$mysqlresult = mysql_query($xsqlCommand);

		$xsqlCommand = "SELECT * FROM eloois WHERE userID=".$_SESSION['Elooi_UserID']." ORDER BY ID DESC LIMIT 1";
		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==1)
		{
			//save file with id
			$ElooiID= mysql_result($mysqlresult,0,"ID");

			copy("c:\\wamp\\www\\audio-temp\\".$_POST["s_mp3_file"] , "c:\\wamp\\www\\audio-elooi\\".$ElooiID."-".$_SESSION['Elooi_UserID'] .".mp3");
			
			/*
			if ($_POST["s_picture_file"]!="")
			{
				$fileExt1     = pathinfo($_POST["s_picture_file"], PATHINFO_EXTENSION);

				$log->lwrite("copy: "."c:\\wamp\\www\\site_veri\\picture_temp\\".$_POST["s_picture_file"]);
				$log->lwrite("-->to: "."c:\\wamp\\www\\audio-picture\\".$ElooiID."-".$_SESSION['Elooi_UserID'].".".$fileExt1);


				copy("c:\\wamp\\www\\site_veri\\picture_temp\\".$_POST["s_picture_file"] , "c:\\wamp\\www\\audio-picture\\".$ElooiID."-".$_SESSION['Elooi_UserID'].".".$fileExt1);

				$log->lwrite("UPDATE eloois SET Picture = '". AddSlashes(Trim($ElooiID."-".$_SESSION['Elooi_UserID'].".".$fileExt1)) ."' WHERE ID=".$ElooiID);
				$update1 = mysql_query("UPDATE eloois SET Picture = '". AddSlashes(Trim($ElooiID."-".$_SESSION['Elooi_UserID'].".".$fileExt1)) ."' WHERE ID=".$ElooiID);
			}
			*/

			//insert tags
			if ($_POST["s_tags"]!="") {

				$log->lwrite("tags: ".$_POST["s_tags"]);

				$tags = explode(",",$_POST["s_tags"]);
				for($i = 0; $i < count($tags); $i++){
					$log->lwrite("adding tag: ".$tags[$i]);

					$TagToAdd = "'".AddSlashes(Trim( $tags[$i]  ))."'";
					$TagToAddID = "0"; //if this remains 0 problem and tag wasnt added

					$xsqlCommand_AllTags = "SELECT * FROM alltags WHERE tag=".$TagToAdd;
					$mysqlresult_AllTags = mysql_query($xsqlCommand_AllTags);
					$num_rows_AllTags = mysql_num_rows($mysqlresult_AllTags);
					if ($num_rows_AllTags==1) //tag found get ID and inc occurence 
					{
						$TagToAddID=mysql_result($mysqlresult_AllTags,0,"ID");
						$xsqlCommand_AllTags = "UPDATE alltags Set TagCount=TagCount+1 WHERE ID=".$TagToAddID;
						$mysqlresult_AllTags = mysql_query($xsqlCommand_AllTags_update);

					} else //if tag isnt found then add and get tag ID
					{
						$xsqlCommand_AllTags = "INSERT INTO alltags (tag,TagCount) VALUES (".$TagToAdd.",1)";
						$mysqlresult_AllTags = mysql_query($xsqlCommand_AllTags);

						$xsqlCommand_AllTags = "SELECT * FROM alltags WHERE tag=".$TagToAdd;
						$mysqlresult_AllTags = mysql_query($xsqlCommand_AllTags);
						$num_rows_AllTags = mysql_num_rows($mysqlresult_AllTags);
						if ($num_rows_AllTags==1) //tag found get ID and inc occurence 
						{
							$TagToAddID=mysql_result($mysqlresult_AllTags,0,"ID");
						}
					}

					$xsqlCommand_AllTags = "INSERT INTO TagCloud (ElooiID,TagID) VALUES (" . $ElooiID . "," . $TagToAddID . ")";
					$mysqlresult_AllTags = mysql_query($xsqlCommand_AllTags);
				}
			}
		}
	}
}
?>

<script type="text/javascript">
<?php 
if ($HasError==1)
{
?>
	alert("<?php echo $ErrorMessage; ?>");
	parent.jQuery("#process-sound").html("");
<?php 
} else
{
	$_SESSION['LastSaveElooiID'] = $ElooiID;
	$_SESSION['LastSaveElooiLength'] = round($PlayTime);
	$_SESSION['LastSaveTags'] = $_POST["s_tags"];

	if ($_POST["s_picture_file"]!="")
	{
		$_SESSION['LastSavePicture'] = AddSlashes(Trim($ElooiID."-".$_SESSION['Elooi_UserID'].".".$fileExt1));
	} else
	{
		$_SESSION['LastSavePicture'] = "";
	}
	
?>
	parent.jQuery("#process-sound").html("");
	var MP3FileToPlay = "http://www.<?php echo $server_domain; ?>/audio-elooi/<?php echo $ElooiID."-".$_SESSION['Elooi_UserID'] .".mp3"; ?>";
	$.colorbox({href:"/elooi-saved.php"});
<?php 
}
?>

</script>