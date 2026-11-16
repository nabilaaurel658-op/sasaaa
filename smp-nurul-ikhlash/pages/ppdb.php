<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$nama_sekolah = get_pengaturan('nama_sekolah');
$ppdb_status = get_pengaturan('ppdb_status');
$tahun_ajaran = get_pengaturan('tahun_ajaran');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_pendaftaran = generate_no_pendaftaran();
    $nama_lengkap = escape($_POST['nama_lengkap']);
    $nisn = escape($_POST['nisn']);
    $tempat_lahir = escape($_POST['tempat_lahir']);
    $tanggal_lahir = escape($_POST['tanggal_lahir']);
    $jenis_kelamin = escape($_POST['jenis_kelamin']);
    $agama = escape($_POST['agama']);
    $alamat = escape($_POST['alamat']);
    $no_hp = escape($_POST['no_hp']);
    $email = escape($_POST['email']);
    $nama_ayah = escape($_POST['nama_ayah']);
    $pekerjaan_ayah = escape($_POST['pekerjaan_ayah']);
    $nama_ibu = escape($_POST['nama_ibu']);
    $pekerjaan_ibu = escape($_POST['pekerjaan_ibu']);
    $no_hp_ortu = escape($_POST['no_hp_ortu']);
    $asal_sekolah = escape($_POST['asal_sekolah']);
    $nilai_rata_rata = escape($_POST['nilai_rata_rata']);

    // Upload files
    $foto_siswa = '';
    $ijazah = '';
    $kartu_keluarga = '';
    $akta_lahir = '';

    if (!empty($_FILES['foto_siswa']['name'])) {
        $upload_foto = upload_file($_FILES['foto_siswa'], '../assets/uploads/dokumentasi/');
        if ($upload_foto['success']) {
            $foto_siswa = $upload_foto['filename'];
        }
    }

    if (!empty($_FILES['ijazah']['name'])) {
        $upload_ijazah = upload_file($_FILES['ijazah'], '../assets/uploads/dokumentasi/', ['pdf']);
        if ($upload_ijazah['success']) {
            $ijazah = $upload_ijazah['filename'];
        }
    }

    if (!empty($_FILES['kartu_keluarga']['name'])) {
        $upload_kk = upload_file($_FILES['kartu_keluarga'], '../assets/uploads/dokumentasi/', ['pdf', 'jpg', 'jpeg', 'png']);
        if ($upload_kk['success']) {
            $kartu_keluarga = $upload_kk['filename'];
        }
    }

    if (!empty($_FILES['akta_lahir']['name'])) {
        $upload_akta = upload_file($_FILES['akta_lahir'], '../assets/uploads/dokumentasi/', ['pdf', 'jpg', 'jpeg', 'png']);
        if ($upload_akta['success']) {
            $akta_lahir = $upload_akta['filename'];
        }
    }

    // Insert ke database
    $sql = "INSERT INTO ppdb (no_pendaftaran, nama_lengkap, nisn, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, no_hp, email, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, no_hp_ortu, asal_sekolah, nilai_rata_rata, foto_siswa, ijazah, kartu_keluarga, akta_lahir, status)
            VALUES ('$no_pendaftaran', '$nama_lengkap', '$nisn', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$agama', '$alamat', '$no_hp', '$email', '$nama_ayah', '$pekerjaan_ayah', '$nama_ibu', '$pekerjaan_ibu', '$no_hp_ortu', '$asal_sekolah', '$nilai_rata_rata', '$foto_siswa', '$ijazah', '$kartu_keluarga', '$akta_lahir', 'pending')";

    if (query($sql)) {
        set_flash_message('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $no_pendaftaran);
        header('Location: ppdb-success.php?no=' . $no_pendaftaran);
        exit();
    } else {
        $error = 'Terjadi kesalahan saat menyimpan data.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB - <?php echo $nama_sekolah; ?></title>
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
                    <li><a href="ppdb.php" class="active">PPDB</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- PPDB Section -->
    <section style="padding: 40px 0;">
        <div class="container">
            <div class="section-title">
                <h2>Formulir Pendaftaran Siswa Baru</h2>
                <p>Tahun Ajaran <?php echo $tahun_ajaran; ?></p>
            </div>

            <?php if ($ppdb_status != 'buka'): ?>
                <div class="alert alert-warning text-center">
                    <h3>Pendaftaran PPDB Belum Dibuka</h3>
                    <p>Silakan cek kembali pada waktu yang telah ditentukan.</p>
                </div>
            <?php else: ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <!-- Data Pribadi -->
                    <h3 class="mb-2">Data Pribadi Siswa</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" name="nisn" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tempat Lahir *</label>
                            <input type="text" name="tempat_lahir" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Jenis Kelamin *</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Agama *</label>
                            <select name="agama" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap *</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>No. HP *</label>
                            <input type="tel" name="no_hp" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Foto Siswa (3x4) *</label>
                        <input type="file" name="foto_siswa" class="form-control" accept="image/*" required>
                    </div>

                    <!-- Data Orang Tua -->
                    <h3 class="mb-2 mt-3">Data Orang Tua</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Ayah *</label>
                            <input type="text" name="nama_ayah" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan Ayah *</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Ibu *</label>
                            <input type="text" name="nama_ibu" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan Ibu *</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No. HP Orang Tua *</label>
                        <input type="tel" name="no_hp_ortu" class="form-control" required>
                    </div>

                    <!-- Data Akademik -->
                    <h3 class="mb-2 mt-3">Data Akademik</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Asal Sekolah *</label>
                            <input type="text" name="asal_sekolah" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nilai Rata-rata Rapor *</label>
                            <input type="number" step="0.01" name="nilai_rata_rata" class="form-control" required>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <h3 class="mb-2 mt-3">Dokumen Pendukung</h3>
                    <div class="form-group">
                        <label>Scan Ijazah/STL (PDF)</label>
                        <input type="file" name="ijazah" class="form-control" accept=".pdf">
                    </div>
                    <div class="form-group">
                        <label>Scan Kartu Keluarga (PDF/JPG/PNG)</label>
                        <input type="file" name="kartu_keluarga" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <div class="form-group">
                        <label>Scan Akta Kelahiran (PDF/JPG/PNG)</label>
                        <input type="file" name="akta_lahir" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
                        <a href="../index.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
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
