<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil ProdukID dari URL menggunakan metode GET
$ProdukID = $_GET['ProdukID'];

// Menyiapkan query untuk menghapus data produk berdasarkan ProdukID
// Menggunakan fungsi mysqli_query untuk menjalankan query
mysqli_query($koneksi, "DELETE FROM tb_produk WHERE ProdukID = '$ProdukID'");

// Setelah proses penghapusan selesai, mengarahkan pengguna kembali ke halaman produk
header("location:produk_data.php");
?>
