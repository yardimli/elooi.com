<?php $page="badges"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>


<div class="banner2" style="width:750px;" id="bannerx">
<div style="font-size:22px; color:white; font-weight:bold; padding:12px">Hakkımızda</div>
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
 

<div id="tagline"><img alt="" class="right-image-about" src="/elooi-logo-75.png" />Elooi, dünyayı dinlemenin<br>yeni yolu.</div>
      <h3>Elooi Nedir?</h3>
<p>
Bir zamanlar 'Söz uçar, yazı kalır,' denirdi. Şimdi Elooi ile söz hem uçuyor, hem kalıyor!
<br><br>
Günümüzde internet ile bütün sınırları aştık sayılabilir. Tek bir sınır dışında. Hâlâ dertlerimizi, sevinçlerimizi ve üzüntülerimizi önümüzdeki klavye yoluyla başkalarına aktarmaya çalışıyoruz. Hâlâ sosyal ağlarda kendimizi dışavurmak için yazmamız gerekiyor! Ama artık Elooi var!
<br><br>
<B>Elooi</B> ile yeni gelişmeleri yazarak değil, doğrudan sesinizle çevrenize duyurabileceksiniz!
<br><br>
<B>Elooi</B> ile hem daha samimi, hem daha özgür olacaksınız!
<br><br>
<B>Elooi</B> ile anlatmak istediklerinizi klavyeyle değil, kendi sesinizle anlatacaksınız!
<br><br>
<B>Elooi</B> ile çevrenizdeki dünyayı dinleyecek ve herkes ile konuşabileceksiniz!
<br><br>
<B>Elooi</B> ile yeni arkadaşlar bulacaksınız!
<br><br>
<B>Elooi</B> ile sesiniz yankılanacak, sınırlarınızı zorlayacaksınız!
</p>

      <h3>Dünyada Elooi<img alt="" class="right-image" src="/images/about-sf.png" /></h3>
            <p>Elooi, İstanbul merkezlidir ancak dünyanın hemen hemen her ülkesinden kullanıcıya sahiptir. Elooi artık İngilizce, Norveççe ve Çince olarak kullanılabiliyor. Kullanıcı hesap ayarlarından veya bütün sayfalardaki dil bağlantılarını kullanıp birkaç tıkla dil tercihlerini değiştirmek çok kolay.</p>

      <h3>Her yerde Elooi<div class="getElooiApp right-image"><div class="get-app"><a class="get-android" href="/devices/android">Android</a></div></div></h3>
            <p>Yakında iPhone, iPad, Blackberry, Windows7 ve Android için tasarlanmış ücretsiz Elooi uygulamaları sayesinde Elooi'yi her yerde kullanabilirsiniz.</p>

</div>

</div>


<div class="badges-section" id="side-section-div" style="top:100px;    padding: 20px; 
   background: none repeat scroll 0 0 #FFFFFF;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 0 1px 3px #A8CFE5;
	background: rgba(255, 255, 255, 0.95);" >


<div class="header3">Bize Ulaşın</div>
Elooi hakkında güncel bilgiler için lütfen şirket blogumuzu okuyun. Ayrıca hizmet soruları, ortaklık teklifleri ya da basın sorguları için bizimle iletişim kurmaktan çekinmeyin.
<br>
<br>
<address>Elo Robot Ltd. <br/> Gömeç Sokak, Acıbadem/Kadıköy <br/> İstanbul, Türkiye 34410 <br/> Eposta: <a href="mailto:iletisim&#064;elooi.com">iletisim&#064;elooi.com</a></address> 

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