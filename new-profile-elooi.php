<?php session_start(); 
ob_start(); ?>
<?php include("/check-user-login.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/lang-en.php'); ?>
<style type="text/css">
	.tipsy-inner { padding: 5px 8px 4px 8px; background-color: black; color: white; max-width: 250px; text-align: left;  
    font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif;
    font-size: 13px;}

	.ui-autocomplete-loading { background: white url('/css/images/ui-anim_basic_16x16.gif') right center no-repeat; }
	#city { width: 25em; }
</style>

<script type="text/javascript" src="/swfobject.js"></script>

<script type="text/javascript">
	<!-- Adobe recommends that developers use SWFObject2 for Flash Player detection. -->
	<!-- For more information see the SWFObject page at Google code (http://code.google.com/p/swfobject/). -->
	<!-- Information is also available on the Adobe Developer Connection Under Detecting Flash Player versions and embedding SWF files with SWFObject 2" -->
	<!-- Set to minimum required Flash Player version or 0 for no version detection -->
	<!-- 10.0.22 is the minimum Flash Player version taht properly supports the Speex audio codec used by default in FLVAR -->
	var swfVersionStr = "10.0.22"; 
	<!-- xiSwfUrlStr can be used to define an express installer SWF. -->
	var xiSwfUrlStr = "";
	var flashvars = {
		userId: "<?php echo $_SESSION['Elooi_UserID'] ?>",
		recorderId: "<?php echo "001".$_SESSION['Elooi_UserID'] ?>",
		sscode: "php"
	};
	var params = {};
	params.quality = "high";
	params.bgcolor = "#ffffff";
	params.play = "true";
	params.loop = "true";
	params.sscode = "asp";
	params.wmode = "transparent";
	params.scale = "showall";
	params.menu = "true";
	params.devicefont = "false";
	params.salign = "";
	params.allowscriptaccess = "sameDomain";
	params.allowFullScreen = "true";
	var attributes = {};
	attributes.id = "audiorecorder";
	attributes.name = "audiorecorder";
	attributes.sscode = "php";
	attributes.align = "middle";
//			swfobject.createCSS("html", "height:100%; background-color: #ffffff;");
//			swfobject.createCSS("body", "margin:0; padding:0; overflow:hidden; height:100%;");
	swfobject.embedSWF(
		"/audiorecorder.swf", "flashContent",
		"320", "140",
		swfVersionStr, xiSwfUrlStr,
		flashvars, params, attributes);
</script>

<script type="text/javascript">
		var swfu_mp3;
//		window.onload = function () {
		swfu_mp3 = new SWFUpload({
			// Backend Settings
			upload_url: "/upload-mp3-elooi.php",
			post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},

			// File Upload Settings
			file_size_limit : "4 MB",	// 2MB
			file_types : "*.mp3",
			file_types_description : "MP3 Dosyası",
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
			button_placeholder_id : "spanButtonPlaceholderMP3",
			button_width: 168,
			button_height: 18,
			button_text : '<span class="flash-button"><?php echo $newelooi_uploadmp3; ?></span>',
			button_text_style : '.flash-button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; width:180px; } .flash-buttonSmall { font-size: 10pt; }',
			button_text_top_padding: 0,
			button_text_left_padding: 18,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// Flash Settings
			flash_url : "/swfupload/swfupload.swf",

			custom_settings : {
				upload_target : "divFileProgressContainerMP3"
			},
			
			// Debug Settings
			debug: false
		});
//		};
</script>


<script type="text/javascript">
	var RecordPressed=0;

	function btSavePressed(streamName,streamDuration,userId,recorderId){
		jQuery('#recording_file').val(streamName);
		jQuery('#recording_length').val(streamDuration);

		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Procsessing; ?></center>");
		jQuery("#process-sound").load('/process-rec.php?type=profile&n='+streamName);
	}
	function btPlayPressed(){	}
	function btPausePressed(){	}
	function btStopPressed(){	}
	function btRecordPressed(){	RecordPressed =1; }

	var uploadTypeX="recording";

	function ProcessElooiSubmit() {
		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Saving; ?></center>");
		var submit_MusicCredit      = jQuery("#xMusicCredit").val();
		var submit_mp3_file         = jQuery("#mp3_file").val();
		var submit_recording_length = jQuery("#recording_length").val();
		var submit_recording_file   = jQuery("#recording_file").val();

		if (submit_mp3_file=="") {
			if ( (uploadTypeX=="recording") && (RecordPressed ==1) ) 
				{ alert("<?php echo $newelooi_press_save; ?>"); } else
				{ alert("<?php echo $newelooi_record_upload; ?>"); }
			jQuery("#process-sound").html("");
		} else
		{
		  //no errors save
			$.post( "/save-elooi.php", { s_Type:"profile", s_MusicCredit:submit_MusicCredit, s_mp3_file:submit_mp3_file, s_recording_length:submit_recording_length, s_recording_file:submit_recording_file },
			  function( data ) {
				  $( "#process-sound" ).html(data);
			  }
			);
		} 
	}

	function ProcessMP3(filename) {
		  jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Procsessing; ?></center>");
		  jQuery("#process-sound").load('/process-rec.php?type=profile&n='+filename);
	}

	function ShowMusicCredit() {
			jQuery("#zMusicCredit").css('display', 'none');
			jQuery("#yMusicCredit").css('display', 'inline');
	}

	function SelectMP3() {
		if (uploadTypeX=="recording") {
			jQuery('#mp3_file').val('');
			jQuery('#recording_file').val('');
			jQuery('#recording_length').val('');

			jQuery("#flashContentParent").css('display', 'none');
			jQuery("#mp3_upload").show();
			jQuery("#upload-type-button").val('<?php echo $newelooi_use_mic; ?>');

			uploadTypeX="mp3";
			RecordPressed =0;
		} else
		{	jQuery('#mp3_file').val('');

			jQuery("#flashContentParent").css('display', 'block');
			jQuery("#mp3_upload").hide();
			jQuery("#upload-type-button").val('<?php echo $newelooi_use_mp3; ?>');
			uploadTypeX="recording";
			RecordPressed =0;
		}
	}

	$(document).ready(function() {
		jQuery("#mp3_upload").hide();
		jQuery('.settingTip').tipsy({trigger: 'hover', fade:true, html:true, gravity: 's'});
		jQuery("#signup_form label").inFieldLabels();
		jQuery('#signup_form [title]').tipsy({trigger: 'focus', fade:true, offsetWidth:200, html:true, gravity: 'w'});

		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		  });

	});

