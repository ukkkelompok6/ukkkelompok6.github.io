<?php
// Mengimpor koneksi database dari file yang terletak di folder config
include "../config/koneksi.php";

// Pastikan session sudah dimulai
session_start();

// Mengambil data dari form menggunakan metode POST
$total = $_POST['TotalHarga']; // Total harga dari transaksi
$tanggal = $_POST['tanggal']; // Tanggal transaksi
$no_trans = $_POST['no_trans']; // Nomor transaksi
$UserID = $_SESSION['UserID']; // UserID yang didapatkan setelah login

// Mengambil ID Pelanggan, jika tidak ada pilih pelanggan default (ID 27)
$PelangganID = isset($_POST['PelangganID']) && $_POST['PelangganID'] !== '' ? $_POST['PelangganID'] : 27;

// Mengambil Jumlah Pembayaran dan Kembalian dari form
$pembayaran = $_POST['pembayaran']; // Jumlah yang dibayar
$kembalian = $_POST['kembalian']; // Jumlah kembalian

// Validasi apakah pembayaran cukup
if ($pembayaran < $total) {
    // Jika pembayaran kurang, beri pesan error dan hentikan proses
    echo "<script>alert('Pembayaran tidak cukup! Total belanja adalah Rp. " . number_format($total) . ".'); window.history.back();</script>";
    exit; // Menghentikan eksekusi lebih lanjut
}

// Query untuk menyisipkan data penjualan ke dalam tabel tb_penjualan
$query = "INSERT INTO tb_penjualan (PenjualanID, TanggalPenjualan, TotalHarga, PelangganID, UserID, JumlahPembayaran, Kembalian) 
          VALUES ('$no_trans', '$tanggal', '$total', '$PelangganID', '$UserID', '$pembayaran', '$kembalian')";

if (mysqli_query($koneksi, $query)) {
    // Jika berhasil, redirect ke halaman transaksi_data.php
    header("location:transaksi_data.php");
    exit(); // Menghentikan script setelah redirect
} else {
    // Jika gagal, tampilkan pesan kesalahan
    echo "Error: " . mysqli_error($koneksi); // Menampilkan pesan kesalahan
}

// Menutup koneksi database
mysqli_close($koneksi);
?>
