<?php
    class message {
        protected $db;
        protected $dir;

        public function __construct() {
            $this->db = new Database();
            $this->dir = $this->db->dir;
        }

        public function getPeople($value) {}

        public function toMsgUrl($str) {}

        public function msgViaBtn($value, $to, $cname) {}

        public function msgCount($con_id, $by) {
            $session = $_SESSION['id'];
            
            if ($by == "user") {
                $query = $this->db->prepare("SELECT message_id FROM message WHERE con_id=:id and TYPE <> :type");
                $query->execute([':id' => $con_id, ':type' => 'name_change']);
            } else if ($by == "group") {
                $query = $this->db->prepare("SELECT message_id FROM message where grp_con_id=:id and type <> :type");
                $query->execute([':con_id' => $con_id, ':type' => 'name_change']);
            }

            $count = $query->rowCount();
            return $count;
        }
    }