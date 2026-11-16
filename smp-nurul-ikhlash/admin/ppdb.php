<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

// Handle update status
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = escape($_GET['status']);
    $catatan = isset($_GET['catatan']) ? escape($_GET['catatan']) : '';

    query("UPDATE ppdb SET status = '$status', catatan = '$catatan' WHERE id = $id");
    set_flash_message('success', 'Status PPDB berhasil diupdate');
    header('Location: ppdb.php');
    exit();
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Filter status
$status_filter = isset($_GET['status']) ? escape($_GET['status']) : '';

// Total PPDB
if ($status_filter) {
    $sql_count = "SELECT COUNT(*) as total FROM ppdb WHERE status = '$status_filter'";
} else {
    $sql_count = "SELECT COUNT(*) as total FROM ppdb";
}
$result_count = query($sql_count);
$total_records = fetch_assoc($result_count)['total'];
$total_pages = ceil($total_records / $per_page);

// Ambil data PPDB
if ($status_filter) {
    $sql_ppdb = "SELECT * FROM ppdb WHERE status = '$status_filter' ORDER BY created_at DESC LIMIT $offset, $per_page";
} else {
    $sql_ppdb = "SELECT * FROM ppdb ORDER BY created_at DESC LIMIT $offset, $per_page";
}
$result_ppdb = query($sql_ppdb);
$ppdb_list = fetch_all($result_ppdb);

$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola PPDB - Admin</title>
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
                <li><a href="berita.php">Kelola Berita</a></li>
                <li><a href="ppdb.php" class="active">Kelola PPDB</a></li>
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
            <h1 style="margin-bottom: 30px;">Kelola PPDB</h1>

            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>

            <!-- Filter -->
            <div style="margin-bottom: 20px;">
                <a href="ppdb.php" class="btn btn-secondary">Semua</a>
                <a href="ppdb.php?status=pending" class="btn btn-secondary">Pending</a>
                <a href="ppdb.php?status=wawancara" class="btn btn-secondary">Wawancara</a>
                <a href="ppdb.php?status=diterima" class="btn btn-secondary">Diterima</a>
                <a href="ppdb.php?status=ditolak" class="btn btn-secondary">Ditolak</a>
            </div>

            <div class="content-card">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Asal Sekolah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($ppdb_list) > 0): ?>
                                <?php $no = $offset + 1; ?>
                                <?php foreach ($ppdb_list as $ppdb): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $ppdb['no_pendaftaran']; ?></td>
                                        <td><?php echo $ppdb['nama_lengkap']; ?></td>
                                        <td><?php echo $ppdb['asal_sekolah']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php
                                                switch($ppdb['status']) {
                                                    case 'pending': echo 'pending'; break;
                                                    case 'diterima': echo 'success'; break;
                                                    case 'ditolak': echo 'danger'; break;
                                                    default: echo 'draft';
                                                }
                                                ?>">
                                                <?php echo ucfirst($ppdb['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo format_tanggal_indonesia($ppdb['created_at']); ?></td>
                                        <td>
                                            <a href="ppdb-detail.php?id=<?php echo $ppdb['id']; ?>" class="btn btn-secondary" style="padding: 8px 15px; font-size: 13px;">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center;">Belum ada data PPDB</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                $url = $status_filter ? "ppdb.php?status=$status_filter" : "ppdb.php";
                echo pagination($total_records, $per_page, $page, $url);
                ?>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
