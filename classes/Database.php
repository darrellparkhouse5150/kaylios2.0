<?php
use \PDO;


class Database extends PDO {
    public static $e;
    public static $database;
    public $dir = '/kaylios';
    public $db_username = 'root';
    public $db_password = 'root';
    public $user_email = '';
    public $user_password = '';
    public $dsn = 'mysql:host=localhost;dbname=kaylios;charset=utf8mb4';

    public function __construct() {
        parent::__construct();

        try {
            self::$database = new PDO($this->dsn, $this->db_username, $this->db_password);
            self::$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $e = self::$e;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        return self::$database;
    }
}