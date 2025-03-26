<?php
require_once 'config.php';

class DB {
    private $conn;
    
    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function query($sql) {
        return $this->conn->query($sql);
    }
    
    public function escape($str) {
        return $this->conn->real_escape_string($str);
    }
    
    public function __destruct() {
        $this->conn->close();
    }
}
?>