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

<div class="main">
    <h2 style="color: #8e2de2;">Laporan Pemeriksaan Balita</h2>

    <!-- Search dan Tombol -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
        <input type="text" id="searchInput" placeholder="Cari Data Pemeriksaan"
               style="padding: 8px 15px; border-radius: 20px; border: 1px solid #ccc; width: 300px;">

        <button onclick="window.print()"
                style="background-color: #a55eea; color: white; border: none; border-radius: 30px; padding: 8px 20px; font-weight: bold;">
            Download PDF
        </button>
    </div>

    <!-- Tabel -->
    <div style="overflow-x: auto;">
        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #e7d8fb; color: #8e2de2;">
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
                    <th style="width: 60px;"><i>Aksi</i></th>
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
                    echo "<td>{$row['na_balita']}</td>"; // nama balita dari tabel data_balita
                    echo "<td>{$row['bb_balita']}</td>";
                    echo "<td>{$row['tb_balita']}</td>";
                    echo "<td>{$row['lila_balita']}</td>";
                    echo "<td>{$row['lika_balita']}</td>";
                    echo "<td>{$row['tanggal_pemeriksaan']}</td>";
                    echo "<td>
                        <a href='edit_pemeriksaan.php?id={$row['no_register']}' style='color:#8e2de2; margin-right:10px;'><i class='fas fa-edit'></i></a>
                        <a href='hapus_pemeriksaan.php?id={$row['no_register']}' onclick=\"return confirm('Yakin ingin menghapus?')\" style='color:#8e2de2;'><i class='fas fa-trash-alt'></i></a>
                    </td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Filter Search -->
<script>
    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("#dataBody tr");

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
