<?php $page="my-elooi"; ?>
<?php require_once("/server-settings.php"); ?>
<?php $subpage="settings-account"; ?>
<?php include("/ortak-header.php"); ?>
<?php include("/check-user-login.php"); ?>

<div class="banner2">
		<h2><img src="/slir/w32-h32-c1.1/<?php echo $_SESSION['Elooi_Picture']; ?>" height=32 style="vertical-align:top; "> <?php echo $_SESSION['Elooi_FullName'];?><?php echo $Settings_Title ?></h2>

  <ul class="settings-tabs_ul"> 
    <li class="settings-active"><a href="/settings/account" id=""><?php echo $Settings_Acconut; ?></a></li> 
    <li><a href="/settings/profile" style="display:block;" id=""><?php echo $Settings_Profile; ?></a></li> 
    <li><a href="/settings/design" id=""><?php echo $Settings_Design; ?></a></li> 
    <li><a href="/settings/notifications" id=""><?php echo $Settings_Notifications; ?></a></li> 
    <li><a href="/settings/password" id=""><?php echo $Settings_Password; ?></a></li> 
  </ul> 

</div>

<?php
if ($_POST["op"]=="")
{
	$Username   = $_SESSION['Elooi_UserName'];
	$Email      = $_SESSION['Elooi_Email'];

	$mysqlresult = mysql_query("SELECT * FROM usersettings WHERE userID=".$_SESSION['Elooi_UserID']);
	$num_rows = mysql_num_rows($mysqlresult);
	$i=0;

	$LanguageID   = mysql_result($mysqlresult,$i,"LanguageID");
	$TimeZoneID   = mysql_result($mysqlresult,$i,"TimeZoneID");

	$privacy_other_find_Email      = mysql_result($mysqlresult,$i,"privacy_other_find_Email");
	$privacy_only_friend_messages  = mysql_result($mysqlresult,$i,"privacy_only_friend_messages");
	$privacy_only_friends_listen   = mysql_result($mysqlresult,$i,"privacy_only_friends_listen");
	$privacy_link_facebook         = mysql_result($mysqlresult,$i,"privacy_link_facebook");
	$sharing_eloois_facebook       = mysql_result($mysqlresult,$i,"sharing_eloois_facebook");
	$sharing_badges_facebook       = mysql_result($mysqlresult,$i,"sharing_badges_facebook");

	$sharing_eloois_twitter        = mysql_result($mysqlresult,$i,"sharing_eloois_twitter");
	$sharing_badges_twitter        = mysql_result($mysqlresult,$i,"sharing_badges_twitter");
}

$HasError      = 0;
$FormError     = "";
$UsernameError = "";
$EmailError    = "";
$PasswordError = "";
$LanguageError = "";
$TimeZoneError = "";

