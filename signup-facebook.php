<?php $page="signup-facebook"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/mini-page-header.php"); ?>
<?php

//SET USERNAME
$Turkish_letters = array("ü","Ü","ç","Ç","ð","Ð","ö","Ö","þ","Þ","ý","Ý","'");
$Turkish_letters2= array("u","U","c","C","g","G","o","O","s","S","i","I","");

if ($_GET["facebook"]=="no")
{
} else
{
require 'facebook.php';

$facebook = new Facebook(array(
  'appId'  => '146170835459093',
  'secret' => '26338bd4a7850c2af95dd62a68ce5989',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	$userpic = $facebook->api('/me', array(
    'fields' => 'picture.type(normal)',
    'type' => 'large'));
	//print_r($userpic);
	//echo $userpic["picture"]["data"]["url"];
	$userpic2 = $userpic["picture"]["data"]["url"];
//	echo $userpic2;
	$Picture = SaveProfileLocal($userpic2,"99999");
//	print_r($user_profile);
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
	exit();
  }
} else
{
	//echo "!";
	header( "Location: http://".$server_domain."/index.php?r=5" ) ;
	exit();
}


if ($user) { 
//	$xsqlCommand = "SELECT * FROM users WHERE Facebook_uid = '".AddSlashes(Trim( $user_profile["id"] ))."' ORDER BY ID DESC LIMIT 1";

//		$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' . $access_token));
		$facebook_username =  $user_profile["username"];
		$facebook_uid = $user_profile["id"];
		if ($facebook_uid=="") { $facebook_uid = "0000000000"; }

		//get_redirect_url('https://graph.facebook.com/'.$facebook_username.'/picture?type=large');

		//search mysql if user is already a member if so log them in and take them to the profile page

		$sqlcommand = "SELECT * FROM users WHERE (facebook_uid='" . AddSlashes(Trim($facebook_uid)) . "')";

		$mysqlresult = mysql_query($sqlcommand);
		$num_rows = mysql_num_rows($mysqlresult);

		if ($num_rows>0) 
		{ 
			header( "Location: http://".$server_domain."/signin-facebook.php" ) ;
			exit();
		}
	}
}

$FirstName  = "";
$MiddleName = "";
$LastName   = "";
$Email      = "";
$Password   = "";
$Location   = "";
$Gender     = "1";

$BirthMonth = "0";
$BirthDay   = "0";
$BirthYear  = "0";
$FormMessage ="";

$Picture    = "placeholder-girl.jpg";
if ($facebook_uid!="")
{
	if ($user_profile["middle_name"]!="")
	{
		$FirstName  = trim($user_profile["first_name"]." ".$user_profile["middle_name"]." ".$user_profile["last_name"]);
	} else
	{
		$FirstName  = trim($user_profile["first_name"]." ".$user_profile["last_name"]);
	}
	$MiddleName = $user_profile["middle_name"];
	$LastName   = $user_profile["last_name"];
	$UserName   = $user_profile["username"];
	$Email      = $user_profile["email"];
	$UserBio    = $user_profile["bio"];
	$Homepage   = $user_profile["website"];
	$Password   = "";
	$Location   = $user_profile["location"]["name"];
	$Gender     = "0";
	if ($user_profile["gender"]=="female") { $Gender     = "1"; }
	if ($user_profile["gender"]=="male") { $Gender     = "2"; }
	
	$Birthday = $user_profile["birthday"];
	$Birthday = explode("/",$Birthday);

	$BirthMonth = $Birthday[0];
	$BirthDay   = $Birthday[1];
	$BirthYear  = $Birthday[2];

	$Picture    = $userpic2;

	$Username = $facebook_username;
	$Username = str_replace($Turkish_letters,$Turkish_letters2,$Username);
	$Username = strtolower($Username);
	if (strlen($Username)>20) $Username = substr($Username,0,20);

	$Loop=1;
	$NameCounter = 0;
	$UsernameSearch = $Username;
	While ($Loop==1)
	{
		//check if username is avilable
		
		$sqlcommand = "SELECT * FROM users WHERE (UserName='" . str_replace("'","",$UsernameSearch) . "')";

		$mysqlresult = mysql_query($sqlcommand);
		$num_rows = mysql_num_rows($mysqlresult);

		if ($num_rows>0) 
		{ 
			$Loop = 1; 
			$NameCounter++;
			if (strlen($Username)>18) $Username = substr($Username,0,18);
			$UsernameSearch = $Username . $NameCounter;
		} else { $Loop = 0; $Username = $UsernameSearch;}
	}
} else
{
}

