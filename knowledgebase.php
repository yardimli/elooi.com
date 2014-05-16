<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Spectrasonics - Knowledgebase</title>
<link href="../css/knowledgebase.css" rel="stylesheet" type="text/css" />
<link href="../css/support.css" rel="stylesheet" type="text/css" />
<link href="../css/styles1.css" rel="stylesheet" type="text/css" />

</head>
<body>
<!-- Header Area -->
<?php include("../settings.php"); ?>
<?php include("../top_menu.php"); ?>

<link href="../css/mktree.css" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript" SRC="../js/mktree.js"></SCRIPT>


<!-- Content Area -->
<?php 
$aParentID  = "0";
$showcatID = $_GET["showcatID"];

if ($showcatID!="")
{
	$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE id='". AddSlashes(Trim($_GET["showcatID"])) ."'");
	$num_rows2 = mysql_num_rows($mysqlresult);

	if ($num_rows2==0)
	{
		$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE ParentID=0 ORDER BY OrderNumber ASC LIMIT 1");
		$aParentID  = mysql_result($mysqlresult,0,"ID");

		$mysqlresult2 = mysql_query("SELECT * FROM kb_categories WHERE ParentID=".mysql_result($mysqlresult,0,"ID")." ORDER BY OrderNumber ASC LIMIT 1");
		$showcatID = mysql_result($mysqlresult2,0,"ID");
	} else
	{
		$aParentID  = mysql_result($mysqlresult,0,"parentID");
	}
} else
{
	$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE ParentID=0 ORDER BY OrderNumber ASC LIMIT 1");
	$aParentID  = mysql_result($mysqlresult,0,"ID");
	$mysqlresult2 = mysql_query("SELECT * FROM kb_categories WHERE ParentID=".mysql_result($mysqlresult,0,"ID")." ORDER BY OrderNumber ASC LIMIT 1");
	$showcatID = mysql_result($mysqlresult2,0,"ID");

}

$mysqlresult3 = mysql_query("SELECT * FROM kb_topics WHERE categoryID='". AddSlashes(Trim($showcatID)) ."' ORDER BY OrderNumber ASC");
$num_rows3 = mysql_num_rows($mysqlresult3);
if ($num_rows3==1)
{

	header("Location: http://" . $server_domain ."/support/knowledgebase_view_topic.php?id=". mysql_result($mysqlresult3,$i3,"id")."&categoryID=". $showcatID ) ;
//	echo "Location: http://" . $server_domain ."/support/knowledgebase_view_topic.php?id=". mysql_result($mysqlresult3,$i3,"id")."&categoryID=". $showcatID ;
	exit();
}
?>

<div class="container-support">
 <div class="knowledgebase_header"><a href="knowledgebase.php">Knowledgebase</a></div>
  <div class="knowledgebase_l_col">
    <ul class="mktree" id="tree1">
<?php
if(!isset($_SESSION['firstname']) ){
	$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE parentID=0 and Status=1 and ( (category_name = 'General') OR (category_name = 'Licensing') ) ORDER BY OrderNumber ASC");
}else
{
$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE parentID=0 and Status=1 ORDER BY OrderNumber ASC");
}
$num_rows = mysql_num_rows($mysqlresult);
$i = 0;
WHILE ($i<$num_rows) {
	?>

      <li <?php if ($aParentID==mysql_result($mysqlresult,$i,"ID")) { echo "class=\"liOpen\""; } ?>><?php echo mysql_result($mysqlresult,$i,"category_name"); ?>
<ul>
<?php
$mysqlresult2 = mysql_query("SELECT * FROM kb_categories WHERE status=1 AND parentID=". mysql_result($mysqlresult,$i,"ID") ." ORDER BY OrderNumber ASC");
$num_rows2 = mysql_num_rows($mysqlresult2);
$i2 = 0;
WHILE ($i2<$num_rows2) {
	?>
          <li><?php if (mysql_result($mysqlresult2,$i2,"ID")==$showcatID) {?><img src="graphics/arrow-selected.gif" width="13" height="16" alt="arrow" /><?php } ?><a href="knowledgebase.php?showcatID=<?php echo mysql_result($mysqlresult2,$i2,"ID"); ?>"><?php echo mysql_result($mysqlresult2,$i2,"category_name"); ?></a></li>
	<?php
	$i2++;
}
?>
        </ul>
      </li>
	<?php
	$i++;
}
?>
    </ul>
  </div>

<?php
	$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE id='". AddSlashes(Trim($showcatID)) ."'");

	$category_name  = mysql_result($mysqlresult,0,"category_name");
	$categoryID     = mysql_result($mysqlresult,0,"id");
	$Status	        = mysql_result($mysqlresult,0,"Status");

	$mysqlresult2 = mysql_query("SELECT * FROM kb_categories WHERE id='". mysql_result($mysqlresult,0,"ParentID") ."'");
	$category_name2  = mysql_result($mysqlresult2,0,"category_name");
	$categoryID2     = mysql_result($mysqlresult2,0,"id");


?>
  <div class="knowledgebase_r_col">
<div class="knowledgebase__address_bar"><a href="knowledgebase.php">Knowledgebase</a> &gt; <a href="knowledgebase.php?showcatID=<?php echo $showcatID; ?>"><?php echo $category_name2; ?></a> &gt; <?php echo $category_name; ?></div>
<div class="knowledgebase-main-search">
  <form id="form1" name="form1" method="post" action="knowledgebase-searchresult.php">
    <label for="textfield"><strong>Search</strong></label>
    <input name="searchq" type="text" class="textfield" id="searchq" size="40"/>
    <label for="select"></label>
    <select name="c" id="c" class="dropfield">
<?php
if(!isset($_SESSION['firstname']) ){
	$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE parentID=0 and Status=1 and ( (category_name = 'General') OR (category_name = 'Licensing') ) ORDER BY OrderNumber ASC");
}else
{
echo "      <option value=\"\">All</option>";
$mysqlresult = mysql_query("SELECT * FROM kb_categories WHERE parentID=0 and Status=1 ORDER BY OrderNumber ASC");
}

$num_rows = mysql_num_rows($mysqlresult);
$i = 0;
WHILE ($i<$num_rows) {
	?>
      <option value="<?php echo mysql_result($mysqlresult,$i,"ID"); ?>" <?php if ( ($aParentID==mysql_result($mysqlresult,$i,"ID")) && ($_GET["showcatID"]!="") ) { echo " SELECTED "; } ?>><?php echo mysql_result($mysqlresult,$i,"category_name"); ?></option>
	<?php
	$i++;
}
?>
    </select>
    <input type="submit" name="Search" id="Search" value="Find" />
  </form>
</div>
<h1><?php echo $category_name; ?></h1>
      <ul class="topiclist">
	  <?php 
		$mysqlresult3 = mysql_query("SELECT * FROM kb_topics WHERE online=1 and categoryID='". AddSlashes(Trim($categoryID)) ."' ORDER BY OrderNumber ASC");
		$num_rows3 = mysql_num_rows($mysqlresult3);
		$i3 = 0;
		WHILE ($i3<$num_rows3) {
			?>
				<li><a href="knowledgebase_view_topic.php?id=<?php echo mysql_result($mysqlresult3,$i3,"id"); ?>&categoryID=<?php echo $categoryID; ?>"><?php echo mysql_result($mysqlresult3,$i3,"topic_title"); ?></a></li>
			<?php
			$i3++;
		}
		?>
    </ul>
      
      <h2><br /><br />
  </h2>
  </div>
  <br /><br /><div class="clear"></div>
</div>

<?php include("../fotter.php"); ?>

</body>
</html>
