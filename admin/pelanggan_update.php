<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil data yang dikirim dari modal edit data pelanggan
$PelangganID = $_POST['id_pelanggan']; // Mengambil ID pelanggan dari input form (hidden field)
$NamaPelanggan = $_POST['nm_pelanggan']; // Mengambil nama pelanggan dari input form
$Alamat = $_POST['alamat']; // Mengambil alamat dari input form
$NomorTelepon = $_POST['no_hp']; // Mengambil nomor telepon dari input form

// Menjalankan query untuk memperbarui data pelanggan di tabel tb_pelanggan
mysqli_query($koneksi, "UPDATE tb_pelanggan SET NamaPelanggan = '$NamaPelanggan', Alamat = '$Alamat', NomorTelepon = '$NomorTelepon' WHERE PelangganID = '$PelangganID'");

// Setelah data berhasil diperbarui, redirect pengguna kembali ke halaman data pelanggan
header("location:pelanggan_data.php");
?>
