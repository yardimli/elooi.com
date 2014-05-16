<?php require_once("/server-settings.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php require_once('/php-functions.php'); ?>
<?php
//empty all inboxes
$users_res = mysql_query("DELETE FROM userinbox");




//add @tags for reply to database
$elooi_res = mysql_query("SELECT ID,ResponseToElooiID FROM eloois WHERE Deleted=0 AND ResponseToElooiID>0 AND EchoElooiID=0");
$elooi_rows = mysql_num_rows($elooi_res);
for ($i=0; $i<$elooi_rows; $i++)
{
	$OwnerElooiID = mysql_result($elooi_res,$i,"ResponseToElooiID");
	$ElooiID = mysql_result($elooi_res,$i,"ID");

	$elooi_res2 = mysql_query("SELECT users.username FROM eloois JOIN users ON eloois.userID=users.ID WHERE eloois.ID=".$OwnerElooiID);
	$elooi_rows2 = mysql_num_rows($elooi_res2);
	if ($elooi_rows2==1) {
		$TagToAdd = ATQ("@".mysql_result($elooi_res2,0,"users.username") );

		$AllTags_res = mysql_query("SELECT * FROM alltags WHERE tag=".$TagToAdd );
		$AllTags_rows = mysql_num_rows($AllTags_res);
		
		if ($AllTags_rows==1) { $TagToAddID=mysql_result($AllTags_res,0,"ID"); } else  //if tag found get ID and inc occurence 
		{   //if tag isnt found then add and get tag ID
			$AllTags_res = mysql_query("INSERT INTO alltags (tag,TagCount) VALUES (". $TagToAdd.",1)");

			$AllTags_res = mysql_query("SELECT * FROM alltags WHERE tag=".$TagToAdd);
			$AllTags_rows = mysql_num_rows($AllTags_res);
			if ($AllTags_rows==1) { $TagToAddID=mysql_result($AllTags_res,0,"ID"); } //tag found get ID
		}
		
		$AllTags_res = mysql_query("SELECT * FROM TagCloud WHERE ElooiID=".$ElooiID." AND TagID=".$TagToAddID );
		$AllTags_rows = mysql_num_rows($AllTags_res);
		if ($AllTags_rows==0) {
			$AllTags_res = mysql_query("INSERT INTO TagCloud (ElooiID,TagID,ResponseTag) VALUES (" . $ElooiID . "," . $TagToAddID . ",1)");
		} else
		{
			$AllTags_res = mysql_query("UPDATE TagCloud Set ResponseTag=1 WHERE ElooiID=" . ATQ($ElooiID) . " AND TagID=" . ATQ($TagToAddID) );
		}

	}
}

$users_res = mysql_query("SELECT * FROM users ORDER BY ID DESC");
$users_rows = mysql_num_rows($users_res);


for ($i=0; $i<$users_rows; $i++)
{
	$UserID=mysql_result($users_res,$i,"ID");
	update_inbox_for_user($UserID);
}
?>