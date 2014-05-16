<?php require_once("/server-settings.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php include("/php-functions.php"); ?>
<?php
	$mysqlresult = mysql_query("SELECT * FROM usersettings WHERE userID=".$_SESSION['Elooi_UserID']);
	$num_rows = mysql_num_rows($mysqlresult);
	$i=0;
?>
<?php require_once('/elooi-translation.php'); ?>

<style type="text/css">

.tipsy-inner { padding: 5px 8px 4px 8px; background-color: black; color: white; max-width: 250px; text-align: left;  
    font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif;
    font-size: 13px;}

	.ui-autocomplete-loading { background: white url('/css/images/ui-anim_basic_16x16.gif') right center no-repeat; }
	#city { width: 25em; }
</style>

<script type="text/javascript" src="/swfobject.js"></script>

<?php
if ($_GET["xtype"]=="mic") {
?>
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
<?php
}
?>

<?php
if ($_GET["xtype"]=="file") {
?>
<script type="text/javascript">
var swfu_mp3;

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
	swfupload_element_id : "flashUI1",		// Setting from graceful degradation plugin
	degraded_element_id : "degradedUI1",	// Setting from graceful degradation plugin

	custom_settings : {
		upload_target : "divFileProgressContainerMP3"
	},
	debug: false
});
</script>
<?php
}
?>

<script type="text/javascript">
var IconFolders = new Array();
var Icons = new Array();
var ElooiTagIcons = new Array();
var FolderPageNumber=1;
var IconPageNumber=1;
var s;

var RecordPressed=0;
var IconsXPos=0;
var DoScrollLeft=0;
var DoScrollRight=0;
var maxScroll=0;
var ScrollStep=20;
var TotalScroll=0;

