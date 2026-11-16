<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM agenda WHERE id = $id";
$result = query($sql);
$agenda = fetch_assoc($result);

if (!$agenda) {
    header('Location: agenda.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = escape($_POST['judul']);
    $deskripsi = escape($_POST['deskripsi']);
    $tanggal_mulai = escape($_POST['tanggal_mulai']);
    $tanggal_selesai = escape($_POST['tanggal_selesai']);
    $waktu = escape($_POST['waktu']);
    $lokasi = escape($_POST['lokasi']);
    $kategori = escape($_POST['kategori']);

    $sql = "UPDATE agenda SET judul = '$judul', deskripsi = '$deskripsi', tanggal_mulai = '$tanggal_mulai', tanggal_selesai = '$tanggal_selesai', waktu = '$waktu', lokasi = '$lokasi', kategori = '$kategori' WHERE id = $id";
    if (query($sql)) {
        set_flash_message('success', 'Agenda berhasil diupdate');
        header('Location: agenda.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Agenda - Admin</title>
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
                <li><a href="siswa.php">Kelola Siswa</a></li>
                <li><a href="agenda.php" class="active">Kelola Agenda</a></li>
                <li><a href="pengaturan.php">Pengaturan</a></li>
                <li><a href="logout.php" style="color: var(--danger-color);">Logout</a></li>
            </ul>
        </div>
        <div class="admin-content">
            <h1 style="margin-bottom:30px;">Edit Agenda</h1>
            <div class="content-card">
                <form action="" method="POST" data-validate>
                    <div class="form-group"><label>Judul *</label><input type="text" name="judul" class="form-control" value="<?php echo $agenda['judul']; ?>" required></div>
                    <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" class="form-control"><?php echo $agenda['deskripsi']; ?></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>Tanggal Mulai *</label><input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $agenda['tanggal_mulai']; ?>" required></div>
                        <div class="form-group"><label>Tanggal Selesai</label><input type="date" name="tanggal_selesai" class="form-control" value="<?php echo $agenda['tanggal_selesai']; ?>"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>Waktu</label><input type="text" name="waktu" class="form-control" value="<?php echo $agenda['waktu']; ?>" placeholder="Contoh: 08:00 - 12:00"></div>
                        <div class="form-group"><label>Lokasi</label><input type="text" name="lokasi" class="form-control" value="<?php echo $agenda['lokasi']; ?>"></div>
                    </div>
                    <div class="form-group"><label>Kategori</label><input type="text" name="kategori" class="form-control" value="<?php echo $agenda['kategori']; ?>" placeholder="Contoh: Upacara, Rapat, dll"></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Update</button> <a href="agenda.php" class="btn btn-secondary">Batal</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
