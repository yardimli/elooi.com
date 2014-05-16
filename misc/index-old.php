<?php $page="index"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>
<?php include("/build-user-inbox.php"); ?>
<?php
//delete and unlink unused tags
$q1 = mysql_query("SELECT ID FROM alltags ORDER BY ID ASC");
$num_rows = mysql_num_rows($q1);
for ($i=0; $i<$num_rows; $i++) {
	$q2 = mysql_query("SELECT * FROM tagcloud JOIN eloois ON eloois.ID=tagcloud.ElooiID WHERE tagID=".mysql_result($q1,$i,"ID") );
	$num_rows2 = mysql_num_rows($q2);
	if ($num_rows2==0) { 
		$q3 = mysql_query("DELETE FROM alltags WHERE ID=".mysql_result($q1,$i,"ID")); 
		$q3 = mysql_query("DELETE FROM tagcloud WHERE tagID=".mysql_result($q1,$i,"ID")); 
	}
}

//update nocase tags
$mysqlresult = mysql_query("UPDATE alltags SET nocaseTag=lower(tag)");


//update nocaseTag freq
$mysqlresult = mysql_query("SELECT DISTINCT nocaseTag,count(*) as xcount FROM tagcloud
LEFT JOIN alltags ON tagcloud.tagID=alltags.ID
GROUP BY nocaseTag");
$num_rows = mysql_num_rows($mysqlresult);
for ($i=0; $i<$num_rows; $i++) {
	$row = mysql_fetch_assoc($mysqlresult);
	$mysqlresult2 = mysql_query("UPDATE alltags set nocaseTagCount=". $row["xcount"] ." WHERE nocaseTag=". ATQ($row["nocaseTag"]) );
}

//update tag freq
$mysqlresult = mysql_query("SELECT tag,tagID,count(*) as xcount FROM tagcloud
LEFT JOIN alltags ON tagcloud.tagID=alltags.ID
GROUP BY tagID");
$num_rows = mysql_num_rows($mysqlresult);
for ($i=0; $i<$num_rows; $i++) {
	$row = mysql_fetch_assoc($mysqlresult);
	$mysqlresult2 = mysql_query("UPDATE alltags set tagCount=". $row["xcount"] ." WHERE ID=".$row["tagID"]);
}


//update short-url
$mysqlresult = mysql_query("SELECT * FROM eloois WHERE linkUrl<>'' AND ( (ShortURL = '') or (ShortURL is null ) )");
$num_rows = mysql_num_rows($mysqlresult);
for ($i=0; $i<$num_rows; $i++) {
	$short = make_bitly_url_2(mysql_result($mysqlresult,$i,"LinkURL"),'elooi','R_2f066b6c16bbed77c2177be9cb03d1c2','xml');
	$mysqlresult2 = mysql_query("UPDATE eloois SET shortURL='". Trim(AddSlashes($short)) ."' WHERE ID=".mysql_result($mysqlresult,$i,"ID") );
}

//update genral points
$q0 = mysql_query("SELECT * FROM USERS ");
$r0 = mysql_num_rows($q0);
for ($i=0; $i<$r0; $i++) {
	
	$userX = mysql_result($q0,$i,"ID");
	$GeneralRepPoints = (mysql_result($q0,$i,"ViewCounter")*1.2);
	$SocialRepPoints = mysql_result($q0,$i,"ViewCounter");

	//self posted eloois
	$q1 = mysql_query("SELECT count(*) as toplam,sum(tracklength) as toplam2 FROM eloois WHERE userID=".$userX." AND EchoUserID=0 AND Deleted=0" );
	$r1 = mysql_num_rows($q1);
	$GeneralRepPoints = $GeneralRepPoints + (mysql_result($q1,0,"toplam")*10)+(mysql_result($q1,0,"toplam2")/10);
	$SocialRepPoints = $SocialRepPoints + (mysql_result($q1,0,"toplam")*2)+(mysql_result($q1,0,"toplam2")/3);

	//echos
	$q1 = mysql_query("SELECT count(*) as toplam FROM eloois WHERE EchoUserID=".$userX." AND Deleted=0" );
	$r1 = mysql_num_rows($q1);
	$GeneralRepPoints = $GeneralRepPoints + (mysql_result($q1,0,"toplam")*3);
	$SocialRepPoints = $SocialRepPoints + (mysql_result($q1,0,"toplam")*5);

	//replies
	$q1 = mysql_query("SELECT count(*) as toplam FROM eloois WHERE UserID=".$userX." AND Deleted=0 AND ResponseToElooiID>0" );
	$r1 = mysql_num_rows($q1);
	$GeneralRepPoints = $GeneralRepPoints + (mysql_result($q1,0,"toplam")*5);
	$SocialRepPoints = $SocialRepPoints + (mysql_result($q1,0,"toplam")*15);

	//pictures
	$q1 = mysql_query("SELECT count(*) as toplam FROM eloois WHERE UserID=".$userX." AND EchoUserID=0 AND picture<>''" );
	$r1 = mysql_num_rows($q1);
	$GeneralRepPoints = $GeneralRepPoints + (mysql_result($q1,0,"toplam")*3);
	$SocialRepPoints = $SocialRepPoints + (mysql_result($q1,0,"toplam")*6);

	//links
	$q1 = mysql_query("SELECT count(*) as toplam FROM eloois WHERE UserID=".$userX." AND EchoUserID=0 AND linkurl<>''" );
	$r1 = mysql_num_rows($q1);
	$GeneralRepPoints = $GeneralRepPoints + (mysql_result($q1,0,"toplam")*2);
	$SocialRepPoints = $SocialRepPoints + (mysql_result($q1,0,"toplam")*4);

	//listens
	$q1 = mysql_query("SELECT sum(listencounter) as toplam FROM eloois WHERE UserID=".$userX." AND EchoUserID=0 " );
	$r1 = mysql_num_rows($q1);
	$GeneralRepPoints = $GeneralRepPoints + (mysql_result($q1,0,"toplam")*4);
	$SocialRepPoints = $SocialRepPoints + (mysql_result($q1,0,"toplam")*2);

	$mysqlresult2 = mysql_query("UPDATE userprofiles SET GeneralRepPoints=". ATQ($GeneralRepPoints) .", SocialRepPoints=".ATQ($SocialRepPoints)." WHERE userID=".$userX );

}
?>

<div class="banner2" style="width:750px; height:30px; padding-top:20px;" id="bannerx">
<span style="color:white; font-family: 'Oleo Script', cursive; font-size:30px; font-weight:normal  "><?php echo $index_page_header; ?></span>
</div>

<div class="content-main " style="width:728px; background: rgba(255, 255, 255, 0.75);" id="maincontentx">

<br>
  <span style="font-size:20px; font-family: 'Oleo Script', cursive;"><strong><?php echo $index_page_welcome; ?></strong></span>
  <br>
  <br>
  <br>
  <span style="font-size:13px;">
  <?php echo $index_page_text; ?>
  </span>

  <br><br><br>
  <span style="line-height:200%">
  <?php echo $index_page_join_fb_txt; ?>
  </span><br><br>
  <a id="facebookButton" onclick="facebookLogin(); return false;" href="#"><font color=white><?php echo $index_page_signin_up_fb_txt; ?></font></a>
<?php echo $Join_No_Facebook; ?>
<!--<br>
<br>
<br>
<div class="getElooiApp">
<span style="font-size:16px;"><?php echo $index_page_mobile; ?></span><br>
<div class="get-app">
<a class="get-android" href="/devices/android">Android</a>
</div>
<div class="get-app">
<a class="get-windows" href="/devices/windows">Windows</a>
</div>
<div class="get-app">
<a class="get-iphone" href="/devices/iphone">iPhone</a>
</div>
-->
<div style="clear: both;"></div>
</div>


<?php include("/ortak-fotter.php"); ?>


<div class="index-side-section" id="side-section-div" style="position:absolute; top:100px;" >

<?php echo $index_page_side_box; ?><br><br>

<?php
	$mysqlresult = mysql_query("SELECT DISTINCT users.* FROM users JOIN eloois ON eloois.UserID=users.ID WHERE Eloois.Deleted=0" );

	$num_rows = mysql_num_rows($mysqlresult);
	$randomnez = array();
	for ($k=0; $k<$num_rows; $k++) { $randomnez[$k]= -1; }

	for ($k=0; $k<$num_rows; $k++) { 
		$k3 = 1;
		while ($k3==1)
		{
			$random=rand(0,$num_rows-1);
			$k3 = 0;
			for ($k2=0; $k2<$num_rows; $k2++) { if ($randomnez[$k2]==$random) { $k3=1; } }
		}
		$randomnez[$k] = $random;
	}

	$i = 0;
	WHILE ($i<$num_rows) {
	?>
		<a href="/u/<?php echo mysql_result($mysqlresult,$randomnez[$i],"userName"); ?>/profil"><img src="/slir/w45-h45-c1.1/<?php echo mysql_result($mysqlresult,$randomnez[$i],"picture"); ?>" style="height:45px; width:45px; opacity:0.9;" onmouseover="this.style.opacity=1;" onmouseout="this.style.opacity=0.9;" /></a>
	<?php
		$i++;
	}

?>



</div>

<script type="text/javascript">

$("#side-section-div").css({"top":$("#bannerx").position().top });
$("#side-section-div").css({"left":$("#maincontentx").position().left+$("#maincontentx").width()+ 50 });

</script>


<?php
/*

- new version fixes:

- how many hours ago doesnt work (might be year issue) ..................ok
- make echo work without having to tag ..................................ok
- make add photo work
- make add link work
- if added photo then link should be remove photo
- if added link then link should be remove link
- hide @mentions  .......................................................ok
- add new language variables to chinese norwegian and turksih versions

- signup upload avatar ajax .............................................ok
- signup image check ....................................................ok
- signup php email checek ...............................................ok
- signup mysql email check  if exists ...................................ok
- signup mysql insert ...................................................ok

- signup form for facebook signup .......................................ok

- signin page like signup page ..........................................ok
- signin mysql ..........................................................ok
- signin with errors ....................................................ok

- use dropdown sigin ....................................................ok 
- signin with facebook ..................................................ok 04.08.2011
- remember me checkbox on both sigin pages ..............................ok 04.08.2011
- make remember me work until logout ....................................ok 04.08.2011
- encryt cookieids for remember me ......................................ok 04.08.2011
- reset password page ...................................................ok 04.08.2011
- send reset email some form of md5 .....................................ok 05.08.2011
- landing page for reset password .......................................ok 05.08.2011
- update reset password single entry ....................................ok 05.08.2011
- store password as hash ................................................ok 06.08.2011
- compare login with hash ...............................................ok 06.08.2011
- signup and profile image update resize ................................ok 06.08.2011
- minumum username char length 8 ........................................ok 06.08.2011
- after signup take user to profile page with welcome tip ...............ok 07.08.2011
- send welcome post with confirmation link on signup ....................ok 07.08.2011
- show hint if user hasnt verified with option to resend ................ok 07.08.2011
- have confirmation link update database for user .......................ok 07.08.2011
- if user change email set verified to false ............................ok 07.08.2011
- download facebook profile image and rename and update db ..............ok 08.08.2011
- on signup check if a facebook member exists ...........................ok 08.08.2011
- if not logged in take to signin page with tooltip .....................ok 08.08.2011
- use yellow tip window above box for tips ..............................ok 08.08.2011
- use gray tip window above box for errors ..............................ok 08.08.2011

- change upper bar after signin .........................................ok
- logout button .........................................................ok


- settings 
	- account ...........................................................ok
		- verify password on submit .....................................ok
		- write tooltips ................................................ok
		- write sidebar
		- connect facebook to my account ................................ok 08.08.2011
		- check for existing facebook connection ........................ok 08.08.2011
		- connect twitter to my account .................................ok 09.08.2011
		- check for existing twitter connection .........................ok 09.08.2011
		- post a tweet after connect ....................................ok 09.08.2011
		- add sharing on twitter checkboxes .............................ok 09.08.2011
		- add normalize my microphone recordings to settings page
		- add sensetive content checkbox to settings page

	- profile ...........................................................ok
		- write tooltips ................................................ok
		- add upload mp3 button .........................................ok
		- mp3 qualit and length reducer .................................ok
		- flv to mp3 converter on the server ............................ok
		- mp3 normalizer and voice detection ............................ok
		- add html5 listen to mp3 .......................................ok
		- write sidebar .................................................ok

	- design
		- make top bar like twitter 100% width with netkitap colors .....ok 09.08.2011
		- select background .............................................ok 10-13.08.2011
		- upload background .............................................ok 10-13.08.2011
		- write sidebar .................................................ok
	- notifications .....................................................ok
		- write tooltips ................................................ok
		- write sidebar .................................................ok
	- update password ...................................................ok
		- write sidebar .................................................ok

--------------------------


-- NEXT FEATURES

- deactivate account option 
- create groups (a group is same as an user, but you cant add eloois, groups have members a member is both a listener and listen to user for the group)
- private eloois that only those who you listen to can hear (temp remove the settings from the backoffice now)
- private messaging (settings is disabled in account settings for now)
- right bar when listening to elooi - show other eloois with similar tags 
- right bar analyze link if picture or video show it
- show users you both listen to in common on right bar (if logged in)
- make location tags clickable
- add floating window like facebook when you hover over tags @tags etc.
- give option to follow tags as well as users
- when echoing an elooi if it is your favorite the echo needs to copy the favorite, or if you favorite an echo you made and delete the echo the favorite is lost as well
- about myself elooi
- stop upload form from working when user is offline
- break connection with twitter
- break connection with facebook
- dont let user connect multiple accounts to 1 twitter
- dont let user connect multiple accounts to 1 facebook
- make account update password popup like twitter
- check flv recording length after convert to mp3 for length check
- transcript option


- inbox
	- send elooi message with text
	- recived messages 
	- read/unread
	- delete
	- reply




JOBS:

- submenu for echos .................................................................ok
- update @tag for username changes in alltags table .................................ok
- listeners and listening to users list .............................................ok
- make left number links work (eloois, listeners, listening to) .....................ok
- left should overflow:crop horizontal  .............................................ok
- show real links when bitly hasnt shortened it yet .................................ok
- dont auto update echo dogtag as echo will get into list or out after refresh ......ok
- add elooi playback counter ........................................................ok
- add profile open counter ..........................................................ok
- add no favorites, no listeners, not listening to anyone, no eloois messages .......ok
 add texts when submen items of echo menu is selected ...............................ok
- expand listeners and listening to user details to right colmun ....................ok
- use userinbox table to show favorite flag on eloois ...............................ok
- add elooi places to include world city-country instead ............................ok
- update userinbox too when person flag/unflags faovorite ...........................ok
- dont edit auto inserted @tags, but edit self inserted @tags .......................ok
- use @ as a icon in the tag ........................................................ok
- link @ to mentions page ...........................................................ok
- make @ tags go to profil page if exists ...........................................ok
- check that all ATQ's are used without ' as atq inserts ' ..........................ok
- make location non clickable tag like time .........................................ok
- make whole tag clickable not just the text ........................................ok
- add button to lock positon of second menubar (store in session/cookie) ............ok
- add play direction button (store in session/cookie) ...............................ok
- single elooi bubble page with play, tags, picture, user info ......................ok
- if on user page and elooi is echo load user info of playing elooi on right side ...ok
- scroll into view a little buggy should be based on play direction .................ok
- dont allow to favorite your own eloois or your echos ..............................ok
- if user doesnt have mentions display no mentions yet text .........................ok
- if you have echoed an elooi show the echo dogtag and unecho on other pages ........ok
- dont select language from profile or in elooi .....................................ok
- add langauge selection to page save langauge to session and account ...............ok
- keep language session on signout ..................................................ok
- choose language from index page only save into session ............................ok
- make right bar texts (benim resimlerim or resimleri based on login) ...............ok
- prevent opening http://elooi.com/u/leonard.mccoy if you are not that user .........ok

/ / / default right bar about person before playback starts \ \ \
- show last photos in right bar .....................................................ok
- show mini thumbnail of listeners and listening to in right bar ....................ok

/ / / when playing elooi right bar \ \ \
- show picture thumbnail for elooi with full view popup link ........................ok
- make the listen to stop listening button in right bar for elooi detail text-only ..ok
- make echo tags clickable ..........................................................ok
- show list of tags in elooi that are used on more than one elooi ...................ok
- show mark offensive link ..........................................................ok
- make response to response add the response to the thread ..........................ok
- if is response show link to thread ................................................ok
- make the response thread work even if the first is deleted ........................ok
- show echos users thumbnails and their own tags ....................................ok
- show user that is mentioned (response or mention or both ) ........................ok

- use world-city database for profile page ..........................................ok
- dont update location if not found in world-city database ..........................ok
- update error messages in backoffice ...............................................ok
- finish translation file site-wide .................................................ok
- add text background color to design tab ...........................................ok
- translate automatic emails sent ...................................................ok

- redesing search bar like twitter ..................................................ok
- redesign tag bubbles in me.php like fenopy ........................................ok
- design automatic emails sent ......................................................ok
- make help tos privacy blog etc all work ...........................................ok

- create 12 badges ..................................................................ok
	- add badges to user account  ...................................................ok
	- show a page containing all badges that can be won  ............................ok
	- point system ..................................................................ok

- create a site map of all php files being used with descriptions ...................ok

- make search work ..................................................................ok
- make design colors reflect in elooi ...............................................ok
- make add to facebook wall and tweet as button .....................................ok
- make change language popup work ...................................................ok
- use language file for facebook and twitter posts ..................................ok
- show gold silver bronze badge numbers and popup to show details ...................ok
- use language file for facebook like button
- add facebook like code to header ..................................................ok
- use new email templates ...........................................................ok
- set timezone and language defaults to language of elooi based on browser agent ....ok
- deploy on godaddy .................................................................ok

- translate chinese .................................................................ok
- create theme sets for elooi .......................................................ok

- simply classical signup ...........................................................ok
- write and record elooi tutorials in english turkish 
- change twitter icons to elooi icons
- make single elooi play more like twitters single tweet

- create fully startrek theme trek.elooi.com
- translate norwegian 
- captcha image when flagging
*/

?>