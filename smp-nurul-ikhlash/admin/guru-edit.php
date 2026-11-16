<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM guru WHERE id = $id";
$result = query($sql);
$guru = fetch_assoc($result);

if (!$guru) {
    header('Location: guru.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = escape($_POST['nip']);
    $nama_lengkap = escape($_POST['nama_lengkap']);
    $jenis_kelamin = escape($_POST['jenis_kelamin']);
    $tempat_lahir = escape($_POST['tempat_lahir']);
    $tanggal_lahir = escape($_POST['tanggal_lahir']);
    $agama = escape($_POST['agama']);
    $alamat = escape($_POST['alamat']);
    $no_hp = escape($_POST['no_hp']);
    $email = escape($_POST['email']);
    $jabatan = escape($_POST['jabatan']);
    $mata_pelajaran = escape($_POST['mata_pelajaran']);
    $status = escape($_POST['status']);

    $foto = $guru['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $upload = upload_file($_FILES['foto'], '../assets/uploads/dokumentasi/');
        if ($upload['success']) {
            if ($guru['foto']) delete_file('../assets/uploads/dokumentasi/' . $guru['foto']);
            $foto = $upload['filename'];
        }
    }

    $sql = "UPDATE guru SET nip = '$nip', nama_lengkap = '$nama_lengkap', jenis_kelamin = '$jenis_kelamin', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', agama = '$agama', alamat = '$alamat', no_hp = '$no_hp', email = '$email', jabatan = '$jabatan', mata_pelajaran = '$mata_pelajaran', foto = '$foto', status = '$status' WHERE id = $id";
    if (query($sql)) {
        set_flash_message('success', 'Guru berhasil diupdate');
        header('Location: guru.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru - Admin</title>
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
                <li><a href="guru.php" class="active">Kelola Guru</a></li>
                <li><a href="siswa.php">Kelola Siswa</a></li>
                <li><a href="agenda.php">Kelola Agenda</a></li>
                <li><a href="pengaturan.php">Pengaturan</a></li>
                <li><a href="logout.php" style="color: var(--danger-color);">Logout</a></li>
            </ul>
        </div>
        <div class="admin-content">
            <h1 style="margin-bottom:30px;">Edit Guru</h1>
            <div class="content-card">
                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <h3 style="margin-bottom:15px;">Data Pribadi</h3>
                    <div class="form-row">
                        <div class="form-group"><label>NIP</label><input type="text" name="nip" class="form-control" value="<?php echo $guru['nip']; ?>"></div>
                        <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="nama_lengkap" class="form-control" value="<?php echo $guru['nama_lengkap']; ?>" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Jenis Kelamin *</label><select name="jenis_kelamin" class="form-control" required><option value="L" <?php echo $guru['jenis_kelamin']=='L'?'selected':''; ?>>Laki-laki</option><option value="P" <?php echo $guru['jenis_kelamin']=='P'?'selected':''; ?>>Perempuan</option></select></div>
                        <div class="form-group"><label>Agama</label><select name="agama" class="form-control"><option <?php echo $guru['agama']=='Islam'?'selected':''; ?>>Islam</option><option <?php echo $guru['agama']=='Kristen'?'selected':''; ?>>Kristen</option><option <?php echo $guru['agama']=='Katolik'?'selected':''; ?>>Katolik</option><option <?php echo $guru['agama']=='Hindu'?'selected':''; ?>>Hindu</option><option <?php echo $guru['agama']=='Buddha'?'selected':''; ?>>Buddha</option><option <?php echo $guru['agama']=='Konghucu'?'selected':''; ?>>Konghucu</option></select></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="<?php echo $guru['tempat_lahir']; ?>"></div>
                        <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $guru['tanggal_lahir']; ?>"></div>
                    </div>
                    <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control"><?php echo $guru['alamat']; ?></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>No. HP</label><input type="tel" name="no_hp" class="form-control" value="<?php echo $guru['no_hp']; ?>"></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?php echo $guru['email']; ?>"></div>
                    </div>
                    <h3 style="margin:20px 0 15px;">Data Pekerjaan</h3>
                    <div class="form-row">
                        <div class="form-group"><label>Jabatan *</label><input type="text" name="jabatan" class="form-control" value="<?php echo $guru['jabatan']; ?>" required></div>
                        <div class="form-group"><label>Mata Pelajaran</label><input type="text" name="mata_pelajaran" class="form-control" value="<?php echo $guru['mata_pelajaran']; ?>"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Status *</label><select name="status" class="form-control" required><option value="aktif" <?php echo $guru['status']=='aktif'?'selected':''; ?>>Aktif</option><option value="nonaktif" <?php echo $guru['status']=='nonaktif'?'selected':''; ?>>Nonaktif</option></select></div>
                        <div class="form-group"><label>Foto</label><input type="file" name="foto" class="form-control" accept="image/*"><?php if($guru['foto']) echo '<br><small>Current: '.$guru['foto'].'</small>'; ?></div>
                    </div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Update</button> <a href="guru.php" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
