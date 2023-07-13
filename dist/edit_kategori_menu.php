<?php
require 'function.php';

$idKategori = $_GET['id'];

$ambil = $conn->query("SELECT * FROM kategori_menu WHERE id_kategori_menu = $idKategori");
$dataKategori = $ambil->fetch_assoc();

// Tombol Simpan ditekan
if (isset($_POST['simpan_data'])) {
    // Mendapatkan data yang diinputkan
    $namaKategori = $_POST['nama_kategori'];
    $deskripsi = $_POST['deskripsi'];

    // Proses update data pelanggan ke database
    $update = $conn->query("UPDATE kategori_menu SET
                            nama_kategori = '$namaPelanggan',
                            deskripsi = '$deskripsi'
                            WHERE id_kategori_menu = $idKategori");

    if ($update) {
        // Data berhasil diupdate, lakukan redirect atau tampilkan pesan sukses
        header("Location: kategori_menu.php");
        exit;
    } else {
        // Terjadi kesalahan saat update data, tampilkan pesan error
        $error = "Terjadi kesalahan saat mengupdate data. Silakan coba lagi.";
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
        <div class="section-header">
          <h1>Edit Kategori Menu</h1>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-6">
              <div class="card">
                <div class="card-body">
                  <form method="POST" action="">
                  <div class="form-group">
                  <label for="nama_kategori">Nama Kategori</label>
                  <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?php echo $dataKategori['nama_kategori']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="deskripsi">Deskripsi</label>
                  <textarea class="form-control" id="deskripsi" name="deskripsi" value="<?php echo $dataKategori['deskripsi']; ?>" required></textarea>
                </div>
                    <button type="submit" class="btn btn-primary" name="simpan_data">Simpan</button>
                    <a href="table_pelanggan.php" class="btn btn-secondary">Batal</a>
                  </form>

                  <?php if (isset($error)) { ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                  <?php } ?>
                </div>
              </div>
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
