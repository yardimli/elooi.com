<?php require_once("/server-settings.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/elooi-translation.php'); ?>

<style type="text/css">

.tipsy-inner { padding: 5px 8px 4px 8px; background-color: black; color: white; max-width: 250px; text-align: left;  
    font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif;
    font-size: 13px;}

	.ui-autocomplete-loading { background: white url('/css/images/ui-anim_basic_16x16.gif') right center no-repeat; }
	#city { width: 25em; }
</style>


<script type="text/javascript">
	var TagDivCounter = 0;
	var TagArray = new Array();
	var TagArrayCounter = 0;
	var AddTag=0;
	var rowname = <?php echo $_GET["rowname"]; ?>;
	var EchoElooiID = <?php 
	if ( ($_GET["EchoElooiID"]!="") && (intval($_GET["EchoElooiID"])>0) ) { $EchoElooiID = $_GET["EchoElooiID"]; } else { $EchoElooiID = "0"; }
	//check if elooi is original or already an echo

	$elooi_res = mysql_query("SELECT * FROM eloois WHERE ID=".$EchoElooiID);
	$elooi_rows = mysql_num_rows($elooi_res);
	if ($elooi_rows>=1) {
		if (mysql_result($elooi_res,0,"EchoElooiID")>0) { echo mysql_result($elooi_res,0,"EchoElooiID"); } else
			{ echo $EchoElooiID; }
	} else
	{ 
		//problem orignial elooiID not found!
		echo "0";
	}
	?>;

	function ProcessElooiEcho() {
		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Saving; ?></center>");

		if (jQuery("#mytags").val()!="") { AddATag(jQuery("#mytags").val());	}

		var submit_tags = TagArray.toString();
		var arLen=TagArray.length;

		if (arLen==0)
		{
			alert("<?php echo $newelooi_add_tags; ?>");
			jQuery("#process-sound").html("");
		} else
		{
			//no errors save
			$.post( "/save-echo.php", { s_tags:submit_tags,s_EchoElooiID:EchoElooiID },
			function( data ) {
				$( "#process-sound" ).html(data);
				/*
				if (jQuery("#dogear_"+rowname).hasClass("favorited")) {
					jQuery("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited").addClass("reechoed-favorited");
				} else {
					jQuery("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited").addClass("reechoed");
				}
				*/
				jQuery("#echo_"+rowname).removeClass("echo-action").addClass("unecho-action");
				jQuery("#echo_"+rowname+" b").text("<?php echo $me_remove_echo; ?>");
			});
		}
	}

	function RemoveTag(TagDivID,TagToRemove)
	{
		jQuery("#tag"+TagDivID).remove();
		var arLen=TagArray.length;
		for (var i=0; i<arLen; i++) { if (TagArray[i]==TagToRemove) { TagArray.splice(i,1); break; } }
		$( "#mytags" ).focus();

		if (TagArray.length==0) { jQuery("#AllMyTags").html('<div style="margin-top:15px; line-height:1.4em;"><?php echo str_replace("'","\'",$newelooi_dont_forget_tags); ?></div>'); }

	}

	function AddATag(TagToAdd)
	{
		TagToAdd = trim(TagToAdd);
		TagToAdd = TagToAdd.replace(/ /gi,"_");
		TagToAdd = TagToAdd.replace(/,/gi,"_");
		AddTag = 0;

		if (TagToAdd.length<=1)
		{
		} else
		{
			var arLen=TagArray.length;
			if (arLen==0) { jQuery("#AllMyTags").html(''); }
			if (TagToAdd.length>20) { TagToAdd = TagToAdd.substring(0,20);	}
			if (trim(TagToAdd)=="") { /* do noting */ } else
			if (arLen==0) { AddTag = 1; }
			if (arLen<7)  { AddTag = 1; }
			if (arLen>=7) { alert("<?php echo $newelooi_max_tags; ?>"); }

			if (AddTag==1) {
				for (var i=0; i<arLen; i++) { if (TagArray[i]==TagToAdd) { AddTag=0; break; } }
			}

			if (AddTag==1)
			{
				TagArray.push(TagToAdd);
				TagDivCounter++;

				jQuery("#AllMyTags").append("<div class=\"tag-box\" id=\"tag"+TagDivCounter+"\">"+trim(TagToAdd)+"<span class=\"ui-icon ui-icon-close\" style=\"cursor:pointer; position:absolute; right:2px; top:-8px;\" onClick=\"javascript: RemoveTag('"+TagDivCounter+"','"+trim(addslashes(TagToAdd))+"'); \"></span></div>");
			}
		}
	}

	function configureAutocomplete() {

	$( "#mytags" ).autocomplete({
					delay: 600,
					autoFocus:true,
					minLength:2,
					source: function( request, response ) {
			//			console.log("begin search");
						$.ajax({
							url: "/search-tags.php", 
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
					focus: function() {
						// prevent value inserted on focus
	//					return false;
					},
					select: function( event, ui ) {
					  AddATag(ui.item.value);
					  this.value ="";
					  return false;

					  //this.autocomplete('close');
					},
					open: function() {
						$(this).data('is_open',true);
					},
					close: function() {
						$(this).data('is_open',false);
	//					console.log("clos");
					}
				});
	}


	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
		  	  if (jQuery("#mytags").val()!="") { AddATag(jQuery("#mytags").val()); jQuery("#mytags").val('');	}
			  event.preventDefault();
			  return false;
			}
		  });

		jQuery('.settingTip').tipsy({trigger: 'hover', fade:true, html:true, gravity: 's'});
		jQuery("#signup_form label").inFieldLabels();
		jQuery('#signup_form [title]').tipsy({trigger: 'focus', fade:true, offsetWidth:200, html:true, gravity: 'w'});


		$( "#mytags" )
			.bind( "keydown", function( event ) {
							if ( (event.keyCode==188) || (event.keyCode==186) || (event.keyCode==32)  ) {
								AddATag(this.value);
								$( "#mytags" ).removeClass( "ui-autocomplete-loading" ); 
								$(this).autocomplete("destroy");
								configureAutocomplete();
								this.value = "";
								return false;
							}
							if (event.keyCode==27)
							{
								if($(this).data('is_open') === true)
								{
									return false;
								}
							}
						});
		configureAutocomplete();
		var t=setTimeout("jQuery('#mytags').focus();",500);

	});
