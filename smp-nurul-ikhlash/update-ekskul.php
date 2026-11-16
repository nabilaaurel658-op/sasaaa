<?php
// Script untuk update tabel ekskul - menambahkan kolom kategori
// Jalankan: update-ekskul.php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'smp_nurul_ikhlash';

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    echo "🔌 Terkoneksi ke database<br>";

    // Cek apakah kolom kategori sudah ada
    $check_column = "SHOW COLUMNS FROM ekskul LIKE 'kategori'";
    $result = $conn->query($check_column);

    if ($result->num_rows > 0) {
        echo "✅ Kolom 'kategori' sudah ada di tabel ekskul<br>";
    } else {
        // Tambahkan kolom kategori
        $sql = "ALTER TABLE ekskul ADD COLUMN kategori ENUM('umum', 'pesantren') DEFAULT 'umum' AFTER jadwal_waktu";
        if ($conn->query($sql)) {
            echo "✅ Kolom 'kategori' berhasil ditambahkan<br>";
        } else {
            echo "❌ Gagal menambahkan kolom: " . $conn->error . "<br>";
        }
    }

    // Insert data ekskul default jika belum ada
    $check_data = "SELECT COUNT(*) as total FROM ekskul";
    $result_data = $conn->query($check_data);
    $total = $result_data->fetch_assoc()['total'];

    if ($total == 0) {
        echo "<br>📝 Menambahkan data ekskul default...<br>";

        $insert_sql = "INSERT INTO ekskul (nama_ekskul, deskripsi, pembina, jadwal_hari, jadwal_waktu, kategori, status) VALUES
        ('Tahfidz Al-Qur''an', 'Program pembinaan hafalan Al-Qur''an yang terintegrasi dengan kegiatan harian santri untuk membentuk generasi penghafal Al-Qur''an.', 'Ust. Pembina Tahfidz', 'Senin-Kamis', '15:00 - 17:00', 'pesantren', 'aktif'),
        ('Kajian Kitab Kuning', 'Pembelajaran membaca dan memahami kitab kuning dengan metode Ibtida''i yang menjadi ciri khas utama sekolah ini.', 'Ust. Pembina Kitab', 'Senin-Rabu', '07:00 - 08:00', 'pesantren', 'aktif'),
        ('Pramuka', 'Kegiatan wajib bagi seluruh siswa jenjang SMP untuk melatih kedisiplinan, kemandirian, dan kerjasama dalam tim.', 'Kakak Pembina Pramuka', 'Jumat', '13:00 - 16:00', 'umum', 'aktif'),
        ('Seni Islami (Tilawah)', 'Seni baca Al-Qur''an dengan tartil yang indah sebagai bagian dari kegiatan kepesantrenan.', 'Ust. Pembina Seni', 'Selasa', '15:00 - 16:30', 'pesantren', 'aktif'),
        ('Hadrah/Rebana', 'Kegiatan seni rebana atau hadrah sebagai tradisi pesantren untuk melatih kerjasama dan kedisiplinan.', 'Ust. Pembina Hadrah', 'Rabu', '15:00 - 16:30', 'pesantren', 'aktif'),
        ('Muhadharah', 'Latihan pidato atau dakwah untuk melatih kepercayaan diri dan kemampuan berbicara di depan umum.', 'Ust. Pembina Dakwah', 'Kamis', '15:00 - 16:30', 'pesantren', 'aktif')";

        if ($conn->query($insert_sql)) {
            echo "✅ Data ekskul default berhasil ditambahkan<br>";
        } else {
            echo "❌ Gagal menambahkan data: " . $conn->error . "<br>";
        }
    } else {
        echo "<br>📊 Data ekskul sudah ada ($total records)<br>";
    }

    echo "<br>";
    echo "========================================<br>";
    echo "🎉 UPDATE EKSKUL SELESAI!<br>";
    echo "========================================<br>";
    echo "<br>";
    echo "<a href='pages/ekskul.php'>👉 Lihat Halaman Ekskul</a>";

    $conn->close();

} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage());
}
?>
