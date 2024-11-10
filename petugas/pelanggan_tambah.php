<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil data yang dikirim dari form modal untuk menambah data pelanggan
$NamaPelanggan = $_POST['nm_pelanggan']; // Mengambil nama pelanggan dari input form
$Alamat = $_POST['alamat'];               // Mengambil alamat dari input form
$NomorTelepon = $_POST['no_hp'];         // Mengambil nomor telepon dari input form

// Menjalankan query untuk menambahkan data pelanggan baru ke tabel tb_pelanggan
// Menggunakan query INSERT untuk menambahkan data baru ke database
mysqli_query($koneksi, "INSERT INTO tb_pelanggan VALUES ('','$NamaPelanggan','$Alamat','$NomorTelepon')");

// Setelah data berhasil ditambahkan, redirect pengguna kembali ke halaman data pelanggan
header("location:pelanggan_data.php");
?>
