<?php require_once("/server-settings.php"); ?>
<?php

$xsqlCommand3 = "SELECT * FROM userprofiles WHERE UserID=43";
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
?>
<?php include("/ortak-header.php"); 

$sqlCommandStreams = "select streams.id,stream, count(*) as toplam from eloois 
left join streams on streamID=streams.ID
group by stream
order by toplam desc";

$sqlStreams = mysql_query($sqlCommandStreams);
$num_rows_streams = mysql_num_rows($sqlStreams);
$i = 0;
while ($i<$num_rows_streams) {
?>
	<div style="display:block; width:100%; height:34px; padding-top:5px; padding-left:10px; font-size:22px; font-weight:bold; color:black;"><?php echo mysql_result($sqlStreams,$i,"stream"); ?></div>
	
	<div style="display:block; width:100%; height:244px; overflow-x:auto; overflow-y:hidden">
		<div style="display:block; width:2440px; height:244px;">
<?php
	for ($k=0; $k<1; $k++)
	{

	$sqlCommandEloois = "SELECT eloois.*,users.firstname,users.username,users.location as ulocation,users.picture as upicture FROM eloois
	JOIN users ON eloois.userID=users.ID
	WHERE ProfileElooi = 0 AND Deleted=0 AND StreamID=". mysql_result($sqlStreams,$i,"streams.id") ." ORDER BY ElooiTime DESC LIMIT 50";
	
	$sqlEloois = mysql_query($sqlCommandEloois);
	$num_rows_eloois = mysql_num_rows($sqlEloois);
	$j = 0;
	while ($j<$num_rows_eloois) {
		$xsqlCommandArticle = "SELECT * FROM urlTable WHERE ID='" . mysql_result($sqlEloois,$j,"urlID") . "'";
		$sqlElooisArticle = mysql_query($xsqlCommandArticle);
		
		?><div id="elooi_<?php echo $arraycounter; ?>" style="font-size:12px; display:inline-block; width:244px; height:244px; overflow:hidden; border:0px; margin-right:2px; position:relative" class="elooiblock">
		
			<div style="position:absolute; left:0px; top:0px; height:212px; width:244px; z-index:1;"><img src="/slir/w244-h212-c115.100/<?php 
			if (mysql_result($sqlEloois,$j,"imageID")!="")
			{
				echo mysql_result($sqlEloois,$j,"imageID");
			} else
			{
				echo "bg/theme_default_modify.jpg";
			}?>" style="width:244px; height:212px;"/></div>
			
			<div style="position:absolute; left:0px; bottom:32px; width:244px; z-index:2; background-color: rgba(0,0,0,0.5)" class="titleblock">
				<div style="padding:5px;">
					<a href="<?php echo mysql_result($sqlElooisArticle,0,"xURL");?>" target="_blank" style="font-size:14px; line-height:20px; color:white; font-weight:bold;"><?php echo mysql_result($sqlElooisArticle,0,"xTitle");?></a>
				</div>
			</div>
			
			<div style="background-color: rgba(0,0,0,0.7); position:absolute; border-radius:5px; left:-240px; top:10px; height:172px; width:204px; padding:10px; z-index:1; overflow:hidden; color:white;" class="descriptionblock">
				<p class="ellipsisbox">
				<?php echo mysql_result($sqlEloois,$j,"Commentary");?>
				</p>
			</div>

			<div style="display:block; position:absolute; top:212px; background:#ccc; width:244px; border-bottom: 1px solid #e7e7e7; color: #777; height:32px; z-index:3;">
				<div style="width:26px; float:left; margin-top:3px; overflow:hidden; height:26px; margin-left:3px; margin-right:4px; margin-bottom:2px;"><img src="/slir/w26-h26-c1.1/<?php echo mysql_result($sqlEloois,$j,"upicture"); ?>"></div>

				<div style="display:block; margint-top:0px; font-size:11px;">
					<b><a href="/u/<?php echo mysql_result($sqlEloois,$j,"username");?>/profil" onclick="javascript:event.stopPropagation();" id="span_username_<?php echo $arraycounter; ?>" style="font-size:11px; color:#444444;"><?php echo mysql_result($sqlEloois,$j,"username");?></a></b> - <?php echo mysql_result($sqlEloois,$j,"Location"); ?></span><br><span id="span_adddate_<?php echo $arraycounter; ?>" style="color:#555555; white-space: nowrap;"><?php 
					echo datetotext( mysql_result($sqlEloois,$j,"ElooiTime") ); ?>&nbsp;&nbsp;</span>
				</div>
			
			</div>
		</div><?php
		$j++;
	}
	
	}
	?>
	
	</div>
	</div>
	
<?php
	$i++;
}
?>
<script type="text/javascript">
	function scroll_resize()
	{
		var y = $(this).scrollTop();
		$("#page").css({"height":$(window).height()-40,"overflow-y":"auto"}); 
		$("#page2").css({"top":$(window).height()-40,"position":"absolute"});
	}

	//$(window).scroll(function (event) {	scroll_resize();  });
	$(window).resize(function(){	
		$("#page").css({"height":$(window).height()-40}); 
		$("#page2").css({"top":$(window).height()-40,"position":"absolute"}); 
	});
	
	$(document).ready(function(){ 
		scroll_resize();
		
		$(".elooiblock").hover(
			function() {
//				$(this).find(".titleblock").hide();
				$(this).find(".titleblock").animate({"left": "270px"}, "fast");
				$(this).find(".descriptionblock").animate({"left": "10px"}, 250);
			},
			function() {
				$(this).find(".titleblock").animate({"left": "0px"}, "fast");
				$(this).find(".descriptionblock").animate({"left": "-240px"}, 250);
//				$(this).find(".titleblock").show();
			}
		);
			
			
	});
</script>

</div>
</body>

