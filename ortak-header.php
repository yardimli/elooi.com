<?php require_once("/server-settings.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php require_once('/php-functions.php'); ?>
<?php
if (($_COOKIE["remember_me"]=="true") && ($_COOKIE["userID"]!="") && ($_SESSION['Elooi_User']!=true))
{
		$xsqlCommand = "SELECT * FROM users WHERE UserID_MD5='" . AddSlashes(Trim($_COOKIE["userID"])) . "'";
//		echo $xsqlCommand;

		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==1)
		{
			$_SESSION['Elooi_User'] = true;
			$_SESSION['Elooi_UserID'] = mysql_result($mysqlresult,0,"ID");
			$_SESSION['Elooi_UserName'] = mysql_result($mysqlresult,0,"Username");
			$_SESSION['Elooi_FullName'] = mysql_result($mysqlresult,0,"FirstName");
			$_SESSION['Elooi_Picture'] = mysql_result($mysqlresult,0,"Picture");
			$_SESSION['Elooi_Location']   = mysql_result($mysqlresult,0,"Location");
			$_SESSION['Elooi_Email']   = mysql_result($mysqlresult,0,"Email");

			header( "Location: http://".$server_domain."/settings/profile" ) ;
			exit();
		} else
		{ //something went wrong delete cookie from host
			setcookie("userID", "", time()-(3600*24));
			setcookie("remember_me", "", time()-(3600*24));
		}
}
?><!DOCTYPE html>
<html lang="en" id="elooicomcom">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="en-us">
<meta name="title" content="Elooi - Cloud of Voice">
<meta name="description" content="Elooi is a new mico-blogging platform based on 60-second voice clips. Record or upload and share your voice or audio files easily. You can also share your Eloois, on twitter and facebook.">
<meta name="keywords" content="elooi, voice tweet, micro-blog, voice micro-blog, voice community, voice city, talk to share,sesli mesaj, ses, kayıt, mikrofon, twitter">
<meta name="robots" content="all">
<meta name="viewport" content="width=960">
<meta name="copyright" content="Copyright (c) 2011 Elo Robot Ltd.">
 <meta property="og:title" content="Elooi - Cloud of Voice"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://elooi.com/"/>
    <meta property="og:image" content="http://elooi.com/elooi-logo-75.png"/>
    <meta property="og:site_name" content="Elooi"/>
    <meta property="fb:admins" content="550737484"/>
    <meta property="fb:app_id" content="146170835459093"/>
    <meta property="og:description" content="Elooi is a new mico-blogging platform based on 60-second voice clips. 
	Record or upload and share your voice or audio files easily. 
	You can also share your Eloois, on twitter and facebook. "/>

<link rel="SHORTCUT ICON" href="http://<?php echo $server_domain; ?>/favicon.ico"> 

<meta name="viewport" content="user-scalable=yes, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

<title><?php echo $Common_header_title; ?></title>

<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<link href="/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script src="/js/jquery-1.10.2.js"></script>
<script src="/js/jquery-ui-1.10.4.js"></script> 

<script src="/js/jquery.infieldlabel.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/jquery.tipsy.js" type="text/javascript"></script>
<script src="/js/jquery.ps-color-picker.js" type="text/javascript"></script>
<script src="/js/jquery.hoverIntent.minified.js" type="text/javascript"></script>

<script src="/js/js-functions.js" type="text/javascript"></script>


<link rel="stylesheet" href="/commentanything/css/main.css" type="text/css" media="screen" />
<script type="text/javascript" src="/commentanything/js/comment.js"></script>

<link href="/css/stiller.css" rel="stylesheet" type="text/css" />

<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<script type="text/javascript">
<?php

