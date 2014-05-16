<?php ?>
<script type="text/javascript">
	var isPlaying = 0;
	var activeRow = -1;
	var PlayingRow = -1;
	var ElooiCount = 0;
	var ElooiIDArray = new Array();
	var UserList = new Array();
	var alinkpress=0;
	var LastUserID=-1;
	var UserRow=-1;
	var PlayDir = 0;
	var TopMenu = "";
	var WaitForMouseOut = 0;

	function scroll_resize()
	{
		var y = $(this).scrollTop();
		var m_view_h = $("#main_grid").height();
		var y_bottom = (y+$(window).height()-90);
		$("#page").css({"height":$(window).height()-50,"width":"1000px"}); 
		$("#grid_rightcol").css({"height":$(window).height()-70}); 
		$("#grid_centercol").css({"height":$(window).height()-60}); 
	}

	//$(window).scroll(function (event) {	scroll_resize();  });
	$(window).resize(function(){	
		$("#page").css({"height":$(window).height()-50,"width":"1000px"}); 
		$("#grid_rightcol").css({"height":$(window).height()-70}); 
		$("#grid_centercol").css({"height":$(window).height()-60}); 
	});

	//--------------------------------------------------------
	//user list functions
	function SetDefaultUserColors(rowname)	{
		if (rowname % 2 == 0) { $("#user_"+rowname).css({"backgroundColor":"#F1F1F5" }); } else
							  { $("#user_"+rowname).css({"backgroundColor":"#FFFFFF" }); }
		$("#user_"+rowname).css({"borderColor":"#DDDDDD" });
		/*
		$("#span_username_"+rowname).css({"color":"#444444" });
		$("#span_adddate_"+rowname).css({"color":"#555555" });
		*/
	}

	function SetUserHoverColors(rowname)	{
		$("#user_"+rowname).css({"backgroundColor":"#F9F9F9" });
		$("#user_"+rowname).css({"borderColor":"#CCCCCC" });
/*
		$("#span_username_"+rowname).css({"color":"#444444" });	
		$("#span_adddate_"+rowname).css({"color":"#555555" });	
*/
	}

	function SetUserColors(rowname)	{
		$("#user_"+rowname).css({"backgroundColor":"#66BBDD" });
		$("#user_"+rowname).css({"borderColor":"#CCCCCC" });
		/*
		$("#span_username_"+rowname).css({"color":"#333333" });	
		$("#span_adddate_"+rowname).css({"color":"#222222" });	
		*/
	}

	function selectUserRow(rowname)
	{
		if (activeRow != rowname) {
			if (activeRow==UserRow) { SetUserColors(activeRow); } else { SetDefaultUserColors(activeRow); }
		}

		activeRow = rowname;
		if (rowname==UserRow) { SetUserColors(UserRow); } else { SetUserHoverColors(rowname);
		}
	}

	function deselectUserRow(rowname) {	
		
		if (UserRow != rowname) { 
			SetDefaultUserColors(rowname); }
	}

	function UserRowClick(rowname)	{
		if (LastUserID!=UserList[rowname]) 
		{
			$('#rightcol_user_info').fadeOut('fast', function(){
				$(this).load("/rightcol-userdetail.php?bg=no&uid="+UserList[rowname], function(){
					$(this).fadeIn('slow', function(){ });
				});
			});
		}
		LastUserID=UserList[rowname];

		SetDefaultUserColors(UserRow);

		UserRow = rowname;
		SetUserColors(rowname);
	}



	//-----------------------------------------------------------------
	//elooi list functions
	function SetDefaultColors(rowname)	{
	/*
		if (rowname % 2 == 0) { $("#elooi_"+rowname).css({"backgroundColor":"#F1F1F5" }); } else
							  { $("#elooi_"+rowname).css({"backgroundColor":"#FFFFFF" }); }
		$("#elooi_"+rowname).css({"borderColor":"#DDDDDD" });
		$("#span_username_"+rowname).css({"color":"#444444" });	
		$("#span_adddate_"+rowname).css({"color":"#555555" });	
		*/
	}

	function SetHoverColors(rowname)	{
	/*
		$("#elooi_"+rowname).css({"backgroundColor":"#F9F9F9" });
		$("#elooi_"+rowname).css({"borderColor":"#CCCCCC" });
		$("#span_username_"+rowname).css({"color":"#444444" });	
		$("#span_adddate_"+rowname).css({"color":"#555555" });	
		*/
	}

	function SetPlayingColors(rowname)	{
	/*
		$("#elooi_"+rowname).css({"backgroundColor":"#66BBDD" });
		$("#elooi_"+rowname).css({"borderColor":"#CCCCCC" });
		$("#span_username_"+rowname).css({"color":"#333333" });	
		$("#span_adddate_"+rowname).css({"color":"#222222" });	
		*/
	}

	function RowClick(rowname)	{
		if (rowname==activeRow) { $("#floatingplaybutton").css({"display":"none" }); }

		rowint = parseInt(rowname);

//		if (LastUserID!=UserList[rowname]) //this check is not needed as the issue is per elooi not user eloois from the same user will have different right bars
		if (ElooiIDArray[PlayingRow]!=ElooiIDArray[rowname]) 
		{
			if ((TopMenu=="profile") || (TopMenu=="timeline") )
			{
				if (UserList[rowname]!=<?php echo $UserID ?>)
				{
					$('#rightcol_user_info').fadeOut('fast', function(){
						$(this).load("/right-col-elooi-info.php?uid="+UserList[rowname]+"&elooiid="+ElooiIDArray[rowname], function(){
							$(this).fadeIn('slow', function(){} ); });
					});
				} else
				{
					$("#rightcol_user_info").load("/rightcol-user-info.php?uid=<?php echo $UserID; ?>");
				}
			} else
			{
				$('#leftcol_user_info').fadeOut('fast', function(){
					$(this).load("/leftcol-user-info.php?bg=no&uid="+UserList[rowname], function(){
						$(this).fadeIn('slow', function(){} ); });
				});
				
				$('#rightcol_user_info').fadeOut('fast', function(){
					$(this).load("/right-col-elooi-info.php?uid="+UserList[rowname]+"&elooiid="+ElooiIDArray[rowname], function(){
							$(this).fadeIn('slow', function(){} ); });
				});

			}
		}

		LastUserID=UserList[rowname];

		if (alinkpress==1) { console.log("exit"); return; }
		if (PlayingRow != rowname) { SetDefaultColors(PlayingRow); $("#action_barn_"+PlayingRow).css({"display":"none" }); }

		//$.get("/elooi-counter.php", { ElooiID: ElooiIDArray[rowname] }, function(data){} );
		SetPlayingColors(rowname);
		$("#action_barn_"+rowname).css({"display":"inline-block" });
		PlayingRow = rowname;
	}

	function selectRow(rowname)
	{
		if (activeRow != rowname) {
			if (activeRow==PlayingRow) { SetPlayingColors(activeRow); } else { SetDefaultColors(activeRow); }
		}

		$("#action_barn_"+rowname).css({"display":"inline-block" });

		activeRow = rowname;
		if (rowname==PlayingRow) { SetPlayingColors(PlayingRow); $("#floatingplaybutton").css({"display":"none" }); } else { SetHoverColors(rowname);
		}
	}

	function deselectRow(rowname) 
	{	
		if (PlayingRow != rowname) { 
			$("#action_barn_"+rowname).css({"display":"none" });
			SetDefaultColors(rowname); 
		}
	}

	//---------------------
	//LEFT LISTEN TO BUTTON 
	function Become_Listener_MouseDown(event)
	{
		if (ListenToButtonType==1) {
			$('#ListenToButton').removeClass("listento-button listento-button-over").addClass('listento-button-down');
		}
		if (ListenToButtonType==2) {
			$('#ListenToButton').removeClass("notlistento-button").addClass('notlistento-button-down');
		}
	}

	function Become_Listener_MouseOver(event)
	{
		if (WaitForMouseOut>0) { WaitForMouseOut--; } else {
			if (ListenToButtonType==1) {
				$('#ListenToButton').removeClass("listento-button").addClass('listento-button-over');
			}
			if (ListenToButtonType==2) {
				$('#ListenToButton').removeClass("subscribed-button").addClass('notlistento-button');
				$("#ListenToButton b").text("<?php echo $me_unbecome_listener; ?>");
				$("#ListenToButtonIcon").removeClass("ischeck").addClass("minus");
			}
		}
	}

	function Become_Listener_MouseOut(event)
	{
		if (WaitForMouseOut>0) { WaitForMouseOut--; } else {
			if (ListenToButtonType==1) {
				$('#ListenToButton').removeClass("listento-button-down listento-button-over").addClass('listento-button');
			}
			if (ListenToButtonType==2) {
				$('#ListenToButton').removeClass("notlistento-button notlistento-button-down").addClass('subscribed-button');
				$("#ListenToButton b").text("<?php echo $me_listening; ?>");
				$("#ListenToButtonIcon").removeClass("minus").addClass("ischeck");
			}
		}
	}

	function Become_Listener(event,ElooiUserID)
	{
		if (ListenToButtonType==1) {
			$.get("/elooi-user-listento.php", { s_ElooiUserID: ElooiUserID,op:"add" },
				function(data){
					ListenToButtonType = 2;
					WaitForMouseOut = 2;
					$("#ListenToButton").removeClass("listento-button listento-button-down listento-button-over").addClass("subscribed-button");
					$("#ListenToButtonIcon").removeClass("plus").addClass("ischeck");
					$("#ListenToButton b").text("<?php echo $me_listening; ?>");
				}
			);
		} else
		if (ListenToButtonType=2)
		{
			$.get("/elooi-user-listento.php", { s_ElooiUserID: ElooiUserID,op:"remove" },
				function(data){
					ListenToButtonType = 1;
					$("#ListenToButton").removeClass("subscribed-button notlistento-button notlistento-button-down").addClass("listento-button");
					$("#ListenToButtonIcon").removeClass("ischeck minus").addClass("plus");
					$("#ListenToButton b").text("<?php echo $me_become_listener; ?>");
				}
			);
		}
	}


	//---------------------
	//RIGHT LISTEN TO BUTTON 
	function Become_Listener_MouseDown_right(event)
	{
		if (ListenToButtonType_right==1) {
			$('#ListenToButton_right').removeClass("listento-button listento-button-over").addClass('listento-button-down');
		}
		if (ListenToButtonType_right==2) {
			$('#ListenToButton_right').removeClass("notlistento-button").addClass('notlistento-button-down');
		}
	}

	function Become_Listener_MouseOver_right(event)
	{
		if (WaitForMouseOut>0) { WaitForMouseOut--; } else {
			if (ListenToButtonType_right==1) {
				$('#ListenToButton_right').removeClass("listento-button").addClass('listento-button-over');
			}
			if (ListenToButtonType_right==2) {
				$('#ListenToButton_right').removeClass("subscribed-button").addClass('notlistento-button');
				$("#ListenToButton_right b").text("<?php echo $me_unbecome_listener; ?>");
				$("#ListenToButtonIcon_right").removeClass("ischeck").addClass("minus");
			}
		}
	}

	function Become_Listener_MouseOut_right(event)
	{
		if (WaitForMouseOut>0) { WaitForMouseOut--; } else {
			if (ListenToButtonType_right==1) {
				$('#ListenToButton_right').removeClass("listento-button-down listento-button-over").addClass('listento-button');
			}
			if (ListenToButtonType_right==2) {
				$('#ListenToButton_right').removeClass("notlistento-button notlistento-button-down").addClass('subscribed-button');
				$("#ListenToButton_right b").text("<?php echo $me_listening; ?>");
				$("#ListenToButtonIcon_right").removeClass("minus").addClass("ischeck");
			}
		}
	}

	function Become_Listener_right(event,ElooiUserID)
	{
		if (ListenToButtonType_right==1) {
			$.get("/elooi-user-listento.php", { s_ElooiUserID: ElooiUserID,op:"add" },
				function(data){
					ListenToButtonType_right = 2;
					WaitForMouseOut = 2;
					$("#ListenToButton_right").removeClass("listento-button listento-button-down listento-button-over").addClass("subscribed-button");
					$("#ListenToButtonIcon_right").removeClass("plus").addClass("ischeck");
					$("#ListenToButton_right b").text("<?php echo $me_listening; ?>");
				}
			);
		} else
		if (ListenToButtonType_right=2)
		{
			$.get("/elooi-user-listento.php", { s_ElooiUserID: ElooiUserID,op:"remove" },
				function(data){
					ListenToButtonType_right = 1;
					$("#ListenToButton_right").removeClass("subscribed-button notlistento-button notlistento-button-down").addClass("listento-button");
					$("#ListenToButtonIcon_right").removeClass("ischeck minus").addClass("plus");
					$("#ListenToButton_right b").text("<?php echo $me_become_listener; ?>");
				}
			);
		}
	}

	function Become_Listener_txt(event,ElooiUserID)
	{
		if (ListenToButtonType_right==1) {
			$.get("/elooi-user-listento.php", { s_ElooiUserID: ElooiUserID,op:"add" },
				function(data){
					ListenToButtonType_right = 2;
					$("#listento_txt").text("<?php echo $me_unbecome_listener; ?>");
				}
			);
		} else
		if (ListenToButtonType_right=2)
		{
			$.get("/elooi-user-listento.php", { s_ElooiUserID: ElooiUserID,op:"remove" },
				function(data){
					ListenToButtonType_right = 1;
					$("#listento_txt").text("<?php echo $me_become_listener; ?>");
				}
			);
		}
	}

	function FlagElooi(event,ElooiID)
	{
		console.log("Flag Elooi:"+ElooiID);
		$.get("/flag-elooi.php", { s_ElooiID: ElooiID },
			function(data){
				$('#FlagElooiLink').tipsy("hide");
				$("#FlagElooi").html('<?php echo $me_flagged; ?>');
			}
		);
	}


	function delete_elooi(rowname,event)
	{
		event.stopPropagation();
		$.colorbox({href:'/delete-elooi.php?rowname='+ElooiIDArray[rowname], width:'510px', escKey:true, overlayClose:true, arrowKey:false, loop:false, scrolling:false, height:'170px', initialWidth:'200px', initialHeight:'150px', opacity:'0.2', speed:350, transition:"elastic", fixed:true});
	}

	function delete_elooi_by_ID(ElooiID,event)
	{
		event.stopPropagation();
		$.colorbox({href:'/delete-elooi.php?rowname='+ElooiID, width:'510px', escKey:true, overlayClose:true, arrowKey:false, loop:false, scrolling:false, height:'170px', initialWidth:'200px', initialHeight:'150px', opacity:'0.2', speed:350, transition:"elastic", fixed:true});
	}


	function addtofavorite(rowname,event)
	{
		event.stopPropagation();
		if (($("#dogear_"+rowname).hasClass("favorited")) || ($("#dogear_"+rowname).hasClass("reechoed-favorited")) )
		{
			//remove favorite
			$.get("/elooi-favorite.php", { ElooiID: ElooiIDArray[rowname],op:"remove" },
			function(data){
				if ($("#dogear_"+rowname).hasClass("reechoed-favorited")) {
				$("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited").addClass("reechoed");
				} else {
				$("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited");
				}
				$("#favorite_"+rowname).removeClass("unfavorite-action").addClass("favorite-action");
				$("#favorite_"+rowname+" b").text("<?php echo $me_add_favorite; ?>");
			});
		} else
		{
			//add favorite
			$.get("/elooi-favorite.php", { ElooiID: ElooiIDArray[rowname],op:"add" },
			function(data){
				if ($("#dogear_"+rowname).hasClass("reechoed")) {
					$("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited").addClass("reechoed-favorited");
				} else {
					$("#dogear_"+rowname).removeClass("reechoed-favorited reechoed favorited").addClass("favorited");
				}
				$("#favorite_"+rowname).removeClass("favorite-action").addClass("unfavorite-action");
				$("#favorite_"+rowname+" b").text("<?php echo $me_remove_favorite; ?>");
			});
		}
	}


	$(document).ready(function(){ 

//		$("a[rel='elooi_photo']").colorbox();
		scroll_resize();

		<?php if (($UserID==-100) or ($UserID==-200)) {	
			// set default background and load info for first user in playlist
			?>
			setBackgroundValues("<?php 
			if ($_SESSION['tileBackground']=="1") { echo "repeat"; } else { echo "no-repeat"; } ?>","<?php echo $_SESSION['backgroundColor']; ?>","<?php echo $_SESSION['backgroundImage']; ?>","", "<?php echo $_SESSION['textColor']; ?>", "<?php echo $_SESSION['headerColor']; ?>", "<?php echo $_SESSION['linkColor']; ?>", "<?php echo $_SESSION['textBackgroundColor']; ?>");

//			$("#leftcol_user_info").load("/leftcol-user-info.php?bg=no&uid="+UserList[1]);
			$("#rightcol_user_info").load("/rightcol-user-info.php?uid=-100"); 
			LastUserID=UserList[1];
		<?php } else { ?>
//		$("#leftcol_user_info").load("/leftcol-user-info.php?uid=<?php echo $UserID; ?>");

		<?php if ($_SESSION['SingleElooiID']!="") { ?>
			$("#rightcol_user_info").load("/rightcol-user-info.php?uid=<?php echo $UserID; ?>");
		<?php } else { ?>
			$("#rightcol_user_info").load("/rightcol-user-info.php?uid=<?php echo $UserID; ?>");
		<?php } ?>
		<?php
		}?>
	});

</script>
