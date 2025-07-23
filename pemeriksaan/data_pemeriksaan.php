<?php
include "includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT p.*, d.na_balita FROM pemeriksaan_balita p JOIN data_balita d ON p.id_balita = d.id_balita");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pemeriksaan Balita</title>
</head>
<body>
    <h2>Data Pemeriksaan Balita</h2>
    <a href="input_pemeriksaan.php">+ Tambah Pemeriksaan</a><br><br>
    <table border="1" cellpadding="5">
        <tr>
            <th>No Register</th><th>Nama Balita</th><th>BB</th><th>TB</th>
            <th>LILA</th><th>LIKA</th><th>Tanggal</th><th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['no_register'] ?></td>
            <td><?= $row['na_balita'] ?></td>
            <td><?= $row['bb_balita'] ?> kg</td>
            <td><?= $row['tb_balita'] ?> cm</td>
            <td><?= $row['lila_balita'] ?> cm</td>
            <td><?= $row['lika_balita'] ?> cm</td>
            <td><?= $row['tanggal_pemeriksaan'] ?></td>
            <td>
                <a href="edit_pemeriksaan.php?id=<?= $row['no_register'] ?>">Edit</a> |
                <a href="hapus_pemeriksaan.php?id=<?= $row['no_register'] ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
