<?php
include('../includes/db.php');
session_start();

// Cek session
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Cek apakah ID dikirim dari URL
if (isset($_GET['id'])) {
    $id_balita = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Ambil nama balita untuk notifikasi
    $nama_query = "SELECT na_balita FROM data_balita WHERE id_balita = ?";
    $nama_stmt = $conn->prepare($nama_query);
    $nama_stmt->bind_param("s", $id_balita);
    $nama_stmt->execute();
    $nama_result = $nama_stmt->get_result();
    $nama_balita = "Unknown";
    
    if ($nama_row = $nama_result->fetch_assoc()) {
        $nama_balita = $nama_row['na_balita'];
    }
    $nama_stmt->close();

    // Mulai transaksi untuk memastikan konsistensi data
    $conn->begin_transaction();
    
    try {
        // Pertama, hapus semua data pemeriksaan yang terkait dengan balita ini
        $delete_pemeriksaan_query = "DELETE FROM pemeriksaan_balita WHERE id_balita = ?";
        $pemeriksaan_stmt = $conn->prepare($delete_pemeriksaan_query);
        $pemeriksaan_stmt->bind_param("s", $id_balita);
        $pemeriksaan_stmt->execute();
        $pemeriksaan_stmt->close();
        
        // Kemudian, hapus data balita
        $query = "DELETE FROM data_balita WHERE id_balita = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id_balita);
        $result = $stmt->execute();

        if ($result && $stmt->affected_rows > 0) {
            // Commit transaksi jika berhasil
            $conn->commit();
            
            // Berhasil hapus
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Success - Data Deleted</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Dihapus!',
                        text: 'Data balita \"$nama_balita\" (ID: $id_balita) dan semua data pemeriksaan terkait telah berhasil dihapus dari sistem.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#8e2de2'
                    }).then((result) => {
                        window.location.href = 'laporan_balita.php';
                    });
                </script>
            </body>
            </html>";
        } else {
            // Rollback jika gagal
            $conn->rollback();
            
            // Gagal hapus
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Error - Delete Failed</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menghapus Data!',
                        text: 'Terjadi kesalahan saat menghapus data. Data mungkin sudah tidak ada atau terjadi kesalahan sistem.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#8e2de2'
                    }).then((result) => {
                        window.location.href = 'laporan_balita.php';
                    });
                </script>
            </body>
            </html>";
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        // Rollback jika terjadi error
        $conn->rollback();
        
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Error - Database Error</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error Database!',
                    text: 'Terjadi kesalahan database saat menghapus data. Silakan coba lagi.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#8e2de2'
                }).then((result) => {
                    window.location.href = 'laporan_balita.php';
                });
            </script>
        </body>
        </html>";
    }
} else {
    // Jika tidak ada ID, tampilkan error
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error - No ID</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'ID Tidak Ditemukan!',
                text: 'Tidak ada ID balita yang diberikan untuk dihapus.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#8e2de2'
            }).then((result) => {
                window.location.href = 'laporan_balita.php';
            });
        </script>
    </body>
    </html>";
}

$conn->close();
?>
