<?php
// Memulai sesi untuk dapat mengakses data sesi
session_start();

// Menghancurkan semua data sesi yang ada saat ini. Ini menghapus semua informasi pengguna, sehingga mereka keluar dari sistem.
session_destroy();

// Mengalihkan pengguna ke halaman index.php setelah logout
header("location:../index.php");
?>
