<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM dokumentasi WHERE id = $id";
$result = query($sql);
$dok = fetch_assoc($result);

if (!$dok) {
    header('Location: dokumentasi.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = escape($_POST['judul']);
    $deskripsi = escape($_POST['deskripsi']);
    $kategori = escape($_POST['kategori']);
    $tanggal = escape($_POST['tanggal']);

    $gambar_utama = $dok['gambar_utama'];
    if (!empty($_FILES['gambar_utama']['name'])) {
        $upload = upload_file($_FILES['gambar_utama'], '../assets/uploads/dokumentasi/');
        if ($upload['success']) {
            if ($dok['gambar_utama']) delete_file('../assets/uploads/dokumentasi/' . $dok['gambar_utama']);
            $gambar_utama = $upload['filename'];
        }
    }

    $sql = "UPDATE dokumentasi SET judul = '$judul', deskripsi = '$deskripsi', kategori = '$kategori', tanggal = '$tanggal', gambar_utama = '$gambar_utama' WHERE id = $id";
    if (query($sql)) {
        set_flash_message('success', 'Dokumentasi berhasil diupdate');
        header('Location: dokumentasi.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokumentasi - Admin</title>
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
                <li><a href="dokumentasi.php" class="active">Kelola Dokumentasi</a></li>
                <li><a href="guru.php">Kelola Guru</a></li>
                <li><a href="siswa.php">Kelola Siswa</a></li>
                <li><a href="agenda.php">Kelola Agenda</a></li>
                <li><a href="pengaturan.php">Pengaturan</a></li>
                <li><a href="logout.php" style="color: var(--danger-color);">Logout</a></li>
            </ul>
        </div>
        <div class="admin-content">
            <h1 style="margin-bottom:30px;">Edit Dokumentasi</h1>
            <div class="content-card">
                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <div class="form-group"><label>Judul *</label><input type="text" name="judul" class="form-control" value="<?php echo $dok['judul']; ?>" required></div>
                    <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" class="form-control"><?php echo $dok['deskripsi']; ?></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>Kategori</label><input type="text" name="kategori" class="form-control" value="<?php echo $dok['kategori']; ?>"></div>
                        <div class="form-group"><label>Tanggal *</label><input type="date" name="tanggal" class="form-control" value="<?php echo $dok['tanggal']; ?>" required></div>
                    </div>
                    <div class="form-group"><label>Gambar Utama</label><input type="file" name="gambar_utama" class="form-control" accept="image/*"><?php if($dok['gambar_utama']) echo '<br><small>Current: '.$dok['gambar_utama'].'</small>'; ?></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Update</button> <a href="dokumentasi.php" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
