<?php
// Script untuk reset password admin
// Jalankan: reset-password.php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'smp_nurul_ikhlash';

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Password baru: admin123
    $new_password = 'admin123';
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password admin
    $sql = "UPDATE admins SET password = '$password_hash' WHERE username = 'admin'";

    if ($conn->query($sql)) {
        echo "✅ Password admin berhasil direset!<br>";
        echo "Username: admin<br>";
        echo "Password baru: admin123<br><br>";
        echo "<a href='admin/login.php'>👉 Login Sekarang</a>";
    } else {
        echo "❌ Gagal reset password: " . $conn->error;
    }

    $conn->close();
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage());
}
?>