</script>


<!-- This contains the hidden content for inline calls -->

<div style="position:absolute; left:0px; top:157px; width:110px; height:90px; padding:5px; z-index:999;" id="process-sound" name="process-sound"></div>

<div style="height:10px"></div>
<form id="signup_form" style="width:400px" method=post action="" autocomplete = "off" onsubmit="javascript:return false;">
<input type="hidden" id="TagsField" name="TagsField" value="" disabled="true">

<div style="position:relative; width:400px">

<div style="position:absolute; top:10px; right:0px;">
	<span class="settingTip" style="margin-left:5px" title="<?php echo $newelooi_dont_forget_tags; ?>">?</span>
</div>

<span>
<label for="mytags"><?php echo $newelooi_tags; ?></label>
<input type="text" name="mytags" value="" id="mytags" class="signup-name-nobackground" style="width:365px; margin-left:0px;">
</span>

<div style="margin-top:10px; margin-bottom:5px; height:60px; width:380px;" id="AllMyTags">
<div style="margin-top:5px; line-height:1.4em;"><?php echo $newelooi_dont_forget_tags; ?></div>
</div>



</div>

</form>

<div style="clear: both;"></div>

<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%; height:30px;">

	<div style="float:right; margin-right:25px;">
	<input class="submitbutton" value="<?php echo $echo_save; ?>" type="button" onClick="ProcessElooiEcho();">
	</div>
</div>