<?php
require 'function.php';

if (isset($_POST['submit'])) {
  // Ambil data dari form
  $idPelanggan = $_POST['id_pelanggan'];
  $tanggalPembelian = $_POST['tanggal_pembelian'];
  $totalPembelian = $_POST['total_pembelian'];

  // Query untuk menyimpan data ke tabel pembelian
  $query = "INSERT INTO pembelian (id_pelanggan, tanggal_pembelian, total_pembelian) 
            VALUES ('$idPelanggan', '$tanggalPembelian', '$totalPembelian')";
  $result = $conn->query($query);

  if ($result) {
    // Data berhasil disimpan, lakukan redirect atau tampilkan pesan sukses
    header("Location: list_pembelian.php");
    exit;
  } else {
    // Terjadi kesalahan saat menyimpan data, tampilkan pesan error
    $error = "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.";
  }
}

// Query untuk mendapatkan daftar pelanggan
$queryPelanggan = "SELECT * FROM pelanggan";
$resultPelanggan = $conn->query($queryPelanggan);
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
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    <div class="main-content">
      <section class="section">
        <div class="section-body">
          <div class="row">
            <div class="col-6">
              <div class="card">
               <div class="card-body d-flex justify-content-center">
                <form method="POST" action="">
                    <div class="text-center">
                    <h1>Tambah Pembelian</h1>
                    </div>
                  <div class="card-body">
                    <?php if (isset($error)) { ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                      </div>
                    <?php } ?>
                    <form method="POST" action="">
                      <div class="form-group">
                        <label for="id_pelanggan">Pelanggan</label>
                        <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                          <option value="">Pilih Pelanggan</option>
                          <?php while ($rowPelanggan = $resultPelanggan->fetch_assoc()) { ?>
                            <option value="<?php echo $rowPelanggan['id_pelanggan']; ?>">
                              <?php echo $rowPelanggan['nama_pelanggan']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="tanggal_pembelian">Tanggal Pembelian</label>
                        <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" required>
                      </div>
                      <div class="form-group">
                        <label for="total_pembelian">Total Pembelian</label>
                        <input type="number" class="form-control" id="total_pembelian" name="total_pembelian" required>
                      </div>
                      <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- ... -->
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

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
