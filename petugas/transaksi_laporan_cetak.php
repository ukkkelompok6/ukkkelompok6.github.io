<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Transaksi || Aplikasi Kasir</title>
    <!-- Menghubungkan file CSS Bootstrap untuk styling -->
    <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <style>
        /* CSS untuk pengaturan tampilan saat mencetak */
        @media print {
            body {
                -webkit-print-color-adjust: exact; /* Memastikan cetakan berwarna sesuai */
            }
            .no-print {
                display: none; /* Menyembunyikan elemen dengan kelas 'no-print' saat dicetak */
            }
            .table {
                width: 100%; /* Memastikan tabel mengambil lebar penuh untuk tampilan cetak */
            }
            .text-right {
                text-align: right; /* Mengatur teks di kanan untuk total */
            }
        }
        /* Margin untuk kontainer utama */
        .container {
            margin-top: 20px; /* Jarak atas untuk kontainer */
        }
        /* Mengatur margin untuk elemen h2 dan p */
        h2, p {
            margin: 5px 0; /* Mengurangi margin untuk tampilan lebih rapi */
        }
    </style>
</head>
<body>
    <?php
    // Mengimpor file koneksi untuk menghubungkan ke database
    include "../config/koneksi.php";
    
    session_start(); // Memulai sesi
    // Memeriksa apakah pengguna sudah login berdasarkan peran
    if ($_SESSION['role'] === "") {
        header("location:../index.php"); // Jika tidak, alihkan ke halaman login
    }
    ?>
    
    <div class="container">
        <h2 class="text-center"><strong>Kasir Toko K6</strong></h2> <!-- Judul cetakan -->
        <p class="text-center"><strong>Jl. Jendral Soedirman No.175 Majalengka</strong></p> <!-- Alamat toko -->
        <br>
        <!-- Tabel untuk menampilkan data transaksi -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NO</th> <!-- Kolom nomor urut -->
                    <th>NOMOR TRANSAKSI</th> <!-- Kolom nomor transaksi -->
                    <th>TANGGAL PENJUALAN</th> <!-- Kolom tanggal penjualan -->
                    <th>NAMA PELANGGAN</th> <!-- Kolom nama pelanggan -->
                    <th>NAMA PETUGAS</th> <!-- Kolom nama petugas (kasir) -->
                    <th>TOTAL</th> <!-- Kolom total harga -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengambil tanggal awal dan akhir dari parameter URL
                $tglawal = $_GET['dari'];
                $tglakhir = $_GET['sampai'];
                $UserID = $_SESSION['UserID']; // Mendapatkan ID pengguna dari sesi
                
                // Query untuk mengambil data penjualan berdasarkan rentang tanggal dan UserID petugas yang login
                $dt_penjualan = mysqli_query($koneksi, "SELECT * FROM tb_penjualan 
                    INNER JOIN tb_pelanggan ON tb_pelanggan.PelangganID = tb_penjualan.PelangganID 
                    INNER JOIN tb_user ON tb_user.UserID = tb_penjualan.UserID 
                    WHERE date(TanggalPenjualan) >= '$tglawal' 
                    AND date(TanggalPenjualan) <= '$tglakhir' 
                    AND tb_penjualan.UserID = '$UserID'  -- Menambahkan filter UserID
                    ORDER BY TanggalPenjualan DESC");
                
                $no = 1; // Inisialisasi nomor urut
                $totalKeseluruhan = 0; // Inisialisasi variabel total keseluruhan

                // Loop untuk menampilkan data penjualan
                while ($penjualan = mysqli_fetch_array($dt_penjualan)) {
                    // Menambahkan total harga ke total keseluruhan
                    $totalKeseluruhan += $penjualan['TotalHarga']; 
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                        <td><?php echo $penjualan['PenjualanID']; ?></td> <!-- Menampilkan ID penjualan -->
                        <td><?php echo $penjualan['TanggalPenjualan']; ?></td> <!-- Menampilkan tanggal penjualan -->
                        <td><?php echo $penjualan['NamaPelanggan']; ?></td> <!-- Menampilkan nama pelanggan -->
                        <td><?php echo $penjualan['NamaUser']; ?></td> <!-- Menampilkan nama petugas (kasir) -->
                        <td><?php echo "Rp. " . number_format($penjualan['TotalHarga']) . ",-"; ?></td> <!-- Menampilkan total harga dengan format mata uang -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="text-right">
            <!-- Menampilkan total keseluruhan di bagian kanan -->
            <strong>Total Keseluruhan: <?php echo "Rp. " . number_format($totalKeseluruhan) . ",-"; ?></strong> 
        </div>

        <br>
        <p class="text-center"><i>"Laporan Transaksi Dari Tanggal <?php echo $tglawal; ?> sampai <?php echo $tglakhir; ?>"</i></p> <!-- Keterangan laporan berdasarkan tanggal -->
    </div>

    <script type="text/javascript">
        window.print(); // Menjalankan fungsi cetak otomatis saat halaman dibuka
    </script>    
</body>
</html>
