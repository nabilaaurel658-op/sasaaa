<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');

// Ambil data ekskul
$sql_ekskul = "SELECT * FROM ekskul WHERE status = 'aktif' ORDER BY kategori, nama_ekskul ASC";
$result_ekskul = query($sql_ekskul);
$ekskul_list = fetch_all($result_ekskul);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler - <?php echo $nama_sekolah; ?></title>
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
                    <li><a href="ekskul.php" class="active">Ekskul</a></li>
                    <li><a href="dokumentasi.php">Dokumentasi</a></li>
                    <li><a href="guru.php">Guru</a></li>
                    <li><a href="ppdb.php" class="btn btn-primary">PPDB</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Ekskul Section -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="section-title">
                <h2>Ekstrakurikuler</h2>
                <p>Kembangkan bakat dan minat Anda melalui berbagai kegiatan ekskul</p>
            </div>

            <!-- Program Unggulan Pesantren -->
            <div style="margin-bottom: 50px;">
                <h3 style="font-size: 28px; color: var(--primary-color); margin-bottom: 30px; text-align: center;">🎓 Program Unggulan Pesantren</h3>
                <?php
                $ekskul_pesantren = array_filter($ekskul_list, function($e) { return $e['kategori'] == 'pesantren'; });
                if (count($ekskul_pesantren) > 0): ?>
                    <div class="grid-3">
                        <?php foreach ($ekskul_pesantren as $ekskul): ?>
                            <div class="card" style="border: 2px solid var(--primary-color);">
                                <?php if ($ekskul['gambar']): ?>
                                    <img src="../assets/uploads/dokumentasi/<?php echo $ekskul['gambar']; ?>" alt="<?php echo $ekskul['nama_ekskul']; ?>" class="card-img">
                                <?php else: ?>
                                    <img src="../assets/images/placeholder.svg" alt="Placeholder" class="card-img">
                                <?php endif; ?>
                                <div class="card-body">
                                    <span class="badge" style="background: var(--primary-color);">Program Pesantren</span>
                                    <h3 class="card-title"><?php echo $ekskul['nama_ekskul']; ?></h3>
                                    <p class="card-text"><?php echo $ekskul['deskripsi']; ?></p>
                                    <div class="card-meta">
                                        <span><strong>Pembina:</strong> <?php echo $ekskul['pembina']; ?></span>
                                    </div>
                                    <div class="card-meta mt-1">
                                        <span><strong>Jadwal:</strong> <?php echo $ekskul['jadwal_hari']; ?>, <?php echo $ekskul['jadwal_waktu']; ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Ekstrakurikuler Umum -->
            <div>
                <h3 style="font-size: 28px; color: var(--accent-color); margin-bottom: 30px; text-align: center;">⚽ Ekstrakurikuler Umum</h3>
                <?php
                $ekskul_umum = array_filter($ekskul_list, function($e) { return $e['kategori'] == 'umum'; });
                if (count($ekskul_umum) > 0): ?>
                    <div class="grid-3">
                        <?php foreach ($ekskul_umum as $ekskul): ?>
                            <div class="card">
                                <?php if ($ekskul['gambar']): ?>
                                    <img src="../assets/uploads/dokumentasi/<?php echo $ekskul['gambar']; ?>" alt="<?php echo $ekskul['nama_ekskul']; ?>" class="card-img">
                                <?php else: ?>
                                    <img src="../assets/images/placeholder.svg" alt="Placeholder" class="card-img">
                                <?php endif; ?>
                                <div class="card-body">
                                    <span class="badge" style="background: var(--accent-color);">Ekskul Umum</span>
                                    <h3 class="card-title"><?php echo $ekskul['nama_ekskul']; ?></h3>
                                    <p class="card-text"><?php echo $ekskul['deskripsi']; ?></p>
                                    <div class="card-meta">
                                        <span><strong>Pembina:</strong> <?php echo $ekskul['pembina']; ?></span>
                                    </div>
                                    <div class="card-meta mt-1">
                                        <span><strong>Jadwal:</strong> <?php echo $ekskul['jadwal_hari']; ?>, <?php echo $ekskul['jadwal_waktu']; ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (count($ekskul_list) == 0): ?>
                <div class="alert alert-info text-center">
                    <p>Belum ada data ekstrakurikuler yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Info Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Informasi Ekskul</h2>
            </div>
            <div class="grid-3">
                <div class="feature-item">
                    <div class="feature-icon">📋</div>
                    <h3>Pendaftaran</h3>
                    <p>Siswa dapat mendaftar maksimal 2 ekskul setiap tahun ajaran. Pendaftaran dilakukan di awal semester.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🏅</div>
                    <h3>Prestasi</h3>
                    <p>Ekskul kami telah meraih berbagai prestasi di tingkat kecamatan hingga nasional.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🎯</div>
                    <h3>Tujuan</h3>
                    <p>Mengembangkan potensi siswa secara holistik: akademik, sosial, dan karakter.</p>
                </div>
            </div>
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
