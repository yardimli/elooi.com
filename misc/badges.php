<?php $page="badges"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>

<div class="banner2" style="width:750px;" id="bannerx">
<h2><?php echo $Header_Badges; ?></h2>
</div>

<div class="content-main " style="width:728px; background: rgba(255, 255, 255, 0.75);" id="maincontentx">

<br>

<table>
<tbody>

<?php 

$q1 = mysql_query("SELECT * FROM badges WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']);
$num_rows = mysql_num_rows($q1);
for ($i=0; $i<$num_rows; $i++) {
?>

<tr><td class="check-cell"></td>
<td class="badge-cell"><a class="badge" title="<?php 
	if (mysql_result($q1,$i,"badgeValue")=="1") { echo "bronze badge"; }
	if (mysql_result($q1,$i,"badgeValue")=="2") { echo "silver badge"; }
	if (mysql_result($q1,$i,"badgeValue")=="3") { echo "gold badge"; }

?>: <?php echo strip_tags(mysql_result($q1,$i,"badgeText")); ?>" href="#"><span class="<?php 
	if (mysql_result($q1,$i,"badgeValue")=="1") { echo "badge3"; }
	if (mysql_result($q1,$i,"badgeValue")=="2") { echo "badge2"; }
	if (mysql_result($q1,$i,"badgeValue")=="3") { echo "badge1"; }

?>"></span>&nbsp;<?php echo mysql_result($q1,$i,"badgeName"); ?></a><span class="item-multiplier">×&nbsp;<?php
$q2 = mysql_query("SELECT count(*) FROM userbadges WHERE badgeID=".mysql_result($q1,$i,"badgeID") );
echo mysql_result($q2,0,0);

?></span>
</td><td class="item-description"><?php echo mysql_result($q1,$i,"badgeText"); ?></td></tr>

<?php
} ?>

</tbody></table>

<div style="clear: both;"></div>
</div>


<script type="text/javascript">
jQuery(document).ready(function(){ 
	setBackgroundValues("no-repeat","#DDF3FC","/bg/theme_default_modify.jpg","", "#272323", "#000000", "#333333","#B2BDCD");
});
</script>

<?php include("/ortak-fotter.php"); ?>


<div class="badges-section" id="side-section-div" style="top:100px; " >

<div id="badges-legend-module" class="module">
        <h4 id="h-legend"><?php echo $Legend_Badges; ?></h4>

        <div id="badge-legend">
            <a class="badge" title="gold badge: awarded rarely" href="/badges?tab=general&amp;filter=gold"><span class="badge1"></span>&nbsp;<?php echo $Badges_Gold; ?></a>
			<div style="padding-top:7px; padding-bottom:17px;"><?php echo $Badges_Gold_Text; ?></div>
            
            <a class="badge" title="silver badge: awarded occasionally" href="/badges?tab=general&amp;filter=silver"><span class="badge2"></span>&nbsp;<?php echo $Badges_Silver; ?></a>
            <div style="padding-top:7px; padding-bottom:17px;"><?php echo $Badges_Silver_Text; ?></div>

            <a class="badge" title="bronze badge: awarded frequently" href="/badges?tab=general&amp;filter=bronze"><span class="badge3"></span>&nbsp;<?php echo $Badges_Bronze; ?></a>
            <div style="padding-top:7px; padding-bottom:17px;"><?php echo $Badges_Bronze_Text; ?></div>
        </div>
    </div>

</div>

<script type="text/javascript">

jQuery("#side-section-div").css({"top":jQuery("#bannerx").position().top });
jQuery("#side-section-div").css({"left":jQuery("#maincontentx").position().left+$("#maincontentx").width()+ 50 });

</script>
