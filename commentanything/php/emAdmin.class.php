<?php
@session_start(); 

    /**
     * @author  Alexey Kulikov aka Clops
     *          Comment Anything ReMake
     *
     * @since   2014
     */
    class emAdmin {

        //pointers
        protected $db;
        protected $format;

        //properties
        protected $action = '';
        protected $result = false;
        protected $relatedID = null;


        /**
         * @param PDO      $db
         * @param emFormat $format
         */
        public function __construct (PDO $db, emFormat $format) {
            $this->db     = $db;
            $this->format = $format;
        }


        /**
         * @param array $data
         */
        public function checkModerationAction (Array $data) {
            if (isset($data['emAct'])) {
                $this->setAction($data['emAct']);
            }

            if (!isset($data['emCommentKey'])) {
                $data['emCommentKey'] = false;
            }
            if (isset($data['emCommentID'])) {
                $this->setRelatedID($data['emCommentID']);
            }
            if (!isset($data['emCommentOID'])) {
                $data['emCommentOID'] = false;
            }

            if ($this->getAction() and $data['emCommentKey'] and $data['emCommentID'] and $data['emCommentOID']) {

                $comment = new emComment($this->db, $this->format, $this->getRelatedID());

                if ($comment->getAccessKey() == $data['emCommentKey'] && $comment->getObjectID() == $data['emCommentOID']) {
                    $this->setResult(true);
                    switch ($this->getAction()) {
                        case 'delete':
                        {
                            $comment->drop();
                            break;
                        }

                        case 'allow':
                        {
                            $comment->persist();
                            break;
                        }
                    }
                }
            }
        }


        /**
         * @return string
         */
        public function getAction () {
            return $this->action;
        }


        /**
         * @param $action
         */
        public function setAction ($action) {
            $this->action = (string)$action;
        }


        /**
         * @return bool
         */
        public function getResult () {
            return $this->result;
        }


        /**
         * @param $result
         */
        public function setResult ($result) {
            $this->result = (bool)$result;
        }

        public function setRelatedID($id){
            $this->relatedID = (int)$id;
        }

        public function getRelatedID(){
            return $this->relatedID;
        }
    }