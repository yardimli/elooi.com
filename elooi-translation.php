<?php require_once("/server-settings.php"); ?>
<?php
if (($_SESSION['Elooi_ILanguageID']=="1") or ($_SESSION['Elooi_ILanguageID']=="") or ($_SESSION['Elooi_ILanguageID']=="0")) {
	include('/elooi-turkish-language.php');
} else

///ENGLISH
if ($_SESSION['Elooi_ILanguageID']=="2") {
	include('/elooi-english-language.php');
} else

///CHINESE
if ($_SESSION['Elooi_ILanguageID']=="3") {
	include('/elooi-chinese-language.php');
} else

///NORWEGIAN
if ($_SESSION['Elooi_ILanguageID']=="4") {
	include('/elooi-norwegian-langauge.php');
}

function lang_aboutme($myname,$uid)
{
	if (($_SESSION['Elooi_ILanguageID']=="1") or ($_SESSION['Elooi_ILanguageID']=="") or ($_SESSION['Elooi_ILanguageID']=="0")) { 
		$res = "<b>@". $myname ."</b>";
		if ($uid==$_SESSION['Elooi_UserID']) { $res= "<b>benim hakkımda</b>"; } else {$res= $res." hakkında"; }
	} else
	if ($_SESSION['Elooi_ILanguageID']=="2") {
		$res = "<b>@". $myname ."</b>";
		if ($uid==$_SESSION['Elooi_UserID']) { $res= "<b>about me</b>"; } else {$res= "about ".$res; }
	} else
	if ($_SESSION['Elooi_ILanguageID']=="3") {
		$res = "<b>@". $myname ."</b>";
		if ($uid==$_SESSION['Elooi_UserID']) { $res= "<b>about me</b>"; } else {$res= "about ".$res; }
	} else
	if ($_SESSION['Elooi_ILanguageID']=="4") {
		$res = "<b>@". $myname ."</b>";
		if ($uid==$_SESSION['Elooi_UserID']) { $res= "<b>about me</b>"; } else {$res= "about ".$res; }
	}

	return $res;

}

function min_rec_time($seconds)
{
	if (($_SESSION['Elooi_ILanguageID']=="1") or ($_SESSION['Elooi_ILanguageID']=="") or ($_SESSION['Elooi_ILanguageID']=="0")) { 
		$res = "Bir Elooi en az 2 saniye uzunluğunda olmalı. Sizin kaydınız ".Round($seconds)." sürdü (başındaki ve sonundaki boşluklar silindikten sonra)";
	} else
	if ($_SESSION['Elooi_ILanguageID']=="2") {
		$res = "Your elooi message must be at least 1 second. Your recording was ".Round($seconds)." seconds after triming.";
	} else
	if ($_SESSION['Elooi_ILanguageID']=="3") {
		$res = "Your elooi message must be at least 1 second. Your recording was ".Round($seconds)." seconds after triming.";
	} else
	if ($_SESSION['Elooi_ILanguageID']=="4") {
		$res = "Your elooi message must be at least 1 second. Your recording was ".Round($seconds)." seconds after triming.";
	}
	return $res;

}

function echo_by($username)
{
	if (($_SESSION['Elooi_ILanguageID']=="1") or ($_SESSION['Elooi_ILanguageID']=="") or ($_SESSION['Elooi_ILanguageID']=="0")) { 
		$res = $username . " tarafından yankılandı!";
	} else
	if ($_SESSION['Elooi_ILanguageID']=="2") {
		$res = "echoed by ". $username;
	} else
	if ($_SESSION['Elooi_ILanguageID']=="3") {
		$res = "echoed by ". $username;
	} else
	if ($_SESSION['Elooi_ILanguageID']=="4") {
		$res = "echoed by ". $username;
	}
	return $res;
}

?>