if ( ($_SESSION['Elooi_ILanguageID']!="") && (intval($_SESSION['Elooi_ILanguageID']) >0) )
{
	if ($_SESSION['Elooi_UserID']!="") {
	?>
	var UserID = "<?php echo $_SESSION['Elooi_UserID']; ?>";
	<?php
	} else
	{	?>
	var UserID = "0";
	<?php
	} 
} else
{	?>
var UserID = "0";
<?php
} 
?>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25502035-1']);
  _gaq.push(['_setDomainName', '.elooi.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>



<body>
<div style="width:100%;height:43px; z-index:4; top:0px; border:0px; solid #ccc; margin-bottom:8px; position: fixed; top:0; -webkit-box-shadow: 0px 1px 5px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.3);
box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.3); background-color: #fff;" id="navigator-bar">

<?php

if ($_SESSION['Elooi_User']==true)
{
?>
<?php require_once('/fb-connect-code.php'); ?>

<div style="position:absolute; top:0px; left:5px; margin: 6px 10px 0; padding: 0; font-family: Tahoma,arial,sans-serif; font-size: 10px; color: #211922;">
	<div href="/categories/" type="button" class="CategoryButton"><em></em></div>
</div>		
	
<div style="position:absolute; top:0px; left:41px; margin: 6px 10px 0; padding: 0; font-family: Tahoma,arial,sans-serif; font-size: 10px; color: #211922;">
			<form action="http://<?php echo $server_domain; ?>/search" class="MiniSearch">
            	<input type="text" value="" size="27" name="q" id="query" is_empty="yes" style="color: rgb(153, 153, 153); ">
            	<button id="query_button" type="submit"><img alt="Search" src="/images/search.gif"></button>
            </form>
</div>		
		
		<div style="position:absolute; left:900px; top:3px;">
			<div style="display:inline-block; width:31px; height:31px; border:1px solid black; -webkit-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75); border-radius:2px;
	-moz-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);
		box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75); background-color: #0a008f; margin-top:2px;"><div style="font-family: 'Montserrat', sans-serif; color:white; font-size:35px; margin-top:-9px; margin-left:5px; font-weight:bold; ">e</div></div>
			
			<div style="display:inline-block; width:170px; height:31px; margin-top:3px;"><div style="font-family: 'Montserrat', sans-serif; color:black; font-size:25px; margin-top:0px; margin-left:-2px; font-weight:bold; text-shadow: 1px 1px 1px rgba(150, 150, 150, 0.3);">looi</div></div>
		</div>
		
		<div style="position:absolute; right:300px; display:inline-block; margin-top:6px;"><span id="new-post-button" style="background: #ff2222;
text-decoration: none;
color: #fff;
cursor: default;
-moz-border-radius: 4px;
-webkit-border-radius: 4px; padding:10px; padding-top:7px; padding-bottom:3px; height:20px; display:block; cursor:pointer" title="">New Post</span></div>	
		
		<div style="position:absolute; left:300px; display:inline-block; margin-top:6px;"><a  class="header-submenu-nav-a <?php if ($page=="my-index") { ?>topnav-active<?php } ?>" href="http://<?php echo $server_domain; ?>/u/<?php echo $_SESSION['Elooi_UserName']; ?>" title=""><?php echo $Common_header_home; ?></a></div>	
		<div style="position:absolute; left:400px; display:inline-block; margin-top:6px;"><a class="header-submenu-nav-a <?php if (($page=="profile-page") && ($UserID==$_SESSION['Elooi_UserID']))  { ?>topnav-active<?php } ?>" href="http://<?php echo $server_domain; ?>/u/<?php echo $_SESSION['Elooi_UserName']; ?>/profil" title=""><?php echo $Common_header_profile; ?></a></div>
		<div style="position:absolute; left:500px; display:inline-block; margin-top:6px;"><a class="header-submenu-nav-a <?php if ($page=="all-new") { ?>topnav-active<?php } ?>" href="http://<?php echo $server_domain; ?>/yeniler" title=""><?php echo $Common_header_latest; ?></a></div>

		<div style="display:inline-block; margin-top:6px; float:right;" ><a id="add_elooi_link" class="header-submenu-nav-a mlink <?php if ($page=="my-elooi") { ?>topnav-active-orange<?php } ?>" onclick="void(0);" ><span><?php echo $Common_header_hi; ?> <?php echo $_SESSION['Elooi_UserName']; ?></span></a> 
		<ul> 
			<ul >
				<li><a class="header-submenu-nav-a" href="/settings/account"><?php echo $Common_header_settings; ?></a></li>
				<li><a class="header-submenu-nav-a" href="/help.php"><?php echo $Common_header_help; ?></a></li>
				<li><a class="header-submenu-nav-a" href="/signout.php"><?php echo $Common_header_signout; ?></a></li>
			</ul>
		</ul> 
		</div> 
	</ul> 
