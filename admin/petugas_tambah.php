<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil data yang dikirim dari form modal tambah data petugas
$NamaUser = $_POST['nm_petugas']; // Mengambil nama petugas dari input form
$Username = $_POST['username']; // Mengambil username dari input form
$Password = md5($_POST['password']); // Mengambil password, lalu mengenkripsi menggunakan md5
$Role = "Petugas"; // Menetapkan role sebagai "Petugas"

// Menjalankan query untuk memasukkan data ke tabel tb_user
mysqli_query($koneksi, "INSERT INTO tb_user VALUES ('','$NamaUser','$Username','$Password','$Role')");

// Setelah data berhasil ditambahkan, mengalihkan pengguna kembali ke halaman petugas_data.php
header("location:petugas_data.php");
?>
