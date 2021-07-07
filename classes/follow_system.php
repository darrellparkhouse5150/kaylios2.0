<?php
    class follow_system {
        public $util;
        public $notify;
        public $avatar;
        public $mutual;

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

        public function unfollow($get) {
            if ($this->is_following($get)) {
                $session = $_SESSION['id'];
                $query = $this->db->prepare('DELETE FROM follow_system where follow_by=:session AND follow_to=:get limit 1');
                $query->execute([':session' => $session, ':get' => $get]);
            }
        }

        public function getFollowers($get) {
            $query = $this->db->prepare('SELECT follow_by FROM follow_system WHERE follow_to=:get');
            $query->execute([':get' => $get]);

            return $query->rowCount();
        }

        public function getPeopleIFollow($get) {
            $query = $this->db->prepare('SELECT follow_to from follow_system WHERE follow_to=:get');
            $query->execute([':get' => $get]);
            $count = $query->rowCount();

            return $count;
        }

        public function followers($get) {
            $session = $_SESSION['id'];

            $this->util = new util();
            $this->avatar = new avatar();
            $this->mutual = new mutual();

            

        }

        public function MeOrNot($get) {
            
        } 
    }

    $fs = new follow_system();
    $fs->is_following('');