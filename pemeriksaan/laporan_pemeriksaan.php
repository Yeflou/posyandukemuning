<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil data pemeriksaan + nama balita dari database
$query = "
    SELECT pemeriksaan_balita.*, data_balita.na_balita 
    FROM pemeriksaan_balita 
    JOIN data_balita ON pemeriksaan_balita.id_balita = data_balita.id_balita
    ORDER BY pemeriksaan_balita.tanggal_pemeriksaan DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksaan Balita</title>
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
        <h2>Laporan Pemeriksaan Balita</h2>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="success-message">
                ✅ Data pemeriksaan berhasil disimpan!
            </div>
        <?php endif; ?>

        <!-- Search dan Tombol -->
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari Data Pemeriksaan">
            </div>

            <button onclick="window.print()" class="download-btn">
                Download PDF
            </button>
        </div>

        <!-- Tabel -->
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Register</th>
                        <th>ID Balita</th>
                        <th>Nama Balita</th>
                        <th>Berat Badan (kg)</th>
                        <th>Tinggi Badan (cm)</th>
                        <th>Lingkar Lengan (cm)</th>
                        <th>Lingkar Kepala (cm)</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th style="width: 60px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataBody">
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$no}.</td>";
                        echo "<td>{$row['no_register']}</td>";
                        echo "<td>{$row['id_balita']}</td>";
                        echo "<td>{$row['na_balita']}</td>";
                        echo "<td>{$row['bb_balita']}</td>";
                        echo "<td>{$row['tb_balita']}</td>";
                        echo "<td>{$row['lila_balita']}</td>";
                        echo "<td>{$row['lika_balita']}</td>";
                        echo "<td>{$row['tanggal_pemeriksaan']}</td>";
                        echo "<td>
                            <a href='edit_pemeriksaan.php?id={$row['no_register']}' class='action-btn'><i class='fas fa-edit'></i></a>
                            <a href='hapus_pemeriksaan.php?id={$row['no_register']}' onclick=\"return confirm('Yakin ingin menghapus?')\" class='action-btn'><i class='fas fa-trash-alt'></i></a>
                        </td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Filter Search -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const dataBody = document.getElementById("dataBody");

    if (searchInput && dataBody) {
        searchInput.addEventListener("keyup", function () {
            const filter = searchInput.value.toLowerCase();
            const rows = dataBody.querySelectorAll("tr");

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    }
});
</script>

</body>
</html>
