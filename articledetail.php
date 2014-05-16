<?php $page="index"; ?>
<?php require_once("/server-settings.php"); ?>
<?php require_once('/php-functions.php'); ?>
<?php
		$sqlCommandEloois = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois
		JOIN users ON eloois.userID=users.ID
		WHERE ProfileElooi = 0 AND Deleted=0 AND eloois.id=". $_GET["id"];

		$sqlEloois = mysql_query($sqlCommandEloois);
		
		$j = 0;
		
		$xsqlCommandArticle = "SELECT * FROM urlTable WHERE ID='" . mysql_result($sqlEloois,$j,"urlID") . "'";
		$sqlElooisArticle = mysql_query($xsqlCommandArticle);
		
		?>

		<div style="position:absolute; left:0px; top:0px; bottom:0px; width:750px; z-index:1; overflow-y:auto; overflow-x:hidden; padding:20px; background: url(/images/paper_background.jpg) no-repeat center center fixed;
    -webkit-background-size: cover; /* For WebKit*/
    -moz-background-size: cover;    /* Mozilla*/
    background-size: cover;         /* Generic*/
" id="articlediv">
		<a href="<?php echo mysql_result($sqlElooisArticle,0,"xURL");?>" target="_blank" style="font-size:20px; line-height:28px; color:black; font-weight:bold;"><?php echo mysql_result($sqlElooisArticle,0,"xTitle2");?></a>		
		<br><br>
			<?php echo mysql_result($sqlElooisArticle,0,"xDocument");?>
		</div>


		<div style="position:absolute; left:820px; top:10px; width:400px; background-color: rgb(249, 237, 184);
border: solid 1px rgb(237, 201, 103);
border-radius: 2px;
font-weight: bold;
margin: 0 20px 11px 10px;
padding: 6px 8px; " ID="ArticleCommentary">
			<?php echo mysql_result($sqlEloois,$j,"Commentary");?>
		</div>

		<div style="position:absolute; left:820px; top:200px; width:400px; margin: 11px 20px 11px 10px;" id="commentdiv">
<?php
    $object_id = 'article_'.$_GET["id"]; //identify the object which is being commented
    include('/commentanything/php/loadComments.php'); //load the comments and display    
?>
</div>

			

		<div style="display:block; position:absolute; left:800px; bottom:2px; height:32px; z-index:3;
background-color: #f5f5f5;
border-color: #e7e7e7;
border-top-style: solid;
border-width: 1px;
color: #888;
padding: 14px 17px;" id="ArticleDetailFotter">
			<div style="width:26px; float:left; margin-top:3px; overflow:hidden; height:26px; margin-left:3px; margin-right:4px; margin-bottom:2px;"><img src="/slir/w26-h26-c1.1/<?php echo mysql_result($sqlEloois,$j,"upicture"); ?>"></div>

			<div style="display:block; margint-top:0px; font-size:11px;">
				<b><a href="/u/<?php echo mysql_result($sqlEloois,$j,"username");?>/profil" onclick="javascript:event.stopPropagation();" id="span_username_<?php echo $arraycounter; ?>" style="font-size:11px; color:#444444;"><?php echo mysql_result($sqlEloois,$j,"username");?></a></b> - <?php echo mysql_result($sqlEloois,$j,"Location"); ?></span><br><span id="span_adddate_<?php echo $arraycounter; ?>" style="color:#555555; white-space: nowrap;"><?php 
				echo datetotext( mysql_result($sqlEloois,$j,"ElooiTime") ); ?>&nbsp;&nbsp;</span>
			</div>

		</div>
<?php
	?>
	

<script type="text/javascript">
	var isiPad = false;
	var isiPadFirstTimeLoad = false;

	var ua = navigator.userAgent.toLowerCase();
	var isiPad_ = navigator.userAgent.match(/iPad/i) != null;
	var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
	//treat ipad and andorid the same way
	if ((isiPad_) || (isAndroid)) { isiPad = true; isiPadFirstTimeLoad = true; }
	
	
	$(document).ready(function(){ 
		
		$("#ArticleDetailFotter").css({"left": ($("#articlediv").outerWidth())+"px", "width": ($("#ArticlePanel").width()-$("#articlediv").outerWidth()-34)+"px"});
		
		$("#ArticleCommentary").css({"left": ($("#articlediv").outerWidth())+"px", "width": ($("#ArticlePanel").width()-$("#articlediv").outerWidth()-40)+"px"});

		$("#commentdiv").css({"left": ($("#articlediv").outerWidth())+"px", "width": ($("#ArticlePanel").width()-$("#articlediv").outerWidth()-22)+"px","top": ($("#ArticleCommentary").outerHeight()+10)+"px" });


		
		$('#articlediv img').each(
        function(){
            $(this).css({'width':'500px','height':'auto'});
        });
	});
</script>

