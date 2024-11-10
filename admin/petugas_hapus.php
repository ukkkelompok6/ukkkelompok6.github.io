<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil UserID dari parameter URL yang diterima melalui metode GET
$UserID = $_GET['UserID'];

// Menjalankan query untuk menghapus data dari tabel tb_user berdasarkan UserID yang diterima
mysqli_query($koneksi, "DELETE FROM tb_user WHERE UserID = '$UserID' ");

// Setelah proses penghapusan selesai, mengalihkan pengguna kembali ke halaman petugas_data.php
header("location:petugas_data.php");
?>
