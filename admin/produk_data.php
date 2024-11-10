<?php
// Mengikutsertakan file header.php untuk menyertakan elemen-elemen awal halaman
// Dengan menyertakan 'header.php', file ini akan memuat bagian awal halaman web seperti HTML doctype,
// tag <html>, meta tags, link ke CSS, serta bagian navigasi dan header yang akan digunakan di setiap halaman.
include "header.php";  

// Ambil nilai pencarian dari form, jika ada
// Cek apakah parameter 'search' ada dalam data POST (biasanya dikirim melalui form pencarian).
// Jika ada, nilai tersebut akan disalin ke variabel $search, jika tidak ada maka nilai $search akan kosong.
$search = isset($_POST['search']) ? $_POST['search'] : '';  

// Tentukan jumlah produk per halaman yang ingin ditampilkan
// Variabel ini mengatur berapa banyak produk yang akan ditampilkan per halaman. Misalnya, jika 10 produk per halaman,
// maka dalam satu halaman hanya akan muncul 10 produk.
$limit = 10;  

// Ambil nilai 'page' dari URL (parameter query string), jika ada.
// Jika tidak ada, maka secara default halaman pertama yang akan ditampilkan adalah halaman 1.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  

// Hitung offset untuk menentukan produk yang akan ditampilkan pada halaman tersebut
// Offset digunakan untuk menentukan mulai dari produk mana yang akan ditampilkan.
// Misalnya, jika halaman 1, maka offset = 0, halaman 2, offset = 10, dst.
// Hal ini digunakan untuk mengambil data yang relevan untuk halaman yang dipilih.
$offset = ($page - 1) * $limit;  

// Query untuk mengambil data produk dari database berdasarkan pencarian dan limit
// Query ini akan menyeleksi data produk yang nama produknya mengandung kata kunci pencarian yang dimasukkan
// oleh pengguna, dan membatasi jumlah produk yang ditampilkan berdasarkan limit dan offset.
$query = "SELECT * FROM tb_produk WHERE NamaProduk LIKE '%$search%' LIMIT $limit OFFSET $offset";  

// Eksekusi query untuk mengambil data produk dari database
// Fungsi mysqli_query digunakan untuk mengeksekusi query yang telah disusun, dan hasilnya disimpan dalam variabel $dt_produk.
// Hasil ini berupa objek hasil query yang kemudian dapat di-loop atau diambil datanya.
$dt_produk = mysqli_query($koneksi, $query);  

// Query untuk menghitung jumlah total produk berdasarkan pencarian
// Query ini digunakan untuk mengetahui total jumlah produk yang ada di database yang sesuai dengan kata kunci pencarian.
// Hasil ini digunakan untuk menghitung jumlah total halaman pada pagination.
$total_query = "SELECT COUNT(*) as total FROM tb_produk WHERE NamaProduk LIKE '%$search%'";  

// Eksekusi query untuk menghitung jumlah produk yang sesuai dengan pencarian
// Hasil query ini akan memberikan informasi jumlah total produk yang ada berdasarkan pencarian yang dimasukkan oleh pengguna.
$total_result = mysqli_query($koneksi, $total_query);  

// Ambil hasil query dan simpan dalam variabel $total_data
// mysqli_fetch_assoc digunakan untuk mengambil hasil query dan mengembalikannya dalam bentuk array asosiatif.
// Array ini akan berisi total produk yang sesuai dengan pencarian.
$total_data = mysqli_fetch_assoc($total_result);  

// Simpan jumlah total produk yang ditemukan
// Nilai dari 'total' yang didapatkan dari query COUNT(*) disalin ke variabel $total_products.
$total_products = $total_data['total'];  

// Hitung jumlah total halaman yang dibutuhkan untuk menampilkan seluruh produk
// Jumlah halaman dihitung berdasarkan total produk dan jumlah produk per halaman ($limit).
// Fungsi ceil digunakan untuk membulatkan ke atas hasil pembagian ini, agar tidak ada halaman yang setengah kosong.
$total_pages = ceil($total_products / $limit);  
?>

