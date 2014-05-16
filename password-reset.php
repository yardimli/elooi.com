<?php $page="password-reset"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/mini-page-header.php"); ?>
<?php

$Email      = "";

$HasError = 0;

if ($_POST["op"]=="reset") {
	$Email      = $_POST["Email"];
}


if ($_POST["op"]=="reset") {
	if ($Email=="") { $Email_Error = $signup_Email_Error; $HasError = 1; } else
 	if (verify_Email($Email)) {} else { $Email_Error = $signup_Email_Error2; $HasError = 1; }


	if ($HasError==0) {
		$Email_      = "'".AddSlashes(Trim($Email))."'";

		$xsqlCommand = "SELECT * FROM users WHERE Email=".$Email_;
//		echo $xsqlCommand;

		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==1)
		{
			$PasswordReset = md5(mysql_result($mysqlresult,0,"ID").time().$randomword);
			$xsqlCommand2 = "UPDATE users set PasswordReset='". $PasswordReset ."' WHERE ID=".mysql_result($mysqlresult,0,"ID");
	//		echo $xsqlCommand2;
			$mysqlresult2 = mysql_query($xsqlCommand2);

//			$pop = new POP3();
//			$pop->Authorise('posta.izlenim.com', 110, 30, 'reset@elooi.com', 'A123456b', 1);

			$mail = new PHPMailer();
			
			if (($_SESSION['Elooi_ILanguageID']=="1") or ($_SESSION['Elooi_ILanguageID']=="") or ($_SESSION['Elooi_ILanguageID']=="0"))	{
				$body             = file_get_contents('password-reset-tr.html');
				$TheSubject = "Elooi Şifre Sıfırlama";
			} 
			else if ($_SESSION['Elooi_ILanguageID']=="2") {
				$body             = file_get_contents('password-reset-en.html');
				$TheSubject = "Elooi Password Reset Request";
			}
			else if ($_SESSION['Elooi_ILanguageID']=="3") {
				$body             = file_get_contents('password-reset-tw.html');
				$TheSubject = "Elooi Password Reset Request";
			}
			else if ($_SESSION['Elooi_ILanguageID']=="4") {
				$body             = file_get_contents('password-reset-no.html');
				$TheSubject = "Elooi Password Reset Request";
			}

			$body             = eregi_replace("[\]",'',$body);
			$body             = str_replace("***URL1***","http://".$server_domain."/password-reset-3.php?q=".$PasswordReset,$body);
			$body             = str_replace("***URL2***","http://".$server_domain."/password-reset-3.php?q=".$PasswordReset,$body);
//			echo $body;
//			exit();

			$mail->IsSMTP();
			$mail->SMTPDebug = 1;
//			$mail->Host     = 'posta.izlenim.com';
			$mail->Host     = 'p3smtpout.secureserver.net'; //posta.izlenim.com
	
			$mail->SetFrom('reset@elooi.com', 'Elooi');
			$mail->AddReplyTo("do-not-reply@elooi.com","Elooi");
			$mail->Subject    = '=?UTF-8?B?'.base64_encode($TheSubject)."?=";
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

			$mail->MsgHTML($body);

			$address = mysql_result($mysqlresult,0,"Email");
			$mail->AddAddress($address, mysql_result($mysqlresult,0,"FirstName"));

			//$mail->AddAttachment("images/phpmailer.gif");      // attachment
			//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment


			if(!$mail->Send()) 
			{
				$HasError = 1;
				$Email_Error=$Password_Reset_Email_Form_Error1 . $mail->ErrorInfo .$Password_Reset_Email_Form_Try_Again;
			} else 
			{
				header( "Location: http://".$server_domain."/password-reset-2.php" ) ;
				exit();
			}

			//send email

		} else
		{
			$HasError = 1;
			$Email_Error=$Password_Reset_Email_Form_Error2;
		}
	}
}

?>

<body>
<div id="narrow_page">
	<a href="/index.php"><img src="<?php
		if ($page_subdomain=="tr") { echo "/cloudofvoice_screen_logo-nobg-tr.jpg"; } else
		if ($page_subdomain=="tw") { echo "/cloudofvoice_screen_logo-nobg-tw.jpg"; } else
		if ($page_subdomain=="no") { echo "/cloudofvoice_screen_logo-nobg-no.jpg"; } else
		if ($page_subdomain=="en") { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } else
								   { echo "/cloudofvoice_screen_logo-nobg-en.jpg"; } ?>" style="height:46px; width:250px; margin-top:8px; margin-left:0px; margin-bottom:5px; border:0px;"></a>

    <div class="slimdes">
		<div class="banner">
			<h2><?php echo $Password_Reset_Email_Form_Title; ?></h2>
		</div>
		<div class="content-main">


<?php if ($Email_Error!="") {?>
<div class="errorbox" style="width:400px; align:center; margin:0 auto; margin-top:5px; margin-bottom:25px;"><?php echo $Email_Error; ?></div>
<?php }?>

<?php echo $Password_Reset_Email_Form_Email_Txt; ?><br>
<form id="signup_form" method=post action="/password/reset" autocomplete = "off">
<input type="hidden" name="op" value="reset">
<div style="height:10px"></div>
<span>
  <label for="Email"><?php echo $Common_header_email; ?></label>
  <input type="text" name="Email" value="<?php echo $Email; ?>" id="Email" class="signup-name" title="<?php echo $Password_Reset_Email_Form_Tip; ?>"  style="width:400px">
</span>
<div style="margin-top:5px; margin-bottom:15px;"></div>
<div style="height:10px"></div>

<input type="submit" name="join_button" value="<?php echo $Submit_Button_Txt; ?>" class="submitbutton" />
</form>
<br>


<br><br>

<script type='text/javascript'>
$('#signup_form [title]').tipsy({trigger: 'focus', fade:true, gravity: 'w'});
$("#signup_form label").inFieldLabels();
</script>


<!-- FOTTER -->
		
			</div>	
		</div>
		
	</div>
 </div>
<div id="lb"></div>

</body>
</html>