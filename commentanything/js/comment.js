/*******************************************************************************
 *  -- Comment Anything facebook Style --                                      *
 *                                                                             *
 *      Author: Kulikov Alexey <a.kulikov@gmail.com>                           *
 *      Web: http://clops.at                                                   *
 *      Since: 28.03.2010                                                      *
 *                                                                             *
 *******************************************************************************/


/***
 *  When a user is typing a comment the size of the textarea is extended
 ***/
function adjustHeight(textarea) {
    var dif = textarea.scrollHeight - textarea.clientHeight;
    if (dif) {
        if (isNaN(parseInt(textarea.style.height))) {
            textarea.style.height = textarea.scrollHeight + "px"
        } else {
            textarea.style.height = parseInt(textarea.style.height) + dif + "px"
        }
    }
}


/***
 *  Creates placeholders for text in the field
 ***/
function inputPlaceholder(input, color) {

    if (!input) return null;

    /**
     * Webkit browsers already implemented placeholder attribute.
     * This function useless for them.
     */
    if (input.placeholder && 'placeholder' in document.createElement(input.tagName)) return input;

    var placeholder_color = color || '#AAA';
    var default_color = input.style.color;
    var placeholder = input.getAttribute('placeholder');

    if (input.value === '' || input.value == placeholder) {
        input.value = placeholder;
        input.style.color = placeholder_color;
    }

    var add_event = /*@cc_on'attachEvent'||@*/'addEventListener';

    input[add_event](/*@cc_on'on'+@*/'focus', function () {
        input.style.color = default_color;
        if (input.value == placeholder) {
            input.value = '';
        }
    }, false);

    input[add_event](/*@cc_on'on'+@*/'blur', function () {
        if (input.value === '') {
            input.value = placeholder;
            input.style.color = placeholder_color;
        } else {
            input.style.color = default_color;
        }
    }, false);

    input.form && input.form[add_event](/*@cc_on'on'+@*/'submit', function () {
        if (input.value == placeholder) {
            input.value = '';
        }
    }, false);

    return input;
}


/***
 *  Heart and soul of the application -- it ADDS the comment to the database
 ***/
function addEMComment(oid) {
    var myComment = $('#addEmComment_' + oid);
    var myName = $('#addEmName_' + oid);
    var myMail = $('#addEmMail_' + oid);
	
	if (UserID=="0") {
		alert("you need to be logged in to comment");
	} else
	{
		if (myComment.val() && myComment.val() != myComment.attr('placeholder')) {

			//mark comment box as inactive
			myComment.attr('disabled', 'true');
			myMail.attr('disabled', 'true');
			myName.attr('disabled', 'true');
			$('#emAddButton_' + oid).attr('disabled', 'true');

			if (myName.val() == myName.attr('placeholder')) {
				document.getElementById('addEmName_' + oid).value = '';
			}

			if (myMail.val() == myMail.attr('placeholder')) {
				document.getElementById('addEmMail_' + oid).value = '';
			}

			$.ajax({
				type:"POST",
				url: '/commentanything/ajax/addComment.php',
				data: {
					comment: encodeURIComponent(myComment.val()),
					object_id: oid,
					sender_name: encodeURIComponent(myName.val()),
					sender_mail: encodeURIComponent(myMail.val()),
					reply_to: $('#replyToEmPost_'+oid).val()
				},
				success:  function (data) {
					if(data.reply_to){
						$('#comment_'+data.reply_to).after(data.html);
					}else{
						if(data.sort == -1){
							$('#emContent_' + oid).prepend(data.html);
						}else{
							$('#emContent_' + oid).append(data.html);
						}
					}

					$('#comment_' + data.id).slideDown();
					$('#total_em_comments_' + oid).html(data.total);
					resetFields(oid);
				},
				error: function(xhr,err){
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
					console.log("responseText: "+xhr.responseText);
				},
				dataType : "json"
			});

		} else {
			myComment.focus();
		}
	}
    return false;
}


/***
 *  Clear Add Comment Fields
 ***/
function resetFields(oid) {
    var obj = document.getElementById('addEmComment_' + oid);
    if (obj) {
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        obj.style.height = '29px';
        inputPlaceholder(document.getElementById('addEmComment_' + oid));
    }

    obj = document.getElementById('addEmName_' + oid);
    if (obj) {
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        inputPlaceholder(document.getElementById('addEmName_' + oid));
    }

    obj = document.getElementById('addEmMail_' + oid);
    if (obj) {
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        inputPlaceholder(document.getElementById('addEmMail_' + oid));
    }

    obj = document.getElementById('emAddButton_' + oid);
    if (obj) {
        obj.disabled = false;
    }

    //put it in the correct place now
    toggleTexts(oid, true);
    $('#emAddCommentHeader_'+oid).append($('#emAddComment_'+oid));
    $('#replyToEmPost_'+oid).val('');
}


/***
 *  Like a comment
 ***/
function iLikeThisComment(cid, inverse) {
    $.ajax({
		type:"POST",
        url: '/commentanything/ajax/likeComment.php', 
		data: {
            comment_id: cid,
            dislike: inverse
        },
		success:  function (data) {
//			console.log(data.text+" "+data.total);
            $('#iLikeThis_' + cid).html('<em>' + data.text + '</em>');
        },
		error: function(xhr,err){
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
			console.log("responseText: "+xhr.responseText);
		},
		dataType : "json"
	});
}


/**
 * Show Reply to Form to THIS comment
 *
 * @param oid object_id
 * @param cid comment_id
 */
function replyToThisComment(cid, oid) {
    toggleTexts(oid);
    $('#replyToEmPost_'+oid).val(cid);

    //append the form where needed
    $('#emAddComment_'+oid).appendTo('#comment_'+cid);
    $('#addEmComment_'+oid).focus();
}


/**
 *
 * @param oid
 * @param reverse
 */
function toggleTexts(oid, reverse){
    var commentButton  = $('#emAddButton_'+oid);
    var commentText    = $('#addEmComment_'+oid);

    //toggle texts
    if(!commentButton.attr('data-alt-toggled') && !reverse || commentButton.attr('data-alt-toggled') && reverse){
        tempToggle = commentButton.val();
        commentButton.val(commentButton.attr('data-alt-value'));
        commentButton.attr('data-alt-value', tempToggle);
        commentButton.attr('data-alt-toggled', 1);
    }

    if(!commentText.attr('data-alt-toggled') && !reverse || commentText.attr('data-alt-toggled') && reverse){
        tempToggle = commentText.attr('placeholder');
        commentText.attr('placeholder', commentText.attr('data-alt-value'));
        commentText.attr('data-alt-value', tempToggle);
        commentText.attr('data-alt-toggled', 1);
    }
}


/***
 *  When there are more than 2 comments they are hidden and can be opened by this function
 ***/
function viewAllComments(obj) {
    $('.emComment_' + obj).slideDown();
    $('#emShowAllComments_' + obj).hide();
    $('#emHideAllComments_' + obj).show();
}

/***
 *  When there are more than 2 comments they are hidden and can be opened by this function
 ***/
function hideAllComments(obj) {
    $('.emHiddenComment_' + obj).slideUp();
    $('#emShowAllComments_' + obj).show();
    $('#emHideAllComments_' + obj).hide();
}

/**
 * Binding listeners
 */
$(document).ready(function () {
    //resetFields();
    $('textarea.addEmComment').bind('keyup', function(event){
        adjustHeight(this);
    });
});
