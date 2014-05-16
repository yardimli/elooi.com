<?php require_once("/server-settings.php"); ?>
<?php require_once('/php-functions.php'); ?>
<?php
$urlVariables = explode("/",$_SERVER['REQUEST_URI']);

$log2 = new Logging();
$log2->lfile('c:/php-log-2');
$log2->lwrite(AddSlashes(Trim(urldecode($_SERVER['REQUEST_URI']))));

if ( ($urlVariables[1] == "search") && ($urlVariables[2] != "") ) {
			$_SESSION['SingleElooiID'] = "";
			$_SESSION['did'] = "";
			$_SESSION['uid'] = -100;
			$_SESSION['me_subpage'] = "";
			$_SESSION['searchq'] = "";
			$_SESSION['etiket'] = "";

			$searchq = urldecode($urlVariables[2]);
			if (substr($searchq,0,3)=="?q=") {
				$_SESSION['searchq'] = substr($searchq,3,100);
				include("/me.php");
			}
} else

if ( ($urlVariables[1] == "u") && ($urlVariables[2] != "") ) {
	$getalias = mysql_query("select ID FROM users WHERE UserName = ".ATQ($urlVariables[2]) );

	if (mysql_num_rows($getalias)==1)
	{
		$_SESSION['etiket'] = "";
		$_SESSION['did'] = "";
		$_SESSION['searchq'] = "";
		$_SESSION['me_subpage'] = $urlVariables[3];
		$_SESSION['uid'] = mysql_result($getalias,0,"ID");
		if ($urlVariables[3]=="elooi") { $_SESSION['SingleElooiID']=$urlVariables[4]; include("/me-single.php");	} else 
		if ($urlVariables[3]=="") { $_SESSION['SingleElooiID'] = ""; include("/me-new.php"); } else
		
		{ $_SESSION['SingleElooiID'] = ""; include("/me.php"); }

	} else
	{
		header( "Location: http://".$server_domain."/index.php?r=0" ) ;
		exit();
		//include("/index.php");
	}
} else

if ( ($urlVariables[1] == "d") && ($urlVariables[2] != "") ) {
	if (intval($urlVariables[2])>0)
	{
		$_SESSION['etiket'] = "";
		$_SESSION['SingleElooiID'] = "";
		$_SESSION['searchq'] = "";
		$_SESSION['uid'] = -100;
		$_SESSION['me_subpage'] = "discussion";
		$_SESSION['did'] = $urlVariables[2];
		include("/me.php");
	} else
	{
		header( "Location: http://".$server_domain."/index.php?r=1" ) ;
		exit();
		//include("/index.php");
	}
} else

if ( ($urlVariables[1] == "etiket") && ($urlVariables[2] != "") ) {
	if (substr($urlVariables[2],0,1)=="@")
	{
		$getalias = mysql_query("select ID FROM users WHERE UserName = ".ATQ(substr($urlVariables[2],1)) );
		if (mysql_num_rows($getalias)==1)
		{
			header( "Location: http://".$server_domain."/u/". substr($urlVariables[2],1) . "/profil" ) ;
			exit();
		} else
		{
			$_SESSION['SingleElooiID'] = "";
			$_SESSION['searchq'] = "";
			$_SESSION['did'] = "";
			$_SESSION['uid'] = -100;
			$_SESSION['me_subpage'] = "";
			$_SESSION['etiket'] = urldecode($urlVariables[2]);
		}
	} else
	{
		$_SESSION['SingleElooiID'] = "";
		$_SESSION['searchq'] = "";
		$_SESSION['did'] = "";
		$_SESSION['uid'] = -100;
		$_SESSION['me_subpage'] = "";
		$_SESSION['etiket'] = urldecode($urlVariables[2]."/".$urlVariables[3]);
	}
	include("/me.php");
}
else if ($urlVariables[1] == "yeniler") {
	$_SESSION['etiket'] = "";
	$_SESSION['me_subpage'] = "";
	$_SESSION['searchq'] = "";
	$_SESSION['uid'] = -100;
	$_SESSION['did'] = "";
	include("/me-allnew.php");
} else
{
	$_SESSION['etiket'] = "";
	$_SESSION['searchq'] = "";
	$_SESSION['me_subpage'] = "";
	header( "Location: http://".$server_domain."/index.php?r=2" ) ;
	exit();
}

?>
