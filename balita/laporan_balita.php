<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil data balita dari database
$query = "SELECT * FROM data_balita";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Balita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="header">
    <h1>Sistem Informasi Pendaftaran dan Pemeriksaan Balita di Posyandu Kemuning 13</h1>
    <small>Jl KH Samanhudi No. 186, Jantirejo RT 01 RW 13, Sondakan, Laweyan, Surakarta</small>
</div>

<div class="container">
    <div class="sidebar">
        <a href="../auth/beranda.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="input_balita.php"><i class="fas fa-user-plus"></i> Input Data Balita</a>
        <a href="../pemeriksaan/input_pemeriksaan.php"><i class="fas fa-notes-medical"></i> Input Data Pemeriksaan Balita</a>
        <a href="laporan_balita.php"><i class="fas fa-file-alt"></i> Laporan Data Balita</a>
        <a href="../pemeriksaan/laporan_pemeriksaan.php"><i class="fas fa-shield-alt"></i> Laporan Pemeriksaan Balita</a>
        <a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <h2>Laporan Data Balita</h2>

        <!-- Search dan Tombol -->
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari Data Balita">
                <i class="fas fa-search"></i>
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
                        <th>Id Balita</th>
                        <th>Nama Ibu Balita</th>
                        <th>Nama Balita</th>
                        <th>NIK Balita</th>
                        <th>Alamat Balita</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Telp</th>
                        <th style="width: 50px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataBody">
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$no}.</td>";
                        echo "<td>{$row['id_balita']}</td>";
                        echo "<td>{$row['na_ibu']}</td>";
                        echo "<td>{$row['na_balita']}</td>";
                        echo "<td>{$row['nik_balita']}</td>";
                        echo "<td>{$row['alamat_balita']}</td>";
                        echo "<td>{$row['tempat_lahir']}</td>";
                        echo "<td>{$row['tanggal_lahir_balita']}</td>";
                        echo "<td>{$row['jenis_kelamin']}</td>";
                        echo "<td>{$row['no_tlp']}</td>";
                        echo "<td>
                            <a href='edit_balita.php?id={$row['id_balita']}' class='action-btn'><i class='fas fa-edit'></i></a>
                            <a href='#' onclick=\"confirmDelete('{$row['id_balita']}', '{$row['na_balita']}')\" class='action-btn'><i class='fas fa-trash-alt'></i></a>
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

<!-- Filter Search JS -->
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

// Fungsi konfirmasi hapus dengan SweetAlert2
function confirmDelete(idBalita, namaBalita) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Data Balita?',
        html: `Apakah Anda yakin ingin menghapus data balita <strong>${namaBalita}</strong> (ID: ${idBalita})?<br><br><small style="color: #dc3545;">Tindakan ini tidak dapat dibatalkan!</small>`,
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke halaman hapus
            window.location.href = `hapus_balita.php?id=${idBalita}`;
        }
    });
}

// Tampilkan notifikasi jika ada parameter status di URL
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');
    
    if (status === 'success' && message) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#8e2de2'
        });
    } else if (status === 'error' && message) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#8e2de2'
        });
    }
});
</script>

</body>
</html>
