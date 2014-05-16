<?php require_once("/server-settings.php"); ?>
<?php
################ FLV Audio Recorder Configuration File ############
######################## MANDATORY FIELDS #########################
//connectionstring:String
//description: the rtmp connection string to the audiorecorder application on your media server
//values: 'rtmp://localhost/audiorecorder/_definst_', 'rtmp://myfmsserver.com/audiorecorder/_definst_', etc...
$config['connectionstring']='rtmp://'.$server_domain.'/audiorecorder/_definst_';


//codec: Number
//desc: what codec to use
//values: 1 for Speex  0 for NellyMoser;	
//default: 1		
$config['codec']= 1;

//soundRate: Number
//desc: the quality of the audio, the higer the value the better the audio quality (bot if you have a bad microphone this value won't really matter that much)
//values: 5,8,11,22 or 44 for when using the older Nelly Moser codec
//values: 0,1,2,3,4,5,6,7,8,9 or 10 for when using Speex
//default : 10
$config['soundRate']=10;

//maxRecordingTime: Number
//desc: the maximum recording time in secdonds
//values: any number greater than 0;
//default: 120
$config['maxRecordingTime']=60;

//userId: String
//desc: the id of the user logged into the website, not mandatory, this var is passed back to the save_audio_to_db.php file via GET when the [SAVE] button in the recorder is pressed
//this variable can also be passed via flashvars, but the value in this file, if not empty, takes precedence
//values: any string or number id
//default:''
$config['userId']='';

//languagefile:String
//description: path to the XML file containing words and phrases to be used in the audio recorder interface, use this setting to switch between languages while maintaining several language files
//values: URL paths to the translation files
//default: 'translations/en.xml'
$config['languagefile']='/translations/en.xml';

##################### DO NOT EDIT BELOW ############################
//integration.php most commonly contains code for integrating with 3rd party CMS systems 
//it is generally used for overwriting values in this file so that whenever you update FLVAR the integration remains unchanged

if (file_exists("/integration.php")){ include("/integration.php");}

echo "donot=removethis";
foreach ($config as $key => $value){
	echo '&'.$key.'='.$value;
}
?>