<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil semua id_balita dari tabel data_balita
$balita_result = mysqli_query($conn, "SELECT id_balita, na_balita FROM data_balita");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Pemeriksaan Balita</title>
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
        <a href="../auth/beranda.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="../balita/input_balita.php"><i class="fas fa-user-plus"></i> Input Data Balita</a>
        <a href="input_pemeriksaan.php"><i class="fas fa-notes-medical"></i> Input Data Pemeriksaan Balita</a>
        <a href="../balita/laporan_balita.php"><i class="fas fa-file-alt"></i> Laporan Data Balita</a>
        <a href="laporan_pemeriksaan.php"><i class="fas fa-shield-alt"></i> Laporan Pemeriksaan Balita</a>
        <a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <h2>Input Data Pemeriksaan Balita</h2>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="success-message">
                ✅ Data berhasil disimpan!
            </div>
        <?php endif; ?>

        <form action="simpan_pemeriksaan.php" method="post" style="max-width: 1000px; margin: auto;">
            <div style="display: flex; gap: 40px;">
                <!-- KIRI -->
                <div style="flex: 1;">
                    <label>ID BALITA</label>
                    <select name="id_balita" required>
                        <option value="">-- Pilih ID Balita --</option>
                        <?php while ($row = mysqli_fetch_assoc($balita_result)): ?>
                            <option value="<?= $row['id_balita'] ?>">
                                <?= $row['id_balita'] ?> - <?= $row['na_balita'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label>No Register</label>
                    <input type="text" name="no_register" required placeholder="Contoh: 01">

                    <label>Berat Badan</label>
                    <input type="text" name="bb_balita" required placeholder="Contoh: 10">

                    <label>Tinggi Badan</label>
                    <input type="text" name="tb_balita" required placeholder="Contoh: 50">
                </div>

                <!-- KANAN -->
                <div style="flex: 1;">
                    <label>Lingkar Lengan</label>
                    <input type="text" name="lila_balita" required placeholder="Contoh: 15">

                    <label>Lingkar Kepala</label>
                    <input type="text" name="lika_balita" required placeholder="Contoh: 42">

                    <label>Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" required>
                </div>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button type="reset">Hapus</button>
                <button type="button" onclick="window.location.href='../auth/beranda.php'">Kembali</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
