<?php

require_once (__DIR__ . "/../config/Database.php");
require_once (__DIR__ . "/../models/Tikus.php");

function redirectToPages(){
    header("Location: ../../views/contents/tikus.php");
    exit;
}

function showError($message, $connection){
    echo $message . "<br>";
    echo "Detail error: " . $connection->error;
}

$database = new Database();
$connection = $database->connect();
$tikus = new Tikus($connection);

if (isset($_POST['createTikus'])) {
    $id_sampel = $_POST['id_sampel'];
    $kode_tikus = $_POST['kode_tikus'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $createTikus = $tikus->create($id_sampel, $kode_tikus, $jenis_kelamin);

    if ($createTikus) {
        redirectToPages();
    } else {
        showError("Data tikus gagal ditambahkan. Silakan periksa kembali data yang diinput.", $connection);
    }
}

if (isset($_POST['updateTikus'])) {
    $id_tikus = $_POST['id_tikus'];
    $id_sampel = $_POST['id_sampel'];
    $kode_tikus = $_POST['kode_tikus'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $updateTikus = $tikus->update($id_tikus, $id_sampel, $kode_tikus, $jenis_kelamin);

    if ($updateTikus) {
        redirectToPages();
    } else {
        showError("Data tikus gagal diperbarui. Pastikan ID tikus valid dan data sudah benar.", $connection);
    }
}

if (isset($_POST['deleteTikus'])) {
    $id_tikus = $_POST['id_tikus'];

    $deleteTikus = $tikus->delete($id_tikus);

    if ($deleteTikus) {
        redirectToPages();
    } else {
        showError("Data tikus gagal dihapus. Pastikan ID tikus valid dan data masih tersedia.", $connection);
    }
}