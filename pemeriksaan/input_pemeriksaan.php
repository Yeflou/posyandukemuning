<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil semua id_balita dari tabel data_balita
$balita_result = mysqli_query($conn, "SELECT id_balita, na_balita FROM data_balita");
?>
<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div style="color: green;">✅ Data berhasil disimpan!</div>
<?php endif; ?>


<div class="main">
    <h2 style="color: #8e2de2;">Input Data Pemeriksaan Balita</h2>

    <form action="/posyandukemuning/pemeriksaan/simpan_pemeriksaan.php" method="post" style="max-width: 1000px; margin: auto;">
        <div style="display: flex; gap: 40px;">
            <!-- KIRI -->
            <div style="flex: 1;">
               
                <label style="color: #8e2de2; font-weight: bold; display: block; text-align: left;  margin-left: 5px;">ID BALITA</label>
<select name="id_balita" required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">
    <option value="">-- Pilih ID Balita --</option>
    <?php while ($row = mysqli_fetch_assoc($balita_result)): ?>
        <option value="<?= $row['id_balita'] ?>">
            <?= $row['id_balita'] ?> - <?= $row['na_balita'] ?>
        </option>
    <?php endwhile; ?>
</select>

                <label style="color: #8e2de2; font-weight: bold; display: block; text-align: left; margin-left: 5px;">No Register</label>
                <input type="text" name="no_register" required placeholder="Contoh: 01" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; text-align: left; margin-left: 5px;">Berat Badan</label>
                <input type="text" name="bb_balita" required placeholder="Contoh: 10" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; text-align: left; margin-left: 5px;">Tinggi Badan</label>
                <input type="text" name="tb_balita" required placeholder="Contoh: 50" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                </div>

            <!-- KANAN -->
            <div style="flex: 1;">
              
                <label style="color: #8e2de2; font-weight: bold; display: block; text-align: left; margin-left: 5px;">Lingkar Lengan</label>
                <input type="text" name="lila_balita" required placeholder="Contoh: 15"style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; text-align: left; margin-left: 5px;">Lingkar Kepala</label>
                <input type="text" name="lika_balita" required placeholder="Contoh: 42" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">

                <label style="color: #8e2de2; font-weight: bold; display: block; text-align: left; margin-left: 5px;">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal_pemeriksaan" required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 20px; background-color: #e7d8fb; border: none;">
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
    <button type="reset" 
        style="padding: 10px 30px; border-radius: 30px; background-color: #d9b4f2; border: none; font-weight: bold; margin: 0 5px;">
        hapus
    </button>

    <button type="button" onclick="loadContent('dashboard.php')" 
        style="padding: 10px 30px; border-radius: 30px; background-color: #d9b4f2; border: none; font-weight: bold; margin: 0 5px;">
        kembali
    </button>

    <button type="submit" 
        style="padding: 10px 30px; border-radius: 30px; background-color: #d9b4f2; border: none; font-weight: bold; margin: 0 5px;">
        simpan
    </button>
</div>

    </form>
</div>
