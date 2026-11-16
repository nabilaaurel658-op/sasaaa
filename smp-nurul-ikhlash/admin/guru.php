<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    query("DELETE FROM guru WHERE id = $id");
    set_flash_message('success', 'Guru berhasil dihapus');
    header('Location: guru.php');
    exit();
}

$sql_guru = "SELECT * FROM guru ORDER BY nama_lengkap ASC";
$result_guru = query($sql_guru);
$guru_list = fetch_all($result_guru);
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Guru - Admin</title>
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
            <div class="d-flex justify-between align-center mb-2">
                <h1>Kelola Guru</h1>
                <a href="guru-tambah.php" class="btn btn-primary">+ Tambah Guru</a>
            </div>
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
            <?php endif; ?>
            <div class="content-card">
                <table>
                    <thead><tr><th>No</th><th>Nama</th><th>NIP</th><th>Jabatan</th><th>Mapel</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php $no=1; foreach($guru_list as $guru): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $guru['nama_lengkap']; ?></td>
                            <td><?php echo $guru['nip'] ?: '-'; ?></td>
                            <td><?php echo $guru['jabatan']; ?></td>
                            <td><?php echo $guru['mata_pelajaran'] ?: '-'; ?></td>
                            <td><?php echo ucfirst($guru['status']); ?></td>
                            <td><a href="guru-edit.php?id=<?php echo $guru['id']; ?>" class="btn btn-secondary" style="padding: 8px 15px;">Edit</a> <a href="guru.php?delete=<?php echo $guru['id']; ?>" class="btn btn-primary" style="padding:5px 10px;background:var(--danger-color);" data-confirm="Hapus?">Hapus</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
