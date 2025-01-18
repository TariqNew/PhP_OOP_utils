<?php

class Connection{
 private $hostname = "locahost";
 private $username = "root";
 private $password = "";
 private $db_name = "demodb";

 public function Databaseconnection(){
    try {
        $dsn = 'mysql:$this->hostname; $this->db_name;';
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Error occured". $e->getMessage();
    }
 }

}

$connection = new Connection();
$connection->Databaseconnection();

if ($connection->Databaseconnection()) {
    echo "Connection succesfully";
}



?>