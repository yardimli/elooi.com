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

		$.post( "/save-echo.php", { s_EchoElooiID:EchoElooiID },
		function( data ) {
				$( "#process-sound" ).html(data);
				jQuery("#echo_"+rowname).removeClass("echo-action").addClass("unecho-action");
				jQuery("#echo_"+rowname+" b").text("<?php echo $me_remove_echo; ?>");
			}
		);
	}


	$(document).ready(function() {
		jQuery('.settingTip').tipsy({trigger: 'hover', fade:true, html:true, gravity: 's'});
		jQuery("#signup_form label").inFieldLabels();
		jQuery('#signup_form [title]').tipsy({trigger: 'focus', fade:true, offsetWidth:200, html:true, gravity: 'w'});
	});
</script>


<!-- This contains the hidden content for inline calls -->

<div style="position:absolute; left:0px; top:127px; width:110px; height:90px; padding:5px; z-index:999;" id="process-sound" name="process-sound"></div>

<div style="height:10px"></div>
<form id="signup_form" style="width:400px" method=post action="" autocomplete = "off" onsubmit="javascript:return false;">

<div style="position:relative; width:400px">

<div style="margin-top:5px; line-height:1.4em;"><?php echo $simple_echo; ?></div>
</div>



</div>

</form>

<div style="clear: both;"></div>

<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%; height:30px;">

	<div style="float:right; margin-right:25px;">
	<input class="submitbutton" value="<?php echo $echo_save; ?>" type="button" onClick="ProcessElooiEcho();">
	</div>
</div>