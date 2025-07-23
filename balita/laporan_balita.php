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

<div class="main">
    <h2 style="color: #8e2de2;">Laporan Data Balita</h2>

    <!-- Search dan Tombol -->
    <!-- Search dan Tombol -->
<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
    <div style="position: relative; width: 300px;">
        <input type="text" id="searchInput" placeholder="Cari Data Pemeriksaan"
               style="padding: 8px 15px 8px 35px; border-radius: 20px; border: 1px solid #ccc; width: 100%;">
        <i class="fas fa-search" style="position: absolute; left: 12px; top: 9px; color: #aaa;"></i>
    </div>

    <button onclick="window.print()"
            style="background-color: #a55eea; color: white; border: none; border-radius: 30px; padding: 8px 20px; font-weight: bold;">
        Download PDF
    </button>
</div>


    <!-- Tabel -->
    <div style="overflow-x: auto;">
        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #e7d8fb; color: #8e2de2;">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                    <th style="width: 50px;"><i>Aksi</i></th>
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
                        <a href='edit_balita.php?id={$row['id_balita']}' style='color:#8e2de2; margin-right:10px;'><i class='fas fa-edit'></i></a>
                        <a href='hapus_balita.php?id={$row['id_balita']}' onclick=\"return confirm('Yakin ingin menghapus?')\" style='color:#8e2de2;'><i class='fas fa-trash-alt'></i></a>
                    </td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
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
    } else {
        console.warn("Search input atau data body tidak ditemukan.");
    }
});
</script>