<?php
}
?>


<?php
if ($_SESSION['Elooi_User']!=true)
{
?>
<?php require_once('/fb-connect-code.php'); ?>
		

<div style="position:absolute; top:0px; left:5px; margin: 6px 10px 0; padding: 0; font-family: Tahoma,arial,sans-serif; font-size: 10px; color: #211922;">
	<div href="/categories/" type="button" class="CategoryButton"><em></em></div>
</div>		
	
<div style="position:absolute; top:0px; left:41px; margin: 6px 10px 0; padding: 0; font-family: Tahoma,arial,sans-serif; font-size: 10px; color: #211922;">
			<form action="http://<?php echo $server_domain; ?>/search" class="MiniSearch">
            	<input type="text" value="" size="27" name="q" id="query" is_empty="yes" style="color: rgb(153, 153, 153); ">
            	<button id="query_button" type="submit"><img alt="Search" src="/images/search.gif"></button>
            </form>
</div>		
		
		<div style="position:absolute; left:900px; top:3px;">
			<div style="display:inline-block; width:31px; height:31px; border:1px solid black; -webkit-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75); border-radius:2px;
	-moz-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);
		box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75); background-color: #0a008f; margin-top:2px;"><div style="font-family: 'Montserrat', sans-serif; color:white; font-size:35px; margin-top:-9px; margin-left:5px; font-weight:bold; ">e</div></div>
			
			<div style="display:inline-block; width:170px; height:31px; margin-top:3px;"><div style="font-family: 'Montserrat', sans-serif; color:black; font-size:25px; margin-top:0px; margin-left:-2px; font-weight:bold; text-shadow: 1px 1px 1px rgba(150, 150, 150, 0.3);">looi</div></div>
		</div>

	<div style="margin-top:7px; float:right; margin-right:10px; " >
		<div style="display:inline-block;" id="topnav-signin"><a href="/signin.php" class="signin"><span><?php echo $Common_header_login_text; ?></span></a> </div>

		<div style="display:inline-block;">
			<?php echo $Common_header_or; ?>
			<a class="header-submenu-nav-a" href="/signup-facebook.php?facebook=no" style="margin-right:0px; margin-left:0px; margin-top:0px; display:inline-block;"><?php echo $Common_header_joinnow; ?></a>
		</div>

		<fieldset id="signin_menu">
			<a id="facebookButton-small" onclick="facebookSignin(); return false;" href="#"><font color=white><?php echo $Common_header_fb_login; ?></font></a>

			<form method="post" id="signin" action="/signin.php">
				<p>
					<input type="hidden" name="op" value="signin_popup">
					<label for="SignIn_Email"><?php echo $Common_header_email; ?></label>
					<input id="SignIn_Email" name="SignIn_Email" value="" title="<?php echo $Common_header_email_tip; ?>" tabindex="4" type="text">
				</p>
				<p>
					<label for="SignIn_Password"><?php echo $Common_header_password; ?></label>
					<input id="SignIn_Password" name="SignIn_Password" value="" title="<?php echo $Common_header_password_tip; ?>" tabindex="5" type="Password">
				</p>
					<p class="remember">
					<input id="signin_submit" value="<?php echo $Common_header_home_signin_button; ?>" tabindex="6" type="submit">
					<input id="remember_me" name="remember_me" value="1" tabindex="7" type="checkbox">
					<label for="remember_me"><?php echo $Common_header_remember_me; ?></label>
				</p>
				<p class="forgot"> <a href="password-reset.php" id="resend_password_link"><?php echo $Common_header_forgot_pwd; ?></a> </p>
			</form>
		</fieldset>
	</div>

