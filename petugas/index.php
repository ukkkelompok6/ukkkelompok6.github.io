<?php
// Mengikutsertakan file header untuk bagian atas halaman
include "header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard <!-- Judul halaman -->
            <small>Aplikasi Kasir Sederhana</small> <!-- Deskripsi singkat -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Data Pelanggan</span>
                        <span class="info-box-number">
                            <?php
                            // Mengambil jumlah pelanggan dari tabel tb_pelanggan
                            $pelanggan = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                            echo mysqli_num_rows($pelanggan); // Menampilkan jumlah pelanggan
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-cart-plus"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Data Produk</span>
                        <span class="info-box-number">
                            <?php
                            // Mengambil jumlah produk dari tabel tb_produk
                            $produk = mysqli_query($koneksi, "SELECT * FROM tb_produk");
                            echo mysqli_num_rows($produk); // Menampilkan jumlah produk
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-bar-chart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Data Transaksi</span>
                        <span class="info-box-number">
                            <?php
                            // Mengambil UserID dari sesi login
                            $UserID = $_SESSION['UserID'];

                            // Mengambil jumlah transaksi yang dilakukan oleh UserID yang sedang login
                            $penjualan = mysqli_query($koneksi, "SELECT * FROM tb_penjualan WHERE UserID = '$UserID'");
                            echo mysqli_num_rows($penjualan); // Menampilkan jumlah transaksi
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">TOTAL TRANSAKSI</span>
                        <span class="info-box-number">
                            <?php
                            // Mengambil UserID dari sesi login
                            $UserID = $_SESSION['UserID'];

                            // Menghitung total harga dari semua transaksi yang dilakukan oleh UserID yang sedang login
                            $total_transaksi = mysqli_query($koneksi, "SELECT SUM(TotalHarga) AS jml_total FROM tb_penjualan WHERE UserID = '$UserID'");
                            $total = 0;
                            while ($t_trans = mysqli_fetch_array($total_transaksi)) {
                                $total = +$t_trans['jml_total']; // Menyimpan total harga
                            }

                            // Menampilkan total transaksi dalam format mata uang
                            echo "RP. ".number_format($total) . ",-";
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
// Mengikutsertakan file footer untuk bagian bawah halaman
include "footer.php";
?>
