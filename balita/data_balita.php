<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_balita"];
    $nama = $_POST["na_balita"];
    $nik = $_POST["nik_balita"];
    $alamat = $_POST["alamat_balita"];
    $tempat = $_POST["tempat_lahir"];
    $tgl = $_POST["tanggal_lahir_balita"];
    $jk = $_POST["jenis_kelamin"];
    $ibu = $_POST["na_ibu"];
    $nik_ibu = $_POST["nik_ibu"];
    $alamat_ibu = $_POST["alamat_ibu"];
    $no_tlp = $_POST["no_tlp"];

    $query = "INSERT INTO data_balita VALUES ('$id', '$nama', '$nik', '$alamat', '$tempat', '$tgl', '$jk', '$ibu', '$nik_ibu', '$alamat_ibu', '$no_tlp')";
    mysqli_query($conn, $query);

    header("Location: data_balita.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Balita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: linear-gradient(to right, #f0f9ff, #e0f2f1); }

        .header {
            background-color: #ccc;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header span {
            font-size: 14px;
            color: #333;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #888;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 15px;
            font-size: 14px;
            font-weight: bold;
            background-color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }

        .sidebar button:hover {
            background-color: #e3e3e3;
        }

        .form-area {
            flex: 1;
            padding: 40px;
        }

        .form-area form {
            max-width: 600px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #aaa;
            box-sizing: border-box;
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .simpan { background-color: #4CAF50; color: white; }
        .kembali { background-color: #777; color: white; }
        .edit, .hapus { background-color: #ccc; }

        .form-actions button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Sistem Informasi Pendaftaran dan Pemeriksaan Balita di Posyandu Kemuning 13</h1>
    <span>Jl KH Samanhudi No 186, Jantirejo RT 01 RW 13, Sondakan Laweyan Surakarta</span>
</div>

<div class="container">
    <div class="sidebar">
        <button onclick="window.location.href='../dashboard.php'">Menu Utama</button>
        <button onclick="window.location.href='input_balita.php'">Input Data Identitas Balita</button>
        <button onclick="window.location.href='../pemeriksaan/input_pemeriksaan.php'">Input Data Pemeriksaan Balita</button>
        <button onclick="window.location.href='laporan_balita.php'">Lap Data Balita</button>
        <button onclick="window.location.href='../pemeriksaan/laporan_pemeriksaan.php'">Lap Data Pemeriksaan Balita</button>
    </div>

    <div class="form-area">
        <h2>Input Data Balita</h2>
        <form method="POST">
            <div class="form-group">
                <label>ID BALITA</label>
                <input type="text" name="id_balita" required>
            </div>
            <div class="form-group">
                <label>Nama Balita</label>
                <input type="text" name="na_balita" required>
            </div>
            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik_balita">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat_balita">
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir_balita">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Ibu</label>
                <input type="text" name="na_ibu">
            </div>
            <div class="form-group">
                <label>NIK Ibu</label>
                <input type="text" name="nik_ibu">
            </div>
            <div class="form-group">
                <label>Alamat Ibu</label>
                <input type="text" name="alamat_ibu">
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_tlp">
            </div>

            <div class="form-actions">
                <button type="button" class="edit" disabled>Edit</button>
                <button type="button" class="hapus" disabled>Hapus</button>
                <button type="button" class="kembali" onclick="window.location.href='data_balita.php'">Kembali</button>
                <button type="submit" class="simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
