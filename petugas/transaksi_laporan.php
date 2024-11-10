<?php
// Menyertakan file header untuk memuat elemen-elemen umum seperti stylesheet dan script yang diperlukan
include "header.php";
?>

<!-- Content Wrapper. Menyimpan semua konten halaman -->
<div class="content-wrapper">

    <!-- Bagian konten utama -->
    <section class="content">
      <div class="row">

        <!-- Kolom untuk formulir filter -->
        <div class="col-md-4">
          <div class="box box-primary">
            <!-- Header dari box -->
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Form untuk memfilter transaksi berdasarkan rentang tanggal -->
                <form action="transaksi_laporan.php" method="$_GET">
                  <table class="table table-bordered table-striped">
                    <tr>
                        <td>
                            <label>Tanggal Awal</label>
                            <!-- Input untuk tanggal awal -->
                            <input type="date" class="form-control" name="tgl_awal" required>
                        </td>
                        <td>
                            <label>Tanggal Akhir</label>
                            <!-- Input untuk tanggal akhir -->
                            <input type="date" class="form-control" name="tgl_akhir" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <!-- Tombol kirim untuk memfilter hasil -->
                            <input type="submit" class="btn btn-primary pull-right" value="filter">
                        </td>
                    </tr>
                  </table>
                </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <?php
        // Memeriksa apakah tanggal awal dan akhir sudah diset dalam permintaan GET
        if(isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
            // Mengambil tanggal dari permintaan GET
            $awal = $_GET['tgl_awal'];
            $akhir = $_GET['tgl_akhir'];
            
            // Mengambil UserID dari session untuk memfilter petugas yang sedang login
            $UserID = $_SESSION['UserID'];
        ?>
        
        <!-- Kolom untuk menampilkan hasil transaksi -->
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header">
                <!-- Tombol untuk mencetak laporan, mengarah ke file PHP terpisah -->
                <a href="transaksi_laporan_cetak.php?dari=<?php echo $awal; ?>&sampai=<?php echo $akhir; ?>" target="_blank" class="btn btn-success pull-right">
                    <i class="glyphicon glyphicon-print"></i>CETAK
                </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                    <th>No</th> <!-- Kolom nomor urut -->
                    <th>NOMOR TRANSAKSI</th> <!-- Kolom untuk ID transaksi -->
                    <th>TANGGAL PENJUALAN</th> <!-- Kolom untuk tanggal penjualan -->
                    <th>NAMA PELANGGAN</th> <!-- Kolom untuk nama pelanggan -->
                    <th>NAMA PETUGAS</th> <!-- Kolom untuk nama petugas -->
                    <th>TOTAL</th> <!-- Kolom untuk total harga -->
                </thead>
                <tbody>
                   <tr>
                   <?php
                    // Query untuk mengambil data transaksi berdasarkan rentang tanggal dan UserID petugas yang login
                    $dt_penjualan = mysqli_query($koneksi, "
                        SELECT * FROM tb_penjualan 
                        INNER JOIN tb_pelanggan ON tb_pelanggan.PelangganID = tb_penjualan.PelangganID 
                        INNER JOIN tb_user ON tb_user.UserID = tb_penjualan.UserID 
                        WHERE tb_penjualan.UserID = '$UserID'  -- Filter berdasarkan UserID petugas yang login
                        AND date(TanggalPenjualan) >= '$awal' 
                        AND date(TanggalPenjualan) <= '$akhir' 
                        ORDER BY TanggalPenjualan DESC
                    ");
                    
                    // Menginisialisasi nomor transaksi
                    $no = 1; 
                    
                    // Mengulang setiap transaksi dan menampilkan hasilnya dalam tabel
                    while($penjualan = mysqli_fetch_array($dt_penjualan)) { 
                        ?>
                        <td><?php echo $no++; ?></td> <!-- Menampilkan nomor transaksi yang diurutkan -->
                        <td><?php echo $penjualan['PenjualanID']; ?></td> <!-- Menampilkan ID transaksi -->
                        <td><?php echo $penjualan['TanggalPenjualan']; ?></td> <!-- Menampilkan tanggal transaksi -->
                        <td><?php echo $penjualan['NamaPelanggan']; ?></td> <!-- Menampilkan nama pelanggan -->
                        <td><?php echo $penjualan['NamaUser']; ?></td> <!-- Menampilkan nama petugas -->
                        <td><?php echo "Rp. ". number_format($penjualan['TotalHarga']). ",-"; ?></td> <!-- Menampilkan total harga, diformat sebagai mata uang -->
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <?php
         } // Akhir dari blok if yang memeriksa apakah tanggal telah diisi
        ?>
      </div>
    </section>
    <!-- /.content -->
</div>

<?php
// Menyertakan file footer untuk memuat elemen footer umum
include "footer.php";
?>