$HasError = 0;
$PasswordError = 0;

if ($_POST["op"]=="save")
{
	$FirstName  = $_POST["FirstName"];
	$LastName   = $_POST["LastName"];
	$MiddleName = $_POST["MiddleName"];
	$Email      = $_POST["Email"];
	$Password   = $_POST["Password"];
	$Location   = $_POST["Location"];
	$Gender     = $_POST["Gender"];
	$Picture    = $_POST["Picture"];

	$BirthMonth = $_POST["BirthMonth"];
	$BirthDay   = $_POST["BirthDay"];
	$BirthYear  = $_POST["BirthYear"];

	$Username   = $_POST["Username"];

	$Username = str_replace($Turkish_letters,$Turkish_letters2,$Username);

	if ( (!preg_match("/^[a-z]+[\w-.]*$/i", $Username)) or (strlen($Username)<6) or (strlen($Username)>20) )
	{
		$Username_Error = "<div class=form-error>".$signup_Username_Error."</div>"; $HasError = 1; 
	} else
	{
		$Username = strtolower($Username);
		if (strlen($Username)>20) $Username = substr($Username,0,20);

		$Loop=1;
		$NameCounter = 0;
		$UsernameSearch = $Username;
		While ($Loop==1)
		{
			//check if username is avilable
			
			$sqlcommand = "SELECT * FROM users WHERE (UserName='" . str_replace("'","",$UsernameSearch) . "')";

			$mysqlresult = mysql_query($sqlcommand);
			$num_rows = mysql_num_rows($mysqlresult);

			if ($num_rows>0) 
			{ 
				$Loop = 1; 
				$NameCounter++;
				if (strlen($Username)>18) $Username = substr($Username,0,18);
				$UsernameSearch = $Username . $NameCounter;
			} else { $Loop = 0; $Username = $UsernameSearch;}
		}
	}

	if (($FirstName=="") or (strlen($FirstName)<2)) { $FirstName_Error = "<div class=form-error>".$signup_FirstName_Error."</div>"; $HasError = 1; }

	if ($Email=="") { $Email_Error = "<div class=form-error>".$signup_Email_Error."</div>"; $HasError = 1; } else
 	if (verify_Email($Email)) {} else { $Email_Error = "<div class=form-error>".$signup_Email_Error2."</div>"; $HasError = 1; }

	$xsqlCommand = "SELECT * FROM users WHERE Email = '".AddSlashes(Trim($Email))."'";
//		echo $xsqlCommand;
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows>0) { 
		$Email_Error = "<div class=form-error>".$signup_Email_Error3."</div>"; 
		$HasError = 1; 
	}


	if ($Password=="") { $Password_Error = "<div class=form-error>".$signup_Password_Error."</div>"; $HasError = 1; $PasswordError = 1; } else
	if (!valid_pass($Password)) {
		$HasError = 1;
		$PasswordError = 1;
		  $Password_Error = "<div class=form-error>".$signup_Password_Error2."</div>";	
	}

