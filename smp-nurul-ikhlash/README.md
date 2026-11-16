# Website SMP Plus Nurul Ikhlash Ibtidai

Website sekolah lengkap dengan sistem PPDB online, dokumentasi kegiatan, dan admin panel.

## Fitur Utama

### 1. Halaman Publik
- **Beranda**: Landing page dengan informasi sekolah, berita terbaru, dan agenda
- **Tentang**: Informasi sejarah, visi, misi, dan tujuan sekolah
- **Berita**: Sistem berita dengan kategori (berita, pengumuman, prestasi)
- **Ekstrakurikuler**: Daftar ekskul dengan jadwal dan pembina
- **Dokumentasi**: Galeri kegiatan dan prestasi siswa
- **Guru**: Profil guru dan staf pengajar
- **PPDB Online**: Formulir pendaftaran siswa baru lengkap

### 2. Admin Panel
- **Dashboard**: Statistik dan ringkasan data
- **Kelola Berita**: CRUD berita dengan status draft/published
- **Kelola PPDB**: Verifikasi dan update status pendaftaran
- **Kelola Ekskul**: Manajemen data ekstrakurikuler
- **Kelola Dokumentasi**: Upload dan kelola galeri kegiatan
- **Kelola Guru**: Manajemen data guru
- **Kelola Siswa**: Manajemen data siswa
- **Kelola Agenda**: Manajemen jadwal kegiatan
- **Pengaturan**: Konfigurasi website sekolah

## Struktur Folder

```
smp-nurul-ikhlash/
├── admin/                      # Halaman admin
│   ├── login.php              # Login admin
│   ├── logout.php             # Logout admin
│   ├── dashboard.php          # Dashboard admin
│   ├── berita.php             # Kelola berita
│   ├── berita-tambah.php      # Tambah berita
│   ├── ppdb.php               # Kelola PPDB
│   ├── ppdb-detail.php        # Detail PPDB
│   ├── ekskul.php             # Kelola ekskul
│   ├── ekskul-tambah.php      # Tambah ekskul
│   ├── pengaturan.php         # Pengaturan website
│   └── ...
├── assets/                     # File statis
│   ├── css/
│   │   └── style.css          # CSS utama
│   ├── js/
│   │   └── main.js            # JavaScript utama
│   ├── images/                # Gambar statis
│   └── uploads/               # File upload
│       ├── berita/            # Upload berita
│       └── dokumentasi/       # Upload dokumentasi
├── includes/                   # File pendukung
│   ├── db.php                 # Koneksi database
│   └── functions.php          # Fungsi helper
├── pages/                      # Halaman publik
│   ├── index.php              # Beranda
│   ├── tentang.php            # Tentang sekolah
│   ├── berita.php             # Daftar berita
│   ├── berita-detail.php      # Detail berita
│   ├── ekskul.php             # Ekstrakurikuler
│   ├── dokumentasi.php        # Dokumentasi kegiatan
│   ├── guru.php               # Guru & staf
│   ├── ppdb.php               # Form PPDB
│   └── ppdb-success.php       # Sukses PPDB
├── database.sql                # Schema database
└── README.md                   # Dokumentasi ini
```

## Instalasi

### 1. Persyaratan
- Web server (Apache/Nginx)
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi

### 2. Setup Database

1. Buat database baru di MySQL:
```sql
CREATE DATABASE smp_nurul_ikhlash;
```

2. Import file `database.sql`:
```bash
mysql -u root -p smp_nurul_ikhlash < database.sql
```

### 3. Konfigurasi Database

Edit file `includes/db.php` sesuaikan dengan konfigurasi database Anda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // Ganti dengan username MySQL Anda
define('DB_PASS', '');          // Ganti dengan password MySQL Anda
define('DB_NAME', 'smp_nurul_ikhlash');
```

### 4. Setup Folder Uploads

Pastikan folder `assets/uploads/` dan subfoldernya memiliki permission write:
```bash
chmod -R 755 assets/uploads/
```

### 5. Akses Website

- **Website Publik**: `http://localhost/smp-nurul-ikhlash/`
- **Admin Panel**: `http://localhost/smp-nurul-ikhlash/admin/`

### 6. Login Admin Default

- **Username**: `admin`
- **Password**: `admin123`

⚠️ **PENTING**: Ganti password admin default setelah login pertama!

## Penggunaan

### Mengelola Berita

1. Login ke admin panel
2. Buka menu "Kelola Berita"
3. Klik "+ Tambah Berita"
4. Isi form (judul, kategori, isi, gambar)
5. Pilih status (draft/published)
6. Klik "Simpan"

### Mengelola PPDB

1. Buka menu "Kelola PPDB"
2. Lihat daftar pendaftar yang masuk
3. Klik "Detail" untuk melihat data lengkap
4. Update status (pending → wawancara → diterima/ditolak)
5. Tambahkan catatan jika diperlukan

### Mengelola Ekskul

1. Buka menu "Kelola Ekskul"
2. Klik "+ Tambah Ekskul"
3. Isi data ekskul (nama, pembina, jadwal)
4. Upload gambar jika ada
5. Klik "Simpan"

### Pengaturan Website

1. Buka menu "Pengaturan"
2. Update informasi sekolah (nama, alamat, kontak)
3. Update link sosial media
4. Atur status PPDB (buka/tutup)
5. Klik "Simpan Pengaturan"

## Customization

### Mengubah Warna Tema

Edit file `assets/css/style.css` dan ubah variabel CSS di bagian `:root`:

```css
:root {
    --primary-color: #1e88e5;    /* Warna utama */
    --secondary-color: #1565c0;  /* Warna sekunder */
    --accent-color: #ff6f00;     /* Warna aksen */
    /* ... */
}
```

### Menambah Logo

1. Upload logo ke folder `assets/images/`
2. Edit file `index.php` dan halaman lainnya
3. Ganti teks logo dengan tag `<img>`

### Menambah Halaman Baru

1. Buat file baru di folder `pages/`
2. Include file pendukung di awal:
```php
require_once '../includes/db.php';
require_once '../includes/functions.php';
```
3. Tambahkan link di navigation menu

## Security Tips

1. **Ganti password admin default**
2. **Gunakan HTTPS** untuk produksi
3. **Validasi input** di semua form
4. **Limit upload file size**
5. **Backup database** secara berkala
6. **Update PHP dan MySQL** ke versi terbaru

## Troubleshooting

### Error: Koneksi Database Gagal
- Cek konfigurasi di `includes/db.php`
- Pastikan MySQL server berjalan
- Verifikasi username dan password

### Error: File Upload Gagal
- Cek permission folder `assets/uploads/`
- Pastikan PHP upload_max_filesize cukup besar
- Verifikasi folder destination ada

### Halaman Tidak Muncul
- Pastikan web server berjalan
- Cek error log PHP
- Verifikasi file permissions

## Support

Untuk bantuan lebih lanjut, hubungi:
- Email: admin@smpnurulikhlash.sch.id
- Instagram: https://www.instagram.com/smpibtidai/

## License

Website ini dibuat untuk SMP Plus Nurul Ikhlash Ibtidai.
