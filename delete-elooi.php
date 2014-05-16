<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php include("/check-user-login.php"); ?>

<script type="text/javascript">
function DeleteElooi() { 
		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Procsessing_2; ?></center>");

		$.get("/elooi-delete.php", { ElooiID: <?php echo $_GET["rowname"]; ?> },
		function(data){
			parent.jQuery("#process-sound").html("");
			$.colorbox({href:"/elooi-deleted.php"});
		});

}

function CancelDeleteElooi() { $.colorbox.close(); }

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

<span class="settings-subheader" style="width:300px"><?php echo $delete_elooi_Question; ?></span>

<div style="clear: both;"></div>

<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%;">

	<div style="margin:0 auto; width:100%; ">
	<input class="submitbutton" value="<?php echo $me_yes_button; ?>" type="button" onClick="DeleteElooi();">
	&nbsp;
	<input class="submitbutton" value="<?php echo $me_cancel_button; ?>" type="button" onClick="CancelDeleteElooi();">
	</div>
</div>