<!-- Content Wrapper: Bagian utama konten halaman -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Data Produk
            <small>Aplikasi Kasir Sederhana</small>
        </h1>
        <ol class="breadcrumb">
            <!-- Breadcrumb atau navigasi link -->
            <!-- Navigasi link untuk menunjukkan urutan atau hirarki halaman yang sedang diakses -->
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Produk</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <!-- Tombol untuk membuka modal tambah produk -->
                <!-- Tombol ini akan membuka modal yang memungkinkan admin menambah produk baru -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah-produk">
                    <i class="glyphicon glyphicon-plus"></i> Tambah
                </button>
                <!-- Form pencarian produk -->
                <!-- Form ini memungkinkan pengguna untuk mencari produk berdasarkan nama -->
                <form method="POST" class="form-inline" style="margin-top: 10px;">
                    <!-- Input pencarian yang akan mengirimkan data melalui method POST -->
                    <!-- Nilai dari input ini akan dikirim ke server untuk memfilter produk yang ditampilkan -->
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="<?php echo htmlspecialchars($search); ?>">
                    <!-- Tombol untuk mengirimkan data pencarian -->
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
            <div class="box-body">
                <!-- Tabel untuk menampilkan produk -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NAMA PRODUK</th>
                            <th>HARGA</th>
                            <th>STOK</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Menyesuaikan nomor urut produk yang akan ditampilkan
                        // Nomor urut dimulai dari offset + 1, untuk menyesuaikan dengan halaman yang sedang ditampilkan
                        $no = $offset + 1;  
                        
                        // Loop untuk menampilkan setiap produk yang diambil dari query
                        // Fungsi mysqli_fetch_array digunakan untuk mengambil baris-baris data produk satu per satu dari hasil query.
                        while ($produk = mysqli_fetch_array($dt_produk)) {  
                        ?>
                            <tr>
                                <!-- Menampilkan nomor urut produk yang sedang ditampilkan -->
                                <td><?php echo $no++; ?></td>  
                                <!-- Menampilkan nama produk -->
                                <td><?php echo $produk['NamaProduk']; ?></td>  
                                <!-- Menampilkan harga produk dengan format mata uang -->
                                <td><?php echo "RP. " . number_format($produk['Harga']).",-"; ?></td>  
                                <!-- Menampilkan jumlah stok produk -->
                                <td><?php echo $produk['Stok']; ?></td>  
                                <td>
                                    <!-- Tombol untuk membuka modal edit produk -->
                                    <!-- Modal ini digunakan untuk mengedit data produk yang sudah ada -->
                                    <button type="button" class="btn btn-xs btn-warning" title="Edit" data-toggle="modal" data-target="#edit-produk<?php echo $produk['ProdukID']; ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </button>

                                    <!-- Modal untuk mengedit data produk -->
                                    <!-- Modal ini berisi form untuk mengedit nama produk, harga, dan stok produk -->
                                    <div class="modal fade" id="edit-produk<?php echo $produk['ProdukID']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Edit Data Produk</h4>
                                                </div>
                                                <!-- Form untuk mengedit produk -->
                                                <form action="produk_update.php" method="POST">
                                                    <div class="modal-body">
                                                        <!-- Form input untuk nama produk -->
                                                        <div class="form-group">
                                                            <label>Nama Produk</label>
                                                            <!-- Input hidden untuk menyimpan ID produk yang akan diedit -->
                                                            <input type="hidden" class="form-control" name="id_produk" value="<?php echo $produk['ProdukID']; ?>">  
                                                            <input type="text" class="form-control" name="nm_produk" value="<?php echo $produk['NamaProduk']; ?>">
                                                        </div>
                                                        <!-- Form input untuk harga produk -->
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input type="text" class="form-control" name="harga" value="<?php echo $produk['Harga']; ?>">
                                                        </div>
                                                        <!-- Form input untuk stok produk -->
                                                        <div class="form-group">
                                                            <label>Stok</label>
                                                            <input type="number" class="form-control" name="stok" value="<?php echo $produk['Stok']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Tombol untuk menyimpan perubahan -->
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol untuk menghapus produk -->
                                    <!-- Tombol ini akan mengarahkan ke halaman 'produk_hapus.php' dengan parameter ProdukID -->
                                    <a href="produk_hapus.php?ProdukID=<?php echo $produk['ProdukID']; ?>" class="btn btn-xs btn-danger" role="button" title="Hapus">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Pagination: navigasi untuk berpindah antar halaman produk -->
                <!-- Loop digunakan untuk menampilkan nomor halaman sesuai dengan total halaman -->
                <nav>
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <!-- Menandai halaman yang sedang aktif -->
                            <li class="<?php echo ($i === $page) ? 'active' : ''; ?>"> 
                                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Modal untuk menambah produk -->
<!-- Modal ini berisi form untuk menambah produk baru ke dalam database -->
<div class="modal fade" id="tambah-produk">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Data Produk</h4>
            </div>
            <!-- Form untuk menambah produk -->
            <form action="produk_tambah.php" method="POST">
                <div class="modal-body">
                    <!-- Form input untuk nama produk -->
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" name="nm_produk">
                    </div>
                    <!-- Form input untuk harga produk -->
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga">
                    </div>
                    <!-- Form input untuk stok produk -->
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" name="stok">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Tombol untuk menyimpan data produk baru -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Mengikutsertakan file footer.php untuk menyertakan elemen-elemen akhir halaman
// Footer ini berisi penutup HTML dan mungkin juga berisi skrip JavaScript untuk interaksi lebih lanjut.
include "footer.php";  
?>
