<?php session_start(); 
$buyuk_grafik="evet";
?>
<?php include("ortak-header.php"); ?>


<!-- tab pane styling -->
<style>
	
/* tab pane styling */
.panes div {
	display:none;		
	padding:15px 10px;
	border:1px solid #999;
	border-top:0;
	height:100px;
	font-size:14px;
	background-color:#fff;
}

</style>

	<div id="content" class="col-full">
		<div id="main">
				<div class="post box" id="post-2543">
				
					<h1 class="title">Welcome to CloudofVoice</h1>
                    <div class="date-comments">
                        <p class="fl">January 16, 2011</p>    
                        <p class="fr"><a href="http://webdesign14.com/category/jquery/" title="View all posts in jQuery" rel="category tag">General</a></p>		                                          
                    </div>        
		
					<div class="entry">
			            												
												
<!-- the tabs -->
<ul class="tabs">
	<li><a href="#">Tab 1</a></li>
	<li><a href="#">Tab 2</a></li>
	<li><a href="#">Tab 3</a></li>
</ul>

<!-- tab "panes" -->
<div class="panes">
	<div>First tab content. Tab contents are called "panes"</div>

	<div>Second tab content</div>
	<div>Third tab content</div>
</div>

<!-- This JavaScript snippet activates those tabs -->
<script>

// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>


</div>

				
				</div><!--/post-->			
					 
	<div id="connect">
		<h3 class="title">Subscribe</h3>
		
		<div class="col-left">
			<p>Subscribe to our e-mail newsletter to receive updates.</p>
			 
			<form class="newsletter-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(&#39;http://feedburner.google.com/fb/a/mailverify?uri=http://feeds.feedburner.com/Webdesign14&#39;, &#39;popupwindow&#39;, &#39;scrollbars=yes,width=550,height=520&#39;);return true">
				<input class="email" type="text" name="email" value="E-mail" onfocus="if (this.value == &#39;E-mail&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;E-mail&#39;;}">
				<input type="hidden" value="http://feeds.feedburner.com/Webdesign14" name="uri">
				<input type="hidden" value="Learn Web Design" name="title">
				<input type="hidden" name="loc" value="en_US">			
				<input class="submit" type="submit" name="submit" value="Submit">
			</form>
					
		</div><!-- col-left -->
		
				<div class="related-posts col-right">
			<h4>Related Posts:</h4>
			
<ul class="woo-sc-related-posts">
	<li><a class="related-title" title="100 Best Photoshop Retouching Tutorials of All Time" href=""><span>100 Best Photoshop Retouching Tutorials of All Time</span></a></li>

	<li><a class="related-title" title="30 Useful Business Card Design Tutorials" href=""><span>30 Useful Business Card Design Tutorials</span></a></li>
</ul>
		</div><!-- col-right -->
									
        <div class="fix"></div>
	</div>
	
</div>

<div id="sidebar">
	
	<!-- Widgetized Sidebar Top -->    						

    
         		<div id="recent-posts-5" class="widget widget_recent_entries">		<h3>Recent Posts</h3>		
				<ul>
				<li><a href="" title="30 jQuery Navigation Plugins and Tutorials">30 jQuery Navigation Plugins and Tutorials</a></li>
				<li><a href="" title="35 High Quality Free Joomla Templates">35 High Quality Free Joomla Templates</a></li>
				<li><a href="" title="135 Best Web Layout Tutorials of All Time">135 Best Web Layout Tutorials of All Time</a></li>
				<li><a href="" title="Back Interfaces Free WordPress Templates">Back Interfaces Free WordPress Templates</a></li>
				<li><a href="" title="25 Useful jQuery Slideshow Tutorials">25 Useful jQuery Slideshow Tutorials</a></li>
				<li><a href="" title="100 Free PSD Web Templates of All Time">100 Free PSD Web Templates of All Time</a></li>
				</ul>

		</div>
		
		
    
    <div class="clear"></div>

</div><!--/sidebar-->

</div> <!--/#content-->

<?php include("ortak-fotter.php"); ?>

