<?php $page="my-elooi"; ?>
<?php $subpage="settings-notifications"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>
<?php include("/check-user-login.php"); ?>

<?php
if ($_POST["op"]=="")
{
	$xsqlCommand = "SELECT * FROM usernotifications WHERE UserID=".$_SESSION['Elooi_UserID'];
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1)
	{
		$i=0;
		$new_text_message = mysql_result($mysqlresult,$i,"new_text_message");
		$new_elooi_message= mysql_result($mysqlresult,$i,"new_elooi_message");
		$new_listener     = mysql_result($mysqlresult,$i,"new_listener");
		$mark_favorite    = mysql_result($mysqlresult,$i,"mark_favorite");
		$friend_request   = mysql_result($mysqlresult,$i,"friend_request");
		$facebook_friend  = mysql_result($mysqlresult,$i,"facebook_friend");
		$new_badge        = mysql_result($mysqlresult,$i,"new_badge");
		$news_and_updates = mysql_result($mysqlresult,$i,"news_and_updates");

	}
}

if ($_POST["op"]=="update_notifications")
{
	$new_text_message  = 0;	if ($_POST['new_text_message']=="on")  { $new_text_message = 1; }
	$new_elooi_message = 0;	if ($_POST['new_elooi_message']=="on") { $new_elooi_message = 1; }
	$new_listener      = 0;	if ($_POST['new_listener']=="on")      { $new_listener = 1; }
	$mark_favorite     = 0;	if ($_POST['mark_favorite']=="on")     { $mark_favorite = 1; }
	$friend_request    = 0;	if ($_POST['friend_request']=="on")    { $friend_request = 1; }
	$facebook_friend   = 0;	if ($_POST['facebook_friend']=="on")   { $facebook_friend = 1; }
	$new_badge         = 0;	if ($_POST['new_badge']=="on")         { $new_badge = 1; }
	$news_and_updates  = 0;	if ($_POST['news_and_updates']=="on")  { $news_and_updates = 1; }

	$xsqlCommand = "UPDATE usernotifications SET new_text_message=".$new_text_message .", new_elooi_message=".$new_elooi_message .", new_listener=".$new_listener .", mark_favorite=".$mark_favorite .", friend_request=".$friend_request .", facebook_friend=".$facebook_friend .", new_badge=".$new_badge .",news_and_updates=".$news_and_updates."  WHERE UserID=".$_SESSION['Elooi_UserID'];

//	echo $xsqlCommand;

	$mysqlresult1 = mysql_query($xsqlCommand);
	if ($mysqlresult1 != "1") { $Update_Message=$Settings_Account_db_Error." (6)"; } else
	{
		$Update_Message=$Settings_Notifications_Update_Message;
	}

}
?>



<div class="banner2">
		<h2><img src="/slir/w32-h32-c1.1/<?php echo $_SESSION['Elooi_Picture']; ?>" height=32 style="vertical-align:top; "> <?php echo $_SESSION['Elooi_FullName'];?><?php echo $Settings_Title ?></h2>

  <ul class="settings-tabs_ul"> 
    <li><a href="/settings/account" id=""><?php echo $Settings_Acconut; ?></a></li> 
    <li><a href="/settings/profile" style="display:block;" id=""><?php echo $Settings_Profile; ?></a></li> 
    <li><a href="/settings/design" id=""><?php echo $Settings_Design; ?></a></li> 
    <li class="settings-active"><a href="/settings/notifications" id=""><?php echo $Settings_Notifications; ?></a></li> 
    <li><a href="/settings/password" id=""><?php echo $Settings_Password; ?></a></li> 
  </ul> 

</div>

<div class="content-main " >

<div class="content-section">

<?php if ($Update_Message!="") {?>
<div class="successbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Update_Message; ?></div>
<?php } ?>

<form id="signup_form" method=post action="/settings/notifications"  autocomplete = "off">
<input type="hidden" name="op" value="update_notifications">

<?php echo $Settings_Notifications_Email_Sent; ?>
<br>
<div style="height:20px"></div>

