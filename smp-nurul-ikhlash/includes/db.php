<?php
// File Koneksi Database
// SMP Plus Nurul Ikhlash Ibtidai

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // Ganti dengan username database Anda
define('DB_PASS', '');          // Ganti dengan password database Anda
define('DB_NAME', 'smp_nurul_ikhlash');

// Membuat koneksi ke database
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Cek koneksi
    if ($conn->connect_error) {
        throw new Exception("Koneksi database gagal: " . $conn->connect_error);
    }

    // Set charset ke utf8mb4 untuk mendukung emoji dan karakter khusus
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Fungsi untuk escape string (mencegah SQL Injection)
function escape($string) {
    global $conn;
    return $conn->real_escape_string($string);
}

// Fungsi untuk mengeksekusi query dan mengembalikan hasil
function query($sql) {
    global $conn;
    $result = $conn->query($sql);
    if (!$result) {
        die("Query Error: " . $conn->error);
    }
    return $result;
}

// Fungsi untuk mengambil satu baris data
function fetch_assoc($result) {
    return $result->fetch_assoc();
}

// Fungsi untuk mengambil semua baris data
function fetch_all($result) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Fungsi untuk mengambil jumlah baris
function num_rows($result) {
    return $result->num_rows;
}

// Fungsi untuk mendapatkan ID terakhir yang di-insert
function insert_id() {
    global $conn;
    return $conn->insert_id;
}

// Fungsi untuk menutup koneksi (opsional, PHP akan menutup otomatis di akhir script)
function close_connection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}
?>
