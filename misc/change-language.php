<?php require_once("/server-settings.php"); ?>
<?php include("/php-functions.php"); ?>
<?php require_once('/elooi-translation.php'); ?>

<script type="text/javascript">

function ChangeILanguage() { 
		//window.location = "http://"+jQuery("#ILanguageID").val()+".elooi.com";
		window.location = "http://elooi.com";
		/*
		jQuery("#process-sound").html("<center><img src=\"/ajax-loader.gif\"><br><?php echo $newelooi_Procsessing_2; ?></center>");
		var submit_ILanguageID = jQuery("#ILanguageID").val();
		$.get("/ChangeIlanguage.php", { ILanguageID_: submit_ILanguageID },
		function(data){
			window.location.reload(); 
//			parent.jQuery("#process-sound").html("");
		});
		*/
}

function CancelChangeILanguage() { $.colorbox.close(); }

</script>

<style type="text/css">

	.tipsy-inner { padding: 5px 8px 4px 8px; background-color: black; color: white; max-width: 250px; text-align: left;  
    font-family: Helvetica Neue,Arial,Helvetica,'Liberation Sans',FreeSans,sans-serif;
    font-size: 13px;}

	.ui-autocomplete-loading { background: white url('/css/images/ui-anim_basic_16x16.gif') right center no-repeat; }
	#city { width: 25em; }
</style>

<div style="position:absolute; right:20px; top:96px; width:110px; height:90px; padding:5px; z-index:999;" id="process-sound" name="process-sound"></div>

<div style="height:10px"></div>

<span class="settings-subheader" style="width:300px"><?php echo $Elooi_Interface_Langauge_Question; ?></span>

<div style="clear: both; height:8px;"></div>


<select id="ILanguageID" name="ILanguageID" class="signup-name-dropdown"  style="width:316px" title="<?php echo $me_Language_hint; ?>">
<?php
$mysqlresult = mysql_query("SELECT * FROM Languages ORDER BY ID ASC");
$num_rows = mysql_num_rows($mysqlresult);
$i = 0;
WHILE ($i<$num_rows) {
?>					<OPTION VALUE="<?php echo StrToLower(mysql_result($mysqlresult,$i,"LanguageShortText")); ?>" <?php
		
					if (mysql_result($mysqlresult,$i,"ID")==$_SESSION['Elooi_ILanguageID']) { echo " SELECTED "; }
					?>><?php echo mysql_result($mysqlresult,$i,"LanguageName") ." (". mysql_result($mysqlresult,$i,"LanguageShortText") .")" ; ?></option>
<?php
	$i++;
} ?>
	</select>
</div>


<div class="actions-div" id="save" style="bottom:0; position: absolute; width:100%;">

	<div style="margin:0 auto; width:100%; ">
	<input class="submitbutton" value="<?php echo $me_apply_button; ?>" type="button" onClick="ChangeILanguage();">
	&nbsp;
	<input class="submitbutton" value="<?php echo $me_cancel_button; ?>" type="button" onClick="CancelChangeILanguage();">
	</div>
</div>

<script type="text/javascript">
	 $('#ILanguageID').tipsy({trigger: 'focus', width:'400px', fade:false, gravity: 'w'});

</script>