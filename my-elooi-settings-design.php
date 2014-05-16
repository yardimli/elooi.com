<?php $page="my-elooi"; ?>
<?php $subpage="settings-design"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>
<?php include("/check-user-login.php"); ?>

<?php
$Update_Message="";

if ($_POST["op"]=="")
{
	$xsqlCommand = "SELECT * FROM userprofiles WHERE UserID=".$_SESSION['Elooi_UserID'];
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1)
	{
		$i=0;
		$TileBackground  = mysql_result($mysqlresult,$i,"TileBackground");
		if ($TileBackground=="") { $backgroundImage = "0"; }

		$backgroundImage = mysql_result($mysqlresult,$i,"backgroundImage");
		if ($backgroundImage=="") { $backgroundImage = "/spacer.gif"; }
		
		$backgroundColor = mysql_result($mysqlresult,$i,"backgroundColor");
		if ($backgroundColor=="") { $backgroundColor = "#FFFFFF"; }
		
		$textColor       = mysql_result($mysqlresult,$i,"textColor");
		if ($textColor=="") { $textColor = "#000000"; }
		
		$linkColor       = mysql_result($mysqlresult,$i,"linkColor");
		if ($linkColor=="") { $linkColor = "#222222"; }

		$headerColor     = mysql_result($mysqlresult,$i,"headerColor");
		if ($headerColor=="") { $headerColor = "#333333"; }

		$TextBackgroundColor  = mysql_result($mysqlresult,$i,"TextBackgroundColor");
		if ($TextBackgroundColor=="") { $TextBackgroundColor = "#CCCCCC"; }
	}
}

if ($_POST["op"]=="update_design")
{
	$TileBackground  = 0; if ($_POST['form_TileBackground']=="on")  { $TileBackground = 1; }

	$backgroundImage = $_POST['form_BackgroundImage'];

	$log->lwrite($backgroundImage);

	if (stripos($backgroundImage,"/site_veri/temp_bg/")!==false)
	{
		$save_path = "c:/wamp/www/audio-backgrounds/"; //"c:/wamp/www/audio-picture/";
		$file_name = str_replace("/site_veri/temp_bg/","",$backgroundImage);

  		$log->lwrite("c:/wamp/www".$backgroundImage);
  		$log->lwrite($save_path . $file_name);

		if (!@copy("c:/wamp/www".$backgroundImage, $save_path . $file_name)) {
			//leave it in temp and save it there
		} else
		{
			$backgroundImage = "/audio-backgrounds/".$file_name;
		}
	}

	$backgroundColor = $_POST['form_BackgroundColor'];
	$textColor       = $_POST['form_TextColor'];
	$linkColor       = $_POST['form_LinkColor'];
	$headerColor     = $_POST['form_HeaderColor'];
	$TextBackgroundColor = $_POST['form_TextBackgroundColor'];

	$TileBackground_  = ATQ($TileBackground);
	$backgroundImage_ = ATQ($backgroundImage);
	$backgroundColor_  = ATQ($backgroundColor);
	$textColor_ = ATQ($textColor);
	$linkColor_  = ATQ($linkColor);
	$headerColor_ = ATQ($headerColor);
	$TextBackgroundColor_ = ATQ($TextBackgroundColor);

	$xsqlCommand = "UPDATE userprofiles SET TileBackground=".$TileBackground_ ." , backgroundImage=".$backgroundImage_ ." , backgroundColor=". $backgroundColor_ .", textColor=". $textColor_ .", linkColor=". $linkColor_ .", headerColor=". $headerColor_ .", TextBackgroundColor=". $TextBackgroundColor_ ." WHERE UserID=".$_SESSION['Elooi_UserID'];

	$_SESSION['TileBackground']   = $TileBackground;
	$_SESSION['backgroundImage']  = $backgroundImage;
	$_SESSION['backgroundColor']  = $backgroundColor;
	$_SESSION['textColor']        = $textColor;
	$_SESSION['TextBackgroundColor']        = $TextBackgroundColor;
	$_SESSION['linkColor']        = $linkColor;
	$_SESSION['headerColor']      = $headerColor;
	//echo $xsqlCommand;
	$mysqlresult1 = mysql_query($xsqlCommand);
	if ($mysqlresult1 != "1") { $Update_Message= $Settings_Account_db_Error." (5)"; } else
	{
		$Update_Message=$Settings_Design_Update_Msg;
	}
}
?>

