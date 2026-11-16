<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');

// Ambil data guru aktif
$sql_guru = "SELECT * FROM guru WHERE status = 'aktif' ORDER BY nama_lengkap ASC";
$result_guru = query($sql_guru);
$guru_list = fetch_all($result_guru);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru & Staf - <?php echo $nama_sekolah; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div>
                <span><i class="icon-phone"></i> <?php echo get_pengaturan('no_telepon'); ?></span>
                <span><i class="icon-email"></i> <?php echo get_pengaturan('email_sekolah'); ?></span>
            </div>
            <div>
                <a href="<?php echo get_pengaturan('instagram'); ?>" target="_blank">Instagram</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="container">
                <div class="logo">
                    <a href="../index.php"><?php echo $nama_sekolah; ?></a>
                </div>
                <button class="mobile-menu-btn" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="Buka menu navigasi">☰</button>
                <ul class="nav-menu" id="primary-navigation">
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="tentang.php">Tentang</a></li>
                    <li><a href="berita.php">Berita</a></li>
                    <li><a href="ekskul.php">Ekskul</a></li>
                    <li><a href="dokumentasi.php">Dokumentasi</a></li>
                    <li><a href="guru.php" class="active">Guru</a></li>
                    <li><a href="ppdb.php" class="btn btn-primary">PPDB</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Guru Section -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="section-title">
                <h2>Guru & Staf Pengajar</h2>
                <p>Tenaga pengajar profesional yang siap mendidik putra-putri Anda</p>
            </div>

            <?php if (count($guru_list) > 0): ?>
                <div class="grid-4">
                    <?php foreach ($guru_list as $guru): ?>
                        <div class="card" style="text-align: center; padding: 20px;">
                            <?php if ($guru['foto']): ?>
                                <img src="../assets/uploads/dokumentasi/<?php echo $guru['foto']; ?>" alt="<?php echo $guru['nama_lengkap']; ?>" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px;">
                            <?php else: ?>
                                <div style="width: 120px; height: 120px; border-radius: 50%; background: var(--light-color); margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 48px;">👤</div>
                            <?php endif; ?>
                            <h3 style="margin-bottom: 5px;"><?php echo $guru['nama_lengkap']; ?></h3>
                            <p style="color: var(--primary-color); font-weight: 500; margin-bottom: 10px;"><?php echo $guru['jabatan']; ?></p>
                            <?php if ($guru['mata_pelajaran']): ?>
                                <p style="color: var(--gray); font-size: 14px;"><?php echo $guru['mata_pelajaran']; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <p>Belum ada data guru yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $nama_sekolah; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>
</html>