<script type="text/javascript">
        $(document).ready(function() {

			$('.MiniSearch INPUT[name="q"]').val("Search");
			
			$("#signin_menu").css({"top":$("#topnav-signin").position().top+21 });
			$("#signin_menu").css({"left":$("#topnav-signin").position().left-$("#signin_menu").width()+$("#topnav-signin").width()-27 });

            $(".signin").click(function(e) {          
				e.preventDefault();
                $("fieldset#signin_menu").toggle();
				$(".signin").toggleClass("menu-open");
            });
			
			$("fieldset#signin_menu").mouseup(function() {
				return false
			});
			$(document).mouseup(function(e) {
				if($(e.target).parent("a.signin").length==0) {
					$(".signin").removeClass("menu-open");
					$("fieldset#signin_menu").hide();
				}
			});			
			
        });
</script>
<?php
}	


?>

</div>

<?php if (($_SESSION['Elooi_User']==true) and ($_SESSION['Elooi_AccountVerified']=="0") and ($page=="my-elooi") and ($_GET["message"]!="welcome") ) { ?>
<div class="successbox" style="width:800px; align:center; margin:0 auto; margin-top:0px; margin-bottom:10px; padding:10px; "><center><?php echo $Common_header_verify_email; ?></center></div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
	$("#xstream").autocomplete({
		
		source:'/suggest_stream.php', 
		minLength:2, 
		autoFocus:true, 
		search: function(event, ui) { 
			$('#loading_indicator2').show();
		},
		response: function(event, ui) {
			$('#loading_indicator2').hide();
		},
		select:function(event, ui)
		{
	//		console.log(ui.item);
	//		console.log(ui.item.label);
			$("#xstream").val(ui.item.label);
			event.preventDefault();
	//		return false;
		},
		focus:function(event, ui)
		{
			$("#xstream").val(ui.item.label);
			event.preventDefault();
		}
	});

	var img_arr_pos = 1;
	var extracted_images = [];
	
	updateWord($("#URLCommentary").val(), "#wordcounter", 40, 100);
	
	$("#URLCommentary").on("input propertychange", function(){
			updateWord($("#URLCommentary").val(), '#wordcounter', 40, 100);
			//console.log("!!");
		});

	$("#newpost_form label").inFieldLabels();
	$('#newpost_form').bind('submit',function(){
		xurlID= $("#urlID").val();
		if (xurlID == "0") {
			$( "#nourl-message" ).dialog({
				modal: true,
				resizable: false,
				height:300,
				width:500,
				open: function(event, ui) {
					$(event.target).dialog('widget')
						.css({ position: 'fixed' })
						.position({ my: 'center', at: 'center', of: window });
				},
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
					}
				}
			});			
			
		} else
		if ($("#xstream").val().length<3) {
			$( "#nostream-message" ).dialog({
				modal: true,
				resizable: false,
				height:300,
				width:500,
				open: function(event, ui) {
					$(event.target).dialog('widget')
						.css({ position: 'fixed' })
						.position({ my: 'center', at: 'center', of: window });
				},
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
					}
				}
			});			
			
		} else
		if (countWords($("#URLCommentary").val())<40) {
			$( "#nocommentary-message" ).dialog({
				modal: true,
				resizable: false,
				height:300,
				width:500,
				open: function(event, ui) {
					$(event.target).dialog('widget')
						.css({ position: 'fixed' })
						.position({ my: 'center', at: 'center', of: window });
				},
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
					}
				}
			});			
			
		} else
		{
			//ajax request to be sent to extract-process.php
		   var postForm = { //Fetch form data
				'urlID'  : xurlID,
				'commentary'  : $("#URLCommentary").val(),
				'stream' : $("#xstream").val(),
				'imageID'  : extracted_images[img_arr_pos-1],
				's_Location' : '<?php echo $_SESSION['Elooi_Location']; ?>'
			};
			console.log("post");

			$.ajax({ //Process the form using $.ajax()
				type        : 'POST', //Method type
				url         : '/process.php', //Your form processing file url
				data        : postForm, //Forms name
				dataType    : 'json',
				error: function(jqXHR,error, errorThrown) {  
				   if(jqXHR.status&&jqXHR.status==400){
						console.log(jqXHR.responseText); 
				   }else{
					   console.log("Something went wrong");
					   $('.throw_error').fadeIn(1000).html("Something went wrong. Please try again."); //Throw relevant error
				   }
				},
				
				success     : function(data) {
					console.log("success "+data);
					$('.throw_error').fadeIn(1000).html("");

					if (!data.success) { //If fails
						if (data.errors.name) { //Returned if any error from process.php
							console.log("error "+data.errors.name);
							$('.throw_error').fadeIn(1000).html(data.errors.name); //Throw relevant error
						}
					} else {
							console.log("done "+data.posted );
							$( "#savepost-message" ).dialog({
								modal: true,
								resizable: false,
								height:300,
								width:500,
								open: function(event, ui) {
									$(event.target).dialog('widget')
										.css({ position: 'fixed' })
										.position({ my: 'center', at: 'center', of: window });
								},
								buttons: {
									Ok: function() {
										$( this ).dialog( "close" );
										$("#new-post-dialog").dialog( "close" );
										 location.reload();
									}
								}
							});			
							
						}
					}
			});
			
		}
		
		
		return false;
	});	

	
	$('#xsiteurl').keyup(function() { //user types url in text field		
		var getUrl  = $('#xsiteurl'); //url to extract from text field
		
		//url to match in the text field
		var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;
		
		//returns true and continue if matched url is found in text field
		if ( (match_url.test(getUrl.val())) && ($("#loading_indicator").is(":hidden")) ) {
				$("#results").hide();
				$("#loading_indicator").show(); //show loading indicator image
				
				var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
				
				//ajax request to be sent to extract-process.php
				$.post('/extract-process.php',{'url': extracted_url}, function(data){         
               		
//					$("#grid_menu").css({'height':'355px'});
//					$("#grid_menu_pusher").css({'height':'369px'});
					$("#urlID").val(data.urlID);
					
					extracted_images = data.images;
					total_images = parseInt(data.images.length);
					img_arr_pos = total_images;
					img_arr_pos = 1;
					if(total_images>0){
						inc_image = '<div class="extracted_thumb" id="extracted_thumb"><img src="/slir/w110-h110-c1.1/'+data.images[img_arr_pos-1]+'" width="110" height="110"></div>';
					}else{
						inc_image ='';
					}
					//content to be loaded in #results element
					var content = '<div class="extracted_url"><div class="extracted_content" style="display:block; overflow:hidden; height:120px; width:627px;">'+ inc_image +'<h4><a href="'+extracted_url+'" target="_blank">'+data.title+'</a></h4><span>'+data.content+'</span></div><div style="height:25px;"><div class="thumb_sel"><span class="prev_thumb" id="thumb_prev">&nbsp;</span><span class="next_thumb" id="thumb_next">&nbsp;</span> </div><div style="padding-top:2px"><span class="small_text" id="total_imgs">'+(img_arr_pos)+' of '+total_images+'</span><span class="small_text">&nbsp;&nbsp;Choose a Thumbnail</span></div></div></div>';
					
					//load results in the element
					$("#results").html(content); //append received data into the element
					$("#results").slideDown(); //show results with slide down effect
					$("#loading_indicator").hide(); //hide loading indicator image
					
					//user clicks previous thumbail
					$("#thumb_prev").bind("click tap", function(e){		
						if(img_arr_pos>1) 
						{
							img_arr_pos--; //thmubnail array position decrement
							
							//replace with new thumbnail
							$("#extracted_thumb").html('<img src="/slir/w110-h110-c1.1/'+extracted_images[img_arr_pos-1]+'" width="110" height="110">');
							
							//show thmubnail position
							$("#total_imgs").html(((img_arr_pos)) +' of '+ total_images);
						}
					});
					
					//user clicks next thumbail
					$("#thumb_next").bind("click tap", function(e){		
						if(img_arr_pos<total_images)
						{
							img_arr_pos++; //thmubnail array position increment
							
							//replace with new thumbnail
							$("#extracted_thumb").html('<img src="/slir/w110-h110-c1.1/'+extracted_images[img_arr_pos-1]+'" width="110" height="110">');
							
							//replace thmubnail position text
							$("#total_imgs").html(((img_arr_pos)) +' of '+ total_images);
						}
					});
					
                },'json');
		}
	});
	
	$("#new-post-button").click( function() {
		$( "#new-post-dialog" ).dialog({
			modal: true,
			resizable: false,
			height:500,
			width:670,
			open: function(event, ui) {
				$(event.target).dialog('widget')
					.css({ position: 'fixed' })
					.position({ my: 'center', at: 'center', of: window });
			}/*,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
					 location.reload();
				}
			}*/
		});			
	});
});
</script>

