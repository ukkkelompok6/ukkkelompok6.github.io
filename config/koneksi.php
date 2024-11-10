<?php 
// Mencoba menghubungkan ke database MySQL
$koneksi = mysqli_connect('localhost', 'root', '', 'k6');  

// Memeriksa apakah koneksi berhasil
if (mysqli_connect_errno()) {     
    // Jika gagal, tampilkan pesan kesalahan
    echo "koneksi gagal: " . mysqli_connect_errno(); 
} 
?>