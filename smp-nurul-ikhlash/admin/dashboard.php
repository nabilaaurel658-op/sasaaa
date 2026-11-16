<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

// Flash message
$flash = get_flash_message();

// Statistik
$sql_siswa = "SELECT COUNT(*) as total FROM siswa WHERE status = 'aktif'";
$result_siswa = query($sql_siswa);
$total_siswa = fetch_assoc($result_siswa)['total'];

$sql_guru = "SELECT COUNT(*) as total FROM guru WHERE status = 'aktif'";
$result_guru = query($sql_guru);
$total_guru = fetch_assoc($result_guru)['total'];

$sql_ppdb = "SELECT COUNT(*) as total FROM ppdb WHERE status = 'pending'";
$result_ppdb = query($sql_ppdb);
$total_ppdb = fetch_assoc($result_ppdb)['total'];

$sql_berita = "SELECT COUNT(*) as total FROM berita WHERE status = 'published'";
$result_berita = query($sql_berita);
$total_berita = fetch_assoc($result_berita)['total'];

$sql_ekskul = "SELECT COUNT(*) as total FROM ekskul WHERE status = 'aktif'";
$result_ekskul = query($sql_ekskul);
$total_ekskul = fetch_assoc($result_ekskul)['total'];

// PPDB terbaru
$sql_ppdb_terbaru = "SELECT * FROM ppdb ORDER BY created_at DESC LIMIT 5";
$result_ppdb_terbaru = query($sql_ppdb_terbaru);
$ppdb_terbaru = fetch_all($result_ppdb_terbaru);

// Berita terbaru
$sql_berita_terbaru = "SELECT * FROM berita ORDER BY created_at DESC LIMIT 5";
$result_berita_terbaru = query($sql_berita_terbaru);
$berita_terbaru = fetch_all($result_berita_terbaru);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: var(--white);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        .stat-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .stat-card h3 {
            font-size: 42px;
            color: #667eea;
            margin-bottom: 8px;
            font-weight: 700;
        }
        .stat-card p {
            color: #718096;
            font-size: 15px;
            font-weight: 500;
        }
    </style>
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
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="berita.php">Kelola Berita</a></li>
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
            <h1 style="margin-bottom: 30px;">Dashboard</h1>

            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>

            <!-- Statistik -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon">👨‍🎓</div>
                    <h3><?php echo $total_siswa; ?></h3>
                    <p>Total Siswa Aktif</p>
                </div>
                <div class="stat-card">
                    <div class="icon">👨‍🏫</div>
                    <h3><?php echo $total_guru; ?></h3>
                    <p>Total Guru Aktif</p>
                </div>
                <div class="stat-card">
                    <div class="icon">📝</div>
                    <h3><?php echo $total_ppdb; ?></h3>
                    <p>PPDB Pending</p>
                </div>
                <div class="stat-card">
                    <div class="icon">📰</div>
                    <h3><?php echo $total_berita; ?></h3>
                    <p>Berita Published</p>
                </div>
                <div class="stat-card">
                    <div class="icon">⚽</div>
                    <h3><?php echo $total_ekskul; ?></h3>
                    <p>Ekskul Aktif</p>
                </div>
            </div>

            <!-- PPDB Terbaru -->
            <div class="content-card">
                <h3>📝 Pendaftaran PPDB Terbaru</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Asal Sekolah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($ppdb_terbaru) > 0): ?>
                                <?php foreach ($ppdb_terbaru as $ppdb): ?>
                                    <tr>
                                        <td><?php echo $ppdb['no_pendaftaran']; ?></td>
                                        <td><?php echo $ppdb['nama_lengkap']; ?></td>
                                        <td><?php echo $ppdb['asal_sekolah']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $ppdb['status'] == 'pending' ? 'pending' : ($ppdb['status'] == 'diterima' ? 'success' : 'danger'); ?>">
                                                <?php echo ucfirst($ppdb['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo format_tanggal_indonesia($ppdb['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">Belum ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <a href="ppdb.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Lihat Semua →</a>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <div class="content-card">
                <h3>📰 Berita Terbaru</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($berita_terbaru) > 0): ?>
                                <?php foreach ($berita_terbaru as $berita): ?>
                                    <tr>
                                        <td><?php echo $berita['judul']; ?></td>
                                        <td><?php echo ucfirst($berita['kategori']); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $berita['status'] == 'published' ? 'success' : 'pending'; ?>">
                                                <?php echo ucfirst($berita['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo format_tanggal_indonesia($berita['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">Belum ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <a href="berita.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Lihat Semua →</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
