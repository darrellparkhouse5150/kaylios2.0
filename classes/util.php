
<?php
include 'follow_system';

class util {
    protected $db;
    protected $follow;

    public function __construct() {
        $this->db = new Database();
    }

    public function isLoggedIn() {
        if (isset($_SESSION['id'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check to see if a user is online
     * @param {object} $user
     */
    public function isOnline($user) {
        if (isset($_SESSION['id'])) {
            $session = $_SESSION['id'];

            if ($user != $session) {
                $query = $this->db->prepare('SELECT max(login_id) as get from login where user_id=:id limit 1');
                $query->execute([':id' => $user]);

                if ($query->rowCount() > 0) {
                    $row = $query->fetch(PDO::FETCH_OBJ);
                    $login = $row->get;

                    $query_logout = $this->db->prepare('SELECT logout from login where login_id =:id limit 1');
                    $query_logout->execute([':id' => $login]);

                    if ($query_logout->rowCount() > 0) {
                        $ret = $query_logout->fetch(PDO::FETCH_OBJ);
                        $logout = $ret->logout;

                        if (substr($logout, 0, 4) == "0000") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            }
        }
    }

    public function getDetails($get_id, $what) {
        $query = $this->db->prepare("SELECT $what from users where id=:id");
        $query->execute([":id" => $get_id]);

        if ($query->rowCount() == 0) {
            return false;
        } else if ($query->rowCount() != 0) {
            return true;
        }
    }

    public function getIdFromGet($get) {
        $query = $this->db->prepare("SELECT id FROM users WHERE username=:get limit 1");
        $query->execute([":get" => $get]);
        $row = $query->fetch(PDO::FETCH_OBJ);

        return $row->id;
    }

    public function MeOrNot($get) {
        if ($this->isLoggedIn()) {
            if ($_SESSION['id']) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function email_verified($id) {
        $email = $this->getDetails($id, 'email_activated');
        if ($email == "no") {
            return false;
        } else {
            return true;
        }
    }

    public function isPrivate($get) {
        $this->follow = new follow_system();

        if ($this->MeOrNot($get) == false && ($this->follow->is_following($get) == false) &&
            $this->getDetails($get, "type") == "private") {
            return true;
        } else {
            return false;
        }
    }

    public function nameShortener($name, $limit) {
        if (strlen($name) >= $limit) {
            return substr($name, 0, intval($limit) - 2).'...';
        } else {
            return $name;
        }
    }

    public function toAbsUrl($str) {
        $regex = "#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#'\"?&//=]*)?#si";
        return preg_replace($regex, '<a class="hash-tag" href="$0" target="_blank">$0</a>', $str);
    }


    public function urlChecker($url) {
        if (substr($url, 0, 1) == "/") {
            $r = 'http://localhost{$url}';
        } else {
            $r = $url;
        }

        return $r;
    }
}