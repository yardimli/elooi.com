<?php $page="signin"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/mini-page-header.php"); ?>
<?php

$Email       = "";
$Password    = "";
$FormMessage = "";

$HasError = 0;
$PasswordError = 0;

if ($_POST["op"]=="signin_popup")
{
	$Email      = $_POST["SignIn_Email"];
	$Password   = $_POST["SignIn_Password"];
	$remember_me= $_POST["remember_me"];
}

if ($_POST["op"]=="signin")
{
	$Email      = $_POST["Email"];
	$Password   = $_POST["Password"];
	$remember_me= $_POST["remember_me"];
}

if ( ($_POST["op"]=="signin_popup") or ($_POST["op"]=="signin"))
{
	if ($Email=="") { $Email_Error = "<div class=form-error>". $signup_Email_Error . "</div>"; $HasError = 1; } else
 	if (verify_Email($Email)) {} else { $Email_Error = "<div class=form-error>". $signup_Email_Error2 . "</div>"; $HasError = 1; }


	if ($Password=="") { $Password_Error = "<div class=form-error>" . $signup_Password_Error ."</div>"; $HasError = 1; } 

	if ($HasError==0)
	{

		$Email_      = "'".AddSlashes(Trim($Email))."'";
		$Password_   = "'".AddSlashes(Trim(md5($Password.$randomword)))."'";

		$xsqlCommand = "SELECT * FROM users WHERE Email=".$Email_." AND Password=".$Password_;
//		echo $xsqlCommand;

		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==1)
		{
			if ($remember_me =="1")
			{
				$xsqlCommand2 = "UPDATE users SET userID_MD5='".md5(mysql_result($mysqlresult,0,"ID").$randomword)."' WHERE Email=".$Email_." AND Password=".$Password_;
				$mysqlresult2 = mysql_query($xsqlCommand2);

				setcookie("userID", md5(mysql_result($mysqlresult,0,"ID").$randomword), time()+(3600*24*31));
				setcookie("remember_me", "true", time()+(3600*24*31));
			}

			$_SESSION['Elooi_User'] = true;
			$_SESSION['Elooi_AccountVerified'] = mysql_result($mysqlresult,0,"AccountVerified");
			$_SESSION['Elooi_UserID'] = mysql_result($mysqlresult,0,"ID");
			$_SESSION['Elooi_UserName'] = mysql_result($mysqlresult,0,"Username");
			$_SESSION['Elooi_FullName'] = mysql_result($mysqlresult,0,"FirstName");
			$_SESSION['Elooi_Picture'] = mysql_result($mysqlresult,0,"Picture");
			$_SESSION['Elooi_Location']   = mysql_result($mysqlresult,0,"Location");
			$_SESSION['Elooi_Email']   = mysql_result($mysqlresult,0,"Email");
			$_SESSION['Facebook_uid']   = mysql_result($mysqlresult,0,"Facebook_uid");
			$_SESSION['Elooi_ILanguageID'] = mysql_result($mysqlresult,0,"ILanguageID");
			

			/*
			if (($server_domain=="tr.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="1")) { 
				$_SESSION['Elooi_ILanguageID']="1"; 
			} else
			if ( 
				(($server_domain=="en.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="2")) or
				(($server_domain=="tw.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="3")) or
				(($server_domain=="no.elooi.com") && ($_SESSION['Elooi_ILanguageID']!="4")) )
				{ 
					if ($_SESSION['Elooi_ILanguageID']=="2") { $server_domain="en.elooi.com"; }
					if ($_SESSION['Elooi_ILanguageID']=="3") { $server_domain="tw.elooi.com"; }
					if ($_SESSION['Elooi_ILanguageID']=="4") { $server_domain="no.elooi.com"; }
				}
			*/
			$server_domain="elooi.com";
			
			$_SESSION['twitter_oauth_token']         = mysql_result($mysqlresult,0,"twitter_oauth_token");
			$_SESSION['twitter_oauth_token_secret']  = mysql_result($mysqlresult,0,"twitter_oauth_token_secret");

			header( "Location: http://".$server_domain."/u/".$_SESSION['Elooi_UserName'] ) ;
			exit();

		} else
		{
			$HasError = 1;
			$FormMessage = $signin_form_error;
		}
	} else
	{
			$FormMessage = $signin_form_generic;
	}
}

?>


<script type="text/javascript" charset="utf-8">
	$(function(){ $("#signup_form label").inFieldLabels(); });
</script>



<body>

<?php require_once('/fb-connect-code.php'); ?>

<div id="narrow_page">
	<a href="/index.php"><img src="<?php
		if ($page_subdomain=="tr") { echo "/cloudofvoice_screen_logo-nobg-tr.jpg"; } else
		if ($page_subdomain=="tw") { echo "/cloudofvoice_screen_logo-nobg-tw.jpg"; } else
		if ($page_subdomain=="no") { echo "/cloudofvoice_screen_logo-nobg-no.jpg"; } else
		if ($page_subdomain=="en") { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } else
								   { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } ?>" style="height:46px; width:250px; margin-top:8px; margin-left:0px; margin-bottom:5px; border:0px;"></a>
 
		<div class="banner" style="height:60px">
			<h2><?php echo $signup_sign_in; ?></h2>
			<span class="bnrmsg" style="float:right"><?php echo $signin_dont_have_account; ?></span>
		</div>
		<div class="content-main">

<?php if ($_GET["q"]=="session_end") {?>
<div class="successbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:15px;"><center><?php echo $signin_session_expire; ?></center></div>
<?php } ?>

		        
<?php if ($FormMessage!="") {?>
<div class="errorbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:15px;">
<?php echo $FormMessage; ?>
<div style="height:5px;"></div>
<span style="line-height:1.2em;">
<?php echo $Email_Error; ?>
<?php echo $Password_Error; ?>
</span>
</div>
<?php } ?>


<form id="signup_form" method=post  autocomplete = "off">
<input type="hidden" name="op" value="signin">
<div style="height:10px"></div>
<span>
  <label for="Email"><?php echo $signup_Email; ?></label>
  <input type="text" name="Email" value="<?php echo $Email; ?>" id="Email" class="signup-name" title="<?php echo $signup_Email_tip; ?>"  style="width:400px">
</span>
<div style="margin-top:5px; margin-bottom:15px;"></div>


<span>
  <label for="Password"><?php echo $signup_Password; ?></label>
  <input type="password" name="Password" value="" id="Password" class="signup-name" title="<?php echo $signup_Password_tip_2; ?>"  style="width:400px">
</span>
<div style="margin-top:5px; margin-bottom:15px;"></div>


<input id="remember_me" name="remember_me" value="1" type="checkbox">
<label for="remember_me"><?php echo $Common_header_remember_me; ?></label>

<div style="height:10px"></div>

<input type="submit" name="join_button" value="<?php echo $Common_header_home_signin_button; ?>" class="submitbutton" />
</form>

<br>
<a href="password-reset.php" id="resend_password_link"><?php echo $Common_header_forgot_pwd; ?></a>


<script type='text/javascript'>
	$(function() {	 $('#signup_form [title]').tipsy({trigger: 'focus', fade:true, gravity: 'w'});    });
</script>

<hr/> 
<div style="margin-bottom:10px"><?php echo $signin_facebook; ?></div>

  <a id="facebookButton-small" onclick="facebookSignin(); return false;" href="#"><font color=white>facebook</font></a>


<!-- FOTTER -->
		
				<div class="clear"></div>
			</div>	
		
	</div>
 </div>
<div id="lb"></div>

</body>
</html>