<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil detail berita
$sql = "SELECT * FROM berita WHERE id = $id AND status = 'published'";
$result = query($sql);
$berita = fetch_assoc($result);

if (!$berita) {
    header('Location: berita.php');
    exit();
}

// Update views
query("UPDATE berita SET views = views + 1 WHERE id = $id");

// Ambil berita terkait
$sql_terkait = "SELECT * FROM berita WHERE id != $id AND status = 'published' ORDER BY created_at DESC LIMIT 3";
$result_terkait = query($sql_terkait);
$berita_terkait = fetch_all($result_terkait);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $berita['judul']; ?> - <?php echo $nama_sekolah; ?></title>
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

    <!-- Berita Detail Section -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto;">
                <a href="berita.php" style="display: inline-block; margin-bottom: 20px; color: var(--primary-color);">← Kembali ke Berita</a>

                <div class="card" style="padding: 30px;">
                    <?php if ($berita['gambar']): ?>
                        <img src="../assets/uploads/berita/<?php echo $berita['gambar']; ?>" alt="<?php echo $berita['judul']; ?>" style="width: 100%; border-radius: var(--border-radius); margin-bottom: 20px;">
                    <?php endif; ?>

                    <span class="badge"><?php echo ucfirst($berita['kategori']); ?></span>

                    <h1 style="margin: 15px 0;"><?php echo $berita['judul']; ?></h1>

                    <div style="color: var(--gray); font-size: 14px; margin-bottom: 20px;">
                        <span><?php echo format_tanggal_lengkap($berita['created_at']); ?></span>
                        <span style="margin: 0 10px;">|</span>
                        <span><?php echo $berita['views']; ?> views</span>
                    </div>

                    <div style="line-height: 1.8; color: var(--dark-color);">
                        <?php echo nl2br($berita['isi']); ?>
                    </div>
                </div>

                <!-- Berita Terkait -->
                <?php if (count($berita_terkait) > 0): ?>
                    <div style="margin-top: 40px;">
                        <h3 style="margin-bottom: 20px;">Berita Terkait</h3>
                        <div class="grid-3">
                            <?php foreach ($berita_terkait as $terkait): ?>
                                <div class="card news-card">
                                    <?php if ($terkait['gambar']): ?>
                                        <img src="../assets/uploads/berita/<?php echo $terkait['gambar']; ?>" alt="<?php echo $terkait['judul']; ?>" class="card-img">
                                    <?php else: ?>
                                        <img src="../assets/images/placeholder.svg" alt="Placeholder" class="card-img">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h4 class="card-title" style="font-size: 16px;"><?php echo $terkait['judul']; ?></h4>
                                        <a href="berita-detail.php?id=<?php echo $terkait['id']; ?>" style="color: var(--primary-color);">Baca →</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
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