<?php 
function get_subdir_files($main_dir) {
    $dirs = scandir($main_dir);
	$FolderCount = 0;
	foreach($dirs as $dir)  {
		if ($dir === '.' || $dir === '..') { continue; } else
		{
			$files=scandir($main_dir."/".$dir);

			echo "IconFolders[".$FolderCount."] = '".$dir."/';\n";
			echo "Icons[".$FolderCount."] = new Array();\n";

			$FileCount=0;
			foreach ($files as $file)  {
				if ($file === '.' || $file === '..') { continue; } else { 
					echo "Icons[".$FolderCount."][".$FileCount."] = '".$file."';\n";
					$FileCount++;
				}
			}
			$FolderCount++;
		}
    }   
} 
get_subdir_files("c:/wamp/www/audio-icons");
?>
	function btSavePressed(streamName,streamDuration,userId,recorderId){
		//jQuery('#recording_file').val(streamName); jQuery('#recording_length').val(streamDuration);

		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Procsessing; ?></center>");
		jQuery("#process-sound").load('/process-rec.php?type=profile&n='+streamName);
	}
	function btPlayPressed(){ }
	function btPausePressed(){ }
	function btStopPressed(){ }
	function btRecordPressed(){	RecordPressed =1; }

	var uploadTypeX="recording";

	function ProcessElooiSubmit() {
		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Saving; ?></center>");

		var submit_mp3_file         = jQuery("#mp3_file").val();
		var submit_Location         = jQuery("#myLocation").val();
		var submit_ReplyToID        = jQuery("#ReplyToID").val();
		var submit_tags             = ElooiTagIcons.toString();
		console.log(submit_tags);

		var arLen=ElooiTagIcons.length;

		if (submit_mp3_file=="") 
		{
			if ( (uploadTypeX=="recording") && (RecordPressed ==1) ) 
				{ alert("<?php echo $newelooi_press_save; ?>"); } else
				{ alert("<?php echo $newelooi_record_upload; ?>"); }
			jQuery("#process-sound").html("");
		} else
		if (arLen==0)
		{
			alert("<?php echo $newelooi_add_tags; ?>");
			jQuery("#process-sound").html("");
		} else
		{
		  //no errors save
			$.post( "/save-elooi.php", { s_Type:"elooi", s_mp3_file:submit_mp3_file, s_Location: submit_Location, s_tags:submit_tags, s_reply_to_id:submit_ReplyToID },
			  function( data ) {
				  $( "#process-sound" ).html(data);
			  }
			);
		} 
	}

	function ProcessMP3(filename) {
		  jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Procsessing; ?></center>");
		  jQuery("#process-sound").load('/process-rec.php?type=elooi&n='+filename);
	}

	$(document).ready(function() {

		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		  });

		$(".location-menu").click(function(e) {

			  var left1 = jQuery(".location-menu").offset().left;
			  var top1 = jQuery(".location-menu").offset().top;
			  var width2 = jQuery(".location-menu").width();
			  var height1 = jQuery(".location-menu").height();

			  jQuery("#location-popup").css( { "position": "absolute","left": (left1) + "px","top": (top1+height1+5) + "px" } );

			e.preventDefault();
			$("fieldset#location-popup").toggle();
			$(".location-menu").toggleClass("menu-open");
			$("#city").focus();
		});
		
		$("fieldset#location-popup").mouseup(function() {
			return false
		});
		$(document).mouseup(function(e) {
			if($(e.target).parent("a.location-menu").length==0) {
				$(".location-menu").removeClass("menu-open");
				$("fieldset#location-popup").hide();
			}
		});			
		

		jQuery('.settingTip').tipsy({trigger: 'hover', fade:true, html:true, gravity: 's'});
		jQuery("#signup_form label").inFieldLabels();
		jQuery('#signup_form [title]').tipsy({trigger: 'focus', fade:true, offsetWidth:200, html:true, gravity: 'w'});


		$( "#city" )
			.bind( "keydown", function( event ) {
							if ( (event.keyCode==27) ) {
								$('fieldset#location-popup').hide(); 
								return false;
							}
			})
			.autocomplete({
			source: function( request, response ) {
	//			console.log("begin search");
				$.ajax({
					url: "/search-places.php", 
					data: { term:escape(request.term) },
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: item.value,
								value: item.value
							}
						}));
					}
				});
			},

			minLength: 2,
			select: function( event, ui ) {
			  jQuery("#location-str").html("<?php echo $newelooi_Location; ?>: "+ui.item.value);
			  jQuery("#myLocation").val(ui.item.value);
			$('fieldset#location-popup').hide(); 

			  //this.autocomplete('close');
			},
			open: function() {
				$(this).data('is_open',true);
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$(this).data('is_open',false);
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});

		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		  });

	
	FolderPageNumber=1;
	LoadFolderPage(FolderPageNumber);


	});

	function SetScrollLeft(valuex) {
		maxScroll = $("#IconList").attr("scrollWidth")-464;
		DoScrollLeft=valuex; 
		if ((DoScrollLeft>0) && (IconsXPos>0))
		{
//			$('#ScrollRightButton').addClass("scrollingHotSpotRightVisible");
			$('#ScrollLeftButton').addClass("scrollingHotSpotLeftVisible");
		} else
		{
//			$('#ScrollRightButton').removeClass("scrollingHotSpotRightVisible");
			$('#ScrollLeftButton').removeClass("scrollingHotSpotLeftVisible");
		}

		if (DoScrollLeft==2)
		{
			ScrollStep=40;
			TotalScroll=0;
			var t=setTimeout("ScrollIcons()",25);
		}

	}

	function SetScrollRight(valuex) {
		maxScroll = $("#IconList").attr("scrollWidth")-464;
		DoScrollRight=valuex; 
		if ((DoScrollRight>0) && (IconsXPos<maxScroll))
		{
			$('#ScrollRightButton').addClass("scrollingHotSpotRightVisible");
//			$('#ScrollLeftButton').addClass("scrollingHotSpotLeftVisible");
		} else
		{
			$('#ScrollRightButton').removeClass("scrollingHotSpotRightVisible");
//			$('#ScrollLeftButton').removeClass("scrollingHotSpotLeftVisible");
		}

		if (DoScrollRight==2)
		{
			ScrollStep=40;
			TotalScroll=0;
			var t=setTimeout("ScrollIcons()",25);
		}
	}

	function ScrollIcons()
	{
		if (DoScrollLeft==2)
		{
			if ((TotalScroll<348) && (IconsXPos>0))
			{
				ScrollStep = Math.floor(ScrollStep / 1.06);
				if (ScrollStep<3) { ScrollStep=3; }
				if (TotalScroll+ScrollStep>347) { ScrollStep=1;	}
				TotalScroll = TotalScroll+ScrollStep;
				IconsXPos =IconsXPos-ScrollStep;

				$('#IconScrollArea').scrollLeft(IconsXPos);
				
				t=setTimeout("ScrollIcons()",30);
			} else
			{
				DoScrollLeft=1;
			}

			if (IconsXPos<=0)
			{
				$('#ScrollLeftButton').removeClass("scrollingHotSpotLeftVisible");
			}

		}

		if (DoScrollRight==2)
		{
			if ((TotalScroll<348) && (IconsXPos<maxScroll))
			{
				ScrollStep = Math.floor(ScrollStep / 1.06);
				if (ScrollStep<3) { ScrollStep=3; }
				if (TotalScroll+ScrollStep>347) { ScrollStep=1;	}
				TotalScroll = TotalScroll+ScrollStep;
				IconsXPos =IconsXPos+ScrollStep;

				$('#IconScrollArea').scrollLeft(IconsXPos);
				
				t=setTimeout("ScrollIcons()",30);
			} else
			{
				DoScrollRight=1;
			}

			if (IconsXPos>=maxScroll)
			{
				$('#ScrollRightButton').removeClass("scrollingHotSpotRightVisible");
			}

		}

	}


