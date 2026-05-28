<?php

class Monitoring {
    private $tablename = "monitoring";
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function showAll(){
        $queryShowAll = "SELECT monitoring.*, tikus.kode_tikus, tikus.jenis_kelamin, sampel.nama_sampel
            FROM " . $this->tablename . "
            JOIN tikus ON monitoring.id_tikus = tikus.id_tikus
            LEFT JOIN sampel ON tikus.id_sampel = sampel.id_sampel
            ORDER BY tikus.kode_tikus ASC, monitoring.hari_ke ASC, monitoring.id DESC";
        return $this->connection->query($queryShowAll);
    }

    public function create($id_tikus, $hari_ke, $berat_badan, $skor_eritema, $skor_edema, $foto_berat, $foto_kulit, $tanggal){
        $queryCreateMonitoring = "INSERT INTO " . $this->tablename . " (id_tikus, hari_ke, berat_badan, skor_eritema, skor_edema, foto_berat, foto_kulit, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($queryCreateMonitoring);
        $stmt->bind_param("iidiisss", $id_tikus, $hari_ke, $berat_badan, $skor_eritema, $skor_edema, $foto_berat, $foto_kulit, $tanggal);
        return $stmt->execute();
    }

    public function findById($id){
        $queryFindMonitoring = "SELECT * FROM " . $this->tablename . " WHERE id = ?";
        $stmt = $this->connection->prepare($queryFindMonitoring);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $id_tikus, $hari_ke, $berat_badan, $skor_eritema, $skor_edema, $foto_berat, $foto_kulit, $tanggal){
        $queryUpdateMonitoring = "UPDATE " . $this->tablename . " SET id_tikus = ?, hari_ke = ?, berat_badan = ?, skor_eritema = ?, skor_edema = ?, foto_berat = ?, foto_kulit = ?, tanggal = ? WHERE id = ?";
        $stmt = $this->connection->prepare($queryUpdateMonitoring);
        $stmt->bind_param("iidiisssi", $id_tikus, $hari_ke, $berat_badan, $skor_eritema, $skor_edema, $foto_berat, $foto_kulit, $tanggal, $id);
        return $stmt->execute();
    }

    public function delete($id){
        $queryDeleteMonitoring = "DELETE FROM " . $this->tablename . " WHERE id = ?";
        $stmt = $this->connection->prepare($queryDeleteMonitoring);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
