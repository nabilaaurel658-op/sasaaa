-- Database Schema untuk SMP Plus Nurul Ikhlash Ibtidai
-- Dibuat oleh Devin

-- Buat database
CREATE DATABASE IF NOT EXISTS smp_nurul_ikhlash;
USE smp_nurul_ikhlash;

-- ============================================
-- 1. Tabel Admin (untuk login admin)
-- ============================================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert admin default (password: admin123 - hash menggunakan password_hash)
INSERT INTO admins (username, password, nama_lengkap, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@smpnurulikhlash.sch.id');

-- ============================================
-- 2. Tabel Berita/Pengumuman
-- ============================================
CREATE TABLE IF NOT EXISTS berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    isi TEXT NOT NULL,
    gambar VARCHAR(255),
    kategori ENUM('berita', 'pengumuman', 'prestasi') DEFAULT 'berita',
    status ENUM('draft', 'published') DEFAULT 'draft',
    views INT DEFAULT 0,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL
);

-- ============================================
-- 3. Tabel Ekskul
-- ============================================
CREATE TABLE IF NOT EXISTS ekskul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ekskul VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    pembina VARCHAR(100),
    jadwal_hari VARCHAR(50),
    jadwal_waktu VARCHAR(50),
    gambar VARCHAR(255),
    kategori ENUM('umum', 'pesantren') DEFAULT 'umum',
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data ekskul default
INSERT INTO ekskul (nama_ekskul, deskripsi, pembina, jadwal_hari, jadwal_waktu, kategori, status) VALUES
('Tahfidz Al-Qur''an', 'Program pembinaan hafalan Al-Qur''an yang terintegrasi dengan kegiatan harian santri untuk membentuk generasi penghafal Al-Qur''an.', 'Ust. Pembina Tahfidz', 'Senin-Kamis', '15:00 - 17:00', 'pesantren', 'aktif'),
('Kajian Kitab Kuning', 'Pembelajaran membaca dan memahami kitab kuning dengan metode Ibtida''i yang menjadi ciri khas utama sekolah ini.', 'Ust. Pembina Kitab', 'Senin-Rabu', '07:00 - 08:00', 'pesantren', 'aktif'),
('Pramuka', 'Kegiatan wajib bagi seluruh siswa jenjang SMP untuk melatih kedisiplinan, kemandirian, dan kerjasama dalam tim.', 'Kakak Pembina Pramuka', 'Jumat', '13:00 - 16:00', 'umum', 'aktif'),
('Seni Islami (Tilawah)', 'Seni baca Al-Qur''an dengan tartil yang indah sebagai bagian dari kegiatan kepesantrenan.', 'Ust. Pembina Seni', 'Selasa', '15:00 - 16:30', 'pesantren', 'aktif'),
('Hadrah/Rebana', 'Kegiatan seni rebana atau hadrah sebagai tradisi pesantren untuk melatih kerjasama dan kedisiplinan.', 'Ust. Pembina Hadrah', 'Rabu', '15:00 - 16:30', 'pesantren', 'aktif'),
('Muhadharah', 'Latihan pidato atau dakwah untuk melatih kepercayaan diri dan kemampuan berbicara di depan umum.', 'Ust. Pembina Dakwah', 'Kamis', '15:00 - 16:30', 'pesantren', 'aktif');

-- ============================================
-- 4. Tabel Dokumentasi Kegiatan
-- ============================================
CREATE TABLE IF NOT EXISTS dokumentasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kategori VARCHAR(100),
    tanggal DATE,
    gambar_utama VARCHAR(255),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL
);

-- ============================================
-- 5. Tabel Galeri Foto (untuk dokumentasi)
-- ============================================
CREATE TABLE IF NOT EXISTS galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dokumentasi_id INT,
    nama_file VARCHAR(255) NOT NULL,
    keterangan VARCHAR(255),
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dokumentasi_id) REFERENCES dokumentasi(id) ON DELETE CASCADE
);

