<?php
// Include header.php
// Fungsi ini untuk menyertakan file header.php yang berisi bagian awal HTML seperti <html>, <head>, dan bagian navigasi di atas halaman.
include "header.php";  

// Pagination configuration
$limit = 10; // Jumlah data yang akan ditampilkan per halaman
// Mengambil nomor halaman yang dikirimkan melalui parameter GET, jika tidak ada maka default halaman pertama
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  
// Menghitung offset berdasarkan halaman yang dipilih. Offset adalah nilai untuk menentukan produk ke berapa yang akan ditampilkan
$offset = ($page - 1) * $limit;  

// Search functionality
// Memeriksa apakah ada parameter pencarian yang dikirimkan melalui form POST, jika ada maka disalin ke variabel $search
$search = isset($_POST['search']) ? $_POST['search'] : '';  

// Query untuk menghitung jumlah total record petugas yang ada dalam database berdasarkan pencarian
// Mengambil data jumlah total petugas yang memiliki role 'petugas' dan nama user yang sesuai dengan kata kunci pencarian
$total_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_user WHERE role='petugas' AND NamaUser LIKE '%$search%'");
// Mengambil hasil query dan menghitung jumlah total petugas yang ditemukan
$total_result = mysqli_fetch_assoc($total_query);
$total_records = $total_result['total'];  // Menyimpan jumlah total petugas yang ditemukan
$total_pages = ceil($total_records / $limit);  // Menghitung jumlah total halaman berdasarkan jumlah data dan limit per halaman

// Query untuk mengambil data petugas yang sesuai dengan pencarian dan limit (pagination)
$dt_user = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE role='petugas' AND NamaUser LIKE '%$search%' LIMIT $limit OFFSET $offset");
// Menentukan nomor urut produk berdasarkan offset yang dihitung sebelumnya
$no = $offset + 1;  
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Data Petugas
            <small>Aplikasi Kasir Sederhana</small>
        </h1>
        <ol class="breadcrumb">
            <!-- Breadcrumb menunjukkan halaman mana yang sedang dibuka di dalam aplikasi -->
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Data Petugas</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <!-- Tombol untuk membuka modal tambah petugas -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah-petugas">
                    <i class="glyphicon glyphicon-plus"></i> Tambah
                </button>

                <!-- Form untuk mencari petugas berdasarkan nama -->
                <form method="POST" action="" style="margin-top: 10px;">
                    <div class="input-group" style="width: 250px;">
                        <!-- Input text untuk memasukkan kata kunci pencarian -->
                        <input type="text" name="search" class="form-control" placeholder="Cari petugas...">
                        <span class="input-group-btn">
                            <!-- Tombol untuk mengirimkan form pencarian -->
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="box-body">
                <!-- Tabel untuk menampilkan data petugas -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <!-- Menampilkan kolom-kolom pada tabel -->
                            <th>No</th>
                            <th>NAMA PETUGAS</th>
                            <th>USERNAME</th>
                            <th>ROLE / AKSES</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Menampilkan data petugas dalam tabel
                        // Menggunakan loop while untuk mengambil setiap baris data dari query dan menampilkannya dalam tabel
                        while ($user = mysqli_fetch_array($dt_user)) {  
                        ?>
                            <tr>
                                <!-- Menampilkan nomor urut berdasarkan offset + 1 -->
                                <td><?php echo $no++; ?></td>
                                <!-- Menampilkan nama petugas -->
                                <td><?php echo $user['NamaUser']; ?></td>
                                <!-- Menampilkan username petugas -->
                                <td><?php echo $user['username']; ?></td>
                                <!-- Menampilkan role atau akses petugas -->
                                <td><?php echo $user['role']; ?></td>
                                <td>
                                    <!-- Tombol untuk membuka modal edit petugas -->
                                    <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit-user<?php echo $user['UserID']; ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </button>

                                    <!-- Modal untuk mengedit data petugas -->
                                    <div class="modal fade" id="edit-user<?php echo $user['UserID']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Edit Data Petugas</h4>
                                                </div>
                                                <!-- Form untuk mengedit petugas -->
                                                <form action="petugas_update.php" method="POST">
                                                    <div class="modal-body">
                                                        <!-- Form input untuk nama petugas -->
                                                        <div class="form-group">
                                                            <label>Nama Petugas</label>
                                                            <input type="hidden" name="id_user" value="<?php echo $user['UserID']; ?>">
                                                            <input type="text" class="form-control" name="nm_user" value="<?php echo $user['NamaUser']; ?>">
                                                        </div>
                                                        <!-- Form input untuk username -->
                                                        <div class="form-group">
                                                            <label>Username</label>
                                                            <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>">
                                                        </div>
                                                        <!-- Form input untuk password -->
                                                        <div class="form-group">
                                                            <label>Password</label>
                                                            <input type="password" class="form-control" name="password" value="<?php echo $user['password']; ?>">
                                                        </div>
                                                        <!-- Form input untuk memilih role petugas -->
                                                        <div class="form-group">
                                                            <label>Role</label>
                                                            <select class="form-control" name="role">
                                                                <option value="Admin" <?php echo $user['role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                                                <option value="Petugas" <?php echo $user['role'] == 'Petugas' ? 'selected' : ''; ?>>Petugas</option>
                                                            </select>
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

                                    <!-- Tombol untuk menghapus petugas -->
                                    <a href="petugas_hapus.php?UserID=<?php echo $user['UserID']; ?>" class="btn btn-xs btn-danger" title="Hapus">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination" style="float: left;">
                <!-- Tombol untuk halaman sebelumnya -->
                <?php if ($page > 1): ?>
                    <li><a href="?page=<?php echo $page - 1; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                <?php endif; ?>
                <!-- Loop untuk menampilkan nomor halaman -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <!-- Menandai halaman yang aktif dengan class 'active' -->
                    <li class="<?php echo $page == $i ? 'active' : ''; ?>"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <!-- Tombol untuk halaman berikutnya -->
                <?php if ($page < $total_pages): ?>
                    <li><a href="?page=<?php echo $page + 1; ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                <?php endif; ?>
            </ul>
        </nav>

    </section>
</div>

<!-- Modal for adding new petugas -->
<div class="modal fade" id="tambah-petugas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Data Petugas</h4>
            </div>
            <!-- Form untuk menambah petugas baru -->
            <form action="petugas_tambah.php" method="POST">
                <div class="modal-body">
                    <!-- Form input untuk nama petugas -->
                    <div class="form-group">
                        <label>Nama Petugas</label>
                        <input type="text" class="form-control" name="nm_petugas">
                    </div>
                    <!-- Form input untuk username petugas -->
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <!-- Form input untuk password petugas -->
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Tombol untuk menyimpan petugas baru -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Include footer.php
// Fungsi ini untuk menyertakan bagian footer yang biasanya berisi tag penutup HTML dan skrip JavaScript untuk interaksi halaman.
include "footer.php";  
?>
