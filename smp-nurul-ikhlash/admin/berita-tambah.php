<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = escape($_POST['judul']);
    $slug = generate_slug($judul);
    $isi = escape($_POST['isi']);
    $kategori = escape($_POST['kategori']);
    $status = escape($_POST['status']);

    // Upload gambar
    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $upload = upload_file($_FILES['gambar'], '../assets/uploads/berita/');
        if ($upload['success']) {
            $gambar = $upload['filename'];
        }
    }

    $sql = "INSERT INTO berita (judul, slug, isi, kategori, status, gambar, created_by)
            VALUES ('$judul', '$slug', '$isi', '$kategori', '$status', '$gambar', {$_SESSION['admin_id']})";

    if (query($sql)) {
        set_flash_message('success', 'Berita berhasil ditambahkan');
        header('Location: berita.php');
        exit();
    } else {
        $error = 'Terjadi kesalahan saat menyimpan data';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 250px; background: var(--dark-color); color: var(--white); padding: 20px 0; position: fixed; height: 100vh; overflow-y: auto; }
        .admin-sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .admin-menu { list-style: none; }
        .admin-menu li a { display: block; padding: 15px 20px; color: var(--white); text-decoration: none; border-left: 3px solid transparent; transition: var(--transition); }
        .admin-menu li a:hover, .admin-menu li a.active { background: rgba(255,255,255,0.1); border-left-color: var(--accent-color); }
        .admin-content { margin-left: 250px; padding: 30px; flex: 1; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h3>🎓 Admin Panel</h3>
                <p style="font-size: 14px; color: var(--gray);">Halo, <?php echo $_SESSION['admin_nama']; ?></p>
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
            <h1 style="margin-bottom: 30px;">Tambah Berita</h1>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="content-card">
                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <div class="form-group">
                        <label>Judul *</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Kategori *</label>
                            <select name="kategori" class="form-control" required>
                                <option value="berita">Berita</option>
                                <option value="pengumuman">Pengumuman</option>
                                <option value="prestasi">Prestasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Isi Berita *</label>
                        <textarea name="isi" class="form-control" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="berita.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
