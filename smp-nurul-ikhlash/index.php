<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Ambil berita terbaru
$sql_berita = "SELECT * FROM berita WHERE status = 'published' ORDER BY created_at DESC LIMIT 3";
$result_berita = query($sql_berita);
$berita_list = fetch_all($result_berita);

// Ambil agenda sekolah
$sql_agenda = "SELECT * FROM agenda WHERE tanggal_mulai >= CURDATE() ORDER BY tanggal_mulai ASC LIMIT 5";
$result_agenda = query($sql_agenda);
$agenda_list = fetch_all($result_agenda);

// Ambil pengaturan website
$nama_sekolah = get_pengaturan('nama_sekolah');
$alamat_sekolah = get_pengaturan('alamat_sekolah');
$no_telepon = get_pengaturan('no_telepon');
$email_sekolah = get_pengaturan('email_sekolah');
$instagram = get_pengaturan('instagram');
$ppdb_status = get_pengaturan('ppdb_status');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nama_sekolah; ?> - Beranda</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div>
                <span><i class="icon-phone"></i> <?php echo $no_telepon; ?></span>
                <span><i class="icon-email"></i> <?php echo $email_sekolah; ?></span>
            </div>
            <div>
                <a href="<?php echo $instagram; ?>" target="_blank">Instagram</a>
            </div>
        </div>
    </div>

    <!-- Header & Navigation -->
    <header>
        <div class="navbar">
            <div class="container">
                <div class="logo">
                    <?php echo $nama_sekolah; ?>
                </div>
                <button class="mobile-menu-btn" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="Buka menu navigasi">☰</button>
                <ul class="nav-menu" id="primary-navigation">
                    <li><a href="index.php" class="active">Beranda</a></li>
                    <li><a href="pages/tentang.php">Tentang</a></li>
                    <li><a href="pages/berita.php">Berita</a></li>
                    <li><a href="pages/ekskul.php">Ekskul</a></li>
                    <li><a href="pages/dokumentasi.php">Dokumentasi</a></li>
                    <li><a href="pages/guru.php">Guru</a></li>
                    <li><a href="pages/ppdb.php" class="btn btn-primary">PPDB</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Selamat Datang di <?php echo $nama_sekolah; ?></h1>
            <p>Mewujudkan Generasi Berakhlak Mulia, Cerdas, dan Berprestasi</p>
            <a href="pages/ppdb.php" class="btn btn-primary">Daftar Sekarang</a>
            <a href="pages/tentang.php" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Keunggulan Kami</h2>
                <p>Kenapa memilih <?php echo $nama_sekolah; ?> sebagai tempat belajar?</p>
            </div>
            <div class="grid-3">
                <div class="feature-item">
                    <div class="feature-icon">📚</div>
                    <h3>Kurikulum Terpadu</h3>
                    <p>Memadukan kurikulum nasional dengan nilai-nilai keislaman untuk membentuk karakter yang kuat.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🏆</div>
                    <h3>Prestasi Siswa</h3>
                    <p>Siswa kami telah meraih berbagai prestasi di tingkat daerah maupun nasional.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🎨</div>
                    <h3>Ekstrakurikuler</h3>
                    <p>Berbagai kegiatan ekskul untuk mengembangkan bakat dan minat siswa.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">👨‍🏫</div>
                    <h3>Guru Profesional</h3>
                    <p>Dididik oleh tenaga pengajar yang berpengalaman dan kompeten di bidangnya.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🕌</div>
                    <h3>Lingkungan Islami</h3>
                    <p>Menciptakan lingkungan belajar yang kondusif dengan nilai-nilai Islami.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💻</div>
                    <h3>Fasilitas Lengkap</h3>
                    <p>Fasilitas pendukung pembelajaran yang modern dan memadai.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news">
        <div class="container">
            <div class="section-title">
                <h2>Berita Terbaru</h2>
                <p>Informasi terkini seputar kegiatan dan prestasi sekolah</p>
            </div>
            <div class="grid-3">
                <?php if (count($berita_list) > 0): ?>
                    <?php foreach ($berita_list as $berita): ?>
                        <div class="card news-card">
                            <?php if ($berita['gambar']): ?>
                                <img src="assets/uploads/berita/<?php echo $berita['gambar']; ?>" alt="<?php echo $berita['judul']; ?>" class="card-img">
                            <?php else: ?>
                                <img src="assets/images/placeholder.svg" alt="Placeholder" class="card-img">
                            <?php endif; ?>
                            <div class="card-body">
                                <span class="badge"><?php echo ucfirst($berita['kategori']); ?></span>
                                <h3 class="card-title"><?php echo $berita['judul']; ?></h3>
                                <p class="card-text"><?php echo limit_text($berita['isi'], 100); ?></p>
                                <div class="card-meta">
                                    <span><?php echo format_tanggal_indonesia($berita['created_at']); ?></span>
                                    <a href="pages/berita-detail.php?id=<?php echo $berita['id']; ?>">Baca Selengkapnya →</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Belum ada berita yang dipublikasikan.</p>
                <?php endif; ?>
            </div>
            <div class="text-center mt-3">
                <a href="pages/berita.php" class="btn btn-secondary">Lihat Semua Berita</a>
            </div>
        </div>
    </section>

    <!-- Agenda Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Agenda Sekolah</h2>
                <p>Jadwal kegiatan yang akan datang</p>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Lokasi</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($agenda_list) > 0): ?>
                            <?php foreach ($agenda_list as $agenda): ?>
                                <tr>
                                    <td><?php echo format_tanggal_indonesia($agenda['tanggal_mulai']); ?></td>
                                    <td><?php echo $agenda['judul']; ?></td>
                                    <td><?php echo $agenda['lokasi']; ?></td>
                                    <td><?php echo $agenda['waktu']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada agenda yang dijadwalkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- PPDB CTA Section -->
    <?php if ($ppdb_status == 'buka'): ?>
    <section class="ppdb">
        <div class="container">
            <h2>Pendaftaran Siswa Baru Telah Dibuka!</h2>
            <p>Segera daftarkan putra-putri Anda untuk tahun ajaran <?php echo get_pengaturan('tahun_ajaran'); ?></p>
            <a href="pages/ppdb.php" class="btn btn-primary">Daftar PPDB Online</a>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-widget">
                    <h3><?php echo $nama_sekolah; ?></h3>
                    <p><?php echo $alamat_sekolah; ?></p>
                    <p>Telp: <?php echo $no_telepon; ?></p>
                    <p>Email: <?php echo $email_sekolah; ?></p>
                </div>
                <div class="footer-widget">
                    <h3>Link Cepat</h3>
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pages/tentang.php">Tentang Kami</a></li>
                        <li><a href="pages/berita.php">Berita</a></li>
                        <li><a href="pages/ppdb.php">PPDB</a></li>
                    </ul>
                </div>
                <div class="footer-widget">
                    <h3>Program</h3>
                    <ul>
                        <li><a href="pages/ekskul.php">Ekstrakurikuler</a></li>
                        <li><a href="pages/dokumentasi.php">Dokumentasi</a></li>
                        <li><a href="pages/guru.php">Guru & Staf</a></li>
                    </ul>
                </div>
                <div class="footer-widget">
                    <h3>Sosial Media</h3>
                    <ul>
                        <li><a href="<?php echo $instagram; ?>" target="_blank">Instagram</a></li>
                        <li><a href="#" target="_blank">Facebook</a></li>
                        <li><a href="#" target="_blank">YouTube</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $nama_sekolah; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
