<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php include("/check-user-login.php"); ?>

<script type="text/javascript">

var rowname = <?php echo $_GET["rowname"]; ?>;
var EchoElooiID = <?php 
if ( ($_GET["EchoElooiID"]!="") && (intval($_GET["EchoElooiID"])>0) ) { $EchoElooiID = $_GET["EchoElooiID"]; } else { $EchoElooiID = "0"; }
echo $EchoElooiID;
?>;

function DeleteEchoElooi() { 
		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Procsessing_2; ?></center>");

		$.get("/echo-delete.php", { ElooiID: EchoElooiID },
		function(data){
			/*
			if (jQuery("#dogear_"+rowname).hasClass("reechoed-favorited")) {
				jQuery("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited").addClass("favorited");
			} else {
				jQuery("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited");
			}
			*/
			jQuery("#echo_"+rowname).removeClass("unecho-action").addClass("echo-action");
			jQuery("#echo_"+rowname+" b").text("<?php echo $me_add_echo; ?>");

			parent.jQuery("#process-sound").html("");
			$.colorbox({href:"/echo-deleted.php"});
		});
}

function CancelDeleteEchoElooi() { $.colorbox.close(); }

</script>

<style type="text/css">

.tipsy-inner { padding: 5px 8px 4px 8px; background-color: black; color: white; max-width: 250px; text-align: left;  
    font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif;
    font-size: 13px;}

	.ui-autocomplete-loading { background: white url('/css/images/ui-anim_basic_16x16.gif') right center no-repeat; }
	#city { width: 25em; }
</style>

<div style="position:absolute; right:20px; top:20px; width:110px; height:90px; padding:5px; z-index:999;" id="process-sound" name="process-sound"></div>

<div style="height:10px"></div>

<span class="settings-subheader" style="width:300px"><?php echo $echo_delete_Question; ?></span>

<div style="clear: both;"></div>

<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%;">

	<div style="margin:0 auto; width:100%; ">
	<input class="submitbutton" value="<?php echo $me_yes_button; ?>" type="button" onClick="DeleteEchoElooi();">
	&nbsp;
	<input class="submitbutton" value="<?php echo $me_cancel_button; ?>" type="button" onClick="CancelDeleteEchoElooi();">
	</div>
</div>