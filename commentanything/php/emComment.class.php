<?php
@session_start(); 

	/**
	 * @author  Alexey Kulikov aka Clops
	 *          Comment Anything ReMake
	 *
	 * @since   2014
	 */
	class emComment
	{

		/**
		 * @var PDO $db
		 */
		protected $db;
		/**
		 * @var emFormat $formatter
		 */
		protected $formatter;

		//properties
		protected $id; //int
		protected $object_id; //varchar(64)
		protected $created; //datetime
		protected $sender_name; //varchar(128)
		protected $sender_mail; //varchar(128)
		public $sender_userID; //int
		protected $sender_ip; //bigint(20)
		protected $comment_text; //text
		protected $admin_reply; //enum(0,1)
		protected $rating_cache; //int
		protected $access_key; //varchar(100)
		protected $visible; //enum(0,1)
		protected $sort_order; //default 0
		protected $level; //default 1
		protected $reply_to;

		//caches
		protected $vote = 0;

		//links
		protected $thread;


		/**
		 * @param PDO $db
		 * @param int $id
		 */
		public function __construct(PDO $db, emFormat $formatter, $id = null)
		{
			$this->setDb($db);
			$this->setFormatter($formatter);
			if (isset($id)) {
				$this->init($id);
			}
		}


		/**
		 * @param PDO $db
		 */
		public function setDb(PDO $db)
		{
			$this->db = $db;
		}


		/**
		 * @param emFormat $format
		 */
		public function setFormatter(emFormat $format)
		{
			$this->formatter = $format;
		}


		/**
		 * @param $id
		 */
		public function init($id)
		{
			if ($data = $this->db->query("SELECT * FROM em_comments WHERE id = " . (int)$id)->fetch()) {
				$this->initFromArray($data);

				return true;
			}

			return false;
		}


		/**
		 * @param array $data
		 *
		 * @return bool
		 */
		public function initFromArray(Array $data)
		{
			$this->id           = (int)$data['id'];
			$this->object_id    = (string)$data['object_id'];
			$this->created      = (string)$data['created'];
			$this->sender_name  = (string)$data['sender_name'];
			$this->sender_mail  = (string)$data['sender_mail'];
			$this->sender_userID  = (string)$data['userid'];
			$this->sender_ip    = long2ip($data['sender_ip']);
			$this->comment_text = (string)$data['comment_text'];
			$this->admin_reply  = (bool)$data['admin_reply'];
			$this->rating_cache = (int)$data['rating_cache'];
			$this->access_key   = (string)$data['access_key'];
			$this->visible      = (bool)$data['visible'];
			$this->sort_order   = (int)$data['sort_order'];
			$this->level        = (int)$data['level'];
			$this->reply_to     = (int)$data['reply_to'];

			if (isset($data['vote'])) {
				$this->setVote($data['vote']);
			}

			return true;
		}


		/**
		 * @param int $id
		 */
		public function setObjectID($id)
		{
			$this->object_id = $id;
		}


		/**
		 * @param string $ip
		 */
		public function setSenderIP($ip = null)
		{
			if (!$ip) {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			$this->sender_ip = $ip;
		}


		/**
		 * @param bool $hidden
		 *
		 * @return bool
		 */
		public function persist($hidden = false)
		{
			if ($_SESSION['Elooi_User']==true)
			{
				$xsession = $_SESSION['Elooi_UserID'];
//			echo "-----".$_SESSION['Elooi_UserID']."----".$_SESSION['Elooi_UserName'].",".$_SESSION['Elooi_Picture']."------++++--";
				$sql = 'userID = ' . $this->db->quote($xsession) . ',';
	//			echo "!".$xsession."!-";
	//			echo $sql;
				
				$sql .= 'object_id     = ' . $this->db->quote($this->getObjectID()) . ',
						 sender_name  = ' . $this->db->quote($this->getSenderName()) . ',
						 sender_mail  = ' . $this->db->quote($this->getSenderMail()) . ',
						 sender_ip    = ' . (int)ip2long($this->getSenderIP()) . ',
						 comment_text = ' . $this->db->quote($this->getCommentText()) . ',
						 rating_cache = ' . $this->db->quote($this->getRatingCache()) . ',
						 visible      = ' . $this->db->quote(($hidden ? 0 : 1)) . ',
						 access_key   = ' . $this->db->quote($this->getAccessKey());
						 

		//		echo $sql;
		//		echo "-----".$_SESSION['Elooi_UserID']."----".$_SESSION['Elooi_UserName'].",".$_SESSION['Elooi_Picture'];
				
				
				if ($this->getID()) {
					$this->db->exec('UPDATE em_comments SET ' . $sql . ' WHERE id = ' . $this->getID());
				} else {


					//in case this is a reply, we need to mark it so!
					if ($this->getReplyTo()) {
						if ($parent = $this->db->query("SELECT * FROM em_comments WHERE id = " . $this->getReplyTo() . " AND object_id = " . $this->db->quote($this->getObjectID()))->fetch()) {
							$sql .= ', reply_to = ' . $this->getReplyTo();

							$newLevel = (int)$parent['level'] + 1;
							if($newLevel > $this->formatter->getReplyDepth()){
								$newLevel = $this->formatter->getReplyDepth();
							}

							//now calculate level and sort order
							$sql .= ', level = ' . ((int)$parent['level'] + 1);

							//and the sort order
							$sql .= ', sort_order = ' . ((int)$parent['sort_order'] + 1);

							//and make some space NOW
							$this->db->query("UPDATE em_comments SET sort_order = sort_order + 1 WHERE sort_order > " . (int)$parent['sort_order'] . " AND object_id = " . $this->db->quote($this->getObjectID()));
						}
					} else {
						//we need to calculate the sort order for this comment
						$maxSortOrder = (int)$this->db->query("SELECT MAX(sort_order) FROM em_comments WHERE object_id = " . $this->db->quote($this->getObjectID()))->fetchColumn();
						$maxSortOrder = $maxSortOrder + 1;
						$sql .= ', sort_order = ' . $maxSortOrder;
					}
					

					$this->db->exec('INSERT INTO em_comments SET created = NOW(), ' . $sql);
					$this->init($this->db->lastInsertId());
				}

				return true;
			} else
			{
				return false;
			}
		}


		/**
		 * @return string
		 */
		public function getObjectID()
		{
			return $this->object_id;
		}


		/**
		 * @return string
		 */
		public function getSenderName()
		{
			return $this->sender_name;
		}


		/**
		 * @param string $name
		 * @param string $default
		 */
		public function setSenderName($name, $default = null)
		{
			if ($name == $default) {
				$name = null;
			}
			$this->sender_name = (string)$name;
		}


		/**
		 * @return mixed
		 */
		public function getSenderMail()
		{
			return $this->sender_mail;
		}

		public function getuserID()
		{
//			print_r($this);
			if ($picture = $this->db->query("SELECT * FROM users WHERE id = " . $this->sender_userID . "" )->fetch()) {
				return $picture["picture"];
			} else
			{
				return "blank.png";
			}
			
		}

		/**
		 * @param string $mail
		 * @param string $default
		 */
		public function setSenderMail($mail, $default = null)
		{
			if ($mail == $default) {
				$mail = null;
			}
			$this->sender_mail = (string)$mail;
		}


		/**
		 * @return string
		 */
		public function getFormattedSenderName()
		{
			return ($this->getSenderName() ? $this->getSenderName() : 'Someone') . ($this->getSenderMail() ? ' <' . $this->getSenderMail() . '>' : '');
		}


		/**
		 * @return string
		 */
		public function getSenderIP()
		{
			return $this->sender_ip;
		}


		/**
		 * @return string
		 */
		public function getCommentText()
		{
			return $this->comment_text;
		}


		/**
		 * @param string $text
		 * @param string $default
		 */
		public function setCommentText($text, $default = null)
		{
			if ($text == $default) {
				$text = null;
			}

			$this->comment_text = $this->formatter->twitterify($this->formatter->cleanInput($text));
		}


		/**
		 * @return string
		 */
		public function getAccessKey()
		{
			return $this->access_key;
		}


		/**
		 * @param string $key
		 */
		public function setAccessKey($key = null)
		{
			if (!$key) {
				$key = md5(uniqid());
			}
			$this->access_key = $key;
		}


		/**
		 *
		 */
		public function drop()
		{
			if ($this->id) {
				$this->db->exec('DELETE FROM em_comments WHERE id = ' . $this->id);
			}
		}


		/**
		 * @return string
		 */
		public function getHTML($counter = 0, $hidden = false)
		{
			return $this->formatter->renderOneComment($this, $counter, $hidden);
		}


		/**
		 * @return int
		 */
		public function getID()
		{
			return $this->id;
		}


		/**
		 * @return int
		 */
		public function getRatingCache()
		{
			return (int)$this->rating_cache;
		}


		/**
		 * @param $vote
		 */
		public function getVote()
		{
			return $this->vote;
		}


		/**
		 * @param $vote
		 */
		public function setVote($vote)
		{
			$vote = (int)$vote;
			if ($vote > 1) {
				$vote = 1;
			}

			if ($vote < -1) {
				$vote = -1;
			}
			$this->vote = $vote;
		}


		/**
		 * @return emComments
		 */
		public function getThread()
		{
			return $this->thread;
		}


		/**
		 * @param emComments $thread
		 */
		public function setThread(emComments $thread)
		{
			$this->thread = $thread;
		}


		/**
		 * @return string
		 */
		public function getCreated()
		{
			return strftime($this->formatter->getDateFormat(), strtotime($this->created));
		}


		/**
		 * @param $created
		 */
		public function setCreated($created)
		{
			$this->created = $created;
		}

		/**
		 * @return int
		 */
		public function getLevel($offset=false)
		{
			if($offset){
				if($this->level > 1){
					return 'margin-left: '.(($this->level-1)*20).'px;';
				}
			}
			return $this->level;
		}

		/**
		 * @return int
		 */
		public function getSortOrder()
		{
			return $this->sort_order;
		}

		/**
		 * @param $replyTo
		 */
		public function setReplyTo($replyTo)
		{
			$this->reply_to = (int)$replyTo;
		}

		/**
		 * @return int
		 */
		public function getReplyTo()
		{
			return $this->reply_to;
		}

		/**
		 * @param $ip
		 */
		public function like($ip, $inverse = false)
		{
			//insert comment into database
			$existing = $this->db->query('SELECT id FROM em_likes WHERE comment_id = ' . $this->db->quote($this->getID()) . ' AND sender_ip = ' . (int)ip2long($ip))->fetchColumn();
			if (!$existing) {
				$this->db->exec('INSERT INTO em_likes SET
                                    comment_id   = ' . $this->db->quote($this->getID()) . ',
                                    sender_ip    = ' . (int)ip2long($ip) . ',
                                    vote         = ' . $this->db->quote(($inverse ? -1 : 1)));
			}

			//generate reply
			$this->rating_cache = (int)$this->db->query("SELECT count(*) AS total FROM em_likes WHERE vote = '1' AND comment_id = " . $this->db->quote($this->getID()))->fetchColumn();
			$this->rating_cache = $this->rating_cache - (int)$this->db->query("SELECT count(*) AS total FROM em_likes WHERE vote = '-1' AND comment_id = " . $this->db->quote($this->getID()))->fetchColumn();
			$this->setVote(($inverse ? -1 : 1));
			$this->persist(!$this->visible);
		}

	}