</script>


<!-- This contains the hidden content for inline calls -->

<div style="position:absolute; right:10px; width:110px; height:90px; padding:5px;" id="process-sound" name="process-sound"></div>

<input type="button" name="upload-type-button" id="upload-type-button" class="submitbutton"  style="width:318px; padding:2px" value="<?php echo $newelooi_use_mp3; ?>" onClick="SelectMP3()" /> 

<br>

<div id="flashContentParent">
<div id="flashContent" style="width:320px; height:140px; border-style: solid; border-width:1px; border-color:black; margin-top:3px;">
	<a href="http://www.adobe.com/go/getflash">
		<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
	</a>
	<p>This page requires Flash Player version 10.0.22 or higher.</p>
</div>
</div>

<div id="mp3_upload" class="upload-mp3-box">

<div style="height:6px"></div>

<div style="margin-top:10px">
		<div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 6px;">
			<span id="spanButtonPlaceholderMP3"></span>
		</div>
	<div id="divFileProgressContainerMP3" style="height: 45px;"></div>
</div>

<div style="height:6px"></div>
<div style="width:286px">
<?php echo $newelooi_mp3_text; ?>
</div>
</div>

<div style="height:5px"></div>

<form id="signup_form" style="width:400px" method=post action="" autocomplete = "off" onsubmit="javascript:return false;">
<input type="hidden" id="recording_file" name="recording_file" value="">
<input type="hidden" id="recording_length" name="recording_length" value="">
<input type="hidden" id="mp3_file" name="mp3_file" value="">

<div class="clicktoedit_text" id="zMusicCredit" onClick="ShowMusicCredit()"><?php echo $newelooi_credit_question; ?></div>
<div style="padding:0px; margin:0px; display:none;" id="yMusicCredit">
<span>
  <label for="xMusicCredit"><?php echo $newelooi_credit_input; ?></label>
  <input type="text" name="xMusicCredit" value="" id="xMusicCredit" class="signup-name" style="width:306px; margin-left:0px;" title="<?php echo $newelooi_credit_hint; ?>">
</span>
<div style="margin-top:5px; margin-bottom:15px;"><span style="font-size:90%"><?php echo $HomepageError; ?></span></div>
</div>

</form>

<div style="clear: both;"></div>

<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%; height:30px;">

	<div style="float:right; margin-right:25px;">
	<input class="submitbutton" value="<?php echo $newelooi_add_elooi; ?>" type="button" onClick="ProcessElooiSubmit();">
	</div>
</div>