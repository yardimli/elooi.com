<?php $page="badges"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>


<div class="banner2" style="width:750px;" id="bannerx">
<div style="font-size:22px; color:white; font-weight:bold; padding:12px">About Us</div>
</div>

<div class="content-main " style="width:728px; 
   padding: 20px; 
   background: none repeat scroll 0 0 #FFFFFF;
    border-radius: 0px 0px 5px 5px;
    box-shadow: 0 1px 3px #A8CFE5;
	background: rgba(255, 255, 255, 0.95);" id="maincontentx">

 <style>

 h2 {
    font-size: 24px;
    margin-bottom: 5px;
}

.right-image-about {
	float:right;
    padding-top: 24px !important;
}

.right-image {
	float:right;
    padding-top: 0px !important;
}

h3 {
	font-weight: normal;
    line-height: 1;
    padding: 0;

	margin: 10px 0 5px;

	border-top: 1px solid #E0EEF5;
    font-size: 16px;
    margin-top: 14px !important;
    padding-top: 24px !important;
}

#tagline {
	color: #333333;
	font-weight: normal;
    font-size: 39px;
	font-family: Arial,sans-serif;
	margin-bottom: 0;
    margin-left: 0;
    margin-right: 0;
    margin-top: -18px !important;
    padding: 0;
    width: 100%;
    clear: both;
    display: block;
    float: none;
	line-height: 118% !important;
	padding-bottom: 12px !important;
    padding-left: 0;
    padding-right: 0;
    padding-top: 8px !important;
}


#sections2 p{
    color: #333333 !important;
    font-size: 14px;
	line-height: 1.5em !important;
    padding-bottom: 10px;
    width: 80%;
    line-height: 18px;
    margin: 0 0 15px;

	padding-left: 12px;
    margin: 0 0 15px;

    margin-bottom: 26px;
    padding-bottom: 10px;

}

.header3 {
	font-weight: normal;
    line-height: 1;
    padding: 0;
    margin-bottom: 10px;

	border-bottom: 1px solid #E0EEF5;
    font-size: 16px;
}

</style>
 
 
 
 

<div style="" id="sections2">
 

<div id="tagline"><img alt="" class="right-image-about" src="/elooi-logo-75.png" />Elooi, a new way to listen<br>and speak.</div>
      <h3>What is Elooi?</h3>
<p>
Elooi is a voice network made up of 60-second recodings called Eloois. It's a new and easy way to discover and share with your voice, and listen to others sharing updates and news.
<br><br>
With <strong>Elooi</strong> you will be tell with your voice not you keyboard!
<br><br>
With <strong>Elooi</strong> you will become more personal and experience a new freedom!
<br><br>
With <strong>Elooi</strong> you will share your knowledge with your Voice and not have to write!
<br><br>
With <strong>Elooi</strong> you will listen to the world around you, and talk with everyone!
<br><br>
With <strong>Elooi</strong> you will make new friends!
<br><br>
With <strong>Elooi</strong> you will Discover!
</p>

      <h3>Elooi Around the World<img alt="" class="right-image" src="/images/about-sf.png" /></h3>
            <p>Elooi, is based in Istanbul, but has servers all over the world and is available in many languages. You can listen and say Eloois in English, Turkish, Chinese and Norwegain. </p>

      <h3>Elooi On Your Devices<div class="getElooiApp right-image"><div class="get-app"><a class="get-android" href="/devices/android">Android</a></div></div></h3>
            <p>Soon Elooi will work on iPhone, iPad, Blackberry, Windows7 and Android devices.</p>

</div>

</div>


<div class="badges-section" id="side-section-div" style="top:100px;    padding: 20px; 
   background: none repeat scroll 0 0 #FFFFFF;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 0 1px 3px #A8CFE5;
	background: rgba(255, 255, 255, 0.95);" >


<div class="header3">Contact Us</div>
To recive update information about Elooi don't forget to check our blog. If you want to contact us about or service or any other topics please drop as en email.
<br>
<br>
<address>Elooi Ltd. <br/> Gömeç Sokak, Acıbadem/Kadıköy <br/> İstanbul, Türkiye 34410 <br/> E-Mail: <a href="mailto:iletisim&#064;elooi.com">contact&#064;elooi.com</a></address> 

</div>



<script type="text/javascript">

jQuery("#side-section-div").css({"top":jQuery("#bannerx").position().top });
jQuery("#side-section-div").css({"left":jQuery("#maincontentx").position().left+$("#maincontentx").width()+ 50 });

</script>


<script type="text/javascript">
jQuery(document).ready(function(){ 
	setBackgroundValues("no-repeat","#DDF3FC","/bg/theme_default_modify.jpg","", "#272323", "#000000", "#333333","#B2BDCD");
});
</script>

<?php include("/ortak-fotter.php"); ?>