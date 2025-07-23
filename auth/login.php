<?php
session_start();
include "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare($conn, "SELECT * FROM user_login WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
        // Benar (naik ke root tempat dashboard.php berada)
       header("Location: http://localhost/posyandukemuning/auth/dashboard.php");



            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Posyandu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fff;
        }

        .header {
            background: linear-gradient(to right, #8c52ff, #34c5cb);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header small {
            display: block;
            margin-top: 5px;
            font-size: 14px;
            font-weight: normal;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            flex-wrap: wrap;
        }

        .login-box {
            background-color: #f2eaff;
            padding: 30px;
            border-radius: 30px;
            width: 350px;
            margin: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #8e2de2;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #888;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            font-size: 16px;
            border: 2px solid #d0bfff;
            border-radius: 25px;
            outline: none;
            background: #fff;
        }

        button.login-btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            background-color: #8e2de2;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button.login-btn:hover {
            background-color: #6d19be;
        }

        .login-image img {
            max-width: 500px;
            height: auto;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        @media(max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 20px;
            }

            .login-image {
                margin-top: 30px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Sistem Informasi Pendaftaran dan Pemeriksaan Balita di Posyandu Kemuning 13</h1>
    <small>
Jalan K.H samanhudi No.186 Jantirejo RT 01/ RW 13 Sondakan Laweyan Surakarta</small>
</div>

<div class="container">
    <div class="login-box">
        <form method="POST">
            <h2>Silahkan login</h2>
            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

    <div class="login-image">
      <img src="/posyandukemuning/assets/images/login.png" alt="Ilustrasi">

    </div>
</div>

</body>
</html>