function LoadFolderPage(FolderPageNumber)
{
	$("#IconList").fadeOut('fast',function() {
		$("#IconList").empty();
		$("#library_name").html("");

		FolderCount=IconFolders.length;
		oneRowIcons = 10;

		if (FolderCount%2>0)
		{
			$("#IconList").css({"width":(Math.floor(((FolderCount+1)*58)/2) )});
		} else
		{
			$("#IconList").css({"width":(Math.floor((FolderCount*58)/2) )});
		}

		IconsXPos = 0;

		for (var i=0; i<FolderCount; i++) { 
			var IconCount=Icons[i].length;
			var RandomIcon = Math.floor(Math.random()*(IconCount));
			RandomIcon=0;

			$("#IconList").append('<div id="folder_'+i+'"  class="TagIconSelectDiv" onClick="IconPageNumber=1; LoadIconFolder('+i+',IconPageNumber);"><center><img src="/slir/w48-c1.1/audio-icons/'+IconFolders[i]+Icons[i][RandomIcon]+'" class="TagIcon"></center></div>'); 

		}
		oneRowIcons = i+4;

//		$('#ScrollRightButton').addClass("scrollingHotSpotRightVisible");
//		$('#ScrollLeftButton').addClass("scrollingHotSpotLeftVisible");

		$("#IconList").fadeIn('slow',function() { } );
	});
}

function LoadIconFolder(FolderID,IconPageNumber) {
	$("#IconList").fadeOut('fast',function() {
		$("#IconList").empty();
		FolderFriendlyName = IconFolders[FolderID].split("-");
		FolderFriendlyName = FolderFriendlyName[1].replace("_"," ");
		$("#library_name").html("&nbsp;-&nbsp;"+FolderFriendlyName.replace("/",""));

		FolderCount=Icons[FolderID].length;
		if (FolderCount%2>0)
		{
			$("#IconList").css({"width":(Math.floor(((FolderCount+1)*58)/2) )});
		} else
		{
			$("#IconList").css({"width":(Math.floor((FolderCount*58)/2) )});
		}
		IconsXPos = 0;

		for (var i=0; i<FolderCount; i++) { 
			iconName = IconFolders[FolderID]+Icons[FolderID][i];
			$("#IconList").append('<div onClick="AddIcon('+FolderID+','+i+');" id="Icon_'+FolderID+'_'+i+'" class="TagIconSelectDiv"><center><div id="DogEar_'+FolderID+'_'+i+'" class="icon-dogear"></div><img src="/slir/w48-c1.1/audio-icons/'+iconName+'" class="TagIcon"></center></div>'); 

			if ( $.inArray(iconName,ElooiTagIcons)!=-1)	{
				$("#DogEar_"+FolderID+'_'+i).addClass("favorited");
			}

		}
		
//		$('#ScrollRightButton').addClass("scrollingHotSpotRightVisible");
//		$('#ScrollLeftButton').addClass("scrollingHotSpotLeftVisible");
		$("#IconList").fadeIn('fast',function() { } );
	});
}

function AddIcon(FolderID,IconID)
{	
	if (ElooiTagIcons.length==0) { $("#NoIconsSelected").remove(); }
	iconName = IconFolders[FolderID]+Icons[FolderID][IconID];
	if ( $.inArray(iconName,ElooiTagIcons)!=-1)
	{
		$("#tagicon_"+FolderID+'_'+IconID).animate({"width":"0px"},"fast", function() { $(this).remove(); } );
		//$("#tagicon_"+FolderID+'_'+IconID).fadeOut(300, function() { $(this).remove(); } );
		$("#DogEar_"+FolderID+'_'+IconID).removeClass("favorited");
		ElooiTagIcons = $.grep(ElooiTagIcons, function(value) { return value != iconName; });
	
		if (ElooiTagIcons.length==0) { $("#IconTagList").append("<img src=\"/site-addelooi-fake-container.jpg\" style=\"position:absolute; left:6px; top:6px; width:492px; height:48px;\" id=\"NoIconsSelected\">"); }

	} else
	{
		if (ElooiTagIcons.length<9)
		{
			ElooiTagIcons.push(iconName);
			$("#IconTagList").append($('<div id="tagicon_'+FolderID+'_'+IconID+'" style="position:relative; float:left"><img src="/slir/w48-c1.1/audio-icons/'+iconName+'" class="TagIconSelected" onClick="DeleteIcon('+FolderID+','+IconID+')"></div>').hide().fadeIn(500)); 
			$("#DogEar_"+FolderID+'_'+IconID).addClass("favorited");
		}
	}
}

