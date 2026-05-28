<?php

require_once (__DIR__ . "/../../app/models/Tikus.php");
require_once (__DIR__ . "/../../app/config/Database.php");

$logoTikusPath = "../../src/img/tikus.png";

$database = new Database();
$connection = $database->connect();

$tikus = new Tikus($connection);
$showAll = $tikus->showAll();

$no = 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CDN Daisy UI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- CDN Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="shortcut icon" href="<?= $logoTikusPath ?>" type="image/x-icon">

    <title>Tikus</title>
</head>
<body>
    <header>
        <div class="navbar bg-base-200 shadow-sm">
            <div class="navbar-start">
                <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /> </svg>
                </div>
                <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="../contents/tikus.php">Tikus</a></li>
                    <li><a href="../contents/sampel.php">Sampel</a></li>
                    <li><a href="../contents/monitoring.php">Monitoring</a></li>
                </ul>
                </div>
            </div>
            <div class="navbar-end">
                <a class="italic font-bold btn btn-ghost text-xl">MONITORING TIKUS</a>
            </div>
        </div>
    </header>
