<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<div class="main" style="text-align: left;">
    <h2 style="color: #8e2de2; text-align: center;">Input Data Balita</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div style="color: green; font-weight: bold; margin-bottom: 15px; background-color: #e6ffe6; padding: 10px; border-radius: 10px;">
            ✅ Data berhasil diinputkan!
        </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
        <div style="color: red; font-weight: bold; margin-bottom: 15px; background-color: #ffe6e6; padding: 10px; border-radius: 10px;">
            ❌ Gagal menyimpan data!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'duplicate'): ?>
        <script>
            alert("ID Balita sudah digunakan, masukkan ID yang baru.");
        </script>
    <?php endif; ?>

    <!-- Cegah alert muncul dua kali saat refresh -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname + "?page=input_balita");
        }
    </script>

    <!-- ✅ FORM -->
    <form action="/posyandukemuning/balita/simpan_balita.php" method="post" style="max-width: 1000px; margin: auto;">
        <div style="display: flex; gap: 40px;">
            <!-- KIRI -->
            <div style="flex: 1;">
                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">ID BALITA</label>
                <input type="text" name="id_balita" required placeholder="Contoh: 0001" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">Nama Ibu</label>
                <input type="text" name="na_ibu" required placeholder="Masukkan nama Ibu Kandung" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">NIK Balita</label>
                <input type="text" name="nik_balita" required placeholder="Contoh: 3370909090987654" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">Nama Balita</label>
                <input type="text" name="na_balita" required placeholder="Masukkan nama balita" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">Alamat</label>
                <input type="text" name="alamat_balita" required placeholder="Alamat Lengkap" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">
            </div>

            <!-- KANAN -->
            <div style="flex: 1;">
                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">Tempat Lahir Balita</label>
                <input type="text" name="tempat_lahir" required placeholder="Contoh: Bandung" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">Tanggal Lahir Balita</label>
                <input type="date" name="tanggal_lahir_balita" required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">Jenis Kelamin</label>
                <select name="jenis_kelamin" required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>

                <label style="color: #8e2de2; font-weight: bold; display: block; margin-left: 5px;">No Telp</label>
                <input type="text" name="no_tlp" pattern="[0-9]+" title="Hanya angka" placeholder="Contoh :081234567890" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">
            </div>
        </div>

        <!-- ✅ TOMBOL -->
        <div style="text-align: center; margin-top: 20px;">
            <button type="reset" 
                style="padding: 10px 30px; border-radius: 30px; background-color: #d9b4f2; border: none; font-weight: bold; margin: 0 5px;">
                Hapus
            </button>

            <button type="button" onclick="loadPage('/posyandukemuning/auth/beranda.php')" 
                 style="padding: 10px 30px; border-radius: 30px; background-color: #d9b4f2; border: none; font-weight: bold; margin: 0 5px;">
                 Kembali
            </button>

            <button type="submit" 
                style="padding: 10px 30px; border-radius: 30px; background-color: #d9b4f2; border: none; font-weight: bold; margin: 0 5px;">
                Simpan
            </button>
        </div>
    </form>
</div>