<style type="text/css">
.progressWrapper {	width: 202px;	overflow: hidden;}
</style>

<div class="banner2" style="width:750px;">
		<h2><img src="/slir/w32-h32-c1.1/<?php echo $_SESSION['Elooi_Picture']; ?>" height=32 style="vertical-align:top; "> <?php echo $_SESSION['Elooi_FullName'];?><?php echo $Settings_Title ?></h2>

  <ul class="settings-tabs_ul"> 
    <li><a href="/settings/account" id=""><?php echo $Settings_Acconut; ?></a></li> 
    <li><a href="/settings/profile" style="display:block;" id=""><?php echo $Settings_Profile; ?></a></li> 
    <li class="settings-active"><a href="/settings/design" id=""><?php echo $Settings_Design; ?></a></li> 
    <li><a href="/settings/notifications" id=""><?php echo $Settings_Notifications; ?></a></li> 
    <li><a href="/settings/password" id=""><?php echo $Settings_Password; ?></a></li> 
  </ul> 
</div>

<div class="content-main " style="width:728px;" id="maincontentx">
<div class="content-section" style="width:728px;">

<?php
if ($Update_Message!="") {?>
<div class="successbox" id="alertbox" style="align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Update_Message; ?></div>
<script type="text/javascript">
setTimeout(function() {  $("#alertbox").slideUp(); }, 5000);
</script>
<?php } ?>

<div id="design_customization" class="content-section">

<script type="text/javascript">