<div id="new-post-dialog" title="New Post" style="display:none" class="ui-front">

<form id="newpost_form" method=post  autocomplete = "off" style="margin-top:10px;">
<input type="hidden" name="op" value="newpost">
<input type="hidden" id="urlID" name="urlID" value="0">

<div id="newpost_form_div">
	<label for="xsiteurl">http://www... like to artice</label>
	<input type="text" name="xsiteurl" value="<?php echo $xsiteurl; ?>" id="xsiteurl" class="signup-name" title="http://www... like to artice"  style="width:628px">
	<img id="loading_indicator" src="/images/ajax-loader.gif">
</div>

<div id="newpost_form_div">
	<label for="xstream">Stream to publish article in</label>
	<input type="text" name="xstream" value="" id="xstream" class="signup-name" title="It is recommended to use mainstream, but you can create your own streams as well."  style="width:628px">
	<img id="loading_indicator2" src="/images/ajax-loader.gif">
</div>

<div id="newpost_form_div" style="margin-bottom:10px;">
	<label for="URLCommentary" class="textblock" style="top:4px; width:600px;">Please write your commentary on this article, you can use hastags in your commentary.</label>
	<textarea class="signup-name" name="URLCommentary" id="URLCommentary" style="width:628px; height:120px"><?php echo $URLCommentary; ?></textarea>
	<div id="wordcounter" style="position:absolute; top:134px; right:4px; font-size:10px; width:200px; text-align:right; z-index:100">Words</div>
