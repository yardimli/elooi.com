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

$sqlCommandStreams = "select streams.id,stream, count(*) as toplam from eloois 
left join streams on streamID=streams.ID
group by stream
order by toplam desc";

$sqlStreams = mysql_query($sqlCommandStreams);
$num_rows_streams = mysql_num_rows($sqlStreams);
$i = 0;
while ($i<$num_rows_streams) {
?>
	<div class="StreamTitleClass" id="StreamTitle"><?php echo mysql_result($sqlStreams,$i,"stream"); ?></div>
	
	<div class="StreamContainerClass" id="StreamContainer">
		<div style="display:block; white-space: nowrap; height:244px; ">
<?php
		$sqlCommandEloois = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois
		JOIN users ON eloois.userID=users.ID
		WHERE ProfileElooi = 0 AND Deleted=0 AND StreamID=". mysql_result($sqlStreams,$i,"streams.id") ." ORDER BY ElooiTime DESC LIMIT 50";

		$sqlEloois = mysql_query($sqlCommandEloois);
		$num_rows_eloois = mysql_num_rows($sqlEloois);
		$j = 0;
		while ($j<$num_rows_eloois) {
			$xsqlCommandArticle = "SELECT * FROM urlTable WHERE ID='" . mysql_result($sqlEloois,$j,"urlID") . "'";
			$sqlElooisArticle = mysql_query($xsqlCommandArticle);

			?><div id="elooi_<?php echo $arraycounter; ?>" class="ElooiBlock"  data-ID="<?php echo mysql_result($sqlEloois,$j,"ID");?>">

				<div style="position:absolute; left:0px; top:0px; height:244px; width:244px; z-index:1;"><img src="/slir/w244-h244-c1.1/<?php 
				if (mysql_result($sqlEloois,$j,"imageID")!="")
				{
					echo mysql_result($sqlEloois,$j,"imageID");
				} else
				{
					echo "bg/theme_default_modify.jpg";
				}?>" style="width:244px; height:244px;"/></div>

				<div style="position:absolute; left:0px; bottom:0px; width:244px; z-index:2; background-color: rgba(0,0,0,0.5)" class="titleblock">
					<div style="padding:5px;">
						<a href="<?php echo mysql_result($sqlElooisArticle,0,"xURL");?>" target="_blank" style="font-size:14px; line-height:20px; color:white; font-weight:bold;"><?php echo mysql_result($sqlElooisArticle,0,"xTitle2");?></a>
					</div>
				</div>

				<div class="DescriptionBlock">
					<p class="ellipsisbox">
					<?php echo mysql_result($sqlEloois,$j,"Commentary");?>
					</p>
				</div>

				
			</div><?php
			$j++;
		}
		?>
		</div>
	</div>
	
<?php
	$i++;
}
?>
<div ID="StreamScrollLeft" style="position:absolute; cursor: pointer; background-color: white; z-index:2; height: 244px; width:100px; opacity:0.2;"></div>

<div ID="StreamScrollRight" style="position:absolute; cursor: pointer; background-color: white; z-index:2; height: 244px; width:100px; opacity:0.2;"></div>

<div ID="ScreenMask" class="ScreenMask"></div>

<div ID="ArticlePanel" class="ArticlePanelClass"></div>


<script type="text/javascript">
	
	var CurrentStream;
	
	var isiPad = false;
	var isiPadFirstTimeLoad = false;

	var ua = navigator.userAgent.toLowerCase();
	var isiPad_ = navigator.userAgent.match(/iPad/i) != null;
	var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
	var ArticlePanel = $("#ArticlePanel");

	//treat ipad and andorid the same way
	if ((isiPad_) || (isAndroid)) { isiPad = true; isiPadFirstTimeLoad = true; }
	
	
	$(document).ready(function(){ 
		
		ArticlePanelWidth = Math.round( $(window).width() * 0.7);
		ArticlePanelHeight = Math.round( ($(window).height()-40) * 0.9);

		ArticlePanel.css({ "left": ($(window).width()/2 - ArticlePanelWidth/2)+"px", 
				   "top" : ((($(window).height()-40)/2 - ArticlePanelHeight/2)+40)+"px",
				   "width" : ArticlePanelWidth+"px",
				   "height" : ArticlePanelHeight+"px"});
						   
		$(".ElooiBlock").click(function() {
			$("#ScreenMask").fadeIn(250);
			ArticlePanel.fadeIn(250);
			$('html, body').css({			'overflow': 'hidden'}); //'height': '100%'		
			var artid = $(this).data("id");
			ArticlePanel.html("Loading....");
			setTimeout( function() {
				$.get("/articledetail.php?id="+artid, function(content) { ArticlePanel.html(content); });
			},250);
			
		});

		$("#ScreenMask").click(function() {
			$('html, body').css({    'overflow': 'auto',    'height': 'auto'});
			$("#ScreenMask").fadeOut(250);
			ArticlePanel.fadeOut(250);
		});
		
		if (isiPad)
		{
			$(".StreamContainerClass").css({"overflow-x":"scroll","-webkit-overflow-scrolling": "touch"});
			$('#StreamScrollLeft').hide();
			$('#StreamScrollRight').hide();
		}
		if (!isiPad)
		{
			$(".StreamContainerClass").hoverIntent(function() { 
					console.log("chagne scrollers "+$(this).position().top+" "+$(window).scrollTop());
					CurrentStream = $(this);
					$("#StreamScrollLeft").css({"left":"0px","top":($(this).position().top) +"px"});
					$("#StreamScrollRight").css({"left":($(this).width()-100)+"px","top":($(this).position().top)+"px"});
			});

			$('#StreamScrollLeft').hoverIntent(function () {
				console.log('Left SCroll')
				CurrentStream.animate({
					scrollLeft: '-=246'
				}, 250, 'easeOutQuad');
			});
			$('#StreamScrollRight').hoverIntent(function () {
				console.log('ok')
				CurrentStream.animate({
					scrollLeft: '+=246'
				}, 250, 'easeOutQuad');
			});	
		}
		
		$(".ElooiBlock").hoverIntent(
			function() {
//				$(this).find(".titleblock").hide();
				$(this).find(".titleblock").animate({"left": "270px"}, "fast");
				$(this).find(".DescriptionBlock").animate({"left": "10px"}, 250);
			},
			function() {
				$(this).find(".titleblock").animate({"left": "0px"}, "fast");
				$(this).find(".DescriptionBlock").animate({"left": "-240px"}, 250);
//				$(this).find(".titleblock").show();

//test commit
			}
		);
			
			
	});
</script>

</div>
</body>

