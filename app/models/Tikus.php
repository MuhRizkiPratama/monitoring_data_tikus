<?php

class Tikus {
    public $id_tikus;
    public $id_sampel;
    public $kode_tikus;
    public $jenis_kelamin;
    private $tablename = "tikus";
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function showAll(){
        $queryShowAll = "SELECT * FROM " . $this->tablename;
        $showAll = $this->connection->query($queryShowAll);
        return $showAll;
    }

    public function create($id_sampel, $kode_tikus, $jenis_kelamin){
        $queryCreateTikus = "INSERT INTO " . $this->tablename . " (id_sampel, kode_tikus, jenis_kelamin) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($queryCreateTikus);
        $stmt->bind_param("iss", $id_sampel, $kode_tikus, $jenis_kelamin);
        return $stmt->execute();
    }

    public function update($id_tikus, $id_sampel, $kode_tikus, $jenis_kelamin){
        $queryUpdateTikus = "UPDATE " . $this->tablename . " SET id_sampel = ?, kode_tikus = ?, jenis_kelamin = ? WHERE id_tikus = ?";
        $stmt = $this->connection->prepare($queryUpdateTikus);
        $stmt->bind_param("issi", $id_sampel, $kode_tikus, $jenis_kelamin, $id_tikus);
        return $stmt->execute();
    }

    public function delete($id_tikus){
        $queryDeleteTikus = "DELETE FROM " . $this->tablename . " WHERE id_tikus = ?";
        $stmt = $this->connection->prepare($queryDeleteTikus);
        $stmt->bind_param("i", $id_tikus);
        return $stmt->execute();
    }
}