jQuery(document).ready(function(){ 

	setBackgroundValues("<?php if ($TileBackground=="1") { echo "repeat"; } else { echo "no-repeat"; } ?>","<?php echo $backgroundColor; ?>","<?php echo $backgroundImage; ?>","/crop_image.php?width=100&height=70&cropratio=3:2&image=<?php echo $backgroundImage; ?>", "<?php echo $textColor; ?>", "<?php echo $headerColor; ?>", "<?php echo $linkColor; ?>", "<?php echo $TextBackgroundColor; ?>");

	$("#BackGroundColorSelector").CanvasColorPicker({
		showRGB:false,showHSB:false,height:180,width:320,color:parseColor2(BackgroundColor),
		onOK: function(rgb,hsb){
			BackgroundColor = RGB2HEX2(rgb);
			updateBackground();
			return true;
		}
	});

	$("#FontTextColorSelector").CanvasColorPicker({
		showRGB:false,showHSB:false,height:180,width:320,color:parseColor2(FontTextColor),
		onOK: function(rgb,hsb){
			FontTextColor = RGB2HEX2(rgb);
			updateBackground();
			return true;
		}
	});

	$("#FontTextBackgroundColorSelector").CanvasColorPicker({
		showRGB:false,showHSB:false,height:180,width:320,color:parseColor2(FontTextBackgroundColor),
		onOK: function(rgb,hsb){
			FontTextBackgroundColor = RGB2HEX2(rgb);
			updateBackground();
			return true;
		}
	});
	

	$("#FontLinkColorSelector").CanvasColorPicker({
		showRGB:false,showHSB:false,height:180,width:320,color:parseColor2(FontLinkColor),
		onOK: function(rgb,hsb){
			FontLinkColor = RGB2HEX2(rgb);
			updateBackground();
			return true;
		}
	});

	$("#FontHeaderColorSelector").CanvasColorPicker({
		showRGB:false,showHSB:false,height:180,width:320,color:parseColor2(FontHeaderColor),
		onOK: function(rgb,hsb){
			FontHeaderColor = RGB2HEX2(rgb);
			updateBackground();
			return true;
		}
	});

<?php
$mysqlresult = mysql_query("SELECT * FROM sitethemes ORDER BY ID ASC");
$num_rows = mysql_num_rows($mysqlresult);
$i = 0;
WHILE ($i<$num_rows) {
?>
	jQuery("#theme<?php echo mysql_result($mysqlresult,$i,"ID"); ?>").click( function(){ 
		setBackgroundValues("<?php if (mysql_result($mysqlresult,$i,"bgRepeat")=="1") { echo "repeat"; } else { echo "no-repeat"; } ?>","<?php echo mysql_result($mysqlresult,$i,"BgColor"); ?>","<?php echo mysql_result($mysqlresult,$i,"bgImage"); ?>","<?php echo mysql_result($mysqlresult,$i,"bgImageSmall"); ?>", "<?php echo mysql_result($mysqlresult,$i,"FontColor"); ?>", "<?php echo mysql_result($mysqlresult,$i,"HeaderColor"); ?>", "<?php echo mysql_result($mysqlresult,$i,"LinkColor"); ?>", "<?php echo mysql_result($mysqlresult,$i,"TextBackgroundColor"); ?>");

		jQuery('#theme<?php echo mysql_result($mysqlresult,$i,"ID"); ?>').removeClass("theme-selector-border").addClass("theme-selector-active");

		return false;
	});
<?php
	$i++;
}
?>

	jQuery("#nobackground").click( function(){ 
		setBackgroundValues("no-repeat","#FFFFFF","", "", "#333333", "#000000", "#333333","#CCCCCC");

		for (var i=0; i<=10; i++) {	jQuery('#theme'+i).removeClass("theme-selector-active").addClass("theme-selector-border"); }
		jQuery('#nobackground').removeClass("theme-selector-border").addClass("theme-selector-active");

		return false;
	}); 

	jQuery("#form_TileBackground").click( function(){ 
		if (jQuery('#form_TileBackground').is(':checked')) { BackgroundRepeat = "repeat"; } else {BackgroundRepeat = "no-repeat";}
		updateBackground();
	}); 

	jQuery("#user_background").click( function(){ 
		updateBackground();

		for (var i=0; i<=10; i++) {	jQuery('#theme'+i).removeClass("theme-selector-active").addClass("theme-selector-border"); }
		jQuery('#nobackground').removeClass("theme-selector-active").addClass("theme-selector-border");
		jQuery('#user_background').removeClass("theme-selector-border").addClass("theme-selector-active");

		return false;
	}); 


	var swfu;
	window.onload = function () {
		swfu = new SWFUpload({
			// Backend Settings
			upload_url: "/upload-background.php",
			post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},

			// File Upload Settings
			file_size_limit : "1 MB",	// 2MB
			file_types : "*.jpg;*.png,*.gif",
			file_types_description : "<?php echo $Settings_Design_Img_Files; ?>",
			file_upload_limit : "0",
			file_queue_limit : 1,

			// Event Handler Settings - these functions as defined in Handlers.js
			//  The handlers are not part of SWFUpload but are part of my website and control how
			//  my website reacts to the SWFUpload events.
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,

			// Button Settings
			button_image_url : "/images/SmallSpyGlassWithTransperancy_17x18.png",
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: 188,
			button_height: 18,
			button_text : '<span class="flash-button"><?php echo $Settings_Design_Upload_Background; ?></span>',
			button_text_style : '.flash-button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; width:200px; } .flash-buttonSmall { font-size: 10pt; }',
			button_text_top_padding: 0,
			button_text_left_padding: 18,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : "/swfupload/swfupload.swf",

			custom_settings : {
				upload_target : "divFileProgressContainer"
			},
			
			// Debug Settings
			debug: false
		});
	};
});

</script>
    <h3><?php echo $Settings_Design_Select_Theme; ?></h3>

	  <input id="user_profile_theme" name="profile_theme" type="hidden" value="1" />
      <div id="themes" class="clearfix">
<?php
$mysqlresult = mysql_query("SELECT * FROM sitethemes ORDER BY ID ASC");
$num_rows = mysql_num_rows($mysqlresult);
$i = 0;
WHILE ($i<$num_rows) {
?>
	<div class="theme-selector theme-selector-border" id="theme<?php echo mysql_result($mysqlresult,$i,"ID"); ?>"><img alt="<?php echo mysql_result($mysqlresult,$i,"ThemeName"); ?>" src="<?php echo mysql_result($mysqlresult,$i,"bgImageSmall"); ?>" /></div>
<?php
	$i++;
}
?>
    </div>

