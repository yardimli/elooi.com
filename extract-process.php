<?php       
	require_once '/read2/Readability.php';
	include_once("include/simple_html_dom.inc.php");

	function file_url($url){
	  $parts = parse_url($url);
	  $path_parts = array_map('rawurldecode', explode('/', $parts['path']));

	  return
		$parts['scheme'] . '://' .
		$parts['host'] .
		implode('/', array_map('rawurlencode', $path_parts))
	  ;
	}	
	
	mysql_pconnect("localhost","root","Mantik77"); //B123456a
	mysql_select_db("cloudofvoice");
	$mysqlresult = mysql_query("SET NAMES utf8");
	$mysqlresult = mysql_query("SET CHARACTER_SET utf8");

	$get_url = $_POST["url"]; 
	
	if ($get_url=="")
	{
		$get_url = $_GET["url"]; 
	}
	
	if ($get_url=="")
	{
		$get_url = "http://techcrunch.com/2014/04/14/sportsetter/";
	}

	if(is_numeric($get_url)){
		$xsqlCommand = "SELECT * FROM urlTable WHERE id='" . mysql_real_escape_string($get_url) . "'";
		$mysqlresult = mysql_query($xsqlCommand);
		$num_rows = mysql_num_rows($mysqlresult);
		if ($num_rows==1)
		{
			$get_url = mysql_result($mysqlresult,0,"xURL");
		}
	}
		

	//load or save url
	$xsqlCommand = "SELECT * FROM urlTable WHERE xURL='" . mysql_real_escape_string($get_url) . "'";
	$mysqlresult = mysql_query($xsqlCommand);
	$num_rows = mysql_num_rows($mysqlresult);
	if ($num_rows==1)
	{
		$xid = mysql_result($mysqlresult,0,"ID");
		
		$page_title = mysql_result($mysqlresult,0,"xTitle");
		$page_body = mysql_result($mysqlresult,0,"xDescription");
		
		if (file_exists( dirname(__FILE__) . "\\aimagecache\\" . $xid . ".html" )) {
			$get_content = file_get_html( dirname(__FILE__) . "\\aimagecache\\" . $xid . ".html" );
		} else
		{
			//get URL content
			$get_content = file_get_html($get_url); 

			file_put_contents( dirname(__FILE__) . "\\aimagecache\\" . $xid . ".html", $get_content );
		}
	} else
	{
		$xsqlCommand = "INSERT INTO urlTable (xURL) VALUES ('" . mysql_real_escape_string($get_url) . "')";
		$mysqlresult = mysql_query($xsqlCommand);
		
		$xsqlCommand = "SELECT * FROM urlTable WHERE xURL='" . mysql_real_escape_string($get_url) . "'";
		$mysqlresult = mysql_query($xsqlCommand);
		$xid = mysql_result($mysqlresult,0,"ID");
	
		//get URL content
		$get_content = file_get_html($get_url); 

		file_put_contents( dirname(__FILE__) . "\\aimagecache\\" . $xid . ".html", $get_content );
	}
	
	//parse and save first version title and description
	$page_title = "";

	if ($get_content->find('meta[property=og:title]'))
	{
		$e = $get_content->find('meta[property=og:title]')[0];
		$page_title = $e->attr['content'];
	}
	
	if ($page_title == "")
	{
		//Get Page Title 
		foreach($get_content->find('title') as $element) 
		{
			$page_title = $element->plaintext;
		}
	}
	
	$page_body ="";
	
	if ( ($get_content->find('meta[name=twitter:description]')) && ($page_body==""))
	{
		$e = $get_content->find('meta[name=twitter:description]')[0];
		$page_body = $e->attr['content'];
	}
	
	if ( ($get_content->find('meta[property=og:description]')) && ($page_body==""))
	{
		$e = $get_content->find('meta[property=og:description]')[0];
		$page_body = $e->attr['content'];
	}
	
	if ( ($get_content->find('meta[name=description]')) && ($page_body==""))
	{
		$e = $get_content->find('meta[name=description]')[0];
		$page_body = $e->attr['content'];
	}

	if ( ($get_content->find('meta[name=Description]')) && ($page_body==""))
	{
		$e = $get_content->find('meta[name=Description]')[0];
		$page_body = $e->attr['content'];
	}

	if ($page_body=="")
	{
		//Get Body Text
		foreach($get_content->find('body') as $element) 
		{
			$page_body = trim($element->plaintext);
			$pos=strpos($page_body, ' ', 200); //Find the numeric position to substract
			$page_body = substr($page_body,0,$pos ); //shorten text to 200 chars
		}
	}
	
	$xsqlCommand = "UPDATE urlTable SET xTitle='" . mysql_real_escape_string($page_title) . "', xDescription='" . mysql_real_escape_string($page_body) . "' WHERE ID=".$xid;
	$mysqlresult = mysql_query($xsqlCommand);

	//get first image
	$image_urls = array();
	$image_urls2 = array();
	$counter=0;
	
	$firstimage=false;
	if ( ($get_content->find('meta[property=og:image]')) && (!$firstimage))
	{
		$e = $get_content->find('meta[property=og:image]')[0];
		$counter++;
		$image_urls[] = $e->attr['content'];
	}
	
	if ( ($get_content->find('meta[itemprop=image]')) && (!$firstimage))
	{
		$e = $get_content->find('meta[itemprop=image]')[0];
		$counter++;
		$image_urls[] = $e->attr['content'];
	}
	
	if ( ($get_content->find('meta[property=twitter:image]')) && (!$firstimage))
	{
		$e = $get_content->find('meta[property=twitter:image]')[0];
		$counter++;
		$image_urls[] = $e->attr['content'];
	}


	//use reatability to get html
	$html = $get_content;
	if (function_exists('tidy_parse_string')) {
		$tidy = tidy_parse_string($html, array(), 'UTF8');
		$tidy->cleanRepair();
		$html = $tidy->value;
	}
	
