<?php
include "header.php"; // Menyertakan file header.php untuk tampilan bagian atas halaman.
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <!-- Tombol untuk membuka modal tambah transaksi -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah-transaksi">
            <i class="glyphicon glyphicon-plus"></i> Tambah
        </button>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- Tabel untuk menampilkan detail transaksi -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NAMA BARANG</th>
                                    <th>JUMLAH</th>
                                    <th>SUB TOTAL</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Mengambil ID penjualan maksimum untuk nomor transaksi
                                $dt_penjualan = mysqli_query($koneksi, "SELECT max(PenjualanID) as PenjualanID FROM tb_penjualan");
                                $penjualan = mysqli_fetch_array($dt_penjualan);
                                // Mengambil PenjualanID terakhir untuk menentukan nomor transaksi berikutnya
                                $kode_penjualan = $penjualan['PenjualanID'];
                                // Mengambil angka urutan 4 digit terakhir dari PenjualanID
                                $urutan = (int) substr($kode_penjualan, -4, 4) + 1; // Menambahkan 1 untuk urutan berikutnya
                                // Membuat awalan kode transaksi berdasarkan tanggal
                                $huruf = date('ymd'); // Format: yymmdd
                                // Menyusun kode transaksi yang baru dengan format 'yymmddXXXX' di mana XXXX adalah urutan
                                $kodeBarang = $huruf . sprintf("%04s", $urutan); 

                                // Mengambil detail penjualan berdasarkan kode transaksi (PenjualanID)
                                $dt_jumlah = mysqli_query($koneksi, "SELECT *, SUM(JumlahProduk) as JumlahProduk 
                                                                     FROM tb_detail_penjualan 
                                                                     INNER JOIN tb_produk ON tb_produk.ProdukID = tb_detail_penjualan.ProdukID 
                                                                     WHERE PenjualanID = '$kodeBarang' 
                                                                     GROUP BY tb_detail_penjualan.ProdukID");
                                
                                $no = 1; // Nomor urut untuk baris pada tabel
                                // Menampilkan data detail transaksi (produk yang dibeli)
                                while ($penjualan = mysqli_fetch_array($dt_jumlah)) { ?>
                                    <tr>
                                        <!-- Menampilkan nomor urut -->
                                        <td><?= $no++; ?></td>
                                        <!-- Menampilkan nama produk -->
                                        <td><?= $penjualan['NamaProduk']; ?></td>
                                        <!-- Menampilkan jumlah produk yang dibeli -->
                                        <td><?= $penjualan['JumlahProduk']; ?></td>
                                        <!-- Menampilkan subtotal harga untuk produk -->
                                        <td><?= "Rp. " . number_format($penjualan['SubTotal']) . ",-"; ?></td>
                                        <td>
                                            <!-- Tombol hapus untuk menghapus detail transaksi -->
                                            <a href="transaksi_barang_hapus.php?ProdukID=<?= $penjualan['ProdukID']; ?>&PenjualanID=<?= $penjualan['PenjualanID']; ?>" 
                                               class="btn btn-xs btn-danger" title="Hapus Data">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <?php
                                    // Menghitung total belanja berdasarkan semua subtotal produk
                                    $sub_total_belanja = mysqli_query($koneksi, "SELECT SUM(SubTotal) AS Sub_Total 
                                                                                  FROM tb_detail_penjualan 
                                                                                  WHERE PenjualanID = '$kodeBarang'");
                                    $total = 0; // Inisialisasi total belanja
                                    // Menjumlahkan semua subtotal produk
                                    while ($total_belanja = mysqli_fetch_array($sub_total_belanja)) { 
                                        $total += $total_belanja['Sub_Total']; 
                                    }
                                    ?>
                                    <td colspan="3">Total Belanja</td>
                                    <!-- Menampilkan total belanja -->
                                    <td colspan="2"><strong><?php echo "Rp. " . number_format($total) . ",-"; ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form untuk menyimpan transaksi -->
            <form action="transaksi_proses.php" method="POST">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body">
                <!-- Input untuk Total Harga (Total Belanja) -->
                <div class="form-group">
                    <input type="hidden" class="form-control" name="TotalHarga" value="<?php echo $total; ?>">
                </div>
                <!-- Input untuk tanggal transaksi -->
                <div class="form-group">
                    <label for="">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" readonly>
                </div>
                <!-- Input untuk Nomor Transaksi -->
                <div class="form-group">
                    <label for="">Nomor Transaksi</label>
                    <input type="text" class="form-control" name="no_trans" value="<?php echo $kodeBarang ?>" readonly>
                </div>
                <!-- Menampilkan data kasir (User) -->
                <div class="form-group">
                    <label for="nm_user">Data Kasir</label>
                    <?php
                    // Mengambil data kasir (user yang login)
                    $UserID = $_SESSION['UserID']; // Mendapatkan UserID dari sesi login
                    $dt_user = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE UserID='$UserID'");
                    while ($user = mysqli_fetch_array($dt_user)) { ?>
                        <input type="hidden" class="form-control" name="UserID" value="<?php echo $user['UserID'] ?>">
                        <input type="text" class="form-control" name="nm_user" value="<?php echo $user['NamaUser'] ?>" readonly>
                    <?php } ?>
                </div>
                <!-- Pilihan Pelanggan -->
                <div class="form-group">
                    <label for="pelanggan">Pilih Pelanggan</label>
                    <!-- Input untuk pencarian pelanggan -->
                    <input type="text" id="searchPelanggan" class="form-control" placeholder="Cari pelanggan...">
                    <!-- Dropdown untuk memilih pelanggan -->
                    <select name="PelangganID" id="pelanggan" class="form-control mt-2">
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        // Menampilkan daftar pelanggan
                        $dt_pelanggan = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                        while ($pelanggan = mysqli_fetch_array($dt_pelanggan)) { ?>
                            <option value="<?php echo $pelanggan['PelangganID']?>"><?php echo $pelanggan['NamaPelanggan']?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Input Jumlah Pembayaran -->
                <div class="form-group">
                    <label for="pembayaran">Jumlah Pembayaran</label>
                    <input type="number" class="form-control" name="pembayaran" id="pembayaran" min="0" required>
                </div>

                <!-- Input Kembalian -->
                <div class="form-group">
                    <label for="kembalian">Kembalian</label>
                    <input type="number" class="form-control" name="kembalian" id="kembalian" readonly>
                </div>

                <!-- Tombol simpan transaksi -->
                <button type="submit" class="btn btn-success pull-right">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Menghitung kembalian secara otomatis
    document.getElementById('pembayaran').addEventListener('input', function() {
        const pembayaran = parseFloat(this.value) || 0;
        const totalBelanja = parseFloat(<?php echo $total; ?>);

        // Menghitung kembalian
        const kembalian = pembayaran - totalBelanja;

        // Menampilkan kembalian (jika lebih besar atau sama dengan 0, jika tidak tampilkan 0)
        document.getElementById('kembalian').value = kembalian >= 0 ? kembalian : 0;
    });
</script>
    </section>
</div>

<!-- Modal untuk menambah transaksi -->
<div class="modal fade" id="tambah-transaksi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Transaksi</h4>
            </div>
            <form action="transaksi_detail_proses.php" method="POST">
                <div class="modal-body">
                    <!-- Input Nomor Transaksi -->
                    <div class="form-group">
                        <label>Nomor Transaksi</label>
                        <input type="text" class="form-control" name="no_trans" value="<?php echo $kodeBarang ?>" readonly>
                    </div>
                    <!-- Input untuk memilih produk -->
                    <div class="form-group">
                        <label>Pilih Produk</label>
                        <!-- Input untuk pencarian produk -->
                        <input type="text" id="searchProduk" class="form-control" placeholder="Cari produk...">
                        <!-- Dropdown untuk memilih produk -->
                        <select name="produk" id="produk" class="form-control mt-2">
                            <option value="">-- Pilih Produk --</option> 
                            <?php
                            // Menampilkan daftar produk
                            $dt_produk = mysqli_query($koneksi, "SELECT * FROM tb_produk");
                            while ($produk = mysqli_fetch_array($dt_produk)) { ?> 
                                <option value="<?php echo $produk['ProdukID']; ?>"><?php echo $produk['NamaProduk'] . " (" . $produk['Stok'] . ")"; ?></option>
                            <?php } ?>
                        </select>    
                    </div>
                    <!-- Input untuk jumlah produk -->
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" required>
                    </div>
                </div>            
                <div class="modal-footer">
                    <!-- Tombol tambah produk ke transaksi -->
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi pencarian pelanggan
    document.getElementById('searchPelanggan').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const options = document.querySelectorAll('#pelanggan option');

        options.forEach(option => {
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(filter) ? '' : 'none';
        });

        // Reset selection jika tidak ada yang cocok
        if (filter === '') {
            document.getElementById('pelanggan').selectedIndex = 0;
        }
    });

    let selectedProductStock = 0; // Variabel untuk menyimpan stok produk yang dipilih

    document.getElementById('produk').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stockInfo = selectedOption.textContent.match(/\((\d+)\)/); // Mengambil stok dari teks

        if (stockInfo) {
            selectedProductStock = parseInt(stockInfo[1]); // Mengupdate stok berdasarkan pilihan
        }
    });

    // Memeriksa jumlah input pada saat menambahkan produk
    document.querySelector('.modal-footer button[type="submit"]').addEventListener('click', function(e) {
        const jumlahInput = document.querySelector('input[name="jumlah"]');
        const jumlah = parseInt(jumlahInput.value);

        if (jumlah > selectedProductStock) {
            e.preventDefault(); // Mencegah form dari pengiriman
            alert(`Jumlah yang dimasukkan melebihi stok yang tersedia (${selectedProductStock}). Silakan masukkan jumlah yang lebih kecil.`);
        }
    });

    // Pencarian produk
    document.getElementById('searchProduk').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const options = document.querySelectorAll('#produk option');

        options.forEach(option => {
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(filter) ? '' : 'none';
        });

        // Reset pilihan jika tidak ada yang cocok
        if (filter === '') {
            document.getElementById('produk').selectedIndex = 0;
        }
    });
</script>

<?php
include "footer.php"; // Menyertakan file footer.php untuk tampilan bagian bawah halaman.
?>
