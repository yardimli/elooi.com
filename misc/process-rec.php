<?php require_once("/server-settings.php"); ?>
<?php include("/check-user-login.php"); ?>
<?php include("/php-functions.php"); ?>
<?php

$input_file = addslashes($_GET["n"]);

if (stripos($input_file,".flv")!==false)
{
	$input_file_name = str_ireplace(".flv","-flv",$input_file);

	//-- -- conver to wav
	$commandx = "c:\\wamp\\www\\ffmpeg\\ffmpeg -i \"c:\\Program Files\\Wowza Media Systems\\Wowza Media Server 2.2.4\\content\\".$input_file."\" -y -t 00:01:00 -ac 1 -ar 44100 \"c:\\wamp\\www\\audio-temp\\".$input_file_name.".wav\"";
	session_write_close();
	$output = shell_exec($commandx);

	//-- -- normalize with sox addd  -c 2 for stereo
	$commandx = "c:\\sox-14-3-2\\sox \"c:\\wamp\\www\\audio-temp\\".$input_file_name.".wav\" \"c:\\wamp\\www\\audio-temp\\".$input_file_name."-normal.wav\" remix - highpass 100 norm compand 0.05,0.2 6:-54,-90,-36,-36,-24,-24,0,-12 0 -90 0.1 vad -T 0.6 -p 0.2 -t 5 fade 0.1 reverse vad -T 0.6 -p 0.2 -t 5 fade 0.1 reverse norm -0.5";
	session_write_close();
	$output = shell_exec($commandx);

	//-- -- save to mp3 dont use -ac 1 windows playback problem mono -ac 2 
	$commandx = "c:\\wamp\\www\\ffmpeg\\ffmpeg -i \"c:\\wamp\\www\\audio-temp\\".$input_file_name."-normal.wav\" -y -ar 44100 -ab 64k -acodec libmp3lame c:\\wamp\\www\\audio-temp\\".$input_file_name.".mp3";
	session_write_close();
	$output = shell_exec($commandx);
	$output_file = $input_file_name.".mp3";

} else
if (stripos($input_file,".mp3")!==false)
{
	require_once('/getid3/getid3.php');
	define('GETID3_HELPERAPPSDIR', 'C:/helperapps/');
	$getID3 = new getID3;
	$ThisFileInfo = $getID3->analyze("c:\\wamp\\www\\site_veri\\mp3_temp\\".$input_file);

	$setBitRate="";
	$setTime="";
	$setMono="";

	if ($ThisFileInfo['audio']['bitrate']>128000) { $setBitRate=" -ab 128k "; }
	if ($ThisFileInfo['playtime_seconds']>60) { $setTime = " -t 00:01:00 "; }
	if (stripos($ThisFileInfo['audio']['channelmode'],"stereo")!==false) { $setMono = " -ac 1 "; }

//	echo $ThisFileInfo['audio']['bitrate_mode']." ";

	if (($setBitRate=="") && ($setTime=="") && ($setMono=="")) //just copy the file 
	{
		copy("c:\\wamp\\www\\site_veri\\mp3_temp\\".$input_file,"c:\\wamp\\www\\audio-temp\\".$input_file);
	} else
	{
		$commandx = "c:\\wamp\\www\\ffmpeg\\ffmpeg -i \"c:\\wamp\\www\\site_veri\\mp3_temp\\".$input_file."\" -y ".$setTime.$setMono.$SetBitRate ." -acodec libmp3lame \"c:\\wamp\\www\\audio-temp\\".$input_file."\""; 
		//-ar 44100 
		session_write_close();
		$output = shell_exec($commandx);
		//echo "<pre>$output</pre>";
	}
	$output_file = $input_file;
}
?>

<script type="text/javascript">
	parent.jQuery("#process-sound").html("");
    parent.jQuery("input[name='mp3_file']").val("<?php echo $output_file; ?>"); 
</script>