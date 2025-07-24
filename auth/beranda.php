<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Posyandu Kemuning 13</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="header">
    <h1>Sistem Informasi Pendaftaran dan Pemeriksaan Balita di Posyandu Kemuning 13</h1>
    <small>Jl KH Samanhudi No. 186, Jantirejo RT 01 RW 13, Sondakan, Laweyan, Surakarta</small>
</div>

<div class="container">
    <div class="sidebar">
        <a href="beranda.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="../balita/input_balita.php"><i class="fas fa-user-plus"></i> Input Data Balita</a>
        <a href="../pemeriksaan/input_pemeriksaan.php"><i class="fas fa-notes-medical"></i> Input Data Pemeriksaan Balita</a>
        <a href="../balita/laporan_balita.php"><i class="fas fa-file-alt"></i> Laporan Data Balita</a>
        <a href="../pemeriksaan/laporan_pemeriksaan.php"><i class="fas fa-shield-alt"></i> Laporan Pemeriksaan Balita</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <h2>Selamat Datang di Sistem Posyandu Kemuning 13</h2>
        <h3 style="font-size: 16px; color: #8e2de2;">
            Sistem ini digunakan untuk mencatat data balita dan pemeriksaan rutin yang dilakukan di Posyandu Kemuning 13.
        </h3>
        <img src="../assets/images/welcome.png" alt="Ilustrasi Selamat Datang"
             style="max-width: 500px; width: 100%; margin-top: 20px;">
    </div>
</div>

</body>
</html>