if ($_POST["op"]=="update_account")
{

	$Username   = $_POST['Username'];

	$Username = str_replace($Turkish_letters,$Turkish_letters2,$Username);
	$Username = strtolower($Username);
	if (strlen($Username)>20) $Username = substr($Username,0,20);

	$Email      = $_POST['Email'];
	$Password   = $_POST['Password'];

	$LanguageID   = $_POST['LanguageID'];
	$TimeZoneID   = $_POST['TimeZoneID'];

	$privacy_other_find_Email  = 0;
	if ($_POST['privacy_other_find_Email']=="on")  { $privacy_other_find_Email      = 1; }

	$privacy_only_friend_messages = 0;
	if ($_POST['privacy_only_friend_messages']=="on") { $privacy_only_friend_messages = 1; }

	$privacy_only_friends_listen = 0;
	if ($_POST['privacy_only_friends_listen']=="on") { $privacy_only_friends_listen = 1; }
		
	$privacy_link_facebook     = 0;
	if ($_POST['privacy_link_facebook']=="on")     { $privacy_link_facebook      = 1; }


	$sharing_eloois_facebook   = 0;
	if ($_POST['sharing_eloois_facebook']=="on")   { $sharing_eloois_facebook      = 1; }

	$sharing_badges_facebook   = 0;
	if ($_POST['sharing_badges_facebook']=="on")   { $sharing_badges_facebook      = 1; }

	$sharing_eloois_twitter   = 0;
	if ($_POST['sharing_eloois_twitter']=="on")   { $sharing_eloois_twitter      = 1; }

	$sharing_badges_twitter   = 0;
	if ($_POST['sharing_badges_twitter']=="on")   { $sharing_badges_twitter      = 1; }


	//if ($LanguageID=="0") { $LanguageError = "<div class=form-error><span class=settingTip>!</span> Please select your default Language</div>"; $HasError = 1; }

	if ($TimeZoneID=="0") { $TimeZoneError = "<div class=form-error>". $Settings_Account_Timezone_Error ."</div>"; $HasError = 1; }

	$UsernameOld = $Username;

	$sqlcommand = "SELECT * FROM users WHERE (ID <>" . $_SESSION['Elooi_UserID'] . ") AND (UserName='" . str_replace("'","",$Username) . "')";
	$mysqlresult = mysql_query($sqlcommand);
	$num_rows = mysql_num_rows($mysqlresult);

	if ( (!preg_match("/^[a-z]+[\w-.]*$/i", $Username)) or (strlen($Username)<8) or (strlen($Username)>20) )
	{

		$UsernameError = "<div class=form-error>". $signup_Username_Error ."</div>"; $HasError = 1; 
	}

	if ($num_rows>0)
	{
		$Loop=1;
		$NameCounter = 0;
		$UsernameSearch = $Username;
		While ($Loop==1)
		{
			//check if username is avilable
			
			$sqlcommand = "SELECT * FROM users WHERE (ID <>" . $_SESSION['Elooi_UserID'] . ") AND (UserName='" . str_replace("'","",$UsernameSearch) . "')";

			$mysqlresult = mysql_query($sqlcommand);
			$num_rows = mysql_num_rows($mysqlresult);

			if ($num_rows>0) 
			{ 
				$Loop = 1; 
				$NameCounter++;
				if (strlen($Username)>19) $Username = substr($Username,0,19);
				$UsernameSearch = $Username . $NameCounter;
			} else { $Loop = 0; $Username = $UsernameSearch;}
		}
	}




	if ($Email=="") { $EmailError = "<div class=form-error>".$signup_Email_Error ."</div>"; $HasError = 1; } else
 	if (verify_Email($Email)) {} else { $EmailError = "<div class=form-error>".$signup_Email_Error2 ."</div>"; $HasError = 1; }

	$xsqlCommand = "SELECT * FROM users WHERE Email = '".AddSlashes(Trim($Email))."' and ID!=".$_SESSION['Elooi_UserID'];

	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows>0) { 
		$EmailError = "<div class=form-error>".$signup_Email_Error3."</div>"; 
		$HasError = 1; 
	}

	$PleaseEnterPassword=0;
	if ($Password=="") { 
		$PasswordError = "<div class=form-error>".$signup_Password_Error ."</div>"; 
		if ($HasError==0) {$PleaseEnterPassword=1;} 
		$HasError = 1;  
	} else
	{
		$xsqlCommand = "SELECT * FROM users WHERE Email = '".AddSlashes(Trim($_SESSION['Elooi_Email']))."' and Password='".AddSlashes(Trim(md5($Password.$randomword)))."' AND ID=".$_SESSION['Elooi_UserID'];

		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==0) { 
			$PasswordError = "<div class=form-error>". $Settings_Password_Error ."</div>"; 
			$HasError = 1; 
		}
	}

	if ($HasError==1)
	{
		$FormError = $signup_Error;

		if ($PleaseEnterPassword=="1")
		{
			$FormError = $Settings_Password_Error2;
		}
	}



	if ($HasError==0)
	{
		//insert into db
		$Username_   = "'".AddSlashes(Trim($Username))."'";
		$Email_      = "'".AddSlashes(Trim($Email))."'";

		
		$xsqlCommand = "UPDATE users SET username =".$Username_.", Email=".$Email_." WHERE ID=".$_SESSION['Elooi_UserID'];
		//echo $xsqlCommand;
		$mysqlresult1 = mysql_query($xsqlCommand);

		if ($Email!=$_SESSION['Elooi_Email'])
		{
			$_SESSION['Elooi_AccountVerified'] = "0";
			$xsqlCommand = "UPDATE users SET AccountVerified=0 WHERE ID=".$_SESSION['Elooi_UserID'];
			//echo $xsqlCommand;
			$mysqlresult1 = mysql_query($xsqlCommand);

			SendEmailVerification($Email, $_SESSION['Elooi_FullName'], "", $_SESSION['Elooi_UserID']);
		}


		$xsqlCommand = "UPDATE usersettings SET LanguageID=".$LanguageID .", TimeZoneID=".$TimeZoneID .", privacy_other_find_Email=".$privacy_other_find_Email .", privacy_only_friend_messages=".$privacy_only_friend_messages .", privacy_only_friends_listen=".$privacy_only_friends_listen .", privacy_link_facebook=".$privacy_link_facebook .", sharing_eloois_facebook=".$sharing_eloois_facebook .", sharing_badges_facebook=".$sharing_badges_facebook .", sharing_eloois_twitter=".$sharing_eloois_twitter .", sharing_badges_twitter=".$sharing_badges_twitter ." WHERE UserID=".$_SESSION['Elooi_UserID'];

		//echo $xsqlCommand;

		$mysqlresult2 = mysql_query($xsqlCommand);
		if ($mysqlresult1 != "1") { $FormError=$Settings_Account_db_Error." (1)"; } else
		if ($mysqlresult2 != "1") { $FormError=$Settings_Account_db_Error." (2)"; } else
		{
			
			$xsqlCommand = "UPDATE allTags SET tag=".ATQ("@".$Username).", nocasetag=".ATQ("@".$Username)." WHERE tag=".ATQ("@".$_SESSION['Elooi_UserName']);
			$mysqlresult1 = mysql_query($xsqlCommand);

			$_SESSION['Elooi_UserName'] = $Username;
			$_SESSION['Elooi_Email']   = $Email;

			$Update_Message=$Settings_Account_Update_Message;
		}
	}
}

