<?php
// Mengimpor file koneksi untuk menghubungkan ke database
include "../config/koneksi.php";

// Mengambil data yang dikirim melalui formulir (POST) 
$notrans = $_POST['no_trans']; // Nomor transaksi
$ProdukID = $_POST['produk'];   // ID produk yang dipilih
$JumlahProduk = $_POST['jumlah']; // Jumlah produk yang ingin ditambahkan

// Menghitung sub total berdasarkan harga produk
$st = mysqli_query($koneksi, "SELECT Harga FROM tb_produk WHERE ProdukID = '$ProdukID'"); // Mengambil harga produk
$harga = mysqli_fetch_assoc($st); // Mengambil hasil sebagai array asosiatif
$sub_total = implode($harga) * $JumlahProduk; // Menghitung subtotal: harga dikali jumlah produk

// Menyimpan detail penjualan ke dalam tabel tb_detail_penjualan
mysqli_query($koneksi, "INSERT INTO tb_detail_penjualan VALUES ('', '$notrans', '$ProdukID', '$JumlahProduk', '$sub_total')");

// Menghitung stok terbaru setelah penjualan
$stok = mysqli_query($koneksi, "SELECT Stok FROM tb_produk WHERE ProdukID ='$ProdukID'"); // Mengambil stok saat ini
$s = mysqli_fetch_assoc($stok); // Mengambil hasil sebagai array asosiatif
$update = implode($s) - $JumlahProduk; // Mengurangi jumlah produk yang dijual dari stok saat ini

// Memperbarui data stok di tabel tb_produk
mysqli_query($koneksi, "UPDATE tb_produk SET Stok='$update' WHERE ProdukID ='$ProdukID'");

// Mengalihkan pengguna kembali ke halaman transaksi_tambah.php setelah operasi berhasil
header("location:transaksi_tambah.php");
?>