//	if ($Location=="") { $Location_Error = "<div class=form-error>".$signup_Location_Error."</div>"; $HasError = 1; }
//	if (($BirthMonth=="0") or ($BirthDay=="0") or ($BirthYear=="0"))  { $BirthDay_Error = "<div class=form-error>".$signup_BirthDay_Error."</div>"; $HasError = 1; }

	if ($HasError==0)
	{
		//insert into db
		$FirstName_  = "'".AddSlashes(Trim($FirstName))."'";
		$LastName_   = "'".AddSlashes(Trim($LastName))."'";
		$MiddleName_ = "'".AddSlashes(Trim($MiddleName))."'";
		$Email_      = "'".AddSlashes(Trim($Email))."'";
		$Password_   = "'".AddSlashes(Trim(md5($Password.$randomword)))."'";
		$Location_   = "'".AddSlashes(Trim($Location))."'";
		$Gender_     = "'".AddSlashes(Trim($Gender))."'";
		$BirthDay_   = "'".AddSlashes(Trim($BirthDay))."'";
		$BirthMonth_ = "'".AddSlashes(Trim($BirthMonth))."'";
		$BirthYear_  = "'".AddSlashes(Trim($BirthYear))."'";
		$Picture_    = "'".AddSlashes(Trim($Picture))."'";

		$xsqlCommand = "INSERT INTO users (FirstName,LastName,Email,Password,Location,Gender,BirthDay,BirthMonth,BirthYear,Picture,SignupDate,SignupIP,facebook_uid,facebook_username,facebook_access_token,MiddleName,UserName) VALUES (".$FirstName_.",".$LastName_.",".$Email_.",".$Password_.",".$Location_.",".$Gender_.",".$BirthDay_.",".$BirthMonth_.",".$BirthYear_.",".$Picture_.",now(),'".getUserIpAddr()."','".AddSlashes(Trim($facebook_uid))."','".AddSlashes(Trim($facebook_username))."','".AddSlashes(Trim($access_token))."',".$MiddleName_.",'".AddSlashes(Trim($Username))."')";

//		echo $xsqlCommand;

		$mysqlresult = mysql_query($xsqlCommand);

		$xsqlCommand = "SELECT * FROM users WHERE Email=".$Email_;
		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==1)
		{

			$Picture = SaveProfileLocal($Picture,mysql_result($mysqlresult,0,"ID"));

			$xsqlCommand1 = "INSERT INTO userprofiles (UserID,homepage,UserBio,backgroundImage,backgroundColor,textColor,linkColor,headerColor,TextBackgroundColor,tileBackground) VALUES (".mysql_result($mysqlresult,0,"ID") . ",'" . AddSlashes(Trim($Homepage)) ."','" . AddSlashes(Trim($UserBio)) ."','/bg/theme_default_modify.jpg','#DDF3FC','#272323','#333333','#000000','#90D4EA',0)";
			$mysqlresult1 = mysql_query($xsqlCommand1);

			$xsqlCommand1 = "INSERT INTO usersettings (UserID,LanguageID,TimezoneID) VALUES (".mysql_result($mysqlresult,0,"ID") .",1,67)";
			$mysqlresult1 = mysql_query($xsqlCommand1);

			$xsqlCommand1 = "INSERT INTO usernotifications (UserID) VALUES (".mysql_result($mysqlresult,0,"ID") .")";
			$mysqlresult1 = mysql_query($xsqlCommand1);

			$_SESSION['Elooi_User'] = true;
			$_SESSION['Elooi_AccountVerified'] = "0";
			$_SESSION['Elooi_UserID']     = mysql_result($mysqlresult,0,"ID");
			$_SESSION['Elooi_UserName']   = mysql_result($mysqlresult,0,"Username");
			$_SESSION['Elooi_FullName']   = mysql_result($mysqlresult,0,"FirstName"); 
			$_SESSION['Elooi_Picture']    = $Picture;
			$_SESSION['Elooi_Location']   = mysql_result($mysqlresult,0,"Location");
			$_SESSION['Elooi_Email']      = mysql_result($mysqlresult,0,"Email");
			$_SESSION['Facebook_uid']     = mysql_result($mysqlresult,0,"Facebook_uid");
			$_SESSION['Elooi_ILanguageID'] = mysql_result($mysqlresult,0,"ILanguageID");

			$_SESSION['twitter_oauth_token']         = mysql_result($mysqlresult,0,"twitter_oauth_token");
			$_SESSION['twitter_oauth_token_secret']  = mysql_result($mysqlresult,0,"twitter_oauth_token_secret");

			if (!SendEmailVerification(mysql_result($mysqlresult,0,"Email"), mysql_result($mysqlresult,0,"FirstName"), "", mysql_result($mysqlresult,0,"ID")))
			{
				header( "Location: http://".$server_domain."/settings/profile?message=welcome-email-error" ) ;
				exit();
			} else
			{
				header( "Location: http://".$server_domain."/settings/profile?message=welcome" ) ;
				exit();
			}

		} else
		{
			$FormMessage = $signup_generic;
		}
	} else
	{
		$FormMessage = $signup_Error;
	}
}

?>

<script type="text/javascript" charset="utf-8">
	$(function(){ $("#signup_form label").inFieldLabels(); });
</script>

<script type="text/javascript"> 

function update_image_file(url, data) {
	theForm=document.signup_form;
	oText1 = theForm.Picture.value;
	theForm.Picture.value = url;
	oText2 = theForm.Picture.value;

	if (oText1 != oText2)
	{
		var el=document.getElementById("image_file_preview");
		el.innerHTML="<img src=\"" + oText2 + "\">";
	}
}

function makeusername()
{
//	theForm=document.signup_form;
//	if (theForm.Username.value=="") { theForm.Username.value = theForm.FirstName.value; }
}
</script>

<body>