?>


<script type="text/javascript" charset="utf-8">
	$(function(){ $("#signup_form label").inFieldLabels(); });
</script>

<div class="content-main " >

<div class="content-section">

<?php if ($Update_Message!="") { ?>
<div class="successbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Update_Message; ?></div>
<?php } ?>

<?php if ($_GET["q"]=="facebook-connect") { ?>
<div class="successbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Settings_Account_fb_Connect; ?> </div>
<?php } ?>

<?php if ($_GET["q"]=="twitter-connect") { ?>
<div class="successbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Settings_Account_twitter_Connect; ?> </div>
<?php 

	$message= $tweet_message; 
	$Twitter = new EpiTwitter($twitter_consumer_key, $twitter_consumer_secret);
	$Twitter->setToken($_SESSION['twitter_oauth_token'],$_SESSION['twitter_oauth_token_secret']);
	//$message Status update
	$status=$Twitter->post_statusesUpdate(array('status' => $message));
	//print_r ($status->response);


} ?>

<?php if ($_GET["q"]=="twitter-denied") { ?>
<div class="errorbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Settings_Account_twitter_Error; ?></div>
<?php } ?>

<?php if ($_GET["q"]=="twitter-not-logged-in") { ?>
<div class="errorbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Settings_Account_twitter_Error2; ?></div>
<?php } ?>

