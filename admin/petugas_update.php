<?php
// Mengikutsertakan file koneksi.php untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil data yang dikirim dari modal edit data kasir/petugas
$UserID = $_POST['id_user']; // Mengambil ID pengguna yang akan diupdate
$NamaUser = $_POST['nm_user']; // Mengambil nama pengguna dari input form
$Username = $_POST['username']; // Mengambil username dari input form
$Password = md5($_POST['password']); // Mengambil password dan mengenkripsinya menggunakan md5
$Role = $_POST['role']; // Mengambil role dari input form

// Menjalankan query untuk memperbarui data kasir/petugas
mysqli_query($koneksi, "UPDATE tb_user SET NamaUser = '$NamaUser', username = '$Username', password = '$Password', role = '$Role' WHERE UserID = '$UserID'");

// Setelah data berhasil diperbarui, mengalihkan pengguna kembali ke halaman petugas_data.php
header("location:petugas_data.php");
?>
