<?php
include "includes/db.php";
session_start();

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan_balita WHERE no_register='$id'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_balita = $_POST["id_balita"];
    $bb = $_POST["bb_balita"];
    $tb = $_POST["tb_balita"];
    $lila = $_POST["lila_balita"];
    $lika = $_POST["lika_balita"];
    $tanggal = $_POST["tanggal_pemeriksaan"];

    $sql = "UPDATE pemeriksaan_balita SET 
        id_balita='$id_balita',
        bb_balita=$bb,
        tb_balita=$tb,
        lila_balita=$lila,
        lika_balita=$lika,
        tanggal_pemeriksaan='$tanggal'
        WHERE no_register='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diupdate'); window.location.href='data_pemeriksaan.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Pemeriksaan</title></head>
<body>
    <h2>Edit Pemeriksaan Balita</h2>
    <form method="POST">
        ID Balita:
        <select name="id_balita" required>
            <?php
            $result = mysqli_query($conn, "SELECT id_balita, na_balita FROM data_balita");
            while ($balita = mysqli_fetch_assoc($result)) {
                $selected = $balita['id_balita'] == $data['id_balita'] ? "selected" : "";
                echo "<option value='{$balita['id_balita']}' $selected>{$balita['id_balita']} - {$balita['na_balita']}</option>";
            }
            ?>
        </select><br>
        Berat Badan: <input type="number" name="bb_balita" value="<?= $data['bb_balita'] ?>"><br>
        Tinggi Badan: <input type="number" name="tb_balita" value="<?= $data['tb_balita'] ?>"><br>
        Lingkar Lengan: <input type="number" name="lila_balita" value="<?= $data['lila_balita'] ?>"><br>
        Lingkar Kepala: <input type="number" name="lika_balita" value="<?= $data['lika_balita'] ?>"><br>
        Tanggal Pemeriksaan: <input type="date" name="tanggal_pemeriksaan" value="<?= $data['tanggal_pemeriksaan'] ?>"><br>
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
