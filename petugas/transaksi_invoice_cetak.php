<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Transaksi || Aplikasi Kasir</title>
    <!-- Link ke CSS Bootstrap untuk styling -->
    <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <style>
        /* Gaya CSS untuk struk transaksi */
        body {
            font-family: 'Courier New', Courier, monospace; /* Mengatur font menjadi monospace */
            width: 57mm; /* Lebar struk dalam milimeter, sesuai dengan ukuran kertas struk */
            margin: auto; /* Memusatkan struk di halaman */
            padding: 10px; /* Padding di sekitar struk */
            border: 1px solid #ddd; /* Garis batas ringan di sekitar struk */
            background-color: #fff; /* Latar belakang putih untuk struk */
            font-size: 10px; /* Ukuran font dasar */
        }
        .text-center {
            text-align: center; /* Mengatur teks agar rata tengah */
        }
        .header {
            font-size: 18px; /* Ukuran font lebih besar untuk header */
            font-weight: bold; /* Menebalkan header */
            margin-bottom: 5px; /* Jarak di bawah header */
        }
        .sub-header {
            font-size: 10px; /* Ukuran font lebih kecil untuk sub-header */
            margin-bottom: 10px; /* Jarak di bawah sub-header */
        }
        .total {
            font-weight: 1px; /* Mengatur ketebalan font untuk total */
            font-size: 10px; /* Ukuran font untuk total */
            margin-top: 10px; /* Jarak di atas total */
        }
        .subtotal {
            font-weight: bold; /* Menebalkan subtotal */
            font-size: 10px; /* Ukuran font untuk subtotal */
            background-color: #f8f9fa; /* Latar belakang terang untuk subtotal */
            padding: 5px; /* Padding di dalam kotak subtotal */
            border: 1px solid #ddd; /* Garis batas di sekitar subtotal */
            border-radius: 5px; /* Sudut melengkung untuk subtotal */
            margin-top: 10px; /* Jarak di atas subtotal */
            text-align: center; /* Mengatur teks agar rata tengah */
        }
        table {
            width: 100%; /* Tabel mengambil lebar penuh dari elemen induk */
            margin-top: 10px; /* Jarak di atas tabel */
        }
        table th, table td {
            padding: 5px; /* Padding di dalam sel tabel */
            text-align: left; /* Mengatur teks dalam sel ke kiri */
            border-bottom: 1px solid #ddd; /* Garis batas bawah untuk sel tabel */
        }
        table th:nth-child(4), table td:nth-child(4) {
            text-align: right; /* Mengatur harga agar rata kanan */
        }
        .footer {
            margin-top: 20px; /* Jarak di atas footer */
            font-size: 9px; /* Ukuran font lebih kecil untuk footer */
            font-style: italic; /* Mengatur teks footer menjadi miring */
            text-align: center; /* Mengatur teks agar rata tengah */
        }
        .line {
            border-top: 1px dashed #000; /* Garis putus-putus untuk pemisahan antar bagian */
            margin: 5px 0; /* Jarak di atas dan bawah garis */
        }

        @media print {
            body {
                width: 57mm; /* Pastikan lebar tetap sama saat mencetak */
            }
            @page {
                margin: 0; /* Menghapus margin halaman saat mencetak */
            }
        }
    </style>