<span class="settings-subheader"><?php echo $Settings_Notifications_Messages; ?></span>
<div style="margin-left:20px; margin-top:10px">
<!--
 <label for="new_text_message" style="cursor:pointer">
 <input id="new_text_message" name="new_text_message" type="checkbox" <?php 
		if ($new_text_message=="1") echo " CHECKED "; ?>  />
	I'm sent a text message <span class="settingTip" title="While elooi is about voice, we do recognize the need to type from time to time. Depending on your privacy settings only your friends or everyone can send you messages. If you want to recive an email when you get sent a text message check this box.">?</span>
 </label>
-->
 <label for="new_elooi_message" style="cursor:pointer">
 <input id="new_elooi_message" name="new_elooi_message" type="checkbox" <?php 
		if ($new_elooi_message=="1") echo " CHECKED "; ?>  />
	<?php echo $Settings_Notifications_Elooi_Reply; ?> <span class="settingTip" title="<?php echo $Settings_Notifications_Elooi_Reply_Tip; ?>">?</span>
 </label>
</div>
<div style="height:20px"></div>

<span class="settings-subheader"><?php echo $Settings_Notifications_Social_Activity; ?></span>
<div style="margin-left:20px; margin-top:10px">

 <label for="new_listener" style="cursor:pointer">
 <input id="new_listener" name="new_listener" type="checkbox" <?php 
		if ($new_listener=="1") echo " CHECKED "; ?>  />
	<?php echo $Settings_Notifications_New_Listener; ?> <span class="settingTip" title="<?php echo $Settings_Notifications_New_Listener_Tip; ?>">?</span>
 </label>
<br>
 <label for="mark_favorite" style="cursor:pointer">
 <input id="mark_favorite" name="mark_favorite" type="checkbox" <?php 
		if ($mark_favorite=="1") echo " CHECKED "; ?>  />
	<?php echo $Settings_Notifications_Favorite; ?> <span class="settingTip" title="<?php echo $Settings_Notifications_Favorite_Tip; ?>">?</span>
 </label>
<br>
 <label for="new_badge" style="cursor:pointer">
 <input id="new_badge" name="new_badge" type="checkbox" <?php 
		if ($new_badge=="1") echo " CHECKED "; ?>  />
	<?php echo $Settings_Notifications_New_Badge; ?> <span class="settingTip" title="<?php echo $Settings_Notifications_New_Badge_Tip; ?>">?</span>
 </label>

</div>
<div style="height:20px"></div>

<span class="settings-subheader"><?php echo $Settings_Notifications_Friend_Activity; ?></span>
<div style="margin-left:20px; margin-top:10px">

 <label for="friend_request" style="cursor:pointer">
 <input id="friend_request" name="friend_request" type="checkbox" <?php 
		if ($friend_request=="1") echo " CHECKED "; ?>  />
	<?php echo $Settings_Notifications_Friend_Request; ?><span class="settingTip" title="<?php echo $Settings_Notifications_Friend_Request_Tip; ?>">?</span>
 </label>
<br>
 <label for="facebook_friend" style="cursor:pointer">
 <input id="facebook_friend" name="facebook_friend" type="checkbox" <?php 
		if ($facebook_friend=="1") echo " CHECKED "; ?>  />
	<?php echo $Settings_Notifications_fb_Friend; ?> <span class="settingTip" title="<?php echo $Settings_Notifications_fb_Friend_Tip; ?>">?</span>
 </label>
</div>
<div style="height:20px"></div>

<span class="settings-subheader"><?php echo $Settings_Notifications_News; ?></span>
<div style="margin-left:20px; margin-top:10px">

 <label for="news_and_updates" style="cursor:pointer">
 <input id="news_and_updates" name="news_and_updates" type="checkbox" <?php 
		if ($news_and_updates=="1") echo " CHECKED "; ?>  />
<?php echo $Settings_Notifications_News_Update; ?> <span class="settingTip" title="<?php echo $Settings_Notifications_News_Update_Tip; ?>">?</span>
 </label>

</div>

<br>

<div class="actions-div" id="save" style="padding-left: 10px;">
	<input type="submit" name="join_button" value="<?php echo $generic_save_changes; ?>" class="submitbutton" />
</div>
</form>

<script type='text/javascript'>
$('.settingTip').tipsy({trigger: 'hover', fade:true, gravity: 's'});
</script>

</div>

<div class="side-section"><?php echo $Settings_Notifications_SideBar; ?></div>

<?php include("/ortak-fotter.php"); ?>