<?php
// File Functions Helper
// SMP Plus Nurul Ikhlash Ibtidai

session_start();

// Cek apakah user sudah login
function is_logged_in() {
    return isset($_SESSION['admin_id']);
}

// Redirect jika belum login
function require_login() {
    if (!is_logged_in()) {
        header("Location: ../admin/login.php");
        exit();
    }
}

// Redirect jika sudah login
function require_guest() {
    if (is_logged_in()) {
        header("Location: ../admin/dashboard.php");
        exit();
    }
}

// Format tanggal Indonesia
function format_tanggal_indonesia($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $parts = explode('-', $tanggal);
    if (count($parts) == 3) {
        $tahun = $parts[0];
        $bulan_num = (int)$parts[1];
        $hari = (int)$parts[2];
        return $hari . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
    }
    return $tanggal;
}

// Format tanggal lengkap dengan hari
function format_tanggal_lengkap($tanggal) {
    $hari = [
        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
    ];

    $date = new DateTime($tanggal);
    $nama_hari = $hari[$date->format('l')];
    $tanggal_indo = format_tanggal_indonesia($tanggal);

    return $nama_hari . ', ' . $tanggal_indo;
}

// Generate slug dari judul
function generate_slug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

// Upload file
function upload_file($file, $destination, $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'], $max_size = 5242880) {
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return ['success' => false, 'message' => 'Tidak ada file yang diupload'];
    }

    $filename = $file['name'];
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Cek ekstensi file
    if (!in_array($file_ext, $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }

    // Cek ukuran file
    if ($file_size > $max_size) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 5MB)'];
    }

    // Generate nama file baru
    $new_filename = uniqid() . '.' . $file_ext;
    $upload_path = $destination . $new_filename;

    // Upload file
    if (move_uploaded_file($file_tmp, $upload_path)) {
        return ['success' => true, 'filename' => $new_filename, 'message' => 'File berhasil diupload'];
    } else {
        return ['success' => false, 'message' => 'Gagal mengupload file'];
    }
}

// Hapus file
function delete_file($filepath) {
    if (file_exists($filepath)) {
        unlink($filepath);
        return true;
    }
    return false;
}

// Mendapatkan pengaturan website
function get_pengaturan($nama) {
    global $conn;
    $sql = "SELECT nilai FROM pengaturan WHERE nama_pengaturan = '$nama'";
    $result = query($sql);
    $row = fetch_assoc($result);
    return $row ? $row['nilai'] : '';
}

// Limit teks (untuk preview)
function limit_text($text, $limit = 100) {
    if (strlen($text) > $limit) {
        return substr($text, 0, $limit) . '...';
    }
    return $text;
}

// Flash message untuk notifikasi
function set_flash_message($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function get_flash_message() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Sanitasi input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Pagination
function pagination($total_records, $per_page, $current_page, $url) {
    $total_pages = ceil($total_records / $per_page);
    $pagination = '<div class="pagination">';

    if ($total_pages > 1) {
        // Previous button
        if ($current_page > 1) {
            $pagination .= '<a href="' . $url . '?page=' . ($current_page - 1) . '">&laquo; Prev</a>';
        }

        // Page numbers
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                $pagination .= '<span class="active">' . $i . '</span>';
            } else {
                $pagination .= '<a href="' . $url . '?page=' . $i . '">' . $i . '</a>';
            }
        }

        // Next button
        if ($current_page < $total_pages) {
            $pagination .= '<a href="' . $url . '?page=' . ($current_page + 1) . '">Next &raquo;</a>';
        }
    }

    $pagination .= '</div>';
    return $pagination;
}

// Generate nomor pendaftaran PPDB
function generate_no_pendaftaran() {
    $tahun = date('Y');
    $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    return 'PPDB' . $tahun . $random;
}
?>
