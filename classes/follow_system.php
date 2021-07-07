<?php
    class follow_system {
        public $util;
        public $notify;

        public function is_following($get) {
            if (isset($_SESSION['id'])) {
                $session = $_SESSION['id'];

                $query = $this->db->prepare("SELECT follow_to from folllow_system where follow_by : session and follow_to=:get limit 1");
                $query->execute([':session' => $session, ':get' => $get]);

                if ($query->rowCount() != 0 || $query->rowCount() != null) {
                    return true;
                } else if ($query->rowCount() == 0) {
                    return  false;
                }
            }
        }

        public function follow($get) {
            $this->util = new util();
            $this->notify = new notify();
            $this->settings = new settings();

            $session = $_SESSION['id'];
            $user_session = $this->util->getDetails($session, 'username');
            $get_user = $this->util->getDetails($get, 'username');

            if ($this->settings->amIBlockd($get) == false) {
                if ($this->is_following($get) == false) {
                    $query = $this->db->prepare('INSERT INTO follow_system(follow_by, follow_by_username, follow_to, follow_to_username, time)
                                                values (:session, :user_session, :get, :get_user, now())');
                    $query->execute([':session' => $session, ':user_session' => $user_session, ':get_user' => $get_user]);

                    $this->notify->followNotification($get, "follow");

                    return "ok";
                } else {
                    return "Already followed";
                }
            }

        }

        public function MeOrNot($get) {
            
        }
    }

    $fs = new follow_system();
    $fs->is_following('');