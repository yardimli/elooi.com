<?php $page="my-elooi"; ?>
<?php $subpage="settings-password"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>
<?php include("/check-user-login.php"); ?>

<div class="banner2">
		<h2><img src="/slir/w32-h32-c1.1/<?php echo $_SESSION['Elooi_Picture']; ?>" height=32 style="vertical-align:top; "> <?php echo $_SESSION['Elooi_FullName'];?><?php echo $Settings_Title ?></h2>

  <ul class="settings-tabs_ul"> 
    <li><a href="/settings/account" id=""><?php echo $Settings_Acconut; ?></a></li> 
    <li><a href="/settings/profile" style="display:block;" id=""><?php echo $Settings_Profile; ?></a></li> 
    <li><a href="/settings/design" id=""><?php echo $Settings_Design; ?></a></li> 
    <li><a href="/settings/notifications" id=""><?php echo $Settings_Notifications; ?></a></li> 
    <li class="settings-active"><a href="/settings/password" id=""><?php echo $Settings_Password; ?></a></li> 
  </ul> 

</div>

<?php
if ($_POST["op"]=="")
{
}

$HasError = 0;
$PasswordOld_Error = "";
$PasswordNew1_Error = "";
$PasswordNew2_Error = "";

if ($_POST["op"]=="update_password")
{
	$Password_Old  = $_POST["Password_Old"];
	$Password_New1 = $_POST["Password_New1"];
	$Password_New2 = $_POST["Password_New2"];

	if ($Password_Old=="") { $PasswordOld_Error = "<div class=form-error>".$Settings_Password_Error1."</div>"; $HasError = 1; } else
	{
		$Password2   = "'".AddSlashes(Trim(md5($Password_Old.$randomword)))."'";

		$xsqlCommand = "SELECT * FROM users WHERE ID=".$_SESSION['Elooi_UserID']." AND Password=".$Password2;
//		echo $xsqlCommand;

		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==0)
		{
			$PasswordOld_Error = "<div class=form-error>".$Settings_Password_Error1."</div>"; $HasError = 1;
		}
	}

	if ($Password_New1=="") { $PasswordNew1_Error = "<div class=form-error>".$Settings_Account_NewPassword_Error1."</div>"; $HasError = 1; } else
	if (!valid_pass($Password_New1)) {
	  $HasError = 1; 
	  $PasswordNew1_Error = "<div class=form-error>". $signup_Password_Error2 ."</div>";	
	} 

	if ($Password_New2=="") { $PasswordNew2_Error = "<div class=form-error>".$Settings_Account_NewPassword_Error2."</div>"; $HasError = 1; } else
	if ($Password_New1!=$Password_New2) { $PasswordNew2_Error = "<div class=form-error>".$Settings_Account_NewPassword_Error3."</div>"; $HasError = 1; }

	if ($HasError==1)
	{
		$Update_Error_Message = $signup_Error;
	}

	if ($HasError==0)
	{
		$NewPassword   = "'".AddSlashes(Trim(md5($Password_New1.$randomword)))."'";
		$xsqlCommand = "UPDATE users SET password =".$NewPassword." WHERE ID=".$_SESSION['Elooi_UserID'];
		//echo $xsqlCommand;
		$mysqlresult1 = mysql_query($xsqlCommand);
		if ($mysqlresult1 != "1") { $Update_Error_Message=$Settings_Account_db_Error." (1)"; } else
		{
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

<?php if ($Update_Error_Message!="") {?>
<div class="errorbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Update_Error_Message; ?>

<?php echo $PasswordOld_Error; ?>
<?php echo $PasswordNew1_Error; ?>
<?php echo $PasswordNew2_Error; ?>

</div>
<?php } else
if ($Update_Message!="") {?>
<div class="successbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Update_Message; ?></div>
<?php } ?>


<form id="signup_form" method=post action="/settings/password"  autocomplete = "off">
<input type="hidden" name="op" value="update_password">

<?php echo $FormError; ?>

<div style="height:10px"></div>
<span>
  <label for="Password_Old"><?php echo $Settings_Password_Current; ?></label>
  <input type="password" name="Password_Old" value="" id="Password_Old" class="signup-name" style="width:400px">
</span>
<br>
<div style="margin-top:5px; margin-bottom:15px;"><span style="font-size:90%"><!--Please type your current password.--></span></div>
<div style="height:10px"></div>

<span>
  <label for="Password_New1"><?php echo $Settings_Password_New; ?></label>
  <input type="password" name="Password_New1" id="Password_New1" value="" class="signup-name" title="<?php echo $signup_Password_Error2; ?>"  style="width:400px">
</span>
<br>
<div style="margin-top:5px; margin-bottom:15px;"><span style="font-size:90%"><!--Please type your new password.--></span></div>
<div style="height:10px"></div>

<span>
  <label for="Password_New2"><?php echo $Settings_Password_Retype; ?></label>
  <input type="password" name="Password_New2" id="Password_New2" class="signup-name" style="width:400px">
</span>
<br>
<div style="margin-top:5px; margin-bottom:15px;"><span style="font-size:90%"><!--Please re-type your new password.--></span></div>
<div style="height:10px"></div>

<br><br><br><br><br><br>

<div class="actions-div" id="save" style="padding-left: 10px;">
	<input type="submit" name="join_button" value="<?php echo $Settings_Account_Update_Password; ?>" class="submitbutton" />
</div>
</form>

<script type='text/javascript'>

    $(function() {
	 $('#signup_form [title]').tipsy({trigger: 'focus', fade:true, gravity: 'w'});
    });

  </script>

</div>

<div class="side-section"><?php echo $Settings_Password_Tip; ?></div>

<?php include("/ortak-fotter.php"); ?>