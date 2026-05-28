<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "monitoring_tikus";

    public function connect() {
        $connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        return $connection;
    }
}

?>