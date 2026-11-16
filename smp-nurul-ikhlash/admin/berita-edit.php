<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM berita WHERE id = $id";
$result = query($sql);
$berita = fetch_assoc($result);

if (!$berita) {
    header('Location: berita.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = escape($_POST['judul']);
    $slug = generate_slug($judul);
    $isi = escape($_POST['isi']);
    $kategori = escape($_POST['kategori']);
    $status = escape($_POST['status']);

    $gambar = $berita['gambar'];
    if (!empty($_FILES['gambar']['name'])) {
        $upload = upload_file($_FILES['gambar'], '../assets/uploads/berita/');
        if ($upload['success']) {
            if ($berita['gambar']) delete_file('../assets/uploads/berita/' . $berita['gambar']);
            $gambar = $upload['filename'];
        }
    }

    $sql = "UPDATE berita SET judul = '$judul', slug = '$slug', isi = '$isi', kategori = '$kategori', status = '$status', gambar = '$gambar' WHERE id = $id";
    if (query($sql)) {
        set_flash_message('success', 'Berita berhasil diupdate');
        header('Location: berita.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita - Admin</title>
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
                <li><a href="berita.php" class="active">Kelola Berita</a></li>
                <li><a href="ppdb.php">Kelola PPDB</a></li>
                <li><a href="ekskul.php">Kelola Ekskul</a></li>
                <li><a href="dokumentasi.php">Kelola Dokumentasi</a></li>
                <li><a href="guru.php">Kelola Guru</a></li>
                <li><a href="siswa.php">Kelola Siswa</a></li>
                <li><a href="agenda.php">Kelola Agenda</a></li>
                <li><a href="pengaturan.php">Pengaturan</a></li>
                <li><a href="logout.php" style="color: var(--danger-color);">Logout</a></li>
            </ul>
        </div>
        <div class="admin-content">
            <h1 style="margin-bottom:30px;">Edit Berita</h1>
            <div class="content-card">
                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <div class="form-group"><label>Judul *</label><input type="text" name="judul" class="form-control" value="<?php echo $berita['judul']; ?>" required></div>
                    <div class="form-row">
                        <div class="form-group"><label>Kategori *</label><select name="kategori" class="form-control" required><option value="berita" <?php echo $berita['kategori']=='berita'?'selected':''; ?>>Berita</option><option value="pengumuman" <?php echo $berita['kategori']=='pengumuman'?'selected':''; ?>>Pengumuman</option><option value="prestasi" <?php echo $berita['kategori']=='prestasi'?'selected':''; ?>>Prestasi</option></select></div>
                        <div class="form-group"><label>Status *</label><select name="status" class="form-control" required><option value="draft" <?php echo $berita['status']=='draft'?'selected':''; ?>>Draft</option><option value="published" <?php echo $berita['status']=='published'?'selected':''; ?>>Published</option></select></div>
                    </div>
                    <div class="form-group"><label>Gambar</label><input type="file" name="gambar" class="form-control" accept="image/*"><?php if($berita['gambar']) echo '<br><small>Current: '.$berita['gambar'].'</small>'; ?></div>
                    <div class="form-group"><label>Isi Berita *</label><textarea name="isi" class="form-control" rows="10" required><?php echo $berita['isi']; ?></textarea></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Update</button> <a href="berita.php" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
