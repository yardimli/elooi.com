<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php include("/check-user-login.php"); ?>

<style type="text/css">

.tipsy-inner { padding: 5px 8px 4px 8px; background-color: black; color: white; max-width: 250px; text-align: left;  
    font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif;
    font-size: 13px;}
</style>


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

	var RetagElooiID = <?php 
	if ( ($_GET["RetagElooiID"]!="") && (intval($_GET["RetagElooiID"])>0) ) { $ReTagElooiID= $_GET["RetagElooiID"]; } else { $ReTagElooiID = "0"; }
	echo $ReTagElooiID;
	?>;

	function ProcessRetagElooi() {
		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Saving; ?></center>");

		var submit_tags = ElooiTagIcons.toString();
		var arLen=ElooiTagIcons.length;

		if (arLen==0)
		{
			alert("<?php echo $newelooi_add_tags; ?>");
			jQuery("#process-sound").html("");
		} else
		{
			//no errors save
			$.post( "/save-retag.php", { s_RetagElooiID:RetagElooiID,  s_Type:"retag_elooi", s_tags:submit_tags },
			function( data ) {
				$( "#process-sound" ).html(data);
			});
		}
	}


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

function AddIconFileName(iconName)
{	
	if (ElooiTagIcons.length<9)
	{
		ElooiTagIcons.push(iconName);
		$("#IconTagList").append($('<div id="tagicon_'+FolderID+'_'+IconID+'" style="position:relative; float:left"><img src="/slir/w48-c1.1/audio-icons/'+iconName+'" class="TagIconSelected" onClick="DeleteIcon('+FolderID+','+IconID+')"></div>').hide().fadeIn(500)); 
		//$("#DogEar_"+FolderID+'_'+IconID).addClass("favorited");
	}
}


function AddIcon(FolderID,IconID)
{	
	if (ElooiTagIcons.length==0) { $("#NoIconsSelected").remove(); }

	iconName = IconFolders[FolderID]+Icons[FolderID][IconID];
	if ( $.inArray(iconName,ElooiTagIcons)!=-1)
	{
		$("#tagicon_"+FolderID+'_'+IconID).animate({"width":"0px"},"fast", function() { $(this).remove(); } );
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


	$(document).ready(function() {

		FolderPageNumber=1;
		LoadFolderPage(FolderPageNumber);

		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		});

		jQuery('.settingTip').tipsy({trigger: 'hover', fade:true, html:true, gravity: 's'});
		jQuery("#signup_form label").inFieldLabels();
		jQuery('#signup_form [title]').tipsy({trigger: 'focus', fade:true, offsetWidth:200, html:true, gravity: 'w'});


		<?php
			$xsqlCommand_tags = "select alltags.tag from tagcloud left join alltags on alltags.ID=tagcloud.TagID where elooiID = ".$ReTagElooiID." AND ResponseTag=0 and (alltags.tag<>'')";
			$mysqlresult_tags = mysql_query($xsqlCommand_tags);
			$num_rows_tags = mysql_num_rows($mysqlresult_tags);
			$i_tags = 0;
			while ($i_tags<$num_rows_tags)
			{
			?>
				tempIconName='<?php echo AddSlashes(mysql_result($mysqlresult_tags,$i_tags,"alltags.tag")); ?>';
				//console.log("==="+tempIconName);
				tempIconData = tempIconName.split("/");
				//console.log(tempIconData[0]+"/");
				//console.log(tempIconData[1]);

				xFolderID= $.inArray(tempIconData[0]+"/",IconFolders);
				if (xFolderID!=-1)
				{
					xIconID= $.inArray(tempIconData[1],Icons[xFolderID]);
					if (xIconID!=-1)
					{
						AddIcon(xFolderID,xIconID);
					}
				}
				<?php 
				$i_tags++;
			} ?>
	});
</script>


<div style="position:absolute; left:0px; top:257px; width:110px; height:70px; padding:5px; z-index:999;" id="process-sound" name="process-sound"></div>
<!--
<div style="position:absolute; top:10px; right:0px;">
	<span class="settingTip" style="margin-left:5px" title="<?php echo $newelooi_dont_forget_tags; ?>">?</span>
</div>
-->
<div style="height:25px"></div>
<form id="signup_form" method=post action="" autocomplete = "off" onsubmit="javascript:return false;">
<input type="hidden" id="TagsField" name="TagsField" value="" disabled="true">

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
</div>

</form>

<div style="clear: both;"></div>

<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%; height:33px;">
	<div style="float:right; margin-right:25px;">
	<input class="submitbutton" value="<?php echo $retag_save; ?>" type="button" onClick="ProcessRetagElooi();">
	</div>
</div>