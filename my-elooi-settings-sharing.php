<?php $page="my-elooi"; ?>
<?php $subpage="settings-sharing"; ?>
<?php include("ortak-header.php"); ?>

<div class="banner2">
		<h2><img src="<?php echo $_SESSION['Elooi_Picture']; ?>" height=28 style="vertical-align:top; "> <?php echo $_SESSION['Elooi_FullName'];?>'s Settings</h2>
<style>

.settings-tabs_ul {height:4px; width:100%; border-bottom:0px solid #e5e5e5; clear:both; }

ul.settings-tabs_ul li {display:inline;line-height:1; }

ul.settings-tabs_ul li a {
	
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    color: #FFFFFF;
    font-weight: normal;
    padding-top: 3px;
	
	border-radius: 4px 4px 0 0;
    display: inline;
    float: left;
    line-height: 21px;
    margin: 0;
    overflow: hidden;
    padding: 4px 10px 3px;
    width: auto;	
	display:block;
	
	}

ul.settings-tabs_ul li a:hover {
	background:#eee;text-decoration:none;padding-bottom:3px; color:black; text-shadow: 0 1px 0 #FFFFFF; display:block;
}


ul.settings-tabs_ul li.settings-active a:hover{text-decoration:none;  display:block;}

ul.settings-tabs_ul li.settings-active a {
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: none repeat scroll 0 0 #FFFFFF;
    border-color: #E5E5E5 #E5E5E5 -moz-use-text-color;
    border-style: solid solid none;
    border-width: 1px 1px 0;
    color: #333333;
    font-weight: bold;
    padding-top: 3px;

	
	border-radius: 4px 4px 0 0;
    display: inline;
    float: left;
    line-height: 21px;
    margin: 0;
    overflow: hidden;
    padding: 4px 10px 3px;
    text-shadow: 0 1px 0 #FFFFFF;
    width: auto;	
}

/*.settings-active a:hover{background:#fff;border:1px solid #e5e5e5;border-bottom:0;color:#333;font-weight:bold;padding-top:3px;}*/

</style>

  <ul class="settings-tabs_ul"> 
    <li><a href="my-elooi-settings-account.php" id="">Account</a></li> 
    <li><a href="my-elooi-settings-profile.php" id="">Profile</a></li> 
    <li><a href="my-elooi-settings-design.php" id="">Design</a></li> 
    <li class="settings-active"><a href="my-elooi-settings-sharing.php" id="">Sharing</a></li> 
    <li><a href="my-elooi-settings-privacy.php" id="">Privacy</a></li> 
    <li><a href="my-elooi-settings-notifications.php" id="">Notifications</a></li> 
    <li><a href="my-elooi-settings-password.php" id="">Password</a></li> 
  </ul> 

		</div>
<style>
.side-section {
    border: 1px solid #C0DEED;
    border-radius: 5px 5px 5px 5px;
    margin-top: 100px;
	max-width: 200px;
    min-width: 180px;
    padding: 19px !important;
    width: auto !important;
	background-color: #DDEEF6;
    border-bottom-right-radius: 5px;
    border-left: 1px solid #C0DEED;
    border-top-right-radius: 5px;
    line-height: 1.2;
	margin-left: 660px;
	padding-bottom: 20px;
	margin: 0;
	font: 13px/18px "Helvetica Neue",Helvetica,Arial,sans-serif;
	text-align: left;
	color: #333333;
	float: right;
}


.content-section {
	margin-right: 0 !important;
	float: left;
    width: 600px;
	margin: 0;
    padding: 0;
	font: 13px/18px "Helvetica Neue",Helvetica,Arial,sans-serif;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	text-align: left;
	color: #333333;
}
</style>

<div class="content-main " >

<li>Share my new elois to Facebook ?
<li>Share my new badges to Facebook ?


<div class="content-section">

</div>

<div class="side-section">
  <h3>Account</h3>
  From here you can change your basic account info, language settings, and your elloi privacy<!-- and location--> settings.
  <br><br>
  <h3>Tips</h3>
  Change your Elooi user name anytime without affecting your existing data. After changing it, make sure to let your listeners know so you'll continue receiving all of your messages with your new user name.<br>
  <br>
  Protect your account to keep your eloois private. Approve who can follow you and keep your eloois out of search results.
</div>





<?php include("ortak-fotter.php"); ?>

