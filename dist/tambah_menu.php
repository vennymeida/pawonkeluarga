<?php
require 'function.php';

// Cek apakah tombol Simpan telah ditekan
$queryKategori = "SELECT * FROM kategori_menu";
$resultKategori = $conn->query($queryKategori);

if (isset($_POST['simpan_data'])) {
    $kategori = $_POST['id_kategori_menu']; 
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $foto = $_POST['foto'];

    // Proses penyimpanan gambar
  $foto = $_FILES['foto']['tmp_name'];
  $fotoData = addslashes(file_get_contents($foto));
    // Proses tambah data menu ke database
    $tambah = $conn->query("INSERT INTO menu (id_kategori_menu, nama_menu, harga, foto) VALUES ('$kategori','$nama_menu', '$harga', '$foto')");

    if ($tambah) {
        // Data berhasil ditambahkan, lakukan redirect ke halaman list_menu.php
        header("Location: list_menu.php");
        exit;
    } else {
        // Terjadi kesalahan saat menambahkan data, tampilkan pesan error
        $error = "Terjadi kesalahan saat menambahkan data. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Pawon Keluarga</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>
<body>
  <div id="app">
    <!-- Bagian header dan sidebar -->

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-body">
          <div class="row">
            <div class="col-6">
              <div class="card">
               <div class="card-body d-flex justify-content-center">
                <form method="POST" action="">
                    <div class="text-center">
                    <h1>Tambah Menu</h1>
                    <div class="form-group">
          <label for="kategori">Kategori:</label>
          <select id="kategori" name="kategori" required>
            <?php while ($kategori = $resultKategori->fetch_assoc()) { ?>
              <option value="<?php echo $kategori['id_kategori_menu']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
            <?php } ?>
          </select>
        </div>
                <div class="form-group">
                  <label for="nama_menu">Nama Menu</label>
                  <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                </div>
                <div class="form-group">
                  <label for="harga">Harga</label>
                  <input type="text" class="form-control" id="harga" name="harga" required>
                </div>
                <div class="form-group">
                  <label for="foto">Foto</label>
                  <input type="file" class="form-control" id="foto" name="foto">
                </div>
                <button type="submit" class="btn btn-primary" name="simpan_data">Simpan</button>
                <a href="list_menu.php" class="btn btn-secondary">Batal</a>
              </form>

              <?php if (isset($error)) { ?>
                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
              <?php } ?>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="assets/modules/jquery-ui/jquery-ui.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/components-table.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>