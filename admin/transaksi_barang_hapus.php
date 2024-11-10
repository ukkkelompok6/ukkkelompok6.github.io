<?php
// Menghubungkan ke database menggunakan file koneksi yang sudah ada
include "../config/koneksi.php";

// Menangkap data ID Produk dan Penjualan dari URL
$ProdukID = $_GET['ProdukID']; // Mengambil ID produk yang ingin dihapus
$PenjualanID = $_GET['PenjualanID']; // Mengambil ID penjualan yang berkaitan

// Menghitung stok terbaru dengan mengambil jumlah produk dari tabel detail penjualan
$jml_stok = mysqli_query($koneksi, "SELECT JumlahProduk FROM tb_detail_penjualan WHERE ProdukID='$ProdukID' AND PenjualanID='$PenjualanID'");
$jml = mysqli_fetch_assoc($jml_stok); // Mengambil hasil query dalam bentuk array asosiatif

// Mengambil stok saat ini dari tabel produk
$stok = mysqli_query($koneksi, "SELECT Stok FROM tb_produk WHERE ProdukID='$ProdukID'");
$s = mysqli_fetch_assoc($stok); // Mengambil hasil query dalam bentuk array asosiatif

// Menjumlahkan stok saat ini dengan jumlah produk yang dihapus dari penjualan
$up_stok = implode($s) + implode($jml); // Menghitung stok terbaru setelah penjualan dihapus

// Mengupdate stok produk di tabel produk dengan nilai stok terbaru
mysqli_query($koneksi, "UPDATE tb_produk SET Stok = '$up_stok' WHERE ProdukID = '$ProdukID'");

// Menghapus data detail penjualan yang berkaitan dengan produk dan penjualan yang dipilih
mysqli_query($koneksi, "DELETE FROM tb_detail_penjualan WHERE ProdukID = '$ProdukID' AND PenjualanID = '$PenjualanID'");

// Mengarahkan kembali ke halaman transaksi_tambah.php setelah penghapusan berhasil
header("location:transaksi_tambah.php");
?>