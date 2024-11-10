<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil data yang dikirim dari form modal untuk menambah data produk
$NamaProduk = $_POST['nm_produk']; // Mengambil nama produk dari input form
$Harga = $_POST['harga'];           // Mengambil harga produk dari input form
$Stok = $_POST['stok'];             // Mengambil stok produk dari input form

// Menyiapkan dan menjalankan query untuk menambahkan data produk ke tabel tb_produk
mysqli_query($koneksi, "INSERT INTO tb_produk VALUES ('', '$NamaProduk', '$Harga', '$Stok')");

// Setelah data berhasil ditambahkan, mengarahkan pengguna kembali ke halaman produk
header("location:produk_data.php");
?>
