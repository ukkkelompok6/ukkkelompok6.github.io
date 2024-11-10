<!DOCTYPE html>
<html lang="id"> <!-- Menentukan bahasa halaman web ini menggunakan kode bahasa Indonesia -->
<head>
  <meta charset="utf-8"> <!-- Menentukan pengkodean karakter untuk HTML ini menggunakan UTF-8 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Memastikan halaman ini kompatibel dengan browser terbaru -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> <!-- Mengatur responsivitas halaman untuk perangkat mobile -->
  <title>Kasir K6 | Log in</title> <!-- Judul halaman yang muncul di tab browser -->

  <!-- Mengikutsertakan CSS Bootstrap untuk styling -->
  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Mengikutsertakan Font Awesome untuk ikon -->
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Mengikutsertakan Ionicons untuk ikon tambahan -->
  <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Mengikutsertakan style AdminLTE untuk tema panel admin -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- Mengikutsertakan style iCheck untuk checkbox dan radio button -->
  <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
  <!-- Menyertakan Google Fonts (Source Sans Pro) untuk tampilan teks yang lebih modern -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Styling tambahan untuk tampilan login -->
  <style>
    body {
      background: linear-gradient(to right, #007bff, #00aaff) !important; /* Membuat latar belakang gradien biru */
      font-family: 'Source Sans Pro', sans-serif; /* Menentukan font yang digunakan di seluruh halaman */
    }

    .login-box {
      width: 360px; /* Lebar kotak login */
      margin: 7% auto; /* Menempatkan kotak login di tengah layar */
      background-color: #ffffff !important; /* Memberikan warna latar belakang putih pada kotak login */
      padding: 30px; /* Memberikan jarak padding dalam kotak login */
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Menambahkan efek bayangan pada kotak login */
      border-radius: 10px; /* Membuat sudut kotak login melengkung */
    }

    .login-logo a {
      font-size: 36px; /* Ukuran font untuk logo login */
      font-weight: bold; /* Menebalkan teks logo */
      color: #4facfe; /* Memberikan warna biru pada logo */
      text-decoration: none; /* Menghapus garis bawah pada teks */
      letter-spacing: 2px; /* Memberikan jarak antar huruf */
    }

    .login-logo a b {
      color: #00f2fe; /* Memberikan warna lain untuk bagian teks yang dibold pada logo */
    }

    .login-box-body {
      padding: 20px; /* Memberikan jarak padding di dalam body kotak login */
    }

    .form-control {
      border-radius: 20px; /* Membuat sudut input menjadi lebih melengkung */
      box-shadow: none; /* Menghapus bayangan pada input */
      border: 1px solid #ddd; /* Memberikan warna border abu-abu muda pada input */
      margin-bottom: 15px; /* Memberikan jarak bawah pada input */
    }

    .form-control:focus {
      border-color: #4facfe; /* Mengubah warna border menjadi biru saat input difokuskan */
    }

    .btn-primary {
      background-color: #4facfe; /* Warna latar belakang tombol */
      border-color: #4facfe; /* Warna border tombol */
      border-radius: 25px; /* Membuat sudut tombol lebih melengkung */
      font-weight: bold; /* Menebalkan teks pada tombol */
      width: 100%; /* Membuat tombol memenuhi lebar form */
    }

    .btn-primary:hover {
      background-color: #00f2fe; /* Mengubah warna tombol saat cursor berada di atas tombol */
      border-color: #00f2fe; /* Mengubah warna border tombol saat hover */
    }

    .alert {
      padding: 15px; /* Padding untuk pesan alert */
      margin-bottom: 20px; /* Memberikan jarak bawah antara alert dengan elemen lainnya */
      background-color: #f8d7da; /* Warna latar belakang merah muda untuk alert kesalahan */
      color: #721c24; /* Warna teks alert kesalahan */
      border-radius: 5px; /* Membuat sudut alert melengkung */
      font-size: 14px; /* Mengubah ukuran font alert */
    }

    .alert-success {
      background-color: #d4edda; /* Warna latar belakang hijau untuk alert sukses */
      color: #155724; /* Warna teks hijau untuk alert sukses */
    }
  </style>

  <!-- JavaScript untuk menampilkan/menyembunyikan password -->
  <script>
    function togglePassword() {
      var passwordField = document.getElementById("password"); // Ambil input password
      var checkbox = document.getElementById("showPassword"); // Ambil checkbox
      if (checkbox.checked) {
        passwordField.type = "text"; // Ganti tipe password menjadi text agar terlihat
      } else {
        passwordField.type = "password"; // Kembalikan tipe password menjadi password untuk menyembunyikan
      }
    }
  </script>
</head>
<body class="hold-transition login-page"> <!-- Halaman login dengan class 'login-page' -->

<div class="login-box"> <!-- Kotak login yang berisi form login -->
  <div class="login-logo">
    <a href="assets/index2.html"><b>K</b>6</a> <!-- Logo login dengan teks 'K6' -->
  </div>
  
  <div class="login-box-body">
    <!-- Menampilkan pesan jika ada -->
    <?php
      // Mengecek apakah ada parameter 'pesan' di URL, jika ada tampilkan pesan yang sesuai
      if(isset($_GET['pesan'])) {
        if($_GET['pesan'] == "gagal") {
          echo "<div class='alert'>Login Gagal, username dan password yang Anda masukkan salah.</div>";
        }
        if($_GET['pesan'] == "logout") {
          echo "<div class='alert alert-success'>Anda telah logout.</div>";
        }
      }
    ?>

    <!-- Form login -->
    <form action="cek_login.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="username" required> <!-- Input untuk username -->
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span> <!-- Ikon untuk input username -->
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" placeholder="Password" name="password" required> <!-- Input untuk password -->
        <span class="glyphicon glyphicon-lock form-control-feedback"></span> <!-- Ikon untuk input password -->
      </div>

      <!-- Checkbox untuk melihat password -->
      <div class="form-group">
        <label>
          <input type="checkbox" id="showPassword" onclick="togglePassword()"> Lihat Password <!-- Checkbox untuk menampilkan password -->
        </label>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary">Sign In</button> <!-- Tombol untuk login -->
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Mengikutsertakan jQuery -->
<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Mengikutsertakan JS Bootstrap -->
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Mengikutsertakan JS iCheck -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>
</body>
</html>