<?php if ($FormError!="") { ?>
<div class="errorbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $FormError; ?>

<?php echo $UsernameError; ?>
<?php echo $EmailError; ?>
<?php echo $TimeZoneError; ?>
<?php echo $PasswordError; ?>

</div>
<?php } ?>

<form id="signup_form" method=post action="/settings/account"  autocomplete = "off">
<input type="hidden" name="op" value="update_account">

<div style="float:right">
	<div class=accountConnect>
	<img src="/facebook-icon.png" style=" float: left; margin-right: 10px; border: 0 none;">
	<?php if ( ($_SESSION['Facebook_uid']!="0") and ($_SESSION['Facebook_uid']!="")  and (isset($_SESSION['Facebook_uid'])) ) { ?>
	<span style="line-height:32px; font-size:14px; color: #2338C9; font-weight: bold;"><?php echo $fb_Connected; ?></span>
	<?php } else { ?>
	<a onclick="facebookConnect(); return false;" href="#" style="line-height:32px; font-size:14px; color: #2398C9; font-weight: bold;"><?php echo $fb_Connect; ?></a>
	<?php } ?>
 <br>
 <br>
 <label for="sharing_eloois_facebook" style="cursor:pointer">
 <input id="sharing_eloois_facebook" name="sharing_eloois_facebook" type="checkbox" <?php 
		if ($sharing_eloois_facebook=="1") echo " CHECKED "; ?> <?php if ( ($_SESSION['Facebook_uid']=="0") or ($_SESSION['Facebook_uid']=="")) { echo "disabled=\"disabled\""; } ?> />
<?php echo $fb_Share; ?> <span class="settingTip" title="<?php echo $fb_Share_Hint; ?>">?</span>
 </label>
<br>
 <label for="sharing_badges_facebook" style="cursor:pointer">
 <input id="sharing_badges_facebook" name="sharing_badges_facebook" type="checkbox" <?php 
		if ($sharing_badges_facebook=="1") echo " CHECKED "; ?> <?php if ( ($_SESSION['Facebook_uid']=="0") or ($_SESSION['Facebook_uid']=="")) { echo "disabled=\"disabled\""; } ?> /><?php echo $fb_Share_Badges; ?> <span class="settingTip" title="<?php echo $fb_Share_Badges_Hint; ?>">?</span>
 </label>

	</div>

	<div style="height:10px"></div>

	<div class=accountConnect>
	<img src="/twitter-icon.png" style=" float: left; margin-right: 10px; border: 0 none;">
	<?php if ( ($_SESSION['twitter_oauth_token']!="") and (isset($_SESSION['twitter_oauth_token'])) ) {
	?>
	<span style="line-height:32px; font-size:14px; color: #2398C9; font-weight: bold; text-decoration: none;"><?php echo $twitter_Connected; ?></span>
	<?php
	} else
	{
	$twitterObj = new EpiTwitter($twitter_consumer_key, $twitter_consumer_secret);
	?>
	<a href="<?php echo $twitterObj->getAuthorizationUrl(); ?>" style="line-height:32px; font-size:14px; color: #2398C9; font-weight: bold; text-decoration: none;"><?php echo $twitter_Connect; ?></a>
	<?php
	}
	?>

<br><br>
 <label for="sharing_eloois_twitter" style="cursor:pointer">
 <input id="sharing_eloois_twitter" name="sharing_eloois_twitter" type="checkbox" <?php 
		if ( ($sharing_eloois_twitter=="1") and ($_SESSION['twitter_oauth_token']!="") ) { echo " CHECKED "; } ?> />
<?php echo $twitter_Share; ?> <span class="settingTip" title="<?php echo $twitter_Share_Hint; ?>">?</span>
 </label>
<br>
 <label for="sharing_badges_twitter" style="cursor:pointer">
 <input id="sharing_badges_twitter" name="sharing_badges_twitter" type="checkbox" <?php 
		if ( ($sharing_badges_twitter=="1") and ($_SESSION['twitter_oauth_token']!="") ) { echo " CHECKED "; } ?> />
