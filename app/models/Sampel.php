<?php

class Sampel {
    private $tablename = "sampel";
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function showAll(){
        $queryShowAll = "SELECT * FROM " . $this->tablename;
        return $this->connection->query($queryShowAll);
    }

    public function create($nama_sampel, $deskripsi){
        $queryCreateSampel = "INSERT INTO " . $this->tablename . " (nama_sampel, deskripsi) VALUES (?, ?)";
        $stmt = $this->connection->prepare($queryCreateSampel);
        $stmt->bind_param("ss", $nama_sampel, $deskripsi);
        return $stmt->execute();
    }

    public function update($id_sampel, $nama_sampel, $deskripsi){
        $queryUpdateSampel = "UPDATE " . $this->tablename . " SET nama_sampel = ?, deskripsi = ? WHERE id_sampel = ?";
        $stmt = $this->connection->prepare($queryUpdateSampel);
        $stmt->bind_param("ssi", $nama_sampel, $deskripsi, $id_sampel);
        return $stmt->execute();
    }

    public function delete($id_sampel){
        $queryDeleteSampel = "DELETE FROM " . $this->tablename . " WHERE id_sampel = ?";
        $stmt = $this->connection->prepare($queryDeleteSampel);
        $stmt->bind_param("i", $id_sampel);
        return $stmt->execute();
    }
}
