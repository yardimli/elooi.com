<?php
$twitterObj = new EpiTwitter($twitter_consumer_key, $twitter_consumer_secret, $_SESSION['twitter_oauth_token'],$_SESSION['twitter_oauth_token_secret']);
$twitterObjUnAuth = new EpiTwitter($twitter_consumer_key, $twitter_consumer_secret);
/*
<h1>Single test to verify everything works ok</h1>

<h2><a href="javascript:void(0);" onclick="viewSource();">View the source of this file</a></h2>
<div id="source" style="display:none; padding:5px; border: dotted 1px #bbb; background-color:#ddd;">
< ? php highlight_file(__FILE__);  ? >
</div>

<hr>

<h2>Generate the authorization link</h2>
< ? php echo $twitterObjUnAuth->getAuthenticateUrl();  ? >

<hr>

<h2>Verify credentials</h2>
< ? php
  $creds = $twitterObj->get('/account/verify_credentials.json');
? >
<pre>
< ? php print_r($creds->response);  ? >
</pre>

<hr>

<h2>Post status</h2>
< ? php */
  //$twitterObjUnAuth->getAuthenticateUrl();
  $status = $twitterObj->post('/statuses/update.json', array('status' => $message));
?>
<?php 
// print_r($status->response); 
?>
