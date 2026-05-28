<?php

require_once (__DIR__ . "/../config/Database.php");
require_once (__DIR__ . "/../models/Monitoring.php");

function redirectToPages($id_tikus = null){
    $location = "../../views/contents/monitoring.php";

    if ($id_tikus) {
        $location .= "?id_tikus=" . urlencode($id_tikus);
    }

    header("Location: " . $location);
    exit;
}

function showError($message, $connection){
    echo $message . "<br>";
    echo "Detail error: " . $connection->error;
}

function uploadMonitoringFile($fieldName){
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $extension = strtolower(pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions)) {
        return null;
    }

    $uploadDirectory = __DIR__ . "/../../src/uploads/monitoring/";
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = $fieldName . "_" . date("YmdHis") . "_" . uniqid() . "." . $extension;
    $targetPath = $uploadDirectory . $fileName;

    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetPath)) {
        return "src/uploads/monitoring/" . $fileName;
    }

    return null;
}

function deleteMonitoringFile($filePath){
    if (!$filePath) {
        return;
    }

    $uploadDirectory = realpath(__DIR__ . "/../../src/uploads/monitoring/");
    $fullPath = realpath(__DIR__ . "/../../" . $filePath);

    if ($uploadDirectory && $fullPath && strpos($fullPath, $uploadDirectory) === 0 && is_file($fullPath)) {
        unlink($fullPath);
    }
}

function getMonitoringScore($fieldName){
    if (!isset($_POST[$fieldName]) || $_POST[$fieldName] === '') {
        return null;
    }

    $score = filter_var($_POST[$fieldName], FILTER_VALIDATE_INT);

    if ($score === false || $score < 0 || $score > 4) {
        return null;
    }

    return $score;
}

$database = new Database();
$connection = $database->connect();
$monitoring = new Monitoring($connection);

if (isset($_POST['createMonitoring'])) {
    $id_tikus = $_POST['id_tikus'];
    $hari_ke = $_POST['hari_ke'];
    $berat_badan = $_POST['berat_badan'];
    $skor_eritema = getMonitoringScore('skor_eritema');
    $skor_edema = getMonitoringScore('skor_edema');
    $tanggal = $_POST['tanggal'];
    $foto_berat = uploadMonitoringFile('foto_berat');
    $foto_kulit = uploadMonitoringFile('foto_kulit');

    if ($skor_eritema === null || $skor_edema === null) {
        showError("Skor eritema dan edema harus diisi dengan nilai 0 sampai 4.", $connection);
        exit;
    }

    $createMonitoring = $monitoring->create($id_tikus, $hari_ke, $berat_badan, $skor_eritema, $skor_edema, $foto_berat, $foto_kulit, $tanggal);

    if ($createMonitoring) {
        redirectToPages($id_tikus);
    } else {
        showError("Data monitoring gagal ditambahkan. Silakan periksa kembali data yang diinput.", $connection);
    }
}

if (isset($_POST['updateMonitoring'])) {
    $id = $_POST['id'];
    $id_tikus = $_POST['id_tikus'];
    $hari_ke = $_POST['hari_ke'];
    $berat_badan = $_POST['berat_badan'];
    $skor_eritema = getMonitoringScore('skor_eritema');
    $skor_edema = getMonitoringScore('skor_edema');
    $tanggal = $_POST['tanggal'];

    if ($skor_eritema === null || $skor_edema === null) {
        showError("Skor eritema dan edema harus diisi dengan nilai 0 sampai 4.", $connection);
        exit;
    }

    $oldMonitoring = $monitoring->findById($id);

    if (!$oldMonitoring) {
        showError("Data monitoring tidak ditemukan.", $connection);
        exit;
    }

    $new_foto_berat = uploadMonitoringFile('foto_berat');
    $new_foto_kulit = uploadMonitoringFile('foto_kulit');
    $delete_foto_berat = isset($_POST['delete_foto_berat']);
    $delete_foto_kulit = isset($_POST['delete_foto_kulit']);

    $foto_berat = $oldMonitoring['foto_berat'];
    $foto_kulit = $oldMonitoring['foto_kulit'];

    if ($new_foto_berat) {
        deleteMonitoringFile($oldMonitoring['foto_berat']);
        $foto_berat = $new_foto_berat;
    } elseif ($delete_foto_berat) {
        deleteMonitoringFile($oldMonitoring['foto_berat']);
        $foto_berat = null;
    }

    if ($new_foto_kulit) {
        deleteMonitoringFile($oldMonitoring['foto_kulit']);
        $foto_kulit = $new_foto_kulit;
    } elseif ($delete_foto_kulit) {
        deleteMonitoringFile($oldMonitoring['foto_kulit']);
        $foto_kulit = null;
    }

    $updateMonitoring = $monitoring->update($id, $id_tikus, $hari_ke, $berat_badan, $skor_eritema, $skor_edema, $foto_berat, $foto_kulit, $tanggal);

    if ($updateMonitoring) {
        redirectToPages($id_tikus);
    } else {
        showError("Data monitoring gagal diperbarui. Silakan periksa kembali data yang diinput.", $connection);
    }
}

if (isset($_POST['deleteMonitoring'])) {
    $id = $_POST['id'];
    $id_tikus = $_POST['id_tikus'] ?? null;
    $oldMonitoring = $monitoring->findById($id);

    if (!$oldMonitoring) {
        showError("Data monitoring tidak ditemukan.", $connection);
        exit;
    }

    $deleteMonitoring = $monitoring->delete($id);

    if ($deleteMonitoring) {
        deleteMonitoringFile($oldMonitoring['foto_berat']);
        deleteMonitoringFile($oldMonitoring['foto_kulit']);
        redirectToPages($id_tikus ?: $oldMonitoring['id_tikus']);
    } else {
        showError("Data monitoring gagal dihapus. Pastikan data masih tersedia.", $connection);
    }
}
