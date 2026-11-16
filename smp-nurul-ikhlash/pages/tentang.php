<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');
$alamat_sekolah = get_pengaturan('alamat_sekolah');
$no_telepon = get_pengaturan('no_telepon');
$email_sekolah = get_pengaturan('email_sekolah');
$tahun_ajaran = get_pengaturan('tahun_ajaran');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - <?php echo $nama_sekolah; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
                    <li><a href="tentang.php" class="active">Tentang</a></li>
                    <li><a href="berita.php">Berita</a></li>
                    <li><a href="ekskul.php">Ekskul</a></li>
                    <li><a href="dokumentasi.php">Dokumentasi</a></li>
                    <li><a href="guru.php">Guru</a></li>
                    <li><a href="ppdb.php" class="btn btn-primary">PPDB</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" style="padding: 60px 0;">
        <div class="container">
            <h1>Tentang Kami</h1>
            <p>Mengenal lebih dekat <?php echo $nama_sekolah; ?></p>
        </div>
    </section>

    <!-- Sejarah Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Sejarah Sekolah</h2>
            </div>
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <p style="margin-bottom: 20px;">
                    <?php echo $nama_sekolah; ?> berdiri dengan visi untuk mencetak generasi yang tidak hanya cerdas secara akademis,
                    tetapi juga memiliki akhlak mulia dan karakter yang kuat. Sejak didirikan, kami terus berkomitmen untuk
                    memberikan pendidikan berkualitas yang memadukan kurikulum nasional dengan nilai-nilai keislaman.
                </p>
                <p>
                    Dengan dukungan fasilitas yang memadai dan tenaga pengajar yang profesional, kami siap mendidik
                    putra-putri Anda menjadi generasi yang berprestasi dan berakhlak mulia.
                </p>
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section style="background: var(--light-color);">
        <div class="container">
            <div class="section-title">
                <h2>Visi & Misi</h2>
            </div>
            <div class="grid-3">
                <div class="card" style="padding: 30px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">Visi</h3>
                    <p>Menjadi lembaga pendidikan unggulan yang menghasilkan generasi berakhlak mulia, cerdas, dan berprestasi.</p>
                </div>
                <div class="card" style="padding: 30px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">Misi</h3>
                    <ul style="margin-left: 20px;">
                        <li>Menyelenggarakan pendidikan berkualitas</li>
                        <li>Membentuk karakter islami</li>
                        <li>Mengembangkan potensi siswa</li>
                        <li>Menciptakan lingkungan belajar kondusif</li>
                    </ul>
                </div>
                <div class="card" style="padding: 30px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">Tujuan</h3>
                    <ul style="margin-left: 20px;">
                        <li>Lulusan berakhlak mulia</li>
                        <li>Prestasi akademik tinggi</li>
                        <li>Keterampilan life skill</li>
                        <li>Berkontribusi bagi bangsa</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Sekolah -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Informasi Sekolah</h2>
            </div>
            <div class="grid-3">
                <div class="feature-item">
                    <div class="feature-icon">📍</div>
                    <h3>Alamat</h3>
                    <p><?php echo $alamat_sekolah; ?></p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📞</div>
                    <h3>Telepon</h3>
                    <p><?php echo $no_telepon; ?></p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">✉️</div>
                    <h3>Email</h3>
                    <p><?php echo $email_sekolah; ?></p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📅</div>
                    <h3>Tahun Ajaran</h3>
                    <p><?php echo $tahun_ajaran; ?></p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🕐</div>
                    <h3>Jam Belajar</h3>
                    <p>Senin - Jumat: 07:00 - 14:00</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🏫</div>
                    <h3>Jenjang</h3>
                    <p>Sekolah Menengah Pertama (SMP)</p>
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
