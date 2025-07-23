<?php
include "includes/db.php";
session_start();

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_balita WHERE id_balita='$id'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $na_balita = $_POST["na_balita"];
    $nik_balita = $_POST["nik_balita"];
    $alamat_balita = $_POST["alamat_balita"];
    $tempat_lahir = $_POST["tempat_lahir"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $na_ibu = $_POST["na_ibu"];
    $nik_ibu = $_POST["nik_ibu"];
    $alamat_ibu = $_POST["alamat_ibu"];
    $no_tlp = $_POST["no_tlp"];

    $sql = "UPDATE data_balita SET 
        na_balita='$na_balita',
        nik_balita='$nik_balita',
        alamat_balita='$alamat_balita',
        tempat_lahir='$tempat_lahir',
        tanggal_lahir_balita='$tanggal_lahir',
        jenis_kelamin='$jenis_kelamin',
        na_ibu='$na_ibu',
        nik_ibu='$nik_ibu',
        alamat_ibu='$alamat_ibu',
        no_tlp='$no_tlp'
        WHERE id_balita='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diupdate'); window.location.href='data_balita.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Balita</title></head>
<body>
    <h2>Edit Data Balita</h2>
    <form method="POST">
        Nama Balita: <input type="text" name="na_balita" value="<?= $data['na_balita'] ?>"><br>
        NIK Balita: <input type="text" name="nik_balita" value="<?= $data['nik_balita'] ?>"><br>
        Alamat: <input type="text" name="alamat_balita" value="<?= $data['alamat_balita'] ?>"><br>
        Tempat Lahir: <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>"><br>
        Tanggal Lahir: <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir_balita'] ?>"><br>
        Jenis Kelamin:
        <select name="jenis_kelamin">
            <option value="Laki-laki" <?= $data['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
            <option value="Perempuan" <?= $data['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
        </select><br>
        Nama Ibu: <input type="text" name="na_ibu" value="<?= $data['na_ibu'] ?>"><br>
        NIK Ibu: <input type="text" name="nik_ibu" value="<?= $data['nik_ibu'] ?>"><br>
        Alamat Ibu: <input type="text" name="alamat_ibu" value="<?= $data['alamat_ibu'] ?>"><br>
        No Telp: <input type="text" name="no_tlp" value="<?= $data['no_tlp'] ?>"><br>
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
