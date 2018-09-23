<?php

class Conn
{
    public $host = 'localhost';
    public $db = 'banco';
    public $user = 'rafael';
    public $password = 123456;
    public $conn = null;

    public function __construct()
    {
        $this->conn = $this->setConn();
    }

    public function setConn()
    {
        if (!$this->conn) {
            try {
                $this->conn = new PDO("mysql:host=" . $this->host. "; dbname=" . $this->db, $this->user, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "PDO erro: " . $e->getMessage();
            }
        }
        return $this->conn;
    }
}