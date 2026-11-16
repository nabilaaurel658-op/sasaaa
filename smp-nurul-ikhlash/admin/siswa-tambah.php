<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = escape($_POST['nis']);
    $nisn = escape($_POST['nisn']);
    $nama_lengkap = escape($_POST['nama_lengkap']);
    $jenis_kelamin = escape($_POST['jenis_kelamin']);
    $tempat_lahir = escape($_POST['tempat_lahir']);
    $tanggal_lahir = escape($_POST['tanggal_lahir']);
    $agama = escape($_POST['agama']);
    $alamat = escape($_POST['alamat']);
    $no_hp = escape($_POST['no_hp']);
    $email = escape($_POST['email']);
    $kelas = escape($_POST['kelas']);
    $nama_ayah = escape($_POST['nama_ayah']);
    $nama_ibu = escape($_POST['nama_ibu']);
    $no_hp_ortu = escape($_POST['no_hp_ortu']);
    $status = escape($_POST['status']);

    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $upload = upload_file($_FILES['foto'], '../assets/uploads/dokumentasi/');
        if ($upload['success']) $foto = $upload['filename'];
    }

    $sql = "INSERT INTO siswa (nis, nisn, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, alamat, no_hp, email, kelas, foto, nama_ayah, nama_ibu, no_hp_ortu, status)
            VALUES ('$nis', '$nisn', '$nama_lengkap', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$agama', '$alamat', '$no_hp', '$email', '$kelas', '$foto', '$nama_ayah', '$nama_ibu', '$no_hp_ortu', '$status')";

    if (query($sql)) {
        set_flash_message('success', 'Siswa berhasil ditambahkan');
        header('Location: siswa.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa - Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 250px; background: var(--dark-color); color: var(--white); padding: 20px 0; position: fixed; height: 100vh; overflow-y: auto; }
        .admin-sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .admin-menu { list-style: none; }
        .admin-menu li a { display: block; padding: 15px 20px; color: var(--white); text-decoration: none; border-left: 3px solid transparent; }
        .admin-menu li a:hover, .admin-menu li a.active { background: rgba(255,255,255,0.1); border-left-color: var(--accent-color); }
        .admin-content { margin-left: 250px; padding: 30px; flex: 1; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h3>🎓 Admin Panel</h3>
                <p>Halo, <?php echo $_SESSION['admin_nama']; ?></p>
            </div>
            <ul class="admin-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="berita.php">Kelola Berita</a></li>
                <li><a href="ppdb.php">Kelola PPDB</a></li>
                <li><a href="ekskul.php">Kelola Ekskul</a></li>
                <li><a href="dokumentasi.php">Kelola Dokumentasi</a></li>
                <li><a href="guru.php">Kelola Guru</a></li>
                <li><a href="siswa.php" class="active">Kelola Siswa</a></li>
                <li><a href="agenda.php">Kelola Agenda</a></li>
                <li><a href="pengaturan.php">Pengaturan</a></li>
                <li><a href="logout.php" style="color: var(--danger-color);">Logout</a></li>
            </ul>
        </div>
        <div class="admin-content">
            <h1 style="margin-bottom:30px;">Tambah Siswa</h1>
            <div class="content-card">
                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <h3 style="margin-bottom:15px;">Data Pribadi</h3>
                    <div class="form-row">
                        <div class="form-group"><label>NIS *</label><input type="text" name="nis" class="form-control" required></div>
                        <div class="form-group"><label>NISN</label><input type="text" name="nisn" class="form-control"></div>
                    </div>
                    <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="nama_lengkap" class="form-control" required></div>
                    <div class="form-row">
                        <div class="form-group"><label>Jenis Kelamin *</label><select name="jenis_kelamin" class="form-control" required><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                        <div class="form-group"><label>Agama</label><select name="agama" class="form-control"><option>Islam</option><option>Kristen</option><option>Katolik</option><option>Hindu</option><option>Buddha</option><option>Konghucu</option></select></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control"></div>
                        <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control"></div>
                    </div>
                    <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control"></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>No. HP</label><input type="tel" name="no_hp" class="form-control"></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
                    </div>
                    <h3 style="margin:20px 0 15px;">Data Sekolah</h3>
                    <div class="form-row">
                        <div class="form-group"><label>Kelas *</label><input type="text" name="kelas" class="form-control" placeholder="Contoh: 7A, 8B, 9C" required></div>
                        <div class="form-group"><label>Status *</label><select name="status" class="form-control" required><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option><option value="lulus">Lulus</option></select></div>
                    </div>
                    <h3 style="margin:20px 0 15px;">Data Orang Tua</h3>
                    <div class="form-row">
                        <div class="form-group"><label>Nama Ayah</label><input type="text" name="nama_ayah" class="form-control"></div>
                        <div class="form-group"><label>Nama Ibu</label><input type="text" name="nama_ibu" class="form-control"></div>
                    </div>
                    <div class="form-group"><label>No. HP Orang Tua</label><input type="tel" name="no_hp_ortu" class="form-control"></div>
                    <div class="form-group"><label>Foto</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Simpan</button> <a href="siswa.php" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