<?php echo $twitter_Share_Badges; ?> <span class="settingTip" title="<?php echo $twitter_Share_Badges_Hint; ?>">?</span>
 </label>

	</div>

</div>

<span>
  <label for="Username"><?php echo $signup_Username; ?></label>
  <input type="text" name="Username" value="<?php echo $Username; ?>" id="Username" class="signup-name" title="<?php echo $signup_Username_tip; ?>"  style="width:400px">
</span>
<br>
<div style="margin-top:5px; margin-bottom:15px;"><span style="font-size:90%"><?php echo $Settings_Account_Public_Profile; ?> <a href="http://<?php echo $server_domain; ?>/<?php if ($UsernameError=="") {echo "u/".$Username; } else { echo "me.php?uid=" . $_SESSION['Elooi_UserID'] ; } ?>">http://<?php echo $server_domain; ?>/<span><?php if ($UsernameError=="") {echo "u/".$Username; } else { echo "me.php?uid=" . $_SESSION['Elooi_UserID'] ; } ?></span></a></span></div>
<div style="height:10px"></div>

<span>
  <label for="Email"><?php echo $signup_Email; ?></label>
  <input type="text" name="Email" value="<?php echo $Email; ?>" id="Email" class="signup-name" title="<?php echo $signup_Email_tip2; ?>"  style="width:400px">
</span>
<div style="margin-top:5px; margin-bottom:15px;"><span style="font-size:90%"><?php echo $Settings_Account_Public_Email; ?></span></div>
<div style="height:5px"></div>
<input type="hidden" name="LanguageID" ID="LanguageID" value="<?php echo $LanguageID; ?>">
<?php
/*
<label for="LanguageID">Language</label>
<br>
	<select id="LanguageID" name="LanguageID" class="signup-name-dropdown"  style="width:200px" title="Your default language when you record will be set to this, also this sets the site language. You can change the language of your eloois when recording.">
		<option value="0">Please select language</option>
<? php
$mysqlresult = mysql_query("SELECT * FROM Languages ORDER BY ID ASC");
$num_rows = mysql_num_rows($mysqlresult);
$i = 0;
WHILE ($i<$num_rows) {
? >
 					<OPTION VALUE="<? php echo mysql_result($mysqlresult,$i,"ID"); ? >" <? php
		
					if (mysql_result($mysqlresult,$i,"ID")==$LanguageID) { echo " SELECTED "; }
					? >><? php echo mysql_result($mysqlresult,$i,"LanguageName"); ? ></option>
< ?php
	$i++;
} ? >
	</select>
<div style="margin-top:5px; margin-bottom:15px;">
<? php echo $LanguageError; ? ></div>
<div style="height:10px"></div>
*/
?>

<label for="TimeZoneID"><?php echo $Settings_Account_TimeZone; ?></label>
<br>
<select id="TimeZoneID" name="TimeZoneID" class="signup-name-dropdown" style="width:300px" >
<option value="0"><?php echo $Settings_Account_TimeZone_Select; ?></option>
<OPTION VALUE="67" >(GMT+02:00) İstanbul</option>
<OPTION VALUE="116" >(GMT+08:00) Taipei</option>
<OPTION VALUE="143" >(GMT+01:00) Oslo</option>
<OPTION VALUE="40" >(GMT) London</option>
<OPTION VALUE="6" >(GMT-08:00) Pacific Time (US & Canada)</option>
<OPTION VALUE="9" >(GMT-07:00) Mountain Time (US & Canada)</option>
<OPTION VALUE="13" >(GMT-06:00) Central Time (US & Canada)</option>
<OPTION VALUE="19" >(GMT-05:00) Eastern Time (US & Canada)</option>

