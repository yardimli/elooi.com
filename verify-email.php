<?php $page="signin"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/mini-page-header.php"); ?>
<?php
$VerificationResult = $Verify_Email_Error;

if (isset($_GET["q"]))
{

	$xsqlCommand = "SELECT * FROM users WHERE VerificationCode='".AddSlashes(Trim($_GET["q"]))."'";
	//echo $xsqlCommand;
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1)
	{
		$_SESSION['Elooi_AccountVerified'] = "1";
		$xsqlCommand = "UPDATE users SET AccountVerified=1 WHERE VerificationCode='".AddSlashes(Trim($_GET["q"]))."'";
		$mysqlresult = mysql_query($xsqlCommand);
		$VerificationResult = $Verify_Email_Thank_You;
	}
}
?>

<body>
<div id="narrow_page">
	<a href="/index.php"><img src="<?php
		if ($page_subdomain=="tr") { echo "/cloudofvoice_screen_logo-nobg-tr.jpg"; } else
		if ($page_subdomain=="tw") { echo "/cloudofvoice_screen_logo-nobg-tw.jpg"; } else
		if ($page_subdomain=="no") { echo "/cloudofvoice_screen_logo-nobg-no.jpg"; } else
		if ($page_subdomain=="en") { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } else
								   { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } ?>" style="height:46px; width:250px; margin-top:8px; margin-left:0px; margin-bottom:5px; border:0px;"></a>

    <div class="slimdes">
		<div class="banner">
			<h2><?php echo $Verify_Email_Title ?></h2>
		</div>
		<div class="content-main" style="line-height:140%">

<br>
<?php echo $VerificationResult; ?>
<br>


<a href="http://<?php echo $server_domain; ?>"><?php echo $Verify_Email_Return; ?></a>.
<br><br>
<!-- FOTTER -->
		
			</div>	
		</div>
		
	</div>
 </div>
<div id="lb"></div>

</body>
</html>