</div>

<div id="results" style="height:143px; width:628px; border:1px solid #BFBFBF; background-color:white; padding:5px; display:none; border-radius:5px; margin-bottom:5px; margin-top:14px;">
</div>
<input type="submit" name="join_button" value="Submit Post" class="submitbutton" style="margin-left:1px; margin-top:5px;" />
<span class="throw_error"></span>
</form>

</div>

<div id="nourl-message" title="No artical URL selected" style="display:none">
  <p>Please <b>copy&paste the url</b> of the article you wish to add to your wall.</p>
</div>

<div id="nostream-message" title="Please choose a stream" style="display:none">
  <p>Please choose one of the <b>main</b><i>Streams</i> or create a new <i>Stream</i> for your post. If you are new to Elooi we recommend that you use the <b>main</b><i>Streams</i> for your posts instead of creating new streams. </p>
</div>

<div id="nocommentary-message" title="Not enough on the commentary" style="display:none">
  <p>Please write your <b>commentary</b> on the article you are sharing. Commentaries should be of medium length (<b>40-100 words</b>). You should share why you find the article interesting.</p>
</div>

<div id="savepost-message" title="Sucessfully Posted" style="display:none">
  <p>The article accomponied with your commentary is now live and on your timeline, people who follow you will get notified. Thank you for sharing.</p>
</div>

<div style="height:50px; width:100%">
</div>

<!--<div id="page" style="overflow:hidden; top:40px; position:absolute; left:0;
    right:0;
    margin-left:auto;
    margin-right:auto; 
	background-image:url(bg2/tiled-bg_body_bg.jpg)">-->
