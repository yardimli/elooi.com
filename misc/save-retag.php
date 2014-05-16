<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php

//update tags

if ( ($_POST["s_tags"]!="") && ($_POST["s_RetagElooiID"]!="") && (intval($_POST["s_RetagElooiID"])>0) ) {
	$ElooiID= $_POST["s_RetagElooiID"];

	//check that the elooi belongs to the user with login
	if (($_SESSION['Elooi_UserID']==1000048)  or ($_SESSION['Elooi_UserID']==43)) {
		$xsqlCommand = "SELECT ID FROM eloois WHERE ID='". $ElooiID ."'";
	} else
	{
		$xsqlCommand = "SELECT ID FROM eloois WHERE userID='". $_SESSION['Elooi_UserID']."' AND ID='". $ElooiID ."'";
	}
	$mysqlresult = mysql_query($xsqlCommand);

	if (mysql_num_rows($mysqlresult)==1)
	{
		//delete existing tags
		$xsqlCommand = "DELETE FROM TagCloud WHERE ElooiID='". $ElooiID."' AND responseTag=0";
		$mysqlresult = mysql_query($xsqlCommand);

		//add tags
		$tags = explode(",",$_POST["s_tags"]);
		for($i = count($tags)-1; $i>=0; $i--){
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
?>

<script type="text/javascript">
	parent.jQuery("#process-sound").html("");
	$.colorbox({href:"/retag-saved.php"});
</script>