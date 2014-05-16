<?php $page="signin"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/mini-page-header.php"); ?>
<?php include("/check-user-login.php"); ?>

<body>
<div id="narrow_page">
	<a href="/index.php"><img src="/cloudofvoice_screen_logo_tr_nobg.png" style="height:46px; margin-left:0px; margin-top:8px; margin-bottom:5px; border:0px;"></a>

    <div class="slimdes">
		<div class="banner">
			<h2><?php echo $Send_Verify_Email_Title; ?></h2>
		</div>
		<div class="content-main" style="line-height:140%">
		<?php
		SendEmailVerification($_SESSION['Elooi_Email'],$_SESSION['Elooi_FullName'],"",$_SESSION['Elooi_UserID']);
		?>
<?php echo $Send_Verify_Email_Send_Text; ?>


<script type='text/javascript'>
$("#signup_form label").inFieldLabels();
$('#signup_form [title]').tipsy({trigger: 'focus', fade:true, gravity: 'w'});
</script>


<!-- FOTTER -->
		
			</div>	
		</div>
		
	</div>
 </div>
<div id="lb"></div>

</body>
</html>