<?php
// Menyertakan file header.php yang biasanya berisi bagian awal HTML, seperti <html>, <head>, dan navigasi
include "header.php";  

// Inisialisasi variabel untuk pagination
$limit = 10; // Menentukan jumlah maksimal data yang ditampilkan per halaman (misalnya 10 data per halaman)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Mengambil parameter 'page' dari URL untuk mengetahui halaman yang sedang dibuka. Jika tidak ada, akan default ke halaman 1
$start = ($page > 1) ? ($page * $limit) - $limit : 0; // Menghitung mulai dari data ke berapa yang harus ditampilkan berdasarkan halaman saat ini
// Rumus untuk start adalah (nomor_halaman * limit) - limit untuk mendapatkan offset. Misalnya halaman 2, limit 10, maka start = 10

// Menghitung total jumlah pelanggan di database untuk pagination
$totalQuery = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pelanggan"); 
$total = mysqli_fetch_assoc($totalQuery)['total']; // Mengambil total jumlah data pelanggan yang ada
$pages = ceil($total / $limit); // Menghitung jumlah total halaman berdasarkan total data dan limit (jumlah data per halaman)
// Fungsi ceil digunakan untuk membulatkan jumlah halaman ke atas jika ada sisa pembagian

// Menangani query pencarian berdasarkan nama pelanggan
$search = isset($_POST['search']) ? $_POST['search'] : ''; // Jika ada parameter 'search' di POST, akan digunakan untuk pencarian
$query = "SELECT * FROM tb_pelanggan WHERE NamaPelanggan LIKE '%$search%' LIMIT {$start}, {$limit}"; // Query SQL untuk mengambil data pelanggan yang sesuai dengan pencarian
// Parameter LIKE digunakan untuk mencocokkan nama pelanggan dengan kata kunci pencarian, LIMIT digunakan untuk menentukan data yang ditampilkan berdasarkan halaman
$dt_pelanggan = mysqli_query($koneksi, $query); // Eksekusi query untuk mengambil data pelanggan
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <!-- Header yang menampilkan judul halaman dan breadcrumb navigasi -->
        <h1>Data Pelanggan<small>Aplikasi Kasir Sederhana</small></h1>
        <ol class="breadcrumb">
            <!-- Breadcrumb untuk navigasi halaman -->
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Pelanggan</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <!-- Tombol untuk membuka modal untuk menambah data pelanggan -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah-pelanggan">
                    <i class="glyphicon glyphicon-plus"></i> Tambah
                </button>

                <!-- Form pencarian pelanggan -->
                <form method="POST" action="" style="margin-top: 10px;">
                    <div class="input-group" style="width: 250px;"> <!-- Menentukan lebar input pencarian -->
                        <input type="text" name="search" class="form-control" placeholder="Cari pelanggan..." style="width: 200px;"> <!-- Input pencarian -->
                        <span class="input-group-btn">
                            <!-- Tombol pencarian -->
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="box-body">
                <!-- Tabel untuk menampilkan data pelanggan -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <!-- Kolom tabel untuk menampilkan data pelanggan -->
                            <th>No</th>
                            <th>NAMA PELANGGAN</th>
                            <th>ALAMAT</th>
                            <th>NO HP</th>
                            <th>OPSI</th> <!-- Kolom untuk menampilkan aksi (edit dan delete) -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $start + 1; // Menentukan nomor urut berdasarkan halaman yang sedang aktif
                        // Looping untuk menampilkan data pelanggan satu per satu
                        while ($pelanggan = mysqli_fetch_array($dt_pelanggan)) { 
                        ?>
                            <tr>
                                <!-- Menampilkan nomor urut pelanggan -->
                                <td><?php echo $no++; ?></td>
                                <!-- Menampilkan nama pelanggan -->
                                <td><?php echo $pelanggan['NamaPelanggan']; ?></td>
                                <!-- Menampilkan alamat pelanggan -->
                                <td><?php echo $pelanggan['Alamat']; ?></td>
                                <!-- Menampilkan nomor telepon pelanggan -->
                                <td><?php echo $pelanggan['NomorTelepon']; ?></td>
                                <td>
                                    <!-- Tombol untuk membuka modal edit data pelanggan -->
                                    <button type="button" class="btn btn-xs btn-warning" title="Edit" data-toggle="modal" data-target="#edit-pelanggan<?php echo $pelanggan['PelangganID']; ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </button>

                                    <!-- Modal untuk mengedit data pelanggan -->
                                    <div class="modal fade" id="edit-pelanggan<?php echo $pelanggan['PelangganID']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Edit Data Pelanggan</h4>
                                                </div>
                                                <!-- Form untuk mengedit data pelanggan -->
                                                <form action="pelanggan_update.php" method="POST">
                                                    <div class="modal-body">
                                                        <!-- Form input untuk nama pelanggan -->
                                                        <div class="form-group">
                                                            <label>Nama Pelanggan</label>
                                                            <input type="hidden" class="form-control" name="id_pelanggan" value="<?php echo $pelanggan['PelangganID']; ?>"> <!-- ID pelanggan untuk proses update -->
                                                            <input type="text" class="form-control" name="nm_pelanggan" value="<?php echo $pelanggan['NamaPelanggan']; ?>"> <!-- Nama pelanggan -->
                                                        </div>
                                                        <!-- Form input untuk alamat pelanggan -->
                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" name="alamat" value="<?php echo $pelanggan['Alamat']; ?>"> <!-- Alamat pelanggan -->
                                                        </div>
                                                        <!-- Form input untuk nomor telepon pelanggan -->
                                                        <div class="form-group">
                                                            <label>No. HP</label>
                                                            <input type="number" class="form-control" name="no_hp" value="<?php echo $pelanggan['NomorTelepon']; ?>"> <!-- Nomor telepon pelanggan -->
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

                                    <!-- Tombol untuk menghapus data pelanggan -->
                                    <a href="pelanggan_hapus.php?PelangganID=<?php echo $pelanggan['PelangganID']; ?>" class="btn btn-xs btn-danger" role="button" title="Hapus">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <!-- Loop untuk menampilkan link pagination berdasarkan jumlah halaman -->
                        <?php for ($i = 1; $i <= $pages; $i++) : ?>
                            <li class="<?= ($page === $i) ? 'active' : ''; ?>">
                                <a href="?page=<?= $i; ?>"><?= $i; ?></a> <!-- Link untuk berpindah halaman -->
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Modal untuk menambah pelanggan -->
<div class="modal fade" id="tambah-pelanggan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data Pelanggan</h4>
            </div>
            <!-- Form untuk menambah pelanggan -->
            <form action="pelanggan_tambah.php" method="POST">
                <div class="modal-body">
                    <!-- Form input untuk nama pelanggan -->
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" class="form-control" name="nm_pelanggan">
                    </div>
                    <!-- Form input untuk alamat pelanggan -->
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat">
                    </div>
                    <!-- Form input untuk nomor telepon pelanggan -->
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="number" class="form-control" name="no_hp">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Tombol untuk menyimpan data pelanggan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Menyertakan file footer.php yang biasanya berisi bagian akhir HTML dan skrip JavaScript
include "footer.php"; 
?>
