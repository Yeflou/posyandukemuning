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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Balita</title>
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
        <h2>Edit Data Balita</h2>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="success-message">
                ✅ Data berhasil diperbarui!
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="error-message">
                ❌ Gagal memperbarui data!
            </div>
        <?php endif; ?>

        <form action="update_balita.php" method="post" style="max-width: 1000px; margin: auto;" id="formEditBalita">
            <input type="hidden" name="id_balita" value="<?= $data['id_balita'] ?>">

            <div style="display: flex; gap: 40px;">
                <!-- KIRI -->
                <div style="flex: 1;">
                    <label>ID BALITA</label>
                    <input type="text" name="id_balita_display" value="<?= $data['id_balita'] ?>" readonly style="background-color: #f8f9fa;">

                    <label>Nama Ibu</label>
                    <input type="text" name="na_ibu" value="<?= $data['na_ibu'] ?>" required placeholder="Masukkan nama Ibu Kandung">

                    <label>NIK Balita</label>
                    <input type="text" name="nik_balita" value="<?= $data['nik_balita'] ?>" required placeholder="Contoh: 3370909090987654">

                    <label>Nama Balita</label>
                    <input type="text" name="na_balita" value="<?= $data['na_balita'] ?>" required placeholder="Masukkan nama balita">

                    <label>Alamat</label>
                    <input type="text" name="alamat_balita" value="<?= $data['alamat_balita'] ?>" required placeholder="Alamat Lengkap">
                </div>

                <!-- KANAN -->
                <div style="flex: 1;">
                    <label>Tempat Lahir Balita</label>
                    <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" required placeholder="Contoh: Bandung">

                    <label>Tanggal Lahir Balita</label>
                    <input type="date" name="tanggal_lahir_balita" value="<?= $data['tanggal_lahir_balita'] ?>" required>

                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required>
                        <option value="Laki-laki" <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>

                    <label>No Telp</label>
                    <input type="text" name="no_tlp" value="<?= $data['no_tlp'] ?>" pattern="[0-9]+" title="Hanya angka" placeholder="Contoh :081234567890">
                </div>
            </div>

            <!-- TOMBOL -->
            <div style="text-align: center; margin-top: 20px;">
                <button type="button" onclick="window.location.href='data_balita.php'">Kembali</button>
                <button type="submit" onclick="return validateForm()">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
// Fungsi validasi form sebelum submit
function validateForm() {
    const form = document.getElementById('formEditBalita');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    // Cek field required
    requiredFields.forEach(field => {
        if (field.value.trim() === '') {
            field.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            field.style.borderColor = '';
        }
    });
    
    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            title: 'Data Belum Lengkap!',
            text: 'Mohon lengkapi semua field yang wajib diisi.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#8e2de2'
        });
        return false;
    }
    
    // Konfirmasi sebelum submit
    Swal.fire({
        icon: 'question',
        title: 'Simpan Perubahan?',
        text: 'Apakah Anda yakin ingin menyimpan perubahan data balita ini?',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#8e2de2',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    
    return false; // Prevent default form submission
}
</script>

</body>
</html>