</head>
<body>
    <?php
    // Menghubungkan ke database
    include "../config/koneksi.php";

    // Memulai sesi untuk mengakses variabel sesi
    session_start();

    // Memeriksa apakah pengguna sudah login
    if ($_SESSION['role'] === "") {
        header("location:../index.php"); // Mengalihkan ke halaman login jika belum login
        exit; // Menghentikan eksekusi script
    }

    // Mengambil PenjualanID dari URL menggunakan metode GET
    $PenjualanID = $_GET['PenjualanID'];

    // Query untuk mendapatkan data penjualan beserta detail pelanggan dan petugas
    $dt_penjualan = mysqli_query($koneksi, "SELECT tb_penjualan.*, tb_pelanggan.NamaPelanggan, tb_user.NamaUser 
        FROM tb_penjualan 
        INNER JOIN tb_pelanggan ON tb_penjualan.PelangganID = tb_pelanggan.PelangganID 
        INNER JOIN tb_user ON tb_penjualan.UserID = tb_user.UserID 
        WHERE PenjualanID = '$PenjualanID'");

    // Mengulangi data penjualan yang diambil dari database
    while ($penjualan = mysqli_fetch_array($dt_penjualan)) {
    ?>
        
            <!-- Header Struk -->
            <h2 class="text-center header">Toko K6</h2> <!-- Nama Toko -->
            <p class="text-center sub-header">Jl. Jendral Soedirman No.175 Majalengka</p> <!-- Alamat Toko -->
            <div class="line"></div> <!-- Garis pemisah -->
            <table>
                <!-- Menampilkan detail penjualan -->
                <tr>
                    <td>NO. Penjualan</td> <!-- Label untuk nomor penjualan -->
                    <td>:</td>
                    <td><?php echo $penjualan['PenjualanID']; ?></td> <!-- Menampilkan ID Penjualan -->
                </tr>
                <tr>
                    <td>Nama Pelanggan</td> <!-- Label untuk nama pelanggan -->
                    <td>:</td>
                    <td><?php echo $penjualan['NamaPelanggan']; ?></td> <!-- Menampilkan nama pelanggan -->
                </tr>
                <tr>
                    <td>Nama Petugas</td> <!-- Label untuk nama petugas -->
                    <td>:</td>
                    <td><?php echo $penjualan['NamaUser']; ?></td> <!-- Menampilkan nama petugas -->
                </tr>
                <tr>
                    <td>Tanggal Transaksi</td> <!-- Label untuk tanggal transaksi -->
                    <td>:</td>
                    <td><?php echo $penjualan['TanggalPenjualan']; ?></td> <!-- Menampilkan tanggal transaksi -->
                </tr>
            </table>
            <div class="line"></div> <!-- Garis pemisah -->
            <h4 class="text-center">Data Barang</h4> <!-- Judul untuk data barang -->
            <table width="57mm">
                <thead>
                    <tr>
                        <td>NO</td> <!-- Kolom nomor -->
                        <td>BARANG</td> <!-- Kolom nama barang -->
                        <td>Jumlah</td> <!-- Kolom jumlah -->
                        <td>Harga</td> <!-- Kolom harga -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mendapatkan data barang yang dibeli
                    $data_belanjaan = mysqli_query($koneksi, "SELECT tb_produk.NamaProduk, 
                        tb_detail_penjualan.JumlahProduk, 
                        tb_produk.Harga AS HargaSatuan, 
                        SUM(tb_detail_penjualan.JumlahProduk * tb_produk.Harga) AS SubTotal 
                        FROM tb_detail_penjualan 
                        INNER JOIN tb_produk ON tb_produk.ProdukID = tb_detail_penjualan.ProdukID 
                        WHERE PenjualanID = '$PenjualanID' 
                        GROUP BY tb_detail_penjualan.ProdukID");

                    $no = 1; // Inisialisasi nomor item
                    $total = 0; // Inisialisasi total harga

                    // Mengulangi setiap item dalam pembelian
                    while ($belanjaan = mysqli_fetch_array($data_belanjaan)) {
                        $total += $belanjaan['SubTotal']; // Menghitung subtotal untuk total keseluruhan
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td> <!-- Menampilkan nomor item -->
                            <td><?php echo $belanjaan['NamaProduk']; ?></td> <!-- Menampilkan nama produk -->
                            <td><?php echo $belanjaan['JumlahProduk']; ?></td> <!-- Menampilkan jumlah produk -->
                            <td><?php echo "Rp." . number_format($belanjaan['HargaSatuan']) . ",-"; ?></td> <!-- Menampilkan harga dengan format -->
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="line"></div> <!-- Garis pemisah -->
            <!-- Menampilkan subtotal dari semua barang yang dibeli -->
            <p class="subtotal">Subtotal: Rp. <?php echo number_format($total) . ",-"; ?></p>
            
            <!-- Menampilkan Bayar dan Kembalian -->
            <table width="57mm">
                <tr>
                    <td>Total Bayar</td>
                    <td>: Rp. <?php echo number_format($penjualan['JumlahPembayaran']); ?>,-</td> <!-- Menampilkan jumlah pembayaran -->
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td>: Rp. <?php echo number_format($penjualan['Kembalian']); ?>,-</td> <!-- Menampilkan kembalian -->
                </tr>
            </table>
            <div class="line"></div> <!-- Garis pemisah -->
            <p class="footer">"Terimakasih Sudah 
                Berbelanja Di Toko Kami"</p> <!-- Pesan terima kasih kepada pelanggan -->
    <?php
    }
    ?>

    <script type="text/javascript">
        window.print(); // Memicu dialog cetak secara otomatis saat halaman dimuat
    </script>
</body>
</html>