-- ============================================
-- 6. Tabel PPDB (Pendaftaran Siswa Baru)
-- ============================================
CREATE TABLE IF NOT EXISTS ppdb (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_pendaftaran VARCHAR(20) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    nisn VARCHAR(20),
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    agama VARCHAR(20),
    alamat TEXT NOT NULL,
    no_hp VARCHAR(20),
    email VARCHAR(100),
    nama_ayah VARCHAR(100),
    pekerjaan_ayah VARCHAR(50),
    nama_ibu VARCHAR(100),
    pekerjaan_ibu VARCHAR(50),
    no_hp_ortu VARCHAR(20),
    asal_sekolah VARCHAR(100),
    nilai_rata_rata DECIMAL(4,2),
    foto_siswa VARCHAR(255),
    ijazah VARCHAR(255),
    kartu_keluarga VARCHAR(255),
    akta_lahir VARCHAR(255),
    status ENUM('pending', 'diterima', 'ditolak', 'wawancara') DEFAULT 'pending',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================
-- 7. Tabel Jadwal Pelajaran
-- ============================================
CREATE TABLE IF NOT EXISTS jadwal_pelajaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kelas VARCHAR(20) NOT NULL,
    hari ENUM('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu') NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    mata_pelajaran VARCHAR(100) NOT NULL,
    guru_pengajar VARCHAR(100),
    ruangan VARCHAR(20),
    semester ENUM('ganjil', 'genap') NOT NULL,
    tahun_ajaran VARCHAR(20) NOT NULL
);

-- ============================================
-- 8. Tabel Guru/Staf
-- ============================================
CREATE TABLE IF NOT EXISTS guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(30),
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    agama VARCHAR(20),
    alamat TEXT,
    no_hp VARCHAR(20),
    email VARCHAR(100),
    jabatan VARCHAR(50),
    mata_pelajaran VARCHAR(100),
    foto VARCHAR(255),
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================
-- 9. Tabel Siswa
-- ============================================
CREATE TABLE IF NOT EXISTS siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) NOT NULL UNIQUE,
    nisn VARCHAR(20),
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    agama VARCHAR(20),
    alamat TEXT,
    no_hp VARCHAR(20),
    email VARCHAR(100),
    kelas VARCHAR(20),
    foto VARCHAR(255),
    nama_ayah VARCHAR(100),
    nama_ibu VARCHAR(100),
    no_hp_ortu VARCHAR(20),
    status ENUM('aktif', 'nonaktif', 'lulus') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================
-- 10. Tabel Prestasi Siswa
-- ============================================
CREATE TABLE IF NOT EXISTS prestasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT,
    judul_prestasi VARCHAR(255) NOT NULL,
    tingkat ENUM('sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional') NOT NULL,
    kategori VARCHAR(50),
    tahun INT,
    deskripsi TEXT,
    sertifikat VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE SET NULL
);

-- ============================================
-- 11. Tabel Agenda Sekolah
-- ============================================
CREATE TABLE IF NOT EXISTS agenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE,
    waktu VARCHAR(50),
    lokasi VARCHAR(100),
    kategori VARCHAR(50),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(id) ON DELETE SET NULL
);

-- ============================================
-- 12. Tabel Pengaturan Website
-- ============================================
CREATE TABLE IF NOT EXISTS pengaturan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pengaturan VARCHAR(100) NOT NULL UNIQUE,
    nilai TEXT NOT NULL,
    keterangan VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert pengaturan default
INSERT INTO pengaturan (nama_pengaturan, nilai, keterangan) VALUES
('nama_sekolah', 'SMP Plus Nurul Ikhlash Ibtidai', 'Nama lengkap sekolah'),
('alamat_sekolah', 'Jl. Pendidikan No. 123, Kota', 'Alamat sekolah'),
('no_telepon', '021-12345678', 'Nomor telepon sekolah'),
('email_sekolah', 'info@smpnurulikhlash.sch.id', 'Email sekolah'),
('tahun_ajaran', '2024/2025', 'Tahun ajaran aktif'),
('instagram', 'https://www.instagram.com/smpibtidai/', 'Link Instagram'),
('facebook', '', 'Link Facebook'),
('youtube', '', 'Link YouTube'),
('twitter', '', 'Link Twitter'),
('ppdb_status', 'buka', 'Status PPDB: buka/tutup');

-- ============================================
-- Index untuk optimasi query
-- ============================================
CREATE INDEX idx_berita_status ON berita(status);
CREATE INDEX idx_berita_kategori ON berita(kategori);
CREATE INDEX idx_ppdb_status ON ppdb(status);
CREATE INDEX idx_ppdb_no_pendaftaran ON ppdb(no_pendaftaran);
CREATE INDEX idx_dokumentasi_kategori ON dokumentasi(kategori);
CREATE INDEX idx_dokumentasi_tanggal ON dokumentasi(tanggal);
CREATE INDEX idx_ekskul_status ON ekskul(status);
CREATE INDEX idx_siswa_kelas ON siswa(kelas);
CREATE INDEX idx_siswa_status ON siswa(status);
CREATE INDEX idx_guru_status ON guru(status);
CREATE INDEX idx_agenda_tanggal ON agenda(tanggal_mulai);
