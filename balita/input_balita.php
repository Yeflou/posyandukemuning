<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Balita</title>
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
        <h2>Input Data Balita</h2>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="success-message">
                ✅ Data berhasil diinputkan!
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="error-message">
                ❌ Gagal menyimpan data!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
            <script>
                alert("ID Balita sudah digunakan, masukkan ID yang baru.");
            </script>
        <?php endif; ?>

        <form action="simpan_balita.php" method="post" style="max-width: 1000px; margin: auto;" id="formBalita">
            <div style="display: flex; gap: 40px;">
                <!-- KIRI -->
                <div style="flex: 1;">
                    <label>ID BALITA</label>
                    <input type="text" name="id_balita" id="id_balita" required placeholder="Contoh: 000001" onblur="checkIdBalita()">
                    <div id="id_balita_status" style="font-size: 12px; margin-top: -5px; margin-bottom: 10px;"></div>

                    <label>Nama Ibu</label>
                    <input type="text" name="na_ibu" required placeholder="Masukkan nama Ibu Kandung">

                    <label>NIK Balita</label>
                    <input type="text" name="nik_balita" id="nik_balita" required placeholder="Contoh: 3370909090987654" onblur="checkNikBalita()">
                    <div id="nik_balita_status" style="font-size: 12px; margin-top: -5px; margin-bottom: 10px;"></div>

                    <label>Nama Balita</label>
                    <input type="text" name="na_balita" required placeholder="Masukkan nama balita">

                    <label>Alamat</label>
                    <input type="text" name="alamat_balita" required placeholder="Alamat Lengkap">
                </div>

                <!-- KANAN -->
                <div style="flex: 1;">
                    <label>Tempat Lahir Balita</label>
                    <input type="text" name="tempat_lahir" required placeholder="Contoh: Bandung">

                    <label>Tanggal Lahir Balita</label>
                    <input type="date" name="tanggal_lahir_balita" required>

                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>

                    <label>No Telp</label>
                    <input type="text" name="no_tlp" pattern="[0-9]+" title="Hanya angka" placeholder="Contoh :081234567890">
                </div>
            </div>

            <!-- TOMBOL -->
            <div style="text-align: center; margin-top: 20px;">
                <button type="reset">Hapus</button>
                <button type="button" onclick="window.location.href='../auth/beranda.php'">Kembali</button>
                <button type="submit" onclick="return validateForm()">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
// Variabel untuk tracking status validasi
let idBalitaValid = false;
let nikBalitaValid = false;

// Fungsi untuk mengecek ID Balita
function checkIdBalita() {
    const idBalita = document.getElementById('id_balita').value.trim();
    const statusDiv = document.getElementById('id_balita_status');
    
    if (idBalita === '') {
        statusDiv.innerHTML = '';
        idBalitaValid = false;
        return;
    }
    
    // Validasi format ID (hanya angka, 6 digit)
    if (!/^\d{6}$/.test(idBalita)) {
        statusDiv.innerHTML = '<span class="validation-status error">❌ ID harus 6 digit angka</span>';
        idBalitaValid = false;
        return;
    }
    
    // Cek ke database
    fetch('check_duplicate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'type=id_balita&value=' + encodeURIComponent(idBalita)
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            statusDiv.innerHTML = '<span class="validation-status error">❌ ID Balita sudah digunakan</span>';
            idBalitaValid = false;
        } else {
            statusDiv.innerHTML = '<span class="validation-status success">✅ ID Balita tersedia</span>';
            idBalitaValid = true;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        statusDiv.innerHTML = '<span class="validation-status warning">⚠️ Gagal mengecek ketersediaan ID</span>';
        idBalitaValid = false;
    });
}

// Fungsi untuk mengecek NIK Balita
function checkNikBalita() {
    const nikBalita = document.getElementById('nik_balita').value.trim();
    const statusDiv = document.getElementById('nik_balita_status');
    
    if (nikBalita === '') {
        statusDiv.innerHTML = '';
        nikBalitaValid = false;
        return;
    }
    
    // Validasi format NIK (16 digit angka)
    if (!/^\d{16}$/.test(nikBalita)) {
        statusDiv.innerHTML = '<span class="validation-status error">❌ NIK harus 16 digit angka</span>';
        nikBalitaValid = false;
        return;
    }
    
    // Cek ke database
    fetch('check_duplicate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'type=nik_balita&value=' + encodeURIComponent(nikBalita)
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            statusDiv.innerHTML = '<span class="validation-status error">❌ NIK sudah terdaftar</span>';
            nikBalitaValid = false;
        } else {
            statusDiv.innerHTML = '<span class="validation-status success">✅ NIK tersedia</span>';
            nikBalitaValid = true;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        statusDiv.innerHTML = '<span class="validation-status warning">⚠️ Gagal mengecek ketersediaan NIK</span>';
        nikBalitaValid = false;
    });
}

// Fungsi validasi form sebelum submit
function validateForm() {
    const form = document.getElementById('formBalita');
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
    
    // Cek validasi ID dan NIK
    if (!idBalitaValid || !nikBalitaValid) {
        Swal.fire({
            icon: 'warning',
            title: 'Data Belum Valid!',
            text: 'Mohon periksa kembali ID Balita dan NIK yang dimasukkan.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#8e2de2'
        });
        return false;
    }
    
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
        title: 'Simpan Data Balita?',
        text: 'Apakah Anda yakin ingin menyimpan data balita ini?',
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
