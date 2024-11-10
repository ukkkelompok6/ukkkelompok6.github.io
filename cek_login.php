<?php
// Mengikutsertakan file koneksi untuk menghubungkan ke database
include "config/koneksi.php";

// Mengambil username, password, dan role dari formulir login
$user = $_POST['username'];
$pass = md5($_POST['password']); // Mengubah password menjadi hash MD5 untuk keamanan

// Melakukan query ke database untuk memeriksa apakah ada pengguna dengan username, password, dan role yang sesuai
$login = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username ='$user' AND password = '$pass'");
$cek = mysqli_num_rows($login); // Menghitung jumlah baris hasil query

// Memeriksa apakah ada pengguna yang ditemukan
if ($cek > 0) {
    $data = mysqli_fetch_assoc($login); // Mengambil data pengguna yang ditemukan
    // Memeriksa role pengguna
    if ($data['role'] == 'Admin') {
        session_start(); // Memulai sesi
        $_SESSION['UserID'] = $data['UserID']; // Menyimpan UserID ke dalam session
        $_SESSION['role'] = 'role'; // Menyimpan role ke dalam session
        header("location:admin/index.php"); // Mengarahkan ke halaman admin
    } else if ($data['role'] == 'Petugas') {
        session_start(); // Memulai sesi
        $_SESSION['UserID'] = $data['UserID']; // Menyimpan UserID ke dalam session
        $_SESSION['role'] = 'role'; // Menyimpan role ke dalam session
        header("location:petugas/index.php"); // Mengarahkan ke halaman petugas
    }
} else {
    // Jika login gagal, mengarahkan kembali ke halaman login dengan pesan gagal
    header("location:index.php?pesan=gagal");
}
?>
