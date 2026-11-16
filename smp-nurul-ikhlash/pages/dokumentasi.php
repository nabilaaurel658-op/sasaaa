<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 9;
$offset = ($page - 1) * $per_page;

// Ambil total dokumentasi
$sql_count = "SELECT COUNT(*) as total FROM dokumentasi";
$result_count = query($sql_count);
$count_data = fetch_assoc($result_count);
$total_records = $count_data['total'];
$total_pages = ceil($total_records / $per_page);

// Ambil data dokumentasi
$sql_dokumentasi = "SELECT * FROM dokumentasi ORDER BY tanggal DESC LIMIT $offset, $per_page";
$result_dokumentasi = query($sql_dokumentasi);
$dokumentasi_list = fetch_all($result_dokumentasi);

// Ambil kategori unik
$sql_kategori = "SELECT DISTINCT kategori FROM dokumentasi WHERE kategori IS NOT NULL AND kategori != '' ORDER BY kategori";
$result_kategori = query($sql_kategori);
$kategori_list = fetch_all($result_kategori);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi Kegiatan - <?php echo $nama_sekolah; ?></title>
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
                    <li><a href="dokumentasi.php" class="active">Dokumentasi</a></li>
                    <li><a href="guru.php">Guru</a></li>
                    <li><a href="ppdb.php" class="btn btn-primary">PPDB</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Dokumentasi Section -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="section-title">
                <h2>Dokumentasi Kegiatan</h2>
                <p>Galeri kegiatan dan prestasi siswa <?php echo $nama_sekolah; ?></p>
            </div>

            <!-- Filter Kategori -->
            <?php if (count($kategori_list) > 0): ?>
                <div style="text-align: center; margin-bottom: 30px;">
                    <a href="dokumentasi.php" class="btn btn-secondary">Semua</a>
                    <?php foreach ($kategori_list as $kat): ?>
                        <a href="dokumentasi.php?kategori=<?php echo urlencode($kat['kategori']); ?>" class="btn btn-secondary">
                            <?php echo $kat['kategori']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (count($dokumentasi_list) > 0): ?>
                <div class="grid-3">
                    <?php foreach ($dokumentasi_list as $dok): ?>
                        <div class="card">
                            <?php if ($dok['gambar_utama']): ?>
                                <img src="../assets/uploads/dokumentasi/<?php echo $dok['gambar_utama']; ?>" alt="<?php echo $dok['judul']; ?>" class="card-img">
                            <?php else: ?>
                                <img src="../assets/images/placeholder.svg" alt="Placeholder" class="card-img">
                            <?php endif; ?>
                            <div class="card-body">
                                <?php if ($dok['kategori']): ?>
                                    <span class="badge"><?php echo $dok['kategori']; ?></span>
                                <?php endif; ?>
                                <h3 class="card-title"><?php echo $dok['judul']; ?></h3>
                                <p class="card-text"><?php echo limit_text($dok['deskripsi'], 100); ?></p>
                                <div class="card-meta">
                                    <span><?php echo format_tanggal_indonesia($dok['tanggal']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php
                echo pagination($total_records, $per_page, $page, 'dokumentasi.php');
                ?>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <p>Belum ada dokumentasi kegiatan yang tersedia.</p>
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
