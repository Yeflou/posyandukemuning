<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM data_balita");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Balita</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        a.button { padding: 6px 10px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>Daftar Data Balita</h2>
    <a href="input_balita.php" class="button">+ Tambah Balita</a>
    <a href="../auth/logout.php" style="float:right;">Logout</a>
    <br><br>
    <table>
        <tr>
            <th>ID</th><th>Nama</th><th>NIK</th><th>Alamat</th><th>Nama Ibu</th><th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['id_balita'] ?></td>
            <td><?= $row['na_balita'] ?></td>
            <td><?= $row['nik_balita'] ?></td>
            <td><?= $row['alamat_balita'] ?></td>
            <td><?= $row['na_ibu'] ?></td>
            <td>
                <a href="edit_balita.php?id=<?= $row['id_balita'] ?>">Edit</a> |
                <a href="hapus_balita.php?id=<?= $row['id_balita'] ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
