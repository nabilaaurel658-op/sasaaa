<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 6;
$offset = ($page - 1) * $per_page;

// Filter kategori
$kategori_filter = isset($_GET['kategori']) ? escape($_GET['kategori']) : '';

// Ambil total berita
if ($kategori_filter) {
    $sql_count = "SELECT COUNT(*) as total FROM berita WHERE status = 'published' AND kategori = '$kategori_filter'";
} else {
    $sql_count = "SELECT COUNT(*) as total FROM berita WHERE status = 'published'";
}
$result_count = query($sql_count);
$count_data = fetch_assoc($result_count);
$total_records = $count_data['total'];
$total_pages = ceil($total_records / $per_page);

// Ambil data berita
if ($kategori_filter) {
    $sql_berita = "SELECT * FROM berita WHERE status = 'published' AND kategori = '$kategori_filter' ORDER BY created_at DESC LIMIT $offset, $per_page";
} else {
    $sql_berita = "SELECT * FROM berita WHERE status = 'published' ORDER BY created_at DESC LIMIT $offset, $per_page";
}
$result_berita = query($sql_berita);
$berita_list = fetch_all($result_berita);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - <?php echo $nama_sekolah; ?></title>
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
                    <li><a href="berita.php" class="active">Berita</a></li>
                    <li><a href="ekskul.php">Ekskul</a></li>
                    <li><a href="dokumentasi.php">Dokumentasi</a></li>
                    <li><a href="guru.php">Guru</a></li>
                    <li><a href="ppdb.php" class="btn btn-primary">PPDB</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Berita Section -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="section-title">
                <h2>Berita & Pengumuman</h2>
                <p>Informasi terkini seputar kegiatan sekolah</p>
            </div>

            <!-- Filter Kategori -->
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="berita.php" class="btn btn-secondary <?php echo !$kategori_filter ? 'active' : ''; ?>">Semua</a>
                <a href="berita.php?kategori=berita" class="btn btn-secondary <?php echo $kategori_filter == 'berita' ? 'active' : ''; ?>">Berita</a>
                <a href="berita.php?kategori=pengumuman" class="btn btn-secondary <?php echo $kategori_filter == 'pengumuman' ? 'active' : ''; ?>">Pengumuman</a>
                <a href="berita.php?kategori=prestasi" class="btn btn-secondary <?php echo $kategori_filter == 'prestasi' ? 'active' : ''; ?>">Prestasi</a>
            </div>

            <?php if (count($berita_list) > 0): ?>
                <div class="grid-3">
                    <?php foreach ($berita_list as $berita): ?>
                        <div class="card news-card">
                            <?php if ($berita['gambar']): ?>
                                <img src="../assets/uploads/berita/<?php echo $berita['gambar']; ?>" alt="<?php echo $berita['judul']; ?>" class="card-img">
                            <?php else: ?>
                                <img src="../assets/images/placeholder.svg" alt="Placeholder" class="card-img">
                            <?php endif; ?>
                            <div class="card-body">
                                <span class="badge"><?php echo ucfirst($berita['kategori']); ?></span>
                                <h3 class="card-title"><?php echo $berita['judul']; ?></h3>
                                <p class="card-text"><?php echo limit_text($berita['isi'], 100); ?></p>
                                <div class="card-meta">
                                    <span><?php echo format_tanggal_indonesia($berita['created_at']); ?></span>
                                    <a href="berita-detail.php?id=<?php echo $berita['id']; ?>">Baca Selengkapnya →</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php
                $url = $kategori_filter ? "berita.php?kategori=$kategori_filter" : "berita.php";
                echo pagination($total_records, $per_page, $page, $url);
                ?>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <p>Belum ada berita yang dipublikasikan.</p>
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
