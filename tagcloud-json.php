<?php  
  
mysql_connect("208.109.97.91","root","Mantik77"); //B123456a
mysql_select_db("cloudofvoice");
$mysqlresult = mysql_query("SET NAMES utf8");
$mysqlresult = mysql_query("SET CHARACTER_SET utf8");
  
  //query the database  
  $query = mysql_query("SELECT * FROM alltags");  
  
  //start json object  
  $json = "({ tags:[";   
  
  //loop through and return results  
  for ($x = 0; $x < mysql_num_rows($query); $x++) {  
	$row = mysql_fetch_assoc($query);  
  
	//continue json object  
	$json .= "{tag:'" . $row["tag"] . "',freq:'" . $row["tagCount"] . "'}";  
  
	//add comma if not last row, closing brackets if is  
	if ($x < mysql_num_rows($query) -1)  
	  $json .= ",";  
	else  
	  $json .= "]})";  
  }  
  
  //return JSON with GET for JSONP callback  
  $response = $_GET["callback"] . $json;  
  echo $response;  
?>  