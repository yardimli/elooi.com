<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php

if ( ($_POST["s_tags"]!="") && ($_POST["s_EchoElooiID"]!="") && (intval($_POST["s_EchoElooiID"])>0) ) {

	$ElooiID= $_POST["s_EchoElooiID"];

	//select elooi to clone
	$xcmd = "SELECT * FROM eloois WHERE ID=".$ElooiID;
	$cloneRes = mysql_query($xcmd);

	//insert clone into eloois table with echoUserID and original Elooi ID
	$xsqlCommand = "INSERT INTO eloois (userID,LanguageID,LinkURL,ShortURL,MusicCredit,ProfileElooi,ResponseToElooiID,ElooiTime,senderIP,Location,TrackLength,Picture,EchoElooiID,EchoUserID) VALUES (" . ATQ(mysql_result($cloneRes,0,"userID")) . "," . ATQ(mysql_result($cloneRes,0,"LanguageID")) . "," . ATQ(mysql_result($cloneRes,0,"LinkURL")) .",". ATQ(mysql_result($cloneRes,0,"ShortURL")) . "," . ATQ(mysql_result($cloneRes,0,"MusicCredit")) . ",0,". ATQ(mysql_result($cloneRes,0,"ResponseToElooiID")) .",now()," . ATQ(getUserIpAddr()) . "," . ATQ(mysql_result($cloneRes,0,"Location")) .",". ATQ(mysql_result($cloneRes,0,"TrackLength")) .",". ATQ(mysql_result($cloneRes,0,"Picture")) ."," . ATQ($ElooiID) ."," . ATQ($_SESSION['Elooi_UserID']) . ")";
	
	$log->lwrite($xsqlCommand);

	$mysqlresult = mysql_query($xsqlCommand);

	//no need to clone original tags since we will show orginal tags in blue and new tags in read from me.php
	$xsqlCommand = "SELECT * FROM eloois WHERE EchoUserID=".$_SESSION['Elooi_UserID']." ORDER BY ID DESC LIMIT 1";
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1)
	{
		$NewElooiID= mysql_result($mysqlresult,0,"ID");

		//insert tags
		if ($_POST["s_tags"]!="") {
			$tags = explode(",",$_POST["s_tags"]);
			for($i = 0; $i < count($tags); $i++){
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

				$xsqlCommand_AllTags = "INSERT INTO TagCloud (ElooiID,TagID) VALUES (" . $NewElooiID . "," . $TagToAddID . ")";
				$mysqlresult_AllTags = mysql_query($xsqlCommand_AllTags);
			}
		}
	}
}
?>

<script type="text/javascript">
	parent.jQuery("#process-sound").html("");
	$.colorbox({href:"/echo-saved.php"});
</script>