//	header('Content-Type: text/plain; charset=utf-8');
//	echo $html;
	
	$readability = new Readability($html, $get_url);
	$readability->debug = false;
	$readability->convertLinksToFootnotes = false;
	$result = $readability->init();
	$xtitle2 = "";
	$xdocument = "";
	//echo "----".$result;
	
	if (!$result) {
		$html = $get_content;
		$readability = new Readability($html, $get_url);
		$readability->debug = false;
		$readability->convertLinksToFootnotes = false;
		$result = $readability->init();
		$xtitle2 = "";
		$xdocument = "";
		
		if (!$result) {
			require '/read/lib/Readability.inc.php';
			$Readability2     = new Readability2($html, "utf-8"); // default charset is utf-8
			$ReadabilityData2 = $Readability2->getContent();

			$title   = $ReadabilityData2['title'];
			$content = $ReadabilityData2['content'];
			$result=true;
		}
		
	}
	
	if ($result) {
		$xtitle2 = $readability->getTitle()->textContent;
		$xdocument = $readability->getContent()->innerHTML;
		if (function_exists('tidy_parse_string')) {
			$tidy = tidy_parse_string($xdocument, array('indent'=>true, 'show-body-only' => true), 'UTF8');
			$tidy->cleanRepair();
			$xdocument = $tidy->value;
		}
		
		$dom = new domDocument;

		$contentPrefix = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html><head><title>..</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
		$contentSuffix = '</body></html>';	
		
		// modify state
		$libxml_previous_state = libxml_use_internal_errors(true);	
		
		$dom->loadHTML($contentPrefix.$xdocument.$contentSuffix);
		
		// handle errors
		libxml_clear_errors();
		// restore
		libxml_use_internal_errors($libxml_previous_state);

		/*** discard white space ***/
		$dom->preserveWhiteSpace = false;

		foreach($dom->getElementsByTagName('img') as $img)
		{
			$url = $img->getAttribute('src');	
			$alt = $img->getAttribute('alt');	
//			echo "Title: $alt<br>$url<br>";
			$counter1++;
			$image_urls[] = $url;
			
			$ext = pathinfo($url, PATHINFO_EXTENSION);
			
			if (strpos($ext,'?') !== false) {
				$ext2 = explode("?",$ext);
				$ext = $ext2[0];
			}
			
			$img->setAttribute('class', 'imageinextract');
			$img->setAttribute('style', 'display:block; margin:5px auto; border:1px solid #999; ');
			$img->setAttribute('src', '/aimagecache/'.$xid.'-'.$counter1.'.'.$ext);
		}
		
		$xbody = $dom->saveHTML();
		$xbody = strstr($xbody,'<body>');
		$xbody = str_replace("<body>","",$xbody);
		$xbody = str_replace($contentSuffix,"",$xbody);

		$xsqlCommand = "UPDATE urlTable SET xTitle2='" . mysql_real_escape_string( $xtitle2 ) . "', xDocument='" . mysql_real_escape_string( $xbody ) . "' WHERE ID=".$xid;
	$mysqlresult = mysql_query($xsqlCommand);
	}
	
	if (count($image_urls)==0)
	{
		//echo "no image";
		foreach($get_content->find('img') as $element) {
			//echo $element->src, "\n";
			$counter1++;
			$image_urls[] = $element->src;
			
	}

	}
	
	//loop through the images if size is less than 200x200 dont suggest it
	for ($i=0; $i<count($image_urls); $i++)
	{
		
		//echo "<br>".$image_urls[$i]." ".$i." ".$xid;
		
		$ext = pathinfo($image_urls[$i], PATHINFO_EXTENSION);
		
		if (strpos($ext,'?') !== false) {
			$ext2 = explode("?",$ext);
			$ext = $ext2[0];
		}
		if ($ext=="") { $ext = "png"; }
		
		if (file_exists( dirname(__FILE__) . "\\aimagecache\\" . $xid ."-".($i+1) . "." . $ext )) {
			//echo "found";
			//$get_content = file_get_html( dirname(__FILE__) . "\\aimagecache\\" . $xid . ".html" );
		} else
		{
			if ( (!stristr($image_urls[$i],'http://')) &&  (!stristr($image_urls[$i],'https://'))) { 
				
				$parse = parse_url($get_url);
				
				$image_urls[$i] = "http://".$parse['host']."/".$image_urls[$i]; 
			} else
			if ( (!stristr($image_urls[$i],'http:')) && (!stristr($image_urls[$i],'https:'))) { 
				$image_urls[$i] = "http:".$image_urls[$i]; 
			}
			
			if (stristr($image_urls[$i],' ')) { $image_urls[$i] = file_url($image_urls[$i]); }
			
			//echo  "- ".$image_urls[$i]."<br>";

			// modify state
			$libxml_previous_state = libxml_use_internal_errors(true);	

			@file_put_contents( dirname(__FILE__) . "\\aimagecache\\" . $xid ."-". ($i+1) . "." . $ext, file_get_contents( $image_urls[$i] ) );
			
			// handle errors
			libxml_clear_errors();
			// restore
			libxml_use_internal_errors($libxml_previous_state);

			
		}
	
		try {
			list($width, $height, $type, $attr) = @getimagesize( dirname(__FILE__) . "\\aimagecache\\" . $xid ."-". ($i+1) . "." . $ext );
			
			//echo $width."x".$height;
			
			if ( ($width>=100) && ($height>=100) && ( ($type==1) || ($type==2) || ($type==3) ) )
			{
				$image_urls2[] = "aimagecache/" . $xid ."-". ($i+1) . "." . $ext;
			}
		}
		catch (ErrorException $e) { }
	}
	
	if ($xtitle2!="") { $page_title = $xtitle2; }
	
	//prepare for JSON 
	$output = array('urlID'=>$xid,'title'=>$page_title, 'images'=>$image_urls2, 'content'=> $page_body);
	echo json_encode($output); //output JSON data
?>