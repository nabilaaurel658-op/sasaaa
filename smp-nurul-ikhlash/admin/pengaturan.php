<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $settings = [
        'nama_sekolah' => escape($_POST['nama_sekolah']),
        'alamat_sekolah' => escape($_POST['alamat_sekolah']),
        'no_telepon' => escape($_POST['no_telepon']),
        'email_sekolah' => escape($_POST['email_sekolah']),
        'tahun_ajaran' => escape($_POST['tahun_ajaran']),
        'instagram' => escape($_POST['instagram']),
        'facebook' => escape($_POST['facebook']),
        'youtube' => escape($_POST['youtube']),
        'twitter' => escape($_POST['twitter']),
        'ppdb_status' => escape($_POST['ppdb_status'])
    ];

    foreach ($settings as $key => $value) {
        query("UPDATE pengaturan SET nilai = '$value' WHERE nama_pengaturan = '$key'");
    }

    set_flash_message('success', 'Pengaturan berhasil disimpan');
    header('Location: pengaturan.php');
    exit();
}

$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Admin</title>
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
                <li><a href="agenda.php">Kelola Agenda</a></li>
                <li><a href="pengaturan.php" class="active">Pengaturan</a></li>
                <li><a href="logout.php" style="color: var(--danger-color);">Logout</a></li>
            </ul>
        </div>
        <div class="admin-content">
            <h1 style="margin-bottom:30px;">Pengaturan Website</h1>
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
            <?php endif; ?>
            <div class="content-card">
                <form action="" method="POST" data-validate>
                    <h3 style="margin-bottom:15px;">Informasi Sekolah</h3>
                    <div class="form-group"><label>Nama Sekolah *</label><input type="text" name="nama_sekolah" class="form-control" value="<?php echo get_pengaturan('nama_sekolah'); ?>" required></div>
                    <div class="form-group"><label>Alamat *</label><textarea name="alamat_sekolah" class="form-control" required><?php echo get_pengaturan('alamat_sekolah'); ?></textarea></div>
                    <div class="form-row">
                        <div class="form-group"><label>No. Telepon *</label><input type="text" name="no_telepon" class="form-control" value="<?php echo get_pengaturan('no_telepon'); ?>" required></div>
                        <div class="form-group"><label>Email *</label><input type="email" name="email_sekolah" class="form-control" value="<?php echo get_pengaturan('email_sekolah'); ?>" required></div>
                    </div>
                    <div class="form-group"><label>Tahun Ajaran *</label><input type="text" name="tahun_ajaran" class="form-control" value="<?php echo get_pengaturan('tahun_ajaran'); ?>" required></div>
                    <h3 style="margin:20px 0 15px;">Sosial Media</h3>
                    <div class="form-group"><label>Instagram</label><input type="url" name="instagram" class="form-control" value="<?php echo get_pengaturan('instagram'); ?>"></div>
                    <div class="form-group"><label>Facebook</label><input type="url" name="facebook" class="form-control" value="<?php echo get_pengaturan('facebook'); ?>"></div>
                    <div class="form-group"><label>YouTube</label><input type="url" name="youtube" class="form-control" value="<?php echo get_pengaturan('youtube'); ?>"></div>
                    <div class="form-group"><label>Twitter</label><input type="url" name="twitter" class="form-control" value="<?php echo get_pengaturan('twitter'); ?>"></div>
                    <h3 style="margin:20px 0 15px;">PPDB</h3>
                    <div class="form-group"><label>Status PPDB</label><select name="ppdb_status" class="form-control"><option value="buka" <?php echo get_pengaturan('ppdb_status')=='buka'?'selected':''; ?>>Buka</option><option value="tutup" <?php echo get_pengaturan('ppdb_status')=='tutup'?'selected':''; ?>>Tutup</option></select></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Simpan Pengaturan</button></div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
