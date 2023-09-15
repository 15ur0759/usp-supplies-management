<?php

class Connection
{
    private $host = "localhost";
    private $dbname = "inventory";
    private $username = "root";
    private $password = "";
    private $settings = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ);
    private $server;
    protected $conn;


    public function openConnection()
    {
        try {
            $this->server = "mysql:host=$this->host;dbname=$this->dbname";
            $this->conn = new PDO($this->server, $this->username, $this->password, $this->settings);

            return $this->conn;
            
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
} 

$db = new Connection();

