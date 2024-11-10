<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil data yang dikirim dari form modal untuk mengedit data produk
$ProdukID = $_POST['id_produk'];    // Mengambil ID produk dari input form
$NamaProduk = $_POST['nm_produk'];   // Mengambil nama produk dari input form
$Harga = $_POST['harga'];            // Mengambil harga produk dari input form
$Stok = $_POST['stok'];              // Mengambil stok produk dari input form

// Menyiapkan dan menjalankan query untuk memperbarui data produk di tabel tb_produk
mysqli_query($koneksi, "UPDATE tb_produk SET NamaProduk = '$NamaProduk', Harga = '$Harga', Stok = '$Stok' WHERE ProdukID = '$ProdukID'");

// Setelah data berhasil diperbarui, mengarahkan pengguna kembali ke halaman data produk
header("location:produk_data.php");
?>