<div id="narrow_page">
	<a href="/index.php"><img src="<?php
		if ($page_subdomain=="tr") { echo "/cloudofvoice_screen_logo-nobg-tr.jpg"; } else
		if ($page_subdomain=="tw") { echo "/cloudofvoice_screen_logo-nobg-tw.jpg"; } else
		if ($page_subdomain=="no") { echo "/cloudofvoice_screen_logo-nobg-no.jpg"; } else
		if ($page_subdomain=="en") { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } else
								   { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } ?>" style="height:46px; width:250px; margin-top:8px; margin-left:0px; margin-bottom:5px; border:0px;"></a>

		<div class="banner" style="height:60px">
			<h2><?php echo $signup_header; ?></h2>
			<span class="bnrmsg" style="float:right"><?php echo $signup_already_have_an_account; ?> <a href="signin.php"><?php echo $signup_sign_in; ?></a></span>
		</div>
		<div class="content-main">
			<div class="container_12">      
			        

<?php if ($FormMessage!="") {?>
<div class="errorbox" style="width:535px; margin-top:5px; margin-bottom:15px;">
<?php echo $FormMessage; ?>
<div style="height:5px;"></div>
<span style="line-height:1.2em;">
<?php echo $FirstName_Error; ?>
<?php echo $Username_Error; ?>
<?php echo $Email_Error; ?>
<?php echo $Password_Error; ?>
<?php // echo $Location_Error; ?>
<?php // echo $BirthDay_Error; ?>
</span>
</div>
<?php } else { ?>
<p class="register-test-control">
<?php echo $signup_subtitle; ?>
</p>
<?php }?>

<form name="signup_form" id="signup_form" method=post  autocomplete = "off">
<input type="hidden" name="op" value="save">
<input name="Picture" type="hidden" class="form" id="Picture" value="<?php echo $Picture; ?>" size="240" />

<span>
<label for="FirstName"><?php echo $signup_FirstName; ?></label>
  <input type="text" name="FirstName" value="<?php echo $FirstName; ?>" id="FirstName" class="signup-name" onBlur="makeusername();"; style="width:400px" title="<?php echo $signup_LastName_tip; ?>">
</span>
<input type="hidden" name="MiddleName" value="<?php echo $MiddleName; ?>" id="MiddleName" >
<input type="hidden" name="LastName" value="<?php echo $LastName; ?>" id="LastName">

<div style="height:15px"></div>
<span>
  <label for="Username"><?php echo $signup_Username; ?></label>
  <input type="text" name="Username" value="<?php echo $Username; ?>" id="Username" class="signup-name" title="<?php echo $signup_Username_tip; ?>"  style="width:400px">
</span>
<div style="height:15px"></div>
<span>
  <label for="Email"><?php echo $signup_Email; ?></label>
  <input type="text" name="Email" value="<?php echo $Email; ?>" id="Email" class="signup-name" title="<?php echo $signup_Email_tip; ?>"  style="width:400px">
</span>
<div style="height:15px"></div>
<span>
  <label for="Password"><?php echo $signup_Password; ?></label>
  <input type="password" name="Password" value="" id="Password" class="signup-name" title="<?php echo $signup_Password_tip; ?>"  style="width:400px">
</span>

<input type="hidden" name="Location" value="<?php echo $Location; ?>" id="Location">

