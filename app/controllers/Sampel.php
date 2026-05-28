<?php

require_once (__DIR__ . "/../config/Database.php");
require_once (__DIR__ . "/../models/Sampel.php");

function redirectToPages(){
    header("Location: ../../views/contents/sampel.php");
    exit;
}

function showError($message, $connection){
    echo $message . "<br>";
    echo "Detail error: " . $connection->error;
}

$database = new Database();
$connection = $database->connect();
$sampel = new Sampel($connection);

if (isset($_POST['createSampel'])) {
    $nama_sampel = $_POST['nama_sampel'];
    $deskripsi = $_POST['deskripsi'];

    $createSampel = $sampel->create($nama_sampel, $deskripsi);

    if ($createSampel) {
        redirectToPages();
    } else {
        showError("Data sampel gagal ditambahkan. Silakan periksa kembali data yang diinput.", $connection);
    }
}

if (isset($_POST['updateSampel'])) {
    $id_sampel = $_POST['id_sampel'];
    $nama_sampel = $_POST['nama_sampel'];
    $deskripsi = $_POST['deskripsi'];

    $updateSampel = $sampel->update($id_sampel, $nama_sampel, $deskripsi);

    if ($updateSampel) {
        redirectToPages();
    } else {
        showError("Data sampel gagal diperbarui. Pastikan ID sampel valid dan data sudah benar.", $connection);
    }
}

if (isset($_POST['deleteSampel'])) {
    $id_sampel = $_POST['id_sampel'];

    $deleteSampel = $sampel->delete($id_sampel);

    if ($deleteSampel) {
        redirectToPages();
    } else {
        showError("Data sampel gagal dihapus. Pastikan ID sampel valid dan data masih tersedia.", $connection);
    }
}
