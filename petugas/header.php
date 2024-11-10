<?php
// Mengikutsertakan file koneksi untuk menghubungkan ke database
include "../config/koneksi.php";

session_start(); // Memulai sesi untuk menyimpan informasi pengguna

// Memeriksa apakah pengguna sudah login berdasarkan role
if ($_SESSION['role'] == "") {
    header("location:../index.php"); // Jika belum login, arahkan ke halaman login
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8"> <!-- Mengatur encoding karakter menjadi UTF-8 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Mengoptimalkan untuk Internet Explorer -->
  <title>K6 | Dashboard</title> <!-- Judul halaman -->
  <!-- Membuat halaman responsif -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Mengikutsertakan CSS Bootstrap -->
  <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Mengikutsertakan Font Awesome untuk ikon -->
  <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Mengikutsertakan Ionicons untuk ikon tambahan -->
  <link rel="stylesheet" href="../assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Mengikutsertakan jVectorMap untuk peta vektor -->
  <link rel="stylesheet" href="../assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Mengikutsertakan style AdminLTE -->
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <!-- Mengikutsertakan skin AdminLTE -->
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">

  <!--[if lt IE 9]>  Komentar kondisional untuk IE 8 dan versi sebelumnya -->
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script> <!-- HTML5 Shim -->
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <!-- Respond.js untuk media queries -->
  

  <!-- Mengikutsertakan Google Font untuk styling teks -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini"> <!-- Kelas untuk mengatur tema dan tata letak -->
<div class="wrapper"> <!-- Kontainer utama -->

  <header class="main-header"> <!-- Bagian header utama -->

    <!-- Logo -->
    <a href="#" class="logo"> <!-- Tautan logo -->
      <span class="logo-lg"><b>K</b>6</span> <!-- Logo besar untuk tampilan penuh -->
    </a>

    <!-- Navbar header -->
    <nav class="navbar navbar-static-top">
      <!-- Tombol toggle sidebar -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span> <!-- Teks tersembunyi untuk aksesibilitas -->
      </a>
      <!-- Menu kanan navbar -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Menu dropdown untuk akun pengguna -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <!-- Tautan dropdown -->
                <span class="hidden-xs"> <!-- Nama pengguna -->
                <?php
                $UserID = $_SESSION['UserID']; // Mendapatkan UserID dari session
                // Mengambil data pengguna dari database
                $dt_user = mysqli_query($koneksi, "SELECT * FROM tb_user where UserID = '$UserID' ");
                while ($user = mysqli_fetch_array($dt_user)){ ?>
                <?php
                echo $user['NamaUser']; // Menampilkan nama pengguna
                }
                ?>
              </span>
            </a>
            <ul class="dropdown-menu"> <!-- Menu dropdown untuk detail pengguna -->
              <!-- Gambar pengguna -->
              <li class="user-header">
                <p>
                <?php
                // Mengambil dan menampilkan informasi pengguna
                $dt_user = mysqli_query($koneksi, "SELECT * FROM tb_user where UserID = '$UserID' ");
                while ($user = mysqli_fetch_array($dt_user)){ ?>
                <?php
                echo $user['NamaUser']. "<small> Username : ".$user['username']."</small>"; // Menampilkan nama dan username
                }
                ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-danger btn-flat">Logout</a> <!-- Tombol logout -->
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  
  <!-- Sidebar kiri, berisi logo dan menu navigasi -->
  <aside class="main-sidebar">
    <section class="sidebar"> <!-- Bagian sidebar -->
      <!-- Panel pengguna di sidebar -->
      <div class="user-panel">
        <div class="pull-left">
          <img>
        </div>
        <div class="pull-left info">
          <p>  
            <?php
            // Mengambil dan menampilkan nama pengguna di sidebar
            $dt_user = mysqli_query($koneksi, "SELECT * FROM tb_user where UserID = '$UserID' ");
            while ($user = mysqli_fetch_array($dt_user)){ ?>
            <?php
            echo $user['NamaUser']; // Menampilkan nama pengguna
            }
            ?>
            </p>
      
        </div>
      </div>

      <!-- Menu sidebar -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li> <!-- Judul menu -->
        <li>
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> <!-- Tautan ke dashboard -->
          </a>
        </li>
        <li>
          <a href="pelanggan_data.php">
            <i class="fa fa-files-o"></i> <span>Data Pelanggan</span> <!-- Tautan ke data pelanggan -->
          </a>
        </li>
        <li>
          <a href="produk_data.php">
            <i class="fa fa-files-o"></i> <span>Data Produk</span> <!-- Tautan ke data produk -->
          </a>
        </li>
        <li>
          <a href="transaksi_data.php">
            <i class="fa fa-money"></i> <span>Data Transaksi</span> <!-- Tautan ke data transaksi -->
          </a>
        </li>
        <li>
          <a href="transaksi_laporan.php">
            <i class="fa fa-book"></i> <span>Laporan Transaksi</span> <!-- Tautan ke laporan transaksi -->
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
