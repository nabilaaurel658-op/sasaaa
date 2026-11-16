<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_ekskul = escape($_POST['nama_ekskul']);
    $deskripsi = escape($_POST['deskripsi']);
    $pembina = escape($_POST['pembina']);
    $jadwal_hari = escape($_POST['jadwal_hari']);
    $jadwal_waktu = escape($_POST['jadwal_waktu']);
    $status = escape($_POST['status']);

    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $upload = upload_file($_FILES['gambar'], '../assets/uploads/dokumentasi/');
        if ($upload['success']) $gambar = $upload['filename'];
    }

    $sql = "INSERT INTO ekskul (nama_ekskul, deskripsi, pembina, jadwal_hari, jadwal_waktu, gambar, status)
            VALUES ('$nama_ekskul', '$deskripsi', '$pembina', '$jadwal_hari', '$jadwal_waktu', '$gambar', '$status')";

    if (query($sql)) {
        set_flash_message('success', 'Ekskul berhasil ditambahkan');
        header('Location: ekskul.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ekskul - Admin</title>
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
                <li><a href="ekskul.php" class="active">Kelola Ekskul</a></li>
                <li><a href="dokumentasi.php">Kelola Dokumentasi</a></li>
                <li><a href="guru.php">Kelola Guru</a></li>
                <li><a href="siswa.php">Kelola Siswa</a></li>
                <li><a href="agenda.php">Kelola Agenda</a></li>
                <li><a href="pengaturan.php">Pengaturan</a></li>
                <li><a href="logout.php" style="color: var(--danger-color);">Logout</a></li>
            </ul>
        </div>
        <div class="admin-content">
            <h1 style="margin-bottom:30px;">Tambah Ekskul</h1>
            <div class="content-card">
                <form action="" method="POST" enctype="multipart/form-data" data-validate>
                    <div class="form-group"><label>Nama Ekskul *</label><input type="text" name="nama_ekskul" class="form-control" required></div>
                    <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" class="form-control"></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>Pembina *</label><input type="text" name="pembina" class="form-control" required></div>
                        <div class="form-group"><label>Kategori *</label><select name="kategori" class="form-control" required><option value="umum">Umum</option><option value="pesantren">Pesantren</option></select></div>
                    </div>
                    <div class="form-group"><label>Status *</label><select name="status" class="form-control" required><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select></div>
                    <div class="form-row">
                        <div class="form-group"><label>Hari *</label><select name="jadwal_hari" class="form-control" required><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option></select></div>
                        <div class="form-group"><label>Waktu *</label><input type="text" name="jadwal_waktu" class="form-control" placeholder="14:00 - 16:00" required></div>
                    </div>
                    <div class="form-group"><label>Gambar</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Simpan</button> <a href="ekskul.php" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
