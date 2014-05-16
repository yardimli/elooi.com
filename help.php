<?php $page="help"; ?>
<?php require_once("/server-settings.php"); ?>
<?php include("/ortak-header.php"); ?>

 <style>

.right-image-about {
	float:right;
    padding-top: 24px !important;
}

.right-image {
	float:right;
    padding-top: 0px !important;
}

ol {
	list-style: decimal inside;
    padding-left: 20px;
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


.sections2-div{
    color: #333333 !important;
    font-size: 13px;
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
 
 
 
 

<?php
	$showcatID = $_GET["catid"];
	if ($showcatID=="") { 
		$category_name2 = "Topic";
//		$showcatID = "76"; 
	} else
	{
		$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']." AND Status=1 AND id=". ATQ($showcatID) );
		$num_rows = mysql_num_rows($mysqlresult);
		if (mysql_result($mysqlresult,0,"ParentID")=="0")
		{
			$ParentID = $showcatID;

			$category_name2  = mysql_result($mysqlresult,0,"category_name");
			$categoryID2     = mysql_result($mysqlresult,0,"id");

			$mysqlresult2 = mysql_query("SELECT * FROM kb_categories WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']." AND parentID=". ATQ($showcatID) . " AND Status=1 ORDER BY OrderNumber ASC" );
			$num_rows2 = mysql_num_rows($mysqlresult2);

			$category_name  = mysql_result($mysqlresult2,0,"category_name");
			$categoryID     = mysql_result($mysqlresult2,0,"id");
			$showcatID = mysql_result($mysqlresult2,0,"id");

		} else
		{
			$category_name  = mysql_result($mysqlresult,0,"category_name");
			$categoryID     = mysql_result($mysqlresult,0,"id");

			$ParentID = mysql_result($mysqlresult,0,"ParentID");

			$mysqlresult2 = mysql_query("SELECT * FROM kb_categories WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']." AND id='". mysql_result($mysqlresult,0,"ParentID") ."' AND Status=1 ");
			$category_name2  = mysql_result($mysqlresult2,0,"category_name");
			$categoryID2     = mysql_result($mysqlresult2,0,"id");
		}
	}

?>

<div class="banner2" style="width:750px;" id="bannerx">
<div style="font-size:17px; color:white; font-weight:bold; padding:12px"><a href="help.php" style="color:white">Help</a> <?php 	if ($showcatID!="") { 
?> &gt; <a href="help.php?showcatID=<?php echo $showcatID; ?>"  style="color:white"><?php echo $category_name2; ?></a> <?php if ($category_name!="") { ?>&gt; <?php echo $category_name; ?><?php } } ?></div>
</div>

<div class="content-main " style="width:728px; 
   padding: 20px; 
   background: none repeat scroll 0 0 #FFFFFF;
    border-radius: 0px 0px 5px 5px;
    box-shadow: 0 1px 3px #A8CFE5;
	background: rgba(255, 255, 255, 0.95);" id="maincontentx">



<?php
	if ($showcatID=="") { 

$catq = mysql_query("SELECT * FROM kb_categories WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']." AND ParentID=0 ORDER BY OrderNumber ASC");
$catn = mysql_num_rows($catq);
for ($i=0; $i<$catn; $i++) { 
	?>
	<div class="header3"><?php echo mysql_result($catq,$i,"category_name"); ?></div>
<div style="line-height:1.6em">
<?php
	$catq2 = mysql_query("SELECT * FROM kb_categories WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']." AND ParentID=".mysql_result($catq,$i,"id")." AND Status=1 ORDER BY OrderNumber ASC");
	$catn2 = mysql_num_rows($catq2);
	for ($i2=0; $i2<$catn2; $i2++) { 
	?>
	&nbsp;&nbsp;<a href="?catid=<?php echo mysql_result($catq2,$i2,"id"); ?>"><?php echo mysql_result($catq2,$i2,"category_name"); ?></a><br>
	<?php
	}
?>
<br>
<br>
</div>
<?php
}

} else
{
		$mysqlresult3 = mysql_query("SELECT * FROM kb_topics WHERE categoryID=". ATQ($showcatID) . " AND Online=1 ORDER BY OrderNumber ASC ");
		$num_rows3 = mysql_num_rows($mysqlresult3);
		if ($num_rows3>0) {
	?>
		 <div class="header3"><?php echo mysql_result($mysqlresult3,0,"topic_title"); ?></div>
	<br>
	 <style>

 h2 {
    font-size: 16px;
    margin-bottom: 5px;
	font-weight:bold;

}

 h3 {
    font-size: 14px;
    margin-bottom: 5px;
	font-weight:bold;
}

</style>
		 <div class="sections2-div"><?php echo mysql_result($mysqlresult3,0,"topic_text"); ?></div>


		 <div class="header3">Othes topics in this category</div>
		 <div class="sections2-div">
	<?php
		}	


	$catq = mysql_query("SELECT * FROM kb_categories WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']." AND ParentID=".$ParentID." AND Status=1 ORDER BY OrderNumber ASC");
	$catn = mysql_num_rows($catq);
	for ($i=0; $i<$catn; $i++) { 
		if (mysql_result($catq,$i,"id") == $showcatID) { echo "<b>"; }
		?>
	<a href="?catid=<?php echo mysql_result($catq,$i,"id"); ?>"><?php echo mysql_result($catq,$i,"category_name"); ?></a><br>
	<?php
		if (mysql_result($catq,$i,"id") == $showcatID) { echo "</b>"; }
	}
}
?>
	</div>

</div>


<div class="badges-section" id="side-section-div" style="top:100px;    padding: 20px; 
   background: none repeat scroll 0 0 #FFFFFF;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 0 1px 3px #A8CFE5;
	background: rgba(255, 255, 255, 0.95);" >


<div class="header3">Help Categories</div>
<div style="line-height:1.6em">
<?php
$catq = mysql_query("SELECT * FROM kb_categories WHERE LanguageID=".$_SESSION['Elooi_ILanguageID']." AND ParentID=0 ORDER BY OrderNumber ASC");
$catn = mysql_num_rows($catq);
for ($i=0; $i<$catn; $i++) { 
	if (mysql_result($catq,$i,"id") == $ParentID) { echo "<b>"; }
	?>
<a href="?catid=<?php echo mysql_result($catq,$i,"id"); ?>"><?php echo mysql_result($catq,$i,"category_name"); ?></a><br>
<?php
	if (mysql_result($catq,$i,"id") == $ParentID) { echo "</b>"; }
}
?>
</div>

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