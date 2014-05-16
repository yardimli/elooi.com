<?php 
if (strpos($_SERVER["SERVER_NAME"],"elooi.com")===false)
{
//	exit;
}
//$some_name = session_name("elooicom");
//session_set_cookie_params ( 0 , '/', '.elooi.com');
session_start(); 
ob_start(); 

header('Content-Type: text/html; charset=UTF-8');

$lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
$page_subdomain = strtolower(substr($_SERVER["SERVER_NAME"], 0, 2));
$server_domain = $_SERVER["SERVER_NAME"];

$twitter_consumer_key = "wYg2fdysRZAqUvmp8aQ";
$twitter_consumer_secret = "OoGEWcWTwJEwJeybidMcUNLVekKvv9Q2x690NIRRhM";

$randomword = "bobblebibblechocolateccaat";
if (($page_subdomain=="tr") or ($page_subdomain=="ww") or ($page_subdomain=="el"))
{ $MysqlIP = "94.101.84.162"; } else
if (($page_subdomain=="en") or ($page_subdomain=="no") or ($page_subdomain=="tw"))
{ $MysqlIP = "208.109.97.91"; } else
{ $MysqlIP = "94.101.84.162"; }

$page_subdomain = "en";
$MysqlIP = "localhost";

mysql_connect($MysqlIP,"root","Mantik77"); //B123456a
mysql_select_db("cloudofvoice");
$mysqlresult = mysql_query("SET NAMES utf8");
$mysqlresult = mysql_query("SET CHARACTER_SET utf8");

$log = new Logging2();
$log->lfile('c:/php-log');
$log->lwrite('-...----------------------------------');

$Turkish_letters = array("ü","Ü","ç","Ç","ğ","Ğ","ö","Ö","ş","Ş","ı","İ","'");
$Turkish_letters2= array("u","U","c","C","g","G","o","O","s","S","i","I","");


//first if url already has langauge subdomain dont worry
if ( ($page_subdomain=="tr") or ($page_subdomain=="en") or ($page_subdomain=="tw") or ($page_subdomain=="no") ) { 
	if ( ($page_subdomain=="tr") ) { 
		$_SESSION["Elooi_ILanguageID"] = "1"; 	
		$server_domain = "tr.elooi.com";
	} else
	if ( ($page_subdomain=="no") ) { 
		$_SESSION["Elooi_ILanguageID"] = "4";
		$server_domain = "no.elooi.com";
	} else
	if ( ($page_subdomain=="tw") ) { 
		$_SESSION["Elooi_ILanguageID"] = "3";
		$server_domain = "tw.elooi.com";
	} else
	if ( ($page_subdomain=="en") ) { 
		$_SESSION["Elooi_ILanguageID"] = "2";
		$server_domain = "en.elooi.com";
	}
	$_SESSION["Elooi_ILanguageID"] = "2";
	$server_domain = "192.168.11.10";
} else
{
	$_SESSION["Elooi_ILanguageID"] = "2";
//	header( "Location: http://elooi.com".$_SERVER["REQUEST_URI"] ) ;
//	exit();
	/*
	//if user have logged in
	if ($_SESSION['Elooi_UserID']!="") {
		if ($_SESSION["Elooi_ILanguageID"] == "1")  { 
			header( "Location: http://tr.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		if ($_SESSION["Elooi_ILanguageID"] == "4") { 
			header( "Location: http://no.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		if ($_SESSION["Elooi_ILanguageID"] == "3") { 
			header( "Location: http://tw.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		if ($_SESSION["Elooi_ILanguageID"] == "2") { 
			header( "Location: http://en.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		{ 
			header( "Location: http://en.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		}
	} else

	//if user have not logged in
	if ($_SESSION['Elooi_UserID']=="") {
		if ($lang=="tr")  { 
			$_SESSION["Elooi_ILanguageID"] = "1";
			header( "Location: http://tr.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		if ($lang=="no") { 
			$_SESSION["Elooi_ILanguageID"] = "4";
			header( "Location: http://no.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		if ($lang=="tw") { 
			$_SESSION["Elooi_ILanguageID"] = "3";
			header( "Location: http://tw.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		if ($lang=="en") { 
			$_SESSION["Elooi_ILanguageID"] = "2";
			header( "Location: http://en.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		} else
		if ($_SESSION['Elooi_UserID']=="") { 
			$_SESSION["Elooi_ILanguageID"] = "2";
			header( "Location: http://en.elooi.com".$_SERVER["REQUEST_URI"] ) ;
			exit();
		}
	}
	*/
}


/**
 * Logging class:
 * - contains lfile, lopen and lwrite methods
 * - lfile sets path and name of log file
 * - lwrite will write message to the log file
 * - first call of the lwrite will open log file implicitly
 * - message is written with the following format: hh:mm:ss (script name) message
 */
class Logging2{
    // define default log file
    private $log_file = '/tmp/logfile.log';
    // define file pointer
    private $fp = null;
    // set log file (path and name)
    public function lfile($path) {
        $this->log_file = $path;
    }
    // write message to the log file
    public function lwrite($message){
        // if file pointer doesn't exist, then open log file
        if (!$this->fp) $this->lopen();
        // define script name
        $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        // define current time
        $time = date('H:i:s');
        // write current time, script name and message to the log file
        fwrite($this->fp, "$time ($script_name) $message\n");
    }
    // open log file
    private function lopen(){
        // define log file path and name
        $lfile = $this->log_file;
        // define the current date (it will be appended to the log file name)
        $today = date('Y-m-d');
        // open log file for writing only; place the file pointer at the end of the file
        // if the file does not exist, attempt to create it
        $this->fp = fopen($lfile . '_' . $today, 'a') or exit("Can't open $lfile!");
    }
}

?>