<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php
	if ( ($_GET["ILanguageID_"]!="") && (intval($_GET["ILanguageID_"]) >0) )
	{
		if ($_SESSION['Elooi_UserID']!="")
		{
			$xsqlCommand = "UPDATE users SET ILanguageID =".ATQ($_GET["ILanguageID_"] )." WHERE ID=".$_SESSION['Elooi_UserID'];
			//echo $xsqlCommand;
			$mysqlresult1 = mysql_query($xsqlCommand);
		}

		$_SESSION['Elooi_ILanguageID'] = $_GET["ILanguageID_"];

	}

	if ($_GET["p"]=="front")
	{
		header( "Location: http://".$server_domain."/" ) ;
	}
	
?>
<?php echo $Elooi_Interface_Langauge_Changed; ?>