<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil detail PPDB
$sql = "SELECT * FROM ppdb WHERE id = $id";
$result = query($sql);
$ppdb = fetch_assoc($result);

if (!$ppdb) {
    header('Location: ppdb.php');
    exit();
}

// Handle update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = escape($_POST['status']);
    $catatan = escape($_POST['catatan']);

    query("UPDATE ppdb SET status = '$status', catatan = '$catatan' WHERE id = $id");
    set_flash_message('success', 'Status PPDB berhasil diupdate');
    header('Location: ppdb.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail PPDB - Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 250px; background: var(--dark-color); color: var(--white); padding: 20px 0; position: fixed; height: 100vh; overflow-y: auto; }
        .admin-sidebar-header { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .admin-menu { list-style: none; }
        .admin-menu li a { display: block; padding: 15px 20px; color: var(--white); text-decoration: none; border-left: 3px solid transparent; transition: var(--transition); }
        .admin-menu li a:hover, .admin-menu li a.active { background: rgba(255,255,255,0.1); border-left-color: var(--accent-color); }
        .admin-content { margin-left: 250px; padding: 30px; flex: 1; }
        .detail-section { margin-bottom: 30px; }
        .detail-section h3 { margin-bottom: 15px; color: var(--primary-color); }
        .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .detail-item { background: var(--light-color); padding: 15px; border-radius: var(--border-radius); }
        .detail-item label { display: block; font-weight: 600; margin-bottom: 5px; color: var(--gray); }
        .detail-item span { font-size: 16px; }
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
            <a href="ppdb.php" style="display: inline-block; margin-bottom: 20px; color: var(--primary-color);">← Kembali</a>

            <h1 style="margin-bottom: 30px;">Detail Pendaftaran PPDB</h1>

            <div class="card" style="padding: 30px; margin-bottom: 30px;">
                <div style="background: var(--light-color); padding: 20px; border-radius: var(--border-radius); margin-bottom: 20px;">
                    <h3 style="margin-bottom: 10px;">Nomor Pendaftaran: <?php echo $ppdb['no_pendaftaran']; ?></h3>
                    <p>Status saat ini: <strong><?php echo ucfirst($ppdb['status']); ?></strong></p>
                </div>

                <!-- Data Pribadi -->
                <div class="detail-section">
                    <h3>Data Pribadi Siswa</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Nama Lengkap</label>
                            <span><?php echo $ppdb['nama_lengkap']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>NISN</label>
                            <span><?php echo $ppdb['nisn'] ?: '-'; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Tempat, Tanggal Lahir</label>
                            <span><?php echo $ppdb['tempat_lahir']; ?>, <?php echo format_tanggal_indonesia($ppdb['tanggal_lahir']); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Jenis Kelamin</label>
                            <span><?php echo $ppdb['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Agama</label>
                            <span><?php echo $ppdb['agama']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>No. HP</label>
                            <span><?php echo $ppdb['no_hp']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Email</label>
                            <span><?php echo $ppdb['email'] ?: '-'; ?></span>
                        </div>
                        <div class="detail-item" style="grid-column: 1 / -1;">
                            <label>Alamat</label>
                            <span><?php echo $ppdb['alamat']; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="detail-section">
                    <h3>Data Orang Tua</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Nama Ayah</label>
                            <span><?php echo $ppdb['nama_ayah']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Pekerjaan Ayah</label>
                            <span><?php echo $ppdb['pekerjaan_ayah']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Nama Ibu</label>
                            <span><?php echo $ppdb['nama_ibu']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Pekerjaan Ibu</label>
                            <span><?php echo $ppdb['pekerjaan_ibu']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>No. HP Orang Tua</label>
                            <span><?php echo $ppdb['no_hp_ortu']; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Data Akademik -->
                <div class="detail-section">
                    <h3>Data Akademik</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Asal Sekolah</label>
                            <span><?php echo $ppdb['asal_sekolah']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Nilai Rata-rata</label>
                            <span><?php echo $ppdb['nilai_rata_rata']; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Dokumen -->
                <div class="detail-section">
                    <h3>Dokumen</h3>
                    <div class="detail-grid">
                        <?php if ($ppdb['foto_siswa']): ?>
                            <div class="detail-item">
                                <label>Foto Siswa</label>
                                <a href="../assets/uploads/dokumentasi/<?php echo $ppdb['foto_siswa']; ?>" target="_blank" style="color: var(--primary-color);">Lihat</a>
                            </div>
                        <?php endif; ?>
                        <?php if ($ppdb['ijazah']): ?>
                            <div class="detail-item">
                                <label>Ijazah/STL</label>
                                <a href="../assets/uploads/dokumentasi/<?php echo $ppdb['ijazah']; ?>" target="_blank" style="color: var(--primary-color);">Lihat</a>
                            </div>
                        <?php endif; ?>
                        <?php if ($ppdb['kartu_keluarga']): ?>
                            <div class="detail-item">
                                <label>Kartu Keluarga</label>
                                <a href="../assets/uploads/dokumentasi/<?php echo $ppdb['kartu_keluarga']; ?>" target="_blank" style="color: var(--primary-color);">Lihat</a>
                            </div>
                        <?php endif; ?>
                        <?php if ($ppdb['akta_lahir']): ?>
                            <div class="detail-item">
                                <label>Akta Kelahiran</label>
                                <a href="../assets/uploads/dokumentasi/<?php echo $ppdb['akta_lahir']; ?>" target="_blank" style="color: var(--primary-color);">Lihat</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card" style="padding: 30px;">
                <h3 style="margin-bottom: 20px;">Update Status</h3>
                <form action="" method="POST" data-validate>
                    <div class="form-group">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" <?php echo $ppdb['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="wawancara" <?php echo $ppdb['status'] == 'wawancara' ? 'selected' : ''; ?>>Wawancara</option>
                            <option value="diterima" <?php echo $ppdb['status'] == 'diterima' ? 'selected' : ''; ?>>Diterima</option>
                            <option value="ditolak" <?php echo $ppdb['status'] == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"><?php echo $ppdb['catatan']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                        <a href="ppdb.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