<input type="hidden" name="Gender" value="<?php echo $Gender; ?>" id="Gender">
<input type="hidden" name="BirthMonth" value="<?php echo $BirthMonth; ?>" id="BirthMonth">
<input type="hidden" name="BirthDay" value="<?php echo $BirthDay; ?>" id="BirthDay">
<input type="hidden" name="BirthYear" value="<?php echo $BirthYear; ?>" id="BirthYear">
<?php
/*
<div style="height:15px"></div>
<span>
  <label for="Location"><? php echo $signup_Location; ? ></label>
  <input type="text" name="Location" value="<? php echo $Location; ? >" id="Location" class="signup-name" title="<? php echo $$signup_Location_tip; ? >"  style="width:400px">
</span>

<div style="margin-top:15px; margin-left:5px; margin-bottom:5px;"><? php echo $signup_Gender; ? ></div>
<div class="shown">
<select id="Gender" name="Gender" class="signup-name" style="width:200px" >
<option value="1" <? php if ($Gender=="1") echo "selected=\"selected\""; ? >><? php echo $signup_Gender_Female; ? ></option>
<option value="2" <? php if ($Gender=="2") echo "selected=\"selected\""; ? >><? php echo $signup_Gender_Male; ? ></option>
<option value="0" <? php if ($Gender=="0") echo "selected=\"selected\""; ? >><? php echo $signup_Gender_NotSay; ? ></option>
</select></div>


<div style="margin-top:15px; margin-left:5px; margin-bottom:5px;">
<? php echo $signup_Birthday; ? > <span id="why">(<a class='example8' href="#"><? php echo $signup_Birthday_why; ? ></a>)</span> 
</div>


<!-- This contains the hidden content for inline calls -->
<div style='display:none'>
<div id='inline_example1' style='padding:10px; background:#fff;'>
<? php echo $signup_Birthday_why_text; ? >
</div>
</div>


<div class="shown">
<select name="BirthMonth" class="signup-name" >
	<option value="0" <? php if ($BirthMonth=="0") echo "selected=\"selected\""; ? >><? php echo $signup_Birth_Month; ? ></option>
	<option value="1" <? php if ($BirthMonth=="1") echo "selected=\"selected\""; ? >><? php echo $signup_January; ? ></option>
	<option value="2" <? php if ($BirthMonth=="2") echo "selected=\"selected\""; ? >><? php echo $signup_February; ? ></option>
	<option value="3" <? php if ($BirthMonth=="3") echo "selected=\"selected\""; ? >><? php echo $signup_March; ? ></option>
	<option value="4" <? php if ($BirthMonth=="4") echo "selected=\"selected\""; ? >><? php echo $signup_April; ? ></option>
	<option value="5" <? php if ($BirthMonth=="5") echo "selected=\"selected\""; ? >><? php echo $signup_May; ? ></option>
	<option value="6" <? php if ($BirthMonth=="6") echo "selected=\"selected\""; ? >><? php echo $signup_June; ? ></option>
	<option value="7" <? php if ($BirthMonth=="7") echo "selected=\"selected\""; ? >><? php echo $signup_July; ? ></option>
	<option value="8" <? php if ($BirthMonth=="8") echo "selected=\"selected\""; ? >><? php echo $signup_August; ? ></option>
	<option value="9" <? php if ($BirthMonth=="9") echo "selected=\"selected\""; ? >><? php echo $signup_September; ? ></option>
	<option value="10" <? php if ($BirthMonth=="10") echo "selected=\"selected\""; ? >><? php echo $signup_October; ? ></option>
	<option value="11" <? php if ($BirthMonth=="11") echo "selected=\"selected\""; ? >><? php echo $signup_November; ? ></option>
	<option value="12" <? php if ($BirthMonth=="12") echo "selected=\"selected\""; ? >><? php echo $signup_December; ? ></option>
</select>


<select name="BirthDay" class="signup-name" >
	<option value="0"  <? php if ($BirthDay=="0") echo "selected=\"selected\""; ? >><? php echo $signup_Birth_Day; ? ></option>
	<? php
	for ($i=1; $i<=31; $i++)
	{
		echo "<option value=\"". $i . "\"";
		if ($BirthDay==$i) echo " selected=\"selected\" ";
		echo ">". $i ."</option>";
	}
	? >
</select>

<select name="BirthYear" class="signup-name" >
	<option value="0"  <? php if ($BirthYear=="0") echo "selected=\"selected\""; ? >><? php echo $signup_Birth_Year; ? ></option>
	<? php
	for ($i=2010; $i>=1900; $i--)
	{
		echo "<option value=\"". $i . "\"";
		if ($BirthYear==$i) echo " selected=\"selected\" ";
		echo ">". $i ."</option>";
	}
	? >
</select>
</div>



Picture<br>
  <div>
	  <div id="image_file_preview" name="image_file_preview" style="float:left; align:left; margin-right:15px; "><? php if ($Picture!="") { echo "<img src=\"".$Picture."\">"; } ? >
	  <br>
	  You can change your picture from your profile page later.
	  </div>

  </div>
  <div style="clear: both;"></div>
<br>

*/
?>

<div style="height:15px"></div>
<input type="submit" name="join_button" value="<?php echo $signup_join_button; ?>" class="submitbutton" />
</form>
<br>

<p class="smalltext gry" style="line-height:1.2em">
    <?php echo $signup_join_text; ?>
</p>


<script type='text/javascript'>

    $(function() {
	 $('#signup_form [title]').tipsy({trigger: 'focus', fade:true, gravity: 'w'});
    });


    $(function() {
		$(".example8").colorbox({width:"300px", inline:true, speed:100, initialWidth:'100px', initialHeight:'100px', opacity:'0.2', speed:350, transition:"elastic" , href:"#inline_example1"});
    });

  </script>




<!-- FOTTER -->
		
				<div class="clear"></div>
			</div>	
		</div>
		
	</div>
 </div>
<div id="lb"></div>

</body>
</html>