<br>
    <h3><?php echo $Settings_Design_Make_Theme; ?></h3>

    <div style="height:90px">
	    <div class="theme-selector theme-selector-border" id="user_background"><img src="/spacer.gif" id="user_image"  /></div>

		<div class="theme-selector theme-selector-border" id="nobackground" style="
		margin-left:10px;
		font-size: 11px;
		height:74px; width:114px;">
			<center><br>
			<img alt="" src="/no_background.gif" style="height:10px; width:10px; display:inline-block;"> <?php echo $Settings_Design_No_Bckg; ?>
			</center>
		</div>

		<div style="float: left; margin-top:1px; margin-left:10px; ">
				<div style="border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 6px;">
					<span id="spanButtonPlaceholder"></span>
				</div>
			<div id="divFileProgressContainer" style="height: 45px;"></div>
		</div>


</div>

	<form action="/settings/design" method="post">
	<input type="hidden" name="op" value="update_design">
	<INPUT TYPE="hidden" NAME="form_BackgroundImage" ID="form_BackgroundImage">
	<INPUT TYPE="hidden" NAME="form_BackgroundColor" ID="form_BackgroundColor">
	<INPUT TYPE="hidden" NAME="form_TextColor" ID="form_TextColor">
	<INPUT TYPE="hidden" NAME="form_LinkColor" ID="form_LinkColor">
	<INPUT TYPE="hidden" NAME="form_HeaderColor" ID="form_HeaderColor">
	<INPUT TYPE="hidden" NAME="form_TextBackgroundColor" ID="form_TextBackgroundColor">


    <div style="height:30px; margin-left:10px;">
	<INPUT TYPE="checkbox" NAME="form_TileBackground" ID="form_TileBackground" <?php 
		if ($TileBackground=="1") echo " CHECKED "; ?>><label for="form_TileBackground"><?php echo $Settings_Design_Tile; ?></label>
	</div>

	<div style="height:90px">
		<div class="theme-selector theme-selector-border theme-selector-box" id="nobackground">
			<center><?php echo $Settings_Design_bg_Color; ?></center>
			<div id="BackGroundColorSelector" style="margin-left:3px; margin-top:3px; width:105px;height:47px;background:#eeeeee;border:1px solid black;line-height:30px;text-align:center;"></div>
		</div>

		<div class="theme-selector theme-selector-border theme-selector-box" id="nobackground">
			<center><?php echo $Settings_Design_TextBackgroundColor; ?></center>
			<div id="FontTextBackgroundColorSelector" style="margin-left:3px; margin-top:3px; width:105px;height:47px;background:#eeeeee;border:1px solid black;line-height:30px;text-align:center;"></div>
		</div>


		<div class="theme-selector theme-selector-border theme-selector-box" id="nobackground">
			<center><?php echo $Settings_Design_txt_Color; ?></center>
			<div id="FontTextColorSelector" style="margin-left:3px; margin-top:3px; width:105px;height:47px;background:#eeeeee;border:1px solid black;line-height:30px;text-align:center;"></div>
		</div>

		<div class="theme-selector theme-selector-border theme-selector-box" id="nobackground">
			<center><?php echo $Settings_Design_link_Color; ?></center>
			<div id="FontLinkColorSelector" style="margin-left:3px; margin-top:3px; width:105px;height:47px;background:#eeeeee;border:1px solid black;line-height:30px;text-align:center;"></div>
		</div>

		<div class="theme-selector theme-selector-border theme-selector-box" id="nobackground">
			<center><?php echo $Settings_Design_header_Color; ?></center>
			<div id="FontHeaderColorSelector" style="margin-left:3px; margin-top:3px; width:105px;height:47px;background:#eeeeee;border:1px solid black;line-height:30px;text-align:center;"></div>
		</div>
    </div>

    <div class="actions-div" id="save" style="padding-left: 10px;">
	    <input class="submitbutton" id="save_button" name="commit" onclick="" type="submit" value="<?php echo $generic_save_changes; ?>" />
	</div>
  </form></div>
</div>


<?php include("/ortak-fotter.php"); ?>

<div class="design-side-section" id="side-section-div" style="position:absolute; top:100px;" >
<?php echo $Settings_Design_SideBar; ?>
</div>

<script type="text/javascript">

jQuery("#side-section-div").css({"top":jQuery("#maincontentx").position().top });
jQuery("#side-section-div").css({"left":jQuery("#maincontentx").position().left+$("#maincontentx").width()+ 50 });

</script>
