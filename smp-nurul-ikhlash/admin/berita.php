<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    query("DELETE FROM berita WHERE id = $id");
    set_flash_message('success', 'Berita berhasil dihapus');
    header('Location: berita.php');
    exit();
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Total berita
$sql_count = "SELECT COUNT(*) as total FROM berita";
$result_count = query($sql_count);
$total_records = fetch_assoc($result_count)['total'];
$total_pages = ceil($total_records / $per_page);

// Ambil data berita
$sql_berita = "SELECT * FROM berita ORDER BY created_at DESC LIMIT $offset, $per_page";
$result_berita = query($sql_berita);
$berita_list = fetch_all($result_berita);

$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="admin-content">
            <div class="d-flex justify-between align-center mb-2">
                <h1>Kelola Berita</h1>
                <a href="berita-tambah.php" class="btn btn-primary">+ Tambah Berita</a>
            </div>

            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>

            <div class="content-card">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($berita_list) > 0): ?>
                                <?php $no = $offset + 1; ?>
                                <?php foreach ($berita_list as $berita): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $berita['judul']; ?></td>
                                        <td><?php echo ucfirst($berita['kategori']); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $berita['status'] == 'published' ? 'success' : 'draft'; ?>">
                                                <?php echo ucfirst($berita['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $berita['views']; ?></td>
                                        <td><?php echo format_tanggal_indonesia($berita['created_at']); ?></td>
                                        <td>
                                            <a href="berita-edit.php?id=<?php echo $berita['id']; ?>" class="btn btn-secondary" style="padding: 8px 15px; font-size: 13px;">Edit</a>
                                            <a href="berita.php?delete=<?php echo $berita['id']; ?>" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px; background: #ef4444;" data-confirm="Apakah Anda yakin ingin menghapus berita ini?">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center;">Belum ada berita</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                echo pagination($total_records, $per_page, $page, 'berita.php');
                ?>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
