<?php require_once("/server-settings.php"); ?>
<?php require_once('/elooi-translation.php'); ?>
<?php 
$UserID=-200;
if ( ( ($_GET["uid"]!="") && (intval($_GET["uid"])>0) ) or ($_SESSION['uid']!="") ) { $UserID =$_GET["uid"]; }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=0.3">
        <title>Galleria Twelve Theme</title>
        <style>
            /* Demo styles */
            html,body{background:#fff;margin:0;}
            .content{color:#fff;font:12px/1.4 "helvetica neue",arial,sans-serif;width:750px;margin:0px auto;}
            a {color:#22BCB9;text-decoration:none;}
            .cred{margin-top:20px;font-size:11px;}

            /* This rule is read by Galleria to define the gallery height: */
            #galleria{height:575px;}
        </style>

        <!-- load jQuery -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

        <!-- load Galleria -->
        <script src="/twelve/galleria/galleria-1.2.5.min.js"></script>

    </head>
<body>
    <div class="content">
        <!-- Adding gallery images. We use resized thumbnails here for better performance, but it’s not necessary -->

        <div id="galleria">
			<?php
			$query = mysql_query("SELECT * FROM eloois WHERE UserID=". $UserID ." AND EchoUserID=0 AND picture<>'' and Deleted=0 ORDER BY ID DESC LIMIT 4");
			for ($x = 0; $x < mysql_num_rows($query); $x++) {  ?>
				<a href="/audio-picture/<?php echo mysql_result($query,$x,"Picture"); ?>">
				<img title="" alt="" src="/audio-picture/<?php echo mysql_result($query,$x,"Picture"); ?>">
				</a>
			<?php
			}
			?>
        </div>
    </div>
    <script>

    // Load the twelve theme
    Galleria.loadTheme('/twelve/galleria/themes/twelve/galleria.twelve.min.js');

    // Initialize Galleria
    $('#galleria').galleria({ imageCrop:false,_showFullscreen:false,_showPopout:false,maxScaleRatio:1,imagePan:true });

    </script>
    </body>
</html>