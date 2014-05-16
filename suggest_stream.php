<?php

if ( !isset($_REQUEST['term']) )
    exit;

require_once("/server-settings.php");

$rs = mysql_query('select * from streams where stream like "%'. mysql_real_escape_string($_REQUEST['term']) .'%" order by stream asc limit 10');

$data = array();
if ( $rs && mysql_num_rows($rs) )
{
    while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
    {
        $data[] = array(
            'label' => $row['stream'] ,
            'color' => $row['color'] ,
            'value' => $row['id']
        );
    }
}

echo json_encode($data);
flush();

