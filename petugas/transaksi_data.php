<?php
// Mengimpor file header yang berisi pengaturan tampilan awal dan koneksi database
include "header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Transaksi
            <small>Aplikasi Kasir Sederhana</small> <!-- Deskripsi aplikasi -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li> <!-- Navigasi ke dashboard -->
            <li class="active">Data Transaksi</li> <!-- Menandai halaman aktif -->
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <!-- Tombol untuk menambah transaksi baru -->
                <a href="transaksi_tambah.php" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>Tambah</a>      
            </div>
            <!-- /.box-header -->

            <!-- Form Pencarian, dipindah ke bawah tombol "Tambah" -->
            <div class="box-body">
                <form action="" method="GET" class="form-inline">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama Pelanggan atau Tanggal" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Cari</button>
                </form>
            </div>
            <!-- /.box-body -->

            <div class="box-body">
                <!-- Tabel untuk menampilkan data transaksi -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>TANGGAL PENJUALAN</th>
                            <th>NAMA PELANGGAN</th>
                            <th>KASIR</th>
                            <th>TOTAL</th>
                            <th>BAYAR</th>
                            <th>KEMBALIAN</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mengambil UserID dari session yang sedang login
                        $UserID = $_SESSION['UserID']; 
                        $search = isset($_GET['search']) ? $_GET['search'] : ''; // Mendapatkan kata kunci pencarian

                        $per_page = 10; // Jumlah data per halaman
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Mengambil halaman yang aktif
                        $offset = ($page - 1) * $per_page; // Menghitung offset untuk query

                        // Query untuk mendapatkan data penjualan dengan JOIN untuk mengambil nama pelanggan dan kasir
                        $sql = "SELECT * FROM tb_penjualan
                                INNER JOIN tb_pelanggan ON tb_pelanggan.PelangganID = tb_penjualan.PelangganID
                                INNER JOIN tb_user ON tb_user.UserID = tb_penjualan.UserID
                                WHERE tb_penjualan.UserID = '$UserID' AND 
                                      (tb_pelanggan.NamaPelanggan LIKE '%$search%' OR 
                                       DATE_FORMAT(tb_penjualan.TanggalPenjualan, '%Y-%m-%d') LIKE '%$search%')
                                LIMIT $per_page OFFSET $offset";

                        $dt_penjualan = mysqli_query($koneksi, $sql); // Menjalankan query
                        $no = $offset + 1; // Nomor urut transaksi
                        while ($transaksi = mysqli_fetch_array($dt_penjualan)) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td> <!-- Nomor urut -->
                                <td><?php echo $transaksi['TanggalPenjualan']; ?></td> <!-- Tanggal transaksi -->
                                <td><?php echo $transaksi['NamaPelanggan']; ?></td> <!-- Nama pelanggan -->
                                <td><?php echo $transaksi['NamaUser']; ?></td> <!-- Nama kasir -->
                                <td><?php echo "Rp. " . number_format($transaksi['TotalHarga'], 2, ',', '.'); ?></td> <!-- Total harga -->
                                <td><?php echo "Rp. " . number_format($transaksi['JumlahPembayaran'], 2, ',', '.'); ?></td> <!-- Jumlah Pembayaran -->
                                <td><?php echo "Rp. " . number_format($transaksi['Kembalian'], 2, ',', '.'); ?></td> <!-- Kembalian -->
                                <td>
                                    <!-- Tombol untuk mencetak invoice -->
                                    <a href="transaksi_invoice_cetak.php?PenjualanID=<?php echo $transaksi['PenjualanID']; ?>" target="_blank" class="btn btn-xs btn-warning" role="button" title="Cetak"><i class="fa fa-print">Cetak</i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Navigasi Paginasi (Diluar Tabel, di bawah tabel) -->
            <div style="text-align: left; margin-top: 10px;">
                <?php
                // Tombol Halaman Sebelumnya
                if ($page > 1) {
                    echo '<a href="?page=' . ($page - 1) . '&search=' . $search . '" class="btn btn-default btn-xs">Previous</a>';
                }

                // Menghitung total transaksi yang ada
                $total_query = "SELECT COUNT(*) as total FROM tb_penjualan
                    INNER JOIN tb_pelanggan ON tb_pelanggan.PelangganID = tb_penjualan.PelangganID 
                    INNER JOIN tb_user ON tb_user.UserID = tb_penjualan.UserID
                    WHERE tb_penjualan.UserID = '$UserID' AND 
                          (tb_pelanggan.NamaPelanggan LIKE '%$search%' OR 
                           DATE_FORMAT(tb_penjualan.TanggalPenjualan, '%Y-%m-%d') LIKE '%$search%')";
                $total_result = mysqli_query($koneksi, $total_query);
                $total_data = mysqli_fetch_assoc($total_result)['total'];

                // Menghitung total halaman yang diperlukan
                $total_pages = ceil($total_data / $per_page);

                // Menampilkan tombol halaman dari 1 hingga total_pages
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active_class = ($i == $page) ? 'style="background-color: #337ab7; color: white;"' : 'style="background-color: #f4f4f4; color: black;"';
                    echo "<a href=\"?page=$i&search=$search\" class=\"btn btn-xs\" $active_class>$i</a> ";
                }

                // Tombol Halaman Berikutnya
                if ($page < $total_pages) {
                    echo '<a href="?page=' . ($page + 1) . '&search=' . $search . '" class="btn btn-default btn-xs">Next</a>';
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>



<?php
// Mengimpor file footer yang berisi penutup halaman
include "footer.php";
?>
