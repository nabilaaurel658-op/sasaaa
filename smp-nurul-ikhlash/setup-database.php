<?php
// Script untuk membuat database dan import schema
// Jalankan file ini sekali saja untuk setup database awal

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'smp_nurul_ikhlash';

try {
    // Koneksi ke MySQL tanpa database
    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    echo "🔌 Terkoneksi ke MySQL server<br>";

    // Drop database jika ada (untuk fresh install)
    $conn->query("DROP DATABASE IF EXISTS $dbname");
    echo "🗑️ Database lama dihapus (jika ada)<br>";

    // Buat database jika belum ada
    $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn->query($sql_create_db)) {
        echo "<div class='step success'>✅ Database '$dbname' berhasil dibuat atau sudah ada.</div>";
    } else {
        die("<div class='step error'>❌ Gagal membuat database: " . $conn->error . "</div>");
    }

    // Pilih database
    $conn->select_db($dbname);

    // Baca file database.sql
    $sql_file = file_get_contents('database.sql');
    if ($sql_file === false) {
        die("<div class='step error'>❌ Tidak bisa membaca file database.sql</div>");
    }

    // Hapus komentar dan split statements
    $sql_file = preg_replace('/--.*$/m', '', $sql_file);
    $sql_file = preg_replace('/\/\*.*?\*\//s', '', $sql_file);
    $statements = explode(';', $sql_file);
    $success_count = 0;
    $error_count = 0;

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && strlen($statement) > 10) {
            if ($conn->query($statement)) {
                $success_count++;
            } else {
                $error_count++;
                echo "<div class='step error'>⚠️ Error: " . $conn->error . "</div>";
            }
        }
    }

    $conn->close();
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Setup Database - SMP Nurul Ikhlash</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .container {
                background: white;
                padding: 50px;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                max-width: 600px;
                width: 100%;
                animation: slideUp 0.5s ease-out;
            }
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .header {
                text-align: center;
                margin-bottom: 40px;
            }
            .header h1 {
                color: #667eea;
                font-size: 32px;
                margin-bottom: 10px;
                font-weight: 700;
            }
            .header p {
                color: #718096;
                font-size: 16px;
            }
            .icon {
                font-size: 80px;
                margin-bottom: 20px;
                display: block;
            }
            .step {
                padding: 15px 20px;
                margin-bottom: 15px;
                border-radius: 10px;
                font-size: 15px;
                border-left: 4px solid;
            }
            .step.success {
                background: #d1fae5;
                color: #065f46;
                border-color: #10b981;
            }
            .step.error {
                background: #fee2e2;
                color: #991b1b;
                border-color: #ef4444;
            }
            .result-box {
                background: #f7fafc;
                padding: 30px;
                border-radius: 15px;
                margin: 30px 0;
                border: 2px solid #e2e8f0;
            }
            .result-box h3 {
                color: #2d3748;
                margin-bottom: 20px;
                font-size: 22px;
                text-align: center;
            }
            .result-item {
                display: flex;
                justify-content: space-between;
                padding: 12px 0;
                border-bottom: 1px solid #e2e8f0;
            }
            .result-item:last-child {
                border-bottom: none;
            }
            .result-label {
                color: #718096;
                font-weight: 500;
            }
            .result-value {
                color: #2d3748;
                font-weight: 700;
            }
            .buttons {
                display: flex;
                gap: 15px;
                margin-top: 30px;
            }
            .btn {
                flex: 1;
                padding: 15px;
                border-radius: 10px;
                text-align: center;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                font-size: 16px;
            }
            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            }
            .btn-secondary {
                background: #e2e8f0;
                color: #4a5568;
            }
            .btn-secondary:hover {
                background: #cbd5e0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <span class="icon">🎉</span>
                <h1>Setup Database Selesai!</h1>
                <p>SMP Plus Nurul Ikhlash Ibtidai</p>
            </div>

            <div class="result-box">
                <h3>📊 Hasil Setup</h3>
                <div class="result-item">
                    <span class="result-label">Database</span>
                    <span class="result-value"><?php echo $dbname; ?></span>
                </div>
                <div class="result-item">
                    <span class="result-label">Statement Berhasil</span>
                    <span class="result-value" style="color: #10b981;"><?php echo $success_count; ?></span>
                </div>
                <div class="result-item">
                    <span class="result-label">Statement Gagal</span>
                    <span class="result-value" style="color: #ef4444;"><?php echo $error_count; ?></span>
                </div>
            </div>

            <div class="buttons">
                <a href="index.php" class="btn btn-primary">🌐 Ke Website</a>
                <a href="admin/login.php" class="btn btn-secondary">🔐 Login Admin</a>
            </div>
        </div>
    </body>
    </html>
    <?php

} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage());
}
?>