function DeleteIcon(FolderID,IconID)
{
	iconName = IconFolders[FolderID]+Icons[FolderID][IconID];
	if ( $.inArray(iconName,ElooiTagIcons)!=-1)
	{
		$("#tagicon_"+FolderID+'_'+IconID).animate({"width":"0px"},"fast", function() { $(this).remove(); } );
		$("#DogEar_"+FolderID+'_'+IconID).removeClass("favorited");
		ElooiTagIcons = $.grep(ElooiTagIcons, function(value) { return value != iconName; });
	}

	if (ElooiTagIcons.length==0) { $("#IconTagList").append("<img src=\"/site-addelooi-fake-container.jpg\" style=\"position:absolute; left:6px; top:6px; width:492px; height:48px; \" id=\"NoIconsSelected\">"); }
}

</script>


<div style="position:absolute; right:10px; width:110px; height:90px; padding:5px;" id="process-sound" name="process-sound"></div>

<?php
if ($_GET["xtype"]=="mic") {
?>

<div id="flashContentParent">
<div id="flashContent" style="width:320px; height:140px; border-style: solid; border-width:1px; border-color:black; margin-top:3px;">
	<a href="http://www.adobe.com/go/getflash">
		<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
	</a>
	<p>This page requires Flash Player version 10.0.22 or higher.</p>
</div>
</div>

<?php
} else
if ($_GET["xtype"]=="file") {
?>
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
<?php 
} 
?>
<div style="height:10px"></div>
<form id="signup_form" style="width:400px" method=post action="" autocomplete = "off" onsubmit="javascript:return false;">
<input type="hidden" id="TagsField" name="TagsField" value="" disabled="true">
<input type="hidden" id="myLocation" name="myLocation" value="<?php echo $_SESSION['Elooi_Location']; ?>" disabled="true">
<input type="hidden" id="mp3_file" name="mp3_file" value="">
<input type="hidden" id="ReplyToID" name="ReplyToID" value="<?php 
if ( ($_GET["replyto"]!="") && (intval($_GET["replyto"])>0) ) { 
	$replycmd = "SELECT ID,ResponseToElooiID FROM Eloois WHERE ID=".$_GET["replyto"];
	$replyres = mysql_query($replycmd);
	if (mysql_result($replyres,0,"ResponseToElooiID")!="0") { echo mysql_result($replyres,0,"ResponseToElooiID"); } else { echo $_GET["replyto"]; }
} 
else {echo "0"; } ?>">

<div style="position:relative; width:486px">
<div id="IconTagList" class="SelectedIconsBox" style="width:500px; height:52px; margin-bottom:10px;"><img src="/site-addelooi-fake-container.jpg" style="position:absolute; left:6px; top:6px; width:492px; height:48px;" id="NoIconsSelected"></div>
<div id="IconFolders" style="width:464px; height:20px; margin-bottom:0px;"><a href="" onClick="FolderPageNumber=1; LoadFolderPage(FolderPageNumber); return false;">Image Sets</a><div id="library_name" style="display:inline-block"></div></div>

<div id="IconArea" style="width:500px; margin:0px; height:110px; position: relative; overflow:hidden; border:0px solid;">
<div id="ScrollLeftButton" class="scrollingHotSpotLeft" onClick="SetScrollLeft(2)" onMouseOver="SetScrollLeft(1)" onMouseOut="SetScrollLeft(0)"></div>
<div id="ScrollRightButton" class="scrollingHotSpotRight" onClick="SetScrollRight(2);"  onMouseOver="SetScrollRight(1);"  onMouseOut="SetScrollRight(0);"></div>
<div id="IconScrollArea" style="left:20px; width:464px; height:110px; position: relative; overflow:hidden">
<div id="IconList"></div>
</div>
</div>
<!--
<div style="position:absolute; top:10px; right:60px;">
	<span class="settingTip" style="margin-left:5px" title="<?php echo $newelooi_dont_forget_tags; ?>">?</span>
</div>
-->

</div>

</form>

<div style="clear: both;"></div>

<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%; height:33px;">

	<div id="container-location">
	  <div id="topnav-location" class="topnav-location"><a href="#" class="location-menu"><span id="location-str"><?php echo $newelooi_Location; ?>: <?php echo $_SESSION['Elooi_Location']; ?></span></a> </div>
	</div>

	<div style="float:right; margin-right:25px;">
	<input class="submitbutton" value="<?php echo $newelooi_add_elooi; ?>" type="button" onClick="ProcessElooiSubmit();">
	</div>
</div>