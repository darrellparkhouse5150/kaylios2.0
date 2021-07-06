
<?php
class util {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function isLoggedIn() {
        if (isset($_SESSION['id'])) {
//            if ($this->getDetails($_SESSION['id'], 'email_activated') == "yes") {
//                return true;
//            }
//
            return true;
        } else {
            return false;
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
}