<?php require_once("/server-settings.php"); ?>
<?php
require_once('/php-functions.php');

$log2 = new Logging();
$log2->lfile('c:/php-log-2');

$q = strtolower(urldecode($_GET["term"]));
$q = utf8_encode($q);

$log2->lwrite( "))".$q );

$q = str_replace("%u0131","ı",$q);
$q = str_replace("%u0130","i",$q);
$q = str_replace("%u011f","ğ",$q);
$q = str_replace("%u011e","ğ",$q);

if (!$q) return;

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

$xsqlCommand1 = "SELECT concat(City.Name,\", \",LocalName,\" (\",country.name,\")\") as xname FROM city JOIN Country ON city.CountryCode = Country.Code WHERE (city.name LIKE '" . AddSlashes(Trim($q)) . "%') ORDER BY city.name ASC LIMIT 5";



$mysqlresult1 = mysql_query($xsqlCommand1);
$num_rows = mysql_num_rows($mysqlresult1);

$i=0;
while ($i<$num_rows)
{
	array_push($result, array("id"=>$i, "label"=>mysql_result($mysqlresult1,$i,"xname"), "value" => strip_tags(mysql_result($mysqlresult1,$i,"xname") ) ) );
	$i++;
}

echo array_to_json($result);

?>