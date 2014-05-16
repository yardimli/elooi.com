<?php require_once("/server-settings.php"); ?>
<?php
if ( ( ($_GET["uid"]!="") && (intval($_GET["uid"])>0) ) or ($_SESSION['uid']!="") )
{
	if ($_SESSION['uid']!="") { $UserID = $_SESSION['uid']; $_SESSION['uid']=""; }
	if ( ($_GET["uid"]!="") && (intval($_GET["uid"])>0) ) { $UserID = $_GET["uid"]; }

	$xsqlCommand = "SELECT * FROM users WHERE ID=".$UserID;
	$mysqlresult = mysql_query($xsqlCommand);
	$UserName = "";
	if (mysql_num_rows($mysqlresult)==1) { $UserName = mysql_result($mysqlresult,0,"UserName"); }
}

if (($UserID!="") and ($UserID!=-100) and ($UserID!=-200)) 
{ 
	$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=".$UserID;
	$mysqlresult3 = mysql_query($xsqlCommand3);

	$_SESSION['tileBackground']   = mysql_result($mysqlresult3,0,"tileBackground");
	$_SESSION['backgroundImage']  = mysql_result($mysqlresult3,0,"backgroundImage");
	$_SESSION['backgroundColor']  = mysql_result($mysqlresult3,0,"backgroundColor");
	$_SESSION['textColor']        = mysql_result($mysqlresult3,0,"textColor");
	$_SESSION['linkColor']        = mysql_result($mysqlresult3,0,"linkColor");
	$_SESSION['headerColor']      = mysql_result($mysqlresult3,0,"headerColor");
	$_SESSION['textBackgroundColor']   = mysql_result($mysqlresult3,0,"textBackgroundColor");

	$col = hex2RGB(mysql_result($mysqlresult3,0,"textBackgroundColor"));
	$_SESSION['textBackgroundColorR']   = $col['red'];
	$_SESSION['textBackgroundColorG']   = $col['green'];
	$_SESSION['textBackgroundColorB']   = $col['blue'];

	$col = hex2RGB(mysql_result($mysqlresult3,0,"BackgroundColor"));
	$_SESSION['BackgroundColorR']   = $col['red'];
	$_SESSION['BackgroundColorG']   = $col['green'];
	$_SESSION['BackgroundColorB']   = $col['blue'];

	if ( ($UserID!=$_SESSION['Elooi_UserID'])  and (($_SESSION['me_subpage']=="") or ($_SESSION['me_subpage']=="mentions") ) )
	{
		$_SESSION['me_subpage']="profil";
	}

	if (($_SESSION['me_subpage']=="") or ($_SESSION['me_subpage']=="mentions") ) { 
		$page="my-index"; 
	} else {
		$page="profile-page"; 
	}
} else 
{
	if (($_SESSION['Elooi_UserID']=="") or ($_SESSION['Elooi_UserID']=="0")) {
		$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=43"; } else
	{	$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=".$_SESSION['Elooi_UserID']; }
	$mysqlresult3 = mysql_query($xsqlCommand3);

	$_SESSION['tileBackground']   = mysql_result($mysqlresult3,0,"tileBackground");
	$_SESSION['backgroundImage']  = mysql_result($mysqlresult3,0,"backgroundImage");
	$_SESSION['backgroundColor']  = mysql_result($mysqlresult3,0,"backgroundColor");
	$_SESSION['textColor']        = mysql_result($mysqlresult3,0,"textColor");
	$_SESSION['linkColor']        = mysql_result($mysqlresult3,0,"linkColor");
	$_SESSION['headerColor']      = mysql_result($mysqlresult3,0,"headerColor");
	$_SESSION['textBackgroundColor']   = mysql_result($mysqlresult3,0,"textBackgroundColor");

	$col = hex2RGB(mysql_result($mysqlresult3,0,"textBackgroundColor"));
	$_SESSION['textBackgroundColorR']   = $col['red'];
	$_SESSION['textBackgroundColorG']   = $col['green'];
	$_SESSION['textBackgroundColorB']   = $col['blue'];

	$col = hex2RGB(mysql_result($mysqlresult3,0,"BackgroundColor"));
	$_SESSION['BackgroundColorR']   = $col['red'];
	$_SESSION['BackgroundColorG']   = $col['green'];
	$_SESSION['BackgroundColorB']   = $col['blue'];

	if (($_SESSION["etiket"]=="") && ($_SESSION["searchq"]==""))	{ $page="all-new";  } else { $page="result-page"; }

}
?>
<?php include("/ortak-header.php"); ?>
<?php include("/me-js.php"); ?>

<div id="grid_rightcol" class="elooi-page-rightcol" style="overflow:hidden; margin-top:10px; float:left; position:fixed; z-index:5; background:<?php echo $_SESSION['textBackgroundColor']; ?>;  background:<?php echo $_SESSION['textBackgroundColor']; ?>; background:rgba(<?php echo $_SESSION['textBackgroundColorR'] ?>,<?php echo $_SESSION['textBackgroundColorG'] ?>,<?php echo $_SESSION['textBackgroundColorB'] ?>,0.75); "" >
	<div id="rightcol_user_info" style="width:330px;">
</div>
</div>


<div style="margin-left:0px; z-index:0; overflow-y:auto; overflow-x:hidden; width:650px; background:#ffffff; margin-top:10px; " id="grid_centercol">
<?php
$top_menu = "";
if ( ($page=="my-index"))  {
	$top_menu = "timeline";
?>
<script type="text/javascript">
	TopMenu="timeline";
</script>


<?php
} else if ($page=="profile-page") {
	$top_menu = "profile";
?>
<script type="text/javascript">
	TopMenu="profile";
</script>

<div id="grid_menu" style="position:relative; z-index:4;  background-color:<?php echo $_SESSION['textBackgroundColor']; ?>; background: rgba(<?php echo $_SESSION['textBackgroundColorR'].",".$_SESSION['textBackgroundColorG'].",".$_SESSION['textBackgroundColorB'];?>, 0.40); width:636px; height:27px; cursor:default; padding:7px;" >

	<a href="/u/<?php echo $UserName ?>/profil" id="" class="googleDugmeText gmailDugme <?php if ($_SESSION['me_subpage']=="profil") { echo " secili"; }?>"  style="border-radius: 3px 0px 0px 3px;" ><?php if ($UserID==$_SESSION['Elooi_UserID']) { echo $me_my_eloois; } else {echo $me_eloois; }?></a><a 
	
	href="/u/<?php echo $UserName ?>/favorites" id="" class="googleDugmeText gmailDugme <?php if ($_SESSION['me_subpage']=="favorites") { echo " secili"; }?>" style="border-radius: 0px 0px 0px 0px; border-left:0px;"><?php if ($UserID==$_SESSION['Elooi_UserID']) { echo $me_my_favorites; } else {echo $me_favorites; }?></a><a 
	
	href="/u/<?php echo $UserName ?>/listento" id="" class="googleDugmeText gmailDugme <?php if ($_SESSION['me_subpage']=="listento") { echo " secili"; }?>" style="border-radius: 0px 0px 0px 0px; border-left:0px;"><?php if ($UserID==$_SESSION['Elooi_UserID']) { echo $me_my_listening_to; } else {echo $me_listening_to; }?></a><a 
	
	href="/u/<?php echo $UserName ?>/listeners" id="" class="googleDugmeText gmailDugme <?php if ($_SESSION['me_subpage']=="listeners") { echo " secili"; }?>" style="border-radius: 0px 3px 3px 0px; border-left:0px;"><?php if ($UserID==$_SESSION['Elooi_UserID']) { echo $me_my_listeneres; } else {echo $me_listeneres; }?></a></li> </a>

</div>
<div id="grid_menu_pusher" style="z-index:1; background:#FFFFFF; width:630px; height:41px; display:none"></div>

<?php
} else if ($_SESSION["searchq"]!="") {
?>

<div id="grid_menu" style="position:relative; z-index:4;  background-color:<?php echo $_SESSION['textBackgroundColor']; ?>; background: rgba(<?php echo $_SESSION['textBackgroundColorR'].",".$_SESSION['textBackgroundColorG'].",".$_SESSION['textBackgroundColorB'];?>, 0.40); width:628px; height:19px; cursor:default; padding:11px;" >
<span style="font-size:20px;  text-shadow: 0px 2px 2px #C5C5C5;"><?php echo str_replace('##TERM##',$_SESSION["searchq"],$Common_Search_Terms); ?></span>
</div>
<div id="grid_menu_pusher" style="z-index:1; background:#FFFFFF; width:630px; height:41px; display:none"></div>

<?php
} else if ($_SESSION["etiket"]!="") {
?>

<div id="grid_menu" style="position:relative; z-index:4;  background-color:<?php echo $_SESSION['textBackgroundColor']; ?>; background: rgba(<?php echo $_SESSION['textBackgroundColorR'].",".$_SESSION['textBackgroundColorG'].",".$_SESSION['textBackgroundColorB'];?>, 0.40); width:628px; height:19px; cursor:default; padding:11px;" >
<span style="font-size:20px;  text-shadow: 0px 2px 2px #C5C5C5;"><?php echo $me_header_tag; ?><?php echo $_SESSION["etiket"]; ?></span>
</div>
<div id="grid_menu_pusher" style="z-index:1; background:#FFFFFF; width:630px; height:41px; display:none"></div>

<?php } 
else if ($_SESSION["did"]!="") {
?>

<div id="grid_menu" style="position:relative; z-index:4;  background-color:<?php echo $_SESSION['textBackgroundColor']; ?>; background: rgba(<?php echo $_SESSION['textBackgroundColorR'].",".$_SESSION['textBackgroundColorG'].",".$_SESSION['textBackgroundColorB'];?>, 0.40); width:628px; height:19px; cursor:default; padding:11px;" >
<span style="font-size:20px;  text-shadow: 0px 2px 2px #C5C5C5;"><?php echo $me_header_conversation; ?></span>
</div>
<div id="grid_menu_pusher" style="z-index:1; background:#FFFFFF; width:630px; height:41px; display:none"></div>

<?php } else { ?>

<div id="grid_menu" style="position:relative; z-index:4; background-color:<?php echo $_SESSION['textBackgroundColor']; ?>; background: rgba(<?php echo $_SESSION['textBackgroundColorR'].",".$_SESSION['textBackgroundColorG'].",".$_SESSION['textBackgroundColorB'];?>, 0.40); width:628px; height:19px; cursor:default; padding:11px;" >
<span style="font-size:20px;  text-shadow: 0px 2px 2px #C5C5C5;"><?php echo $me_newest_eloois; ?></span>
</div>
<div id="grid_menu_pusher" style="z-index:1; background:#FFFFFF; width:630px; height:41px; display:none"></div>

<?php } 
 
if ($UserID==-100)
{
	if ($_SESSION["etiket"]!="")
	{
		$xsqlCommand = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois
		JOIN users ON eloois.userID=users.ID
		LEFT JOIN tagcloud ON tagcloud.elooiID=eloois.ID
		LEFT JOIN alltags ON alltags.ID=tagcloud.tagID

		WHERE ProfileElooi = 0 AND Deleted=0 AND alltags.noCaseTag='" . $_SESSION["etiket"] ."' ORDER BY ElooiTime DESC LIMIT 50";
		//echo $xsqlCommand;
	} else

	if ($_SESSION["searchq"]!="")
	{
		$xsqlCommand = "SELECT distinct eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois
		JOIN users ON eloois.userID=users.ID
		JOIN userprofiles ON eloois.userID=userprofiles.userID
		LEFT JOIN tagcloud ON tagcloud.elooiID=eloois.ID

		WHERE ProfileElooi = 0 AND Deleted=0 AND ( (alltags.noCaseTag LIKE '%" . $_SESSION["searchq"] ."%') OR (users.username LIKE '%" . $_SESSION["searchq"] ."%') OR (users.firstname LIKE '%" . $_SESSION["searchq"] ."%') OR (userprofiles.userBio LIKE '%" . $_SESSION["searchq"] ."%')) ORDER BY ElooiTime DESC LIMIT 50";
		//echo $xsqlCommand;
	} else
	{
		$xsqlCommand = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois
		JOIN users ON eloois.userID=users.ID
		WHERE ProfileElooi = 0 AND Deleted=0 ORDER BY ElooiTime DESC LIMIT 100";
	}
	$mysqlresult = mysql_query($xsqlCommand);
} else
{
	$UseMyInbox = 0;
	update_inbox_for_user($UserID);
	if ($_SESSION['me_subpage']=="badges") {
		$xsqlCommand = "SELECT * FROM badges JOIN userBadges ON badges.badgeID=userBadges.badgeID WHERE userBadges.userID=".ATQ($UserID)." AND LanguageID=".$_SESSION['Elooi_ILanguageID'];
	} else

	if ($_SESSION['me_subpage']=="profil") {
		$xsqlCommand = "UPDATE users SET ViewCounter=ViewCounter+1 WHERE ID=" . ATQ($UserID);
		$mysqlresult = mysql_query($xsqlCommand);
		
		if ($UserID==$_SESSION['Elooi_UserID']) { $UseMyInbox = 1; }

		$xsqlCommand = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture,IsFavorite FROM userInbox
		JOIN eloois ON userInbox.ElooiID=eloois.ID
		JOIN users ON eloois.userID=users.ID
		WHERE userInbox.UserID=".$UserID." AND userInBox.IsOwn=1 AND OriginalInList=0 ORDER BY userInbox.ElooiDate DESC LIMIT 50";
	} else
	
	if ($_SESSION['me_subpage']=="favorites") {

		if ($UserID==$_SESSION['Elooi_UserID']) { $UseMyInbox = 0; }

		$xsqlCommand = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois
		JOIN favorites ON favorites.ElooiID=eloois.ID
		JOIN users ON eloois.userID=users.ID
		WHERE eloois.deleted=0 and favorites.UserID=".$UserID." ORDER BY ElooiTime DESC LIMIT 50";
	} else

	if ($_SESSION['me_subpage']=="listento") {
		$xsqlCommand = "SELECT users.*,userprofiles.* FROM listeners
		JOIN users ON listeners.ListeningToID=users.ID
		JOIN userprofiles ON listeners.ListeningToID=userprofiles.userID
		WHERE listeners.UserID=".$UserID." ORDER BY listeners.ID DESC LIMIT 50";
	} else

	if ($_SESSION['me_subpage']=="listeners") {
		$xsqlCommand = "SELECT users.*,userprofiles.* FROM listeners
		JOIN users ON listeners.UserID=users.ID
		JOIN userprofiles ON listeners.UserID=userprofiles.userID
		WHERE listeners.ListeningToID=".$UserID." ORDER BY listeners.ID DESC LIMIT 50";
	} else

	
	if ($_SESSION['me_subpage']=="") {
		if ($UserID==$_SESSION['Elooi_UserID']) { $UseMyInbox = 1; }

		if ($UseMyInbox == 1){
			$xsqlCommand = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture,IsFavorite FROM userInbox
			JOIN eloois ON userInbox.ElooiID=eloois.ID
			JOIN users ON eloois.userID=users.ID
			WHERE userInbox.UserID=".$UserID." AND OriginalInList=0 ORDER BY userInbox.ElooiDate DESC LIMIT 50";
		} else
		{ //if viewing someone elses timeline only show their eloois and their echos, not updates from their followers
			$xsqlCommand = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture,IsFavorite FROM userInbox
			JOIN eloois ON userInbox.ElooiID=eloois.ID
			JOIN users ON eloois.userID=users.ID
			WHERE userInbox.UserID=".$UserID." AND userInBox.IsOwn=1 ORDER BY userInbox.ElooiDate DESC LIMIT 50";
		}
	}
//	echo $xsqlCommand;
	$mysqlresult = mysql_query($xsqlCommand);
}
$num_rows = mysql_num_rows($mysqlresult);

if ($num_rows==0) { //no results
	if ($_SESSION["searchq"]!="") { ?>
	<center><br><br><?php echo $Common_Search_NoResult; ?></center>
	<?php }

	if ($_SESSION['me_subpage']=="profil") {?>
	<center><br><br>@<?php echo $UserName; ?> <?php echo $me_no_elooi_yet; ?></center>
	<?php }

	if ($_SESSION['me_subpage']=="favorites") {?>
	<center><br><br>@<?php echo $UserName; ?> <?php echo $me_no_favorites; ?></center>
	<?php }

	if ($_SESSION['me_subpage']=="listento") {?>
	<center><br><br>@<?php echo $UserName; ?> <?php echo $me_no_listening; ?></center>
	<?php }

	if ($_SESSION['me_subpage']=="listeners") {?>
	<center><br><br>@<?php echo $UserName; ?> <?php echo $me_no_listeners; ?></center>
	<?php }

}


if (($_SESSION['me_subpage']=="listento") or ($_SESSION['me_subpage']=="listeners")) {

	echo "<script type=\"text/javascript\">\nvar ElooiCount = ". $num_rows .";\n";
	$arraycounter = 0;
	$i = 0;
	while ($i<$num_rows) {
		$arraycounter++;
		echo "UserList[" . $arraycounter . "] = \"" . mysql_result($mysqlresult,$i,"users.ID") . "\"; \n";
		$i++;
	}
	echo "</script>";

	$i = 0;
	$arraycounter = 0;
	while ($i<$num_rows) {
		$arraycounter++;
	?>
	<div id="user_<?php echo $arraycounter; ?>" class="elooi_row" onMouseOver="javascript:selectUserRow('<?php echo $arraycounter; ?>');" onMouseOut="javascript:deselectUserRow('<?php echo $arraycounter; ?>')" onClick="javascript:UserRowClick('<?php echo $arraycounter; ?>');" <?php if ($arraycounter % 2 == 0) { echo "style=\"background:#F1F1F5;\""; } ?> >

		<div style="width:52px; float:left; margin-top:3px; overflow:hidden; height:52px; margin-left:5px; margin-right:8px;">
		<a href="/u/<?php echo mysql_result($mysqlresult,$i,"username");?>/profil" onclick="javascript:event.stopPropagation();"><img src="/slir/w52-h52-c1.1/<?php echo mysql_result($mysqlresult,$i,"picture"); ?>"></a>
		</div>

		<div style="margin-left:60px; min-height:52px;">

			<div style="display:block; margint-top:0px; min-height:20px; margin-left:4px; line-height:130%; ">
				<b><a href="/u/<?php echo mysql_result($mysqlresult,$i,"username");?>/profil" onclick="javascript:event.stopPropagation();" id="span_username_<?php echo $arraycounter; ?>" style="font-size:12px; color:#4444AA;">@<?php echo mysql_result($mysqlresult,$i,"username");?></a></b>
				<span style="font-size:12px; color:#666666;"><?php echo mysql_result($mysqlresult,$i,"firstname");?></span><br>
				<span style="font-size:12px; color:#666666;"><?php echo mysql_result($mysqlresult,$i,"location");?></span><br>
				<?php if (mysql_result($mysqlresult,$i,"homepage")!="") {?>
				<a href="<?php echo mysql_result($mysqlresult,$i,"homepage");?>" style="font-size:12px; color:#3333AA;"><?php echo mysql_result($mysqlresult,$i,"homepage");?></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
		$i++;
	}
} else
{

//build data arrays
echo "<script type=\"text/javascript\">\nvar ElooiCount = ". $num_rows .";\n";
$arraycounter = 0;
$i = 0;
while ($i<$num_rows) {
	$arraycounter++;
	if (mysql_result($mysqlresult,$i,"EchoElooiID")!="0") 
	{
	} else {
		echo "ElooiIDArray[" . $arraycounter . "] = \"".mysql_result($mysqlresult,$i,"eloois.ID") . "\"; ";
		echo "UserList[" . $arraycounter . "] = \"" . mysql_result($mysqlresult,$i,"eloois.userID") . "\"; \n";
	}
	$i++;
}	
echo "</script>";


//show list
$arraycounter = 0;
$i = 0;
while ($i<$num_rows) {
		$arraycounter++;

		$xsqlCommandArticle = "SELECT * FROM urlTable WHERE ID='" . mysql_result($mysqlresult,$i,"urlID") . "'";
		$mysqlresultArticle = mysql_query($xsqlCommandArticle);
		
?>
<a name="elooiname_<?php echo $arraycounter; ?>">
<div id="elooi_<?php echo $arraycounter; ?>" class="elooi_row" style="font-size:12px;" onMouseOver="javascript:selectRow('<?php echo $arraycounter; ?>');" onMouseOut="javascript:deselectRow('<?php echo $arraycounter; ?>')" onClick="javascript:RowClick('<?php echo $arraycounter; ?>');">
	<div id="dogear_<?php echo $arraycounter; ?>" class="tweet-dogear <?php
		
		//add favorited and/or echo dogtag 
		$favunlink = 0;
		$unecho    = 0;
		if ($_SESSION['Elooi_UserID']!="") { //if user has logged in start check
			//check if query is using inbox to grab favorites from inbox or favorites table
			if ($UseMyInbox == 0) {
				$favCmd = "SELECT * FROM favorites WHERE elooiID=".mysql_result($mysqlresult,$i,"ID")." AND userID=".$_SESSION['Elooi_UserID'];
				$favRes = mysql_query($favCmd);
				
				if (mysql_num_rows($favRes)==1) { $favunlink=1; $log->lwrite($favCmd." --> ".mysql_num_rows($favRes)); }
			} else
			{
				if (mysql_result($mysqlresult,$i,"IsFavorite")==1) { $favunlink=1; }
			}
		}
		
		if (($favunlink==1) && ($unecho==1)) { echo " reechoed-favorited "; } else
		if ($favunlink==1)  { echo " favorited "; } else

		?>"></div>
		
		<div style="padding:10px; background-color:#ECEFF5">
			<img src="/slir/w72-h72-c1.1/<?php 
			if (mysql_result($mysqlresult,$i,"imageID")!="")
			{
				echo mysql_result($mysqlresult,$i,"imageID");
			} else
			{
				echo "bg/theme_default_modify.jpg";
			}?>" style="float:left; margin-right:4px; margin-bottom:4px; border:2px solid #ccc; border-radius:4px;" />
			<a href="<?php echo mysql_result($mysqlresultArticle,0,"xURL");?>" target="_blank" style="font-size:17px;"><?php echo mysql_result($mysqlresultArticle,0,"xTitle");?></a>
			
			<div style="margin-top:4px;"><?php echo mysql_result($mysqlresultArticle,0,"xDescription");?></div>
		
			<div style="clear:both; border: 1px solid #999; padding:7px; border-radius:3px;"><?php echo mysql_result($mysqlresult,$i,"Commentary");?></div>
		</div>
		
<?php
    $object_id = 'article_'.mysql_result($mysqlresult,$i,"ID"); //identify the object which is being commented
    include('/commentanything/php/loadComments.php'); //load the comments and display    
?>
		

		<div style="display:block; background:#eee; border-bottom: 1px solid #e7e7e7; color: #777; height:42px;">
			<div style="width:36px; float:left; margin-top:3px; overflow:hidden; height:36px; margin-left:5px; margin-right:4px; margin-bottom:2px;"><img src="/slir/w36-h36-c1.1/<?php echo mysql_result($mysqlresult,$i,"upicture"); ?>"></div>

			<div style="display:block; margint-top:0px; height:20px;">
				<b><a href="/u/<?php echo mysql_result($mysqlresult,$i,"username");?>/profil" onclick="javascript:event.stopPropagation();" id="span_username_<?php echo $arraycounter; ?>" style="font-size:12px; color:#444444;"><?php echo mysql_result($mysqlresult,$i,"username");?></a></b> <span style="font-size:11px; color:#777777;"><?php echo mysql_result($mysqlresult,$i,"firstname");?> - <?php echo mysql_result($mysqlresult,$i,"Location"); ?></span>
			</div>
		
			<div style="display:block; margin-left:4px; margin-bottom:0px; height:8px; font-size:11px; ">
				<span id="span_adddate_<?php echo $arraycounter; ?>" style="color:#555555;"><a href="/u/<?php if ($UserName!="") { echo $UserName; } else { echo mysql_result($mysqlresult,$i,"username"); }
				echo "/elooi/" . mysql_result($mysqlresult,$i,"ID"); ?>" onClick="javascript:event.stopPropagation();"><?php 
				echo datetotext( mysql_result($mysqlresult,$i,"ElooiTime") ); ?></a>&nbsp;&nbsp;</span>
				<?php
				if ($_SESSION['Elooi_UserID']!="") { ?>
				<span id="action_barn_<?php echo $arraycounter; ?>" style="display:none">
					<span class="elooi-actions">
						<a class="<?php if ($favunlink==1) { echo "unfavorite-action"; } else { echo "favorite-action";} ?>" onclick="addtofavorite('<?php echo $arraycounter; ?>',event); return false;" href="#" id="favorite_<?php echo $arraycounter; ?>" >
							<span>
								<i></i><b><?php if ($favunlink==1) { echo $me_remove_favorite; } else { echo $me_add_favorite; } ?></b>
							</span>
						</a>
						<?php

						if ( ($_SESSION['Elooi_UserID']==mysql_result($mysqlresult,$i,"userID")) or ($_SESSION['Elooi_UserID']==1000048) or ($_SESSION['Elooi_UserID']==43)) { ?>
						<a class="delete-action" onclick="delete_elooi('<?php echo $arraycounter; ?>',event); return false;" href="#">
							<span><i></i><b><?php echo $me_delete; ?></b></span></a>
						
						<?php } ?>
					</span>
				<span>
				<?php } //toolbar for users who logged in
				?>
			</div>
		</div>
</div>


<?php
	$i++;
}

}
?>

</div>

<div style="height:20px"></div>



  <fieldset id="location-popup">
	<input type="hidden" name="op" value="signin_popup">
      <label for="city"><?php echo $Footer_Location; ?></label>
      <input id="city" name="city" value="" tabindex="4" type="text">
      </p>
	  <a href="#" onClick="javascript: $('#location-str').html('<?php echo $newelooi_Location; ?>: '); $('#myLocation').val('none'); $('.location-menu').removeClass('menu-open'); $('fieldset#location-popup').hide(); return false;"><?php echo $Footer_No_Location; ?></a>
  </fieldset>
</body></html>