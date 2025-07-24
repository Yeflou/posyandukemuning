<?php
session_start();
session_destroy(); // Hapus semua session login

// Redirect ke halaman login
header("Location: /posyandukemuning/auth/login.php");
exit();
