<?php
@session_start(); 

	/**
	 * @author  Alexey Kulikov aka Clops
	 *          Comment Anything ReMake
	 *
	 * @since   2014
	 */

	/**
	 * @var array $lang
	 */
	require_once(__DIR__ . '/../config.inc.php');
	require_once(__DIR__ . '/../php/emComment.class.php');
	require_once(__DIR__ . '/../php/emComments.class.php');
	require_once(__DIR__ . '/../php/emMailer.class.php');

	//init
	$comment = new emComment($db, $format);

	//set
//	echo $comment->sender_userID." -----!!!! ".$_SESSION['Elooi_UserID'].",".$_SESSION['Elooi_User'].",".$_SESSION['Elooi_UserName'].",".$_SESSION['Elooi_Picture'];

	$comment->sender_userID = $_SESSION['Elooi_UserID'];
	
//	echo $comment->sender_userID." -----!!!! ".$_SESSION['Elooi_UserID'].",".$_SESSION['Elooi_User'].",".$_SESSION['Elooi_UserName'].",".$_SESSION['Elooi_Picture'];
	$comment->setObjectID($_REQUEST['object_id']);
	$comment->setCommentText($_REQUEST['comment'], $lang['enterComment']);
	$comment->setSenderName(urldecode($_REQUEST['sender_name']), $lang['enterName']);
	$comment->setSenderMail(urldecode($_REQUEST['sender_mail']), $lang['enterMail']);
	$comment->setSenderIP();
	$comment->setAccessKey();

	//this is a reply to an existing comment, hurray!
	if ($format->getAllowReply() and isset($_REQUEST['reply_to'])) {
		$comment->setReplyTo($_REQUEST['reply_to']);
	}


	if ($comment->getCommentText()) {
		$comment->persist($format->getModerateComments());

		//emails sir?
		$mailer = new emMailer($format);
		$mailer->commentAdded($comment, $_SERVER['HTTP_REFERER']);

		//needed for counters
		$comments = new emComments($db, $format, $comment->getObjectID());

		//send reply to browser
		$format->sendJSonReply(array(
			'id'       => $comment->getID(),
			'total'    => count($comments),
			'html'     => $comment->getHTML(0, true),
			'sort'     => $format->getSort(),
			'reply_to' => $comment->getReplyTo()
		));
	}