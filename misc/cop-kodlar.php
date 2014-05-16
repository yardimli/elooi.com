signup adlar:

<span>
<label for="MiddleName"><?php echo $signup_MiddleName; ?></label>
  <input type="text" name="MiddleName" value="<?php echo $MiddleName; ?>" id="MiddleName" class="signup-name"  style="width:101px">
</span>

<span>
  <label for="LastName"><?php echo $signup_LastName; ?></label>
  <input type="text" name="LastName" value="<?php echo $LastName; ?>" id="LastName" class="signup-name" onBlur="makeusername();"; title="<?php echo $signup_LastName_tip; ?>"  style="width:131px">
</span>


me.php

<script type="text/javascript">
/*
		jQuery("#jquery_jplayer_1").bind($.jPlayer.event.timeupdate, function(event) { 
		//console.log(event.jPlayer.status.currentPercentAbsolute); 
		isPlaying = 1; });
*/

</script>

stiller.css
/* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
/*	font: inherit; */
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}

