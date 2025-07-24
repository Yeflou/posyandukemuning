<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .header {
            background: linear-gradient(to right, #8e2de2, #34c5cb);
            color: white;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header small {
            font-size: 13px;
        }

        .container {
            display: flex;
            height: calc(100vh - 100px);
        }

        .sidebar {
            width: 300px;
            background-color: #a55eea;
            padding: 20px 10px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            margin: 8px 0;
            width: 80%;
            text-decoration: none;
            color: white;
            background-color: #bb86fc;
            border-radius: 30px;
            font-weight: bold;
            padding: 12px 20px 12px 30px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #7b4ddb;
        }

        .sidebar i {
            margin-right: 16px;
            font-size: 18px;
        }

        .main {
            flex: 1;
            padding: 30px;
            text-align: center;
        }

        .main h2 {
            color: #8e2de2;
        }

        .main img {
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Sistem Informasi Pendaftaran dan Pemeriksaan Balita di Posyandu Kemuning 13</h1>
    <small>Jl KH Samanhudi No. 186, Jantirejo RT 01 RW 13, Sondakan, Laweyan, Surakarta</small>
</div>

<div class="container">
    <div class="sidebar">
       <div class="sidebar">
    <a href="#" onclick="loadPage('/posyandukemuning/auth/beranda.php')"><i class="fas fa-home"></i> Beranda</a>
    <a href="#" onclick="loadPage('/posyandukemuning/balita/input_balita.php')"><i class="fas fa-user-plus"></i> Input Data Balita</a>
    <a href="#" onclick="loadPage('/posyandukemuning/pemeriksaan/input_pemeriksaan.php')"><i class="fas fa-notes-medical"></i> Input Data Pemeriksaan Balita</a>
    <a href="#" onclick="loadPage('/posyandukemuning/balita/laporan_balita.php')"><i class="fas fa-file-alt"></i> Laporan Data Balita</a>
    <a href="#" onclick="loadPage('/posyandukemuning/pemeriksaan/laporan_pemeriksaan.php')"><i class="fas fa-shield-alt"></i> Laporan Pemeriksaan Balita</a>
    <a href="/posyandukemuning/auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

    </div>

    <div class="main" id="main-content">
        <h2>Selamat Datang di Sistem Posyandu Kemuning 13</h2>
        <h3 style="font-size: 16px; color: #8e2de2;">
    Sistem ini digunakan untuk mencatat data balita dan pemeriksaan rutin yang dilakukan di Posyandu Kemuning 13.
</h3>
        <img src="/posyandukemuning/assets/images/welcome.png" alt="Ilustrasi Selamat Datang"
     style="max-width: 500px; width: 100%; margin-top: 20px;">

    </div>
</div>

<script>
function loadPage(file) {
    fetch(file)
        .then(res => {
            if (!res.ok) throw new Error("Gagal memuat halaman");
            return res.text();
        })
        .then(html => {
            document.getElementById("main-content").innerHTML = html;
        })
        .catch(err => {
            document.getElementById("main-content").innerHTML = `<p style="color:red;">${err.message}</p>`;
        });
}
</script>

</body>
<script>
  function loadPage(page) {
    fetch(page)
      .then(response => response.text())
      .then(html => {
        document.getElementById('main-content').innerHTML = html;
      })
      .catch(err => {
        document.getElementById('main-content').innerHTML = "<p>Halaman gagal dimuat.</p>";
        console.error("Gagal memuat halaman:", err);
      });
  }
</script>

</html>
