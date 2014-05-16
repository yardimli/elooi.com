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
$mysqlresult2 = mysql_query("SELECT * FROM kb_categories WHERE status=1 and parentID=". mysql_result($mysqlresult,$i,"ID") ." ORDER BY OrderNumber ASC");
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

$searchq = $_POST["searchq"]."";
$searchfield = $_POST["c"]."";

if ($searchq=="") $searchq = $_GET["q"];
if ($searchfield=="") $searchfield = $_GET["c"];

$q1 = " (";
$kt=explode(" ",$searchq);//Breaking the string to array of words
// Now let us generate the sql 
while(list($key,$val)=each($kt)){
	$val2 = $val;
	$val2 = rtrim($val2,"s");

	if($val2<>" " and strlen($val2) > 0){$q1 .= " ( (topic_title like '%$val2%') OR (keywords like '%$val2%') OR (topic_text like '%$val2%') OR (kb_categories.category_name like '%$val2%') OR (kb_categories.parent_cat_name like '%$val2%') ) AND ";}
}// end of while
$q1=substr($q1,0,(strlen($q1)-4));
$q1 .= ") ";

if ($searchq=="") {$q1 =""; } else { $q1 ="(". $q1 . ") AND "; }

if ($searchfield=="") 
{
	$search_sql2 = "SELECT kb_topics.*,kb_categories.category_name,kb_categories.parentID,kb_categories.parent_cat_name FROM kb_topics ".
	" LEFT JOIN kb_categories ON categoryID=kb_categories.ID".
	" WHERE ". $q1 ." (online=1) AND (kb_categories.status=1)";
} else
{
	$search_sql2 = "SELECT kb_topics.*,kb_categories.category_name,kb_categories.parentID FROM kb_topics ".
	" LEFT JOIN kb_categories ON categoryID=kb_categories.ID".
	" WHERE ". $q1 ." (online=1) AND (kb_categories.status=1) AND (kb_categories.parentID=".$searchfield.")";
}
//	echo $search_sql2;

$mysqlresult2 = mysql_query($search_sql2);
$num_rows2 = mysql_num_rows($mysqlresult2);


?>
  <div class="knowledgebase_r_col">
  <div class="knowledgebase__address_bar"><a href="knowledgebase.php">Knowledgebase</a> &gt; Search Results for &quot;<strong><?php echo $searchq; ?></strong>&quot; (<?php echo $num_rows2; ?> Topic)</div>
      <div class="knowledgebase-main-search">
		  <form id="form1" name="form1" method="post" action="knowledgebase-searchresult.php">
			<label for="textfield"><strong>Search</strong></label>
			<input name="searchq" type="text" class="textfield" id="searchq" size="40"/ value="<?php echo $searchq; ?>">
			<label for="c"></label>
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
     <ul class="kb-searchresults">
<?php
$i2 = 0;
$result_per_page = 10;
$p= $_GET["p"];
if ($p=="") $p =1;

$total_pages = round ($num_rows2 / $result_per_page);

if ( ($total_pages * $result_per_page) < $num_rows2) $total_pages++;

$i2 = ( ( (int)$p-1) * $result_per_page);

$i4 = 0;
WHILE (($i2<$num_rows2) && ($i4<$result_per_page)) {

	$parentID=mysql_result($mysqlresult2,$i2,"parentID");
	if ($parentID=="") $parentID="0";

	$mysqlresult3 = mysql_query("SELECT * FROM kb_categories WHERE ID=".$parentID);
	$num_rows3 = mysql_num_rows($mysqlresult3);
	$parentCatName  = "";
	if ($num_rows3==1 ) { $parentCatName = mysql_result($mysqlresult3,0,"category_name"); }
	$i = 0;
	?>

		 <li><span class="topic"><a href="knowledgebase_view_topic.php?id=<?php echo mysql_result($mysqlresult2,$i2,"id"); ?>&categoryID=<?php echo mysql_result($mysqlresult2,$i2,"categoryID"); ?>"><?php echo mysql_result($mysqlresult2,$i2,"topic_title"); ?></a></span><br />
         <span class="category"><?php echo $parentCatName; ?> > <?php echo mysql_result($mysqlresult2,$i2,"category_name"); ?></span></li>
	<?php
	$i2++;
	$i4++;
}
?>

       </ul>
    
      
<?php if ($total_pages>=1) { ?>      
    <table border="0" cellpadding="0" cellspacing="0" class="kb-searchresults-pager">
       <tr>
         <td align="left" class="inactive"><?php if ((int)$p>1) { ?><a href="knowledgebase-searchresult.php?p=<?php echo (int)$p - 1; ?>&f=<?php echo $f; ?>&q=<?php echo $searchq; ?>"><?php } ?>prev</a></td>
         <td align="center" style="letter-spacing:0.4em">
		 
<?php
		 $i4 = 1;
WHILE (($i4<=$total_pages)) {

	if ($i4==(int)$p)
	{
?>
		 <strong><?php echo $i4; ?></strong> 
<?php } else { ?><a href="knowledgebase-searchresult.php?p=<?php echo $i4; ?>&f=<?php echo $f; ?>&q=<?php echo $searchq; ?>"><?php echo $i4; ?></a>
<?php
}
	$i4++;
}
	?>		 
		 </td>
         <td align="right" class="inactive"><?php if ((int)$p<$total_pages) { ?><a href="knowledgebase-searchresult.php?p=<?php echo (int)$p + 1; ?>&f=<?php echo $f; ?>&q=<?php echo $searchq; ?>"><?php } ?>next</a></td>
       </tr>
    </table>
<?php
}	
	?>
    <br /><br />

  </div>
  <br /><br /><div class="clear"></div>
</div>
</div>
<?php include("../fotter.php"); ?>
</body>
</html>