<?php
$mysqlresult = mysql_query("SELECT * FROM timezones ORDER BY offset ASC");
$num_rows = mysql_num_rows($mysqlresult);
$i = 0;
WHILE ($i<$num_rows) {
?>
					<OPTION VALUE="<?php echo mysql_result($mysqlresult,$i,"ID"); ?>" <?php
		
					if (mysql_result($mysqlresult,$i,"ID")==$TimeZoneID) { echo " SELECTED "; }
					?>><?php echo mysql_result($mysqlresult,$i,"gmt") . " ". mysql_result($mysqlresult,$i,"timezone_location"); ?></option>
<?php
	$i++;
}
?>



</select>
<div style="margin-top:5px; margin-bottom:15px;"><span style="font-size:90%"><?php echo $Settings_Account_TimeZone_Hint; ?></span></div>
<div style="height:10px"></div>


<span class="settings-subheader"><?php echo $Settings_Account_Privacy; ?></span>
<div style="margin-left:20px; margin-top:10px">

 <label for="privacy_other_find_Email" style="cursor:pointer">
 <input id="privacy_other_find_Email" name="privacy_other_find_Email" type="checkbox" <?php 
		if ($privacy_other_find_Email=="1") echo " CHECKED "; ?> />
<?php echo $Settings_Account_Privacy_Email; ?><span class="settingTip" title="<?php echo $Settings_Account_Privacy_Email_Hint; ?>">?</span>
 </label>
<?php
/*
<br>
 <label for="privacy_only_friend_messages" style="cursor:pointer">
 <input id="privacy_only_friend_messages" name="privacy_only_friend_messages" type="checkbox" <? php 
		if ($privacy_only_friend_messages=="1") echo " CHECKED "; ? > />
Only friends can contact me.<span class="settingTip" title="Contacting people on Elooi can be done through text messaging or leaving a personal Elooi. You will see these in your inbox. <br>It is recomended that you only allow your friends to contact you. Others should first befriend you.">?</span>
 </label>

<br>
 <label for="privacy_only_friends_listen" style="cursor:pointer">
 <input id="privacy_only_friends_listen" name="privacy_only_friends_listen" type="checkbox" <? php 
		if ($privacy_only_friends_listen=="1") echo " CHECKED "; ? > />
Only my frineds can listen to my eloois <span class="settingTip" title="Normally everyone can listen to your elooi recordings, thats part of the fun. But if you want only your frineds to hear you check this option.">?</span>
 </label>
*/
?>
<br>
 <label for="privacy_link_facebook" style="cursor:pointer">
 <input id="privacy_link_facebook" name="privacy_link_facebook" type="checkbox" <?php 
		if ($privacy_link_facebook=="1") echo " CHECKED "; ?> />
<?php echo $Settings_Account_Privacy_fb; ?> <span class="settingTip" title="<?php echo $Settings_Account_Privacy_fb_Hint; ?>">?</span>
 </label>

</div>

<div style="height:15px"></div>


<div style="margin-top:5px; margin-bottom:5px;"><?php echo $Settings_Account_Type_Password; ?></div>
<span>
  <label for="Password"><?php echo $signup_Password; ?></label>
  <input type="password" name="Password" value="" id="Password" class="signup-name" style="width:400px">
</span>
<div style="margin-top:5px; margin-bottom:15px;"></div>



<div class="actions-div" id="save" style="padding-left: 10px;">
	<input type="submit" name="join_button" value="<?php echo $generic_save_changes; ?>" class="submitbutton" />
</div>
</form>

<script type='text/javascript'>

    $(function() {
	 $('.settingTip').tipsy({trigger: 'hover', fade:true, html:true, gravity: 's'});
	 $('#signup_form [title]').tipsy({trigger: 'focus', fade:true, gravity: 'w'});
    });

  </script>
  <!--<br><a href="">Deactivate my account</a>-->
</div>

<div class="side-section">
<?php echo $Settings_Account_SideBar; ?>
</div>




<?php include("/ortak-fotter.php"); ?>

