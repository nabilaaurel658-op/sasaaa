<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');
$no_pendaftaran = isset($_GET['no']) ? escape($_GET['no']) : '';

// Ambil data pendaftaran
$sql = "SELECT * FROM ppdb WHERE no_pendaftaran = '$no_pendaftaran'";
$result = query($sql);
$data = fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - <?php echo $nama_sekolah; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px; padding: 50px 20px;">
        <div class="card" style="text-align: center; padding: 40px;">
            <div style="font-size: 80px; margin-bottom: 20px;">✅</div>
            <h1 style="color: var(--success-color); margin-bottom: 20px;">Pendaftaran Berhasil!</h1>
            <p style="margin-bottom: 30px;">Terima kasih telah mendaftar di <?php echo $nama_sekolah; ?></p>

            <?php if ($data): ?>
                <div style="background: var(--light-color); padding: 20px; border-radius: var(--border-radius); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 15px;">Nomor Pendaftaran Anda:</h3>
                    <div style="font-size: 32px; font-weight: bold; color: var(--primary-color); margin-bottom: 10px;">
                        <?php echo $data['no_pendaftaran']; ?>
                    </div>
                    <p style="color: var(--gray);">Simpan nomor ini untuk pengecekan status pendaftaran</p>
                </div>

                <div style="text-align: left; margin-bottom: 30px;">
                    <h3 style="margin-bottom: 15px;">Ringkasan Data:</h3>
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-weight: 600;">Nama Lengkap</td>
                            <td><?php echo $data['nama_lengkap']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Asal Sekolah</td>
                            <td><?php echo $data['asal_sekolah']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Tanggal Pendaftaran</td>
                            <td><?php echo format_tanggal_lengkap($data['created_at']); ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Status</td>
                            <td><span style="background: var(--warning-color); color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Pending</span></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>

            <div style="background: #e3f2fd; padding: 20px; border-radius: var(--border-radius); margin-bottom: 30px; text-align: left;">
                <h4 style="margin-bottom: 10px;">Informasi Selanjutnya:</h4>
                <ul style="margin-left: 20px;">
                    <li>Panitia akan menghubungi Anda untuk jadwal wawancara</li>
                    <li>Pantau status pendaftaran secara berkala</li>
                    <li>Siapkan dokumen asli untuk verifikasi</li>
                    <li>Hubungi <?php echo get_pengaturan('no_telepon'); ?> jika ada pertanyaan</li>
                </ul>
            </div>

            <a href="../index.php" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
