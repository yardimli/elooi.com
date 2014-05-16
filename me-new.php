<?php require_once("/server-settings.php"); ?>
<?php
if ( ( ($_GET["uid"]!="") && (intval($_GET["uid"])>0) ) or ($_SESSION['uid']!="") )
{
	if ($_SESSION['uid']!="") { $UserID = $_SESSION['uid']; $_SESSION['uid']=""; }
	if ( ($_GET["uid"]!="") && (intval($_GET["uid"])>0) ) { $UserID = $_GET["uid"]; }

	$xsqlCommand = "SELECT * FROM users WHERE ID=".$UserID;
	$mysqlresult = mysql_query($xsqlCommand);
	$UserName = "";
	if (mysql_num_rows($mysqlresult)==1) { $UserName = mysql_result($mysqlresult,0,"UserName"); }
}

if (($UserID!="") and ($UserID!=-100) and ($UserID!=-200)) 
{ 
	$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=".$UserID;
	$mysqlresult3 = mysql_query($xsqlCommand3);

	$_SESSION['tileBackground']   = mysql_result($mysqlresult3,0,"tileBackground");
	$_SESSION['backgroundImage']  = mysql_result($mysqlresult3,0,"backgroundImage");
	$_SESSION['backgroundColor']  = mysql_result($mysqlresult3,0,"backgroundColor");
	$_SESSION['textColor']        = mysql_result($mysqlresult3,0,"textColor");
	$_SESSION['linkColor']        = mysql_result($mysqlresult3,0,"linkColor");
	$_SESSION['headerColor']      = mysql_result($mysqlresult3,0,"headerColor");
	$_SESSION['textBackgroundColor']   = mysql_result($mysqlresult3,0,"textBackgroundColor");

	$col = hex2RGB(mysql_result($mysqlresult3,0,"textBackgroundColor"));
	$_SESSION['textBackgroundColorR']   = $col['red'];
	$_SESSION['textBackgroundColorG']   = $col['green'];
	$_SESSION['textBackgroundColorB']   = $col['blue'];

	$col = hex2RGB(mysql_result($mysqlresult3,0,"BackgroundColor"));
	$_SESSION['BackgroundColorR']   = $col['red'];
	$_SESSION['BackgroundColorG']   = $col['green'];
	$_SESSION['BackgroundColorB']   = $col['blue'];

	if ( ($UserID!=$_SESSION['Elooi_UserID'])  and (($_SESSION['me_subpage']=="") or ($_SESSION['me_subpage']=="mentions") ) )
	{
		$_SESSION['me_subpage']="profil";
	}

	if (($_SESSION['me_subpage']=="") or ($_SESSION['me_subpage']=="mentions") ) { 
		$page="my-index"; 
	} else {
		$page="profile-page"; 
	}
} else 
{
	if (($_SESSION['Elooi_UserID']=="") or ($_SESSION['Elooi_UserID']=="0")) {
		$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=43"; } else
	{	$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=".$_SESSION['Elooi_UserID']; }
	$mysqlresult3 = mysql_query($xsqlCommand3);

	$_SESSION['tileBackground']   = mysql_result($mysqlresult3,0,"tileBackground");
	$_SESSION['backgroundImage']  = mysql_result($mysqlresult3,0,"backgroundImage");
	$_SESSION['backgroundColor']  = mysql_result($mysqlresult3,0,"backgroundColor");
	$_SESSION['textColor']        = mysql_result($mysqlresult3,0,"textColor");
	$_SESSION['linkColor']        = mysql_result($mysqlresult3,0,"linkColor");
	$_SESSION['headerColor']      = mysql_result($mysqlresult3,0,"headerColor");
	$_SESSION['textBackgroundColor']   = mysql_result($mysqlresult3,0,"textBackgroundColor");

	$col = hex2RGB(mysql_result($mysqlresult3,0,"textBackgroundColor"));
	$_SESSION['textBackgroundColorR']   = $col['red'];
	$_SESSION['textBackgroundColorG']   = $col['green'];
	$_SESSION['textBackgroundColorB']   = $col['blue'];

	$col = hex2RGB(mysql_result($mysqlresult3,0,"BackgroundColor"));
	$_SESSION['BackgroundColorR']   = $col['red'];
	$_SESSION['BackgroundColorG']   = $col['green'];
	$_SESSION['BackgroundColorB']   = $col['blue'];

	if (($_SESSION["etiket"]=="") && ($_SESSION["searchq"]==""))	{ $page="all-new";  } else { $page="result-page"; }

}
?>
<?php include("/ortak-header.php"); ?>
<?php include("/me-js.php"); ?>

<div style="width:1000px; margin:0 auto; padding:0px; overflow:hidden;" id="main_grid">

<div id="grid_rightcol" class="elooi-page-rightcol" style="float:left; position:fixed; z-index:5; background:<?php echo $_SESSION['textBackgroundColor']; ?>;  background:<?php echo $_SESSION['textBackgroundColor']; ?>; background:rgba(<?php echo $_SESSION['textBackgroundColorR'] ?>,<?php echo $_SESSION['textBackgroundColorG'] ?>,<?php echo $_SESSION['textBackgroundColorB'] ?>,0.75); "" >
	<div id="rightcol_user_info" style="width:330px;">
	</div>
</div>

