<?php
sleep(2);

$q = strtolower($_GET["term"]);
if (!$q) return;

$items = array(
"Heuglin's Gull"=>"Larus heuglini"
);

function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "\"".addslashes($key)."\"";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}

$result = array();

mysql_connect("208.109.97.91","root","Mantik77"); //B123456a
mysql_select_db("cloudofvoice");
$mysqlresult = mysql_query("SET NAMES utf8");
$mysqlresult = mysql_query("SET CHARACTER_SET utf8");

$xsqlCommand1 = "SELECT DISTINCT name FROM places WHERE name LIKE '".AddSlashes(Trim($q))."%' ORDER BY name ASC LIMIT 5";
$mysqlresult1 = mysql_query($xsqlCommand1);
$num_rows = mysql_num_rows($mysqlresult1);

$i=0;
while ($i<$num_rows)
{
	array_push($result, array("id"=>$i, "label"=>mysql_result($mysqlresult1,$i,"name"), "value" => strip_tags(mysql_result($mysqlresult1,$i,"name") ) ) );
	$i++;
}

echo array_to_json($result);

?>