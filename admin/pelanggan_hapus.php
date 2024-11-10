<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil nilai PelangganID dari parameter URL yang dikirimkan
$PelangganID = $_GET['PelangganID'];

// Melakukan query untuk menghapus data pelanggan berdasarkan PelangganID
// Query ini akan menghapus baris yang memiliki PelangganID yang sesuai dari tabel tb_pelanggan
mysqli_query($koneksi, "DELETE FROM tb_pelanggan WHERE PelangganID = '$PelangganID'");

// Setelah eksekusi query, redirect pengguna kembali ke halaman data pelanggan
header("location:pelanggan_data.php");
?>
