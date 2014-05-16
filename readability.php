<?php
require_once '/read2/Readability.php';
//header('Content-Type: text/plain; charset=utf-8');

// get latest Medialens alert 
// (change this URL to whatever you'd like to test)
$url = 'http://modernistcuisine.com/2013/01/why-cook-sous-vide/';
$html = file_get_contents($url);

// Note: PHP Readability expects UTF-8 encoded content.
// If your content is not UTF-8 encoded, convert it 
// first before passing it to PHP Readability. 
// Both iconv() and mb_convert_encoding() can do this.

// If we've got Tidy, let's clean up input.
// This step is highly recommended - PHP's default HTML parser
// often doesn't do a great job and results in strange output.
if (function_exists('tidy_parse_string')) {
	$tidy = tidy_parse_string($html, array(), 'UTF8');
	$tidy->cleanRepair();
	$html = $tidy->value;
}

// give it to Readability
$readability = new Readability($html, $url);
// print debug output? 
// useful to compare against Arc90's original JS version - 
// simply click the bookmarklet with FireBug's console window open
$readability->debug = false;
// convert links to footnotes?
$readability->convertLinksToFootnotes = false;
// process it
$result = $readability->init();
// does it look like we found what we wanted?
if ($result) {
	echo "<h2>";
	echo $readability->getTitle()->textContent, "\n\n";
	echo "</h2>";
	
	$content = $readability->getContent()->innerHTML;
	
	// if we've got Tidy, let's clean it up for output
	if (function_exists('tidy_parse_string')) {
		$tidy = tidy_parse_string($content, array('indent'=>true, 'show-body-only' => true), 'UTF8');
		$tidy->cleanRepair();
		$content = $tidy->value;
	}
	
	$dom = new domDocument;

	/*** load the html into the object ***/
	 $contentPrefix = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html><head><title>..</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
		$contentSuffix = '</body></html>';	
		
	$dom->loadHTML($contentPrefix.$content.$contentSuffix);

	/*** discard white space ***/
	$dom->preserveWhiteSpace = false;

	$counter1 = 0;
	foreach($dom->getElementsByTagName('img') as $img)
		{
			$url = $img->getAttribute('src');	
			$alt = $img->getAttribute('alt');	
//			echo "Title: $alt<br>$url<br>";
			$counter1++;

			$ext = pathinfo($url, PATHINFO_EXTENSION);
			if (strpos($ext,'?') !== false) {
				$ext2 = explode("?",$ext);
				$ext = $ext2[0];
			}

			file_put_contents( dirname(__FILE__) . "\\aimagecache\\testimage-".$counter1 . "." . $ext, file_get_contents( $url ) );

			$img->setAttribute('class', 'imageinextract');
			$img->setAttribute('style', 'display:block; margin:5px auto; border:1px solid #999; ');
			$img->setAttribute('src', '/aimagecache/testimage-'.$counter1.'.'.$ext);
			
		}	
		
//	echo $dom->saveHTML();
	echo $content;
		
		
} else {
	echo 'Looks like we couldn\'t find the content. :(';
} 