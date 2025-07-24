<?php
include "../includes/db.php";
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil ID dari URL
$id_balita = $_GET['id'] ?? null;

// Cek ID valid
if (!$id_balita) {
    echo "ID tidak ditemukan!";
    exit();
}

// Ambil data balita dari database
$sql = "SELECT * FROM data_balita WHERE id_balita = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_balita);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Jika data tidak ditemukan
if (!$data) {
    echo "Data balita tidak ditemukan.";
    exit();
}
?>

<div class="main">
    <h2 style="color: #8e2de2;">Edit Data Balita</h2>

    <form action="update_balita.php" method="post" style="max-width: 800px; margin: auto;">
        <input type="hidden" name="id_balita" value="<?= $data['id_balita'] ?>">

        <label>Nama Ibu:</label>
        <input type="text" name="na_ibu" value="<?= $data['na_ibu'] ?>" required><br>

        <label>NIK:</label>
        <input type="text" name="nik_balita" value="<?= $data['nik_balita'] ?>" required><br>

        <label>Nama Balita:</label>
        <input type="text" name="na_balita" value="<?= $data['na_balita'] ?>" required><br>

        <label>Alamat:</label>
        <input type="text" name="alamat_balita" value="<?= $data['alamat_balita'] ?>" required><br>

        <label>Tempat Lahir:</label>
        <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" required><br>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir_balita" value="<?= $data['tanggal_lahir_balita'] ?>" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki" <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
            <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
        </select><br>

        <label>No Telp:</label>
        <input type="text" name="no_tlp" value="<?= $data['no_tlp'] ?>"><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
