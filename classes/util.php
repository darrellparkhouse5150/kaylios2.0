
<?php
include 'follow_system';

class util {
    protected $db;
    protected $follow;
    protected $

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
}