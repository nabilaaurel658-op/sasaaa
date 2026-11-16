<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM siswa WHERE id = $id";
$result = query($sql);
$siswa = fetch_assoc($result);

if (!$siswa) {
    header('Location: siswa.php');
    exit();
}

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

    $foto = $siswa['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $upload = upload_file($_FILES['foto'], '../assets/uploads/dokumentasi/');
        if ($upload['success']) {
            if ($siswa['foto']) delete_file('../assets/uploads/dokumentasi/' . $siswa['foto']);
            $foto = $upload['filename'];
        }
    }

    $sql = "UPDATE siswa SET nis = '$nis', nisn = '$nisn', nama_lengkap = '$nama_lengkap', jenis_kelamin = '$jenis_kelamin', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', agama = '$agama', alamat = '$alamat', no_hp = '$no_hp', email = '$email', kelas = '$kelas', foto = '$foto', nama_ayah = '$nama_ayah', nama_ibu = '$nama_ibu', no_hp_ortu = '$no_hp_ortu', status = '$status' WHERE id = $id";
    if (query($sql)) {
        set_flash_message('success', 'Siswa berhasil diupdate');
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
    <title>Edit Siswa - Admin</title>
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
            <h1 style="margin-bottom:30px;">Edit Siswa</h1>
            <div class="content-card">
                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <h3 style="margin-bottom:15px;">Data Pribadi</h3>
                    <div class="form-row">
                        <div class="form-group"><label>NIS *</label><input type="text" name="nis" class="form-control" value="<?php echo $siswa['nis']; ?>" required></div>
                        <div class="form-group"><label>NISN</label><input type="text" name="nisn" class="form-control" value="<?php echo $siswa['nisn']; ?>"></div>
                    </div>
                    <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="nama_lengkap" class="form-control" value="<?php echo $siswa['nama_lengkap']; ?>" required></div>
                    <div class="form-row">
                        <div class="form-group"><label>Jenis Kelamin *</label><select name="jenis_kelamin" class="form-control" required><option value="L" <?php echo $siswa['jenis_kelamin']=='L'?'selected':''; ?>>Laki-laki</option><option value="P" <?php echo $siswa['jenis_kelamin']=='P'?'selected':''; ?>>Perempuan</option></select></div>
                        <div class="form-group"><label>Agama</label><select name="agama" class="form-control"><option <?php echo $siswa['agama']=='Islam'?'selected':''; ?>>Islam</option><option <?php echo $siswa['agama']=='Kristen'?'selected':''; ?>>Kristen</option><option <?php echo $siswa['agama']=='Katolik'?'selected':''; ?>>Katolik</option><option <?php echo $siswa['agama']=='Hindu'?'selected':''; ?>>Hindu</option><option <?php echo $siswa['agama']=='Buddha'?'selected':''; ?>>Buddha</option><option <?php echo $siswa['agama']=='Konghucu'?'selected':''; ?>>Konghucu</option></select></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="<?php echo $siswa['tempat_lahir']; ?>"></div>
                        <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $siswa['tanggal_lahir']; ?>"></div>
                    </div>
                    <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control"><?php echo $siswa['alamat']; ?></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>No. HP</label><input type="tel" name="no_hp" class="form-control" value="<?php echo $siswa['no_hp']; ?>"></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?php echo $siswa['email']; ?>"></div>
                    </div>
                    <h3 style="margin:20px 0 15px;">Data Sekolah</h3>
                    <div class="form-row">
                        <div class="form-group"><label>Kelas *</label><input type="text" name="kelas" class="form-control" value="<?php echo $siswa['kelas']; ?>" required></div>
                        <div class="form-group"><label>Status *</label><select name="status" class="form-control" required><option value="aktif" <?php echo $siswa['status']=='aktif'?'selected':''; ?>>Aktif</option><option value="nonaktif" <?php echo $siswa['status']=='nonaktif'?'selected':''; ?>>Nonaktif</option><option value="lulus" <?php echo $siswa['status']=='lulus'?'selected':''; ?>>Lulus</option></select></div>
                    </div>
                    <h3 style="margin:20px 0 15px;">Data Orang Tua</h3>
                    <div class="form-row">
                        <div class="form-group"><label>Nama Ayah</label><input type="text" name="nama_ayah" class="form-control" value="<?php echo $siswa['nama_ayah']; ?>"></div>
                        <div class="form-group"><label>Nama Ibu</label><input type="text" name="nama_ibu" class="form-control" value="<?php echo $siswa['nama_ibu']; ?>"></div>
                    </div>
                    <div class="form-group"><label>No. HP Orang Tua</label><input type="tel" name="no_hp_ortu" class="form-control" value="<?php echo $siswa['no_hp_ortu']; ?>"></div>
                    <div class="form-group"><label>Foto</label><input type="file" name="foto" class="form-control" accept="image/*"><?php if($siswa['foto']) echo '<br><small>Current: '.$siswa['foto'].'</small>'; ?></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Update</button> <a href="siswa.php" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
