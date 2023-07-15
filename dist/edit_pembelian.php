<?php
require 'function.php';

// Periksa apakah parameter ID pembelian telah diterima
if (isset($_GET['id'])) {
  $idPembelian = $_GET['id'];

  // Query untuk mendapatkan data pembelian berdasarkan ID
  $query = "SELECT * FROM pembelian WHERE id_pembelian = $idPembelian";
  $result = $conn->query($query);

  // Periksa apakah data pembelian ditemukan
  if ($result->num_rows > 0) {
    $dataPembelian = $result->fetch_assoc();

    // Query untuk mendapatkan daftar pelanggan
    $queryPelanggan = "SELECT * FROM pelanggan";
    $resultPelanggan = $conn->query($queryPelanggan);
  } else {
    // Jika data pembelian tidak ditemukan, lakukan redirect atau tampilkan pesan error
    header("Location: list_pembelian.php");
    exit;
  }
}

if (isset($_POST['submit'])) {
  // Ambil data dari form
  $idPembelian = $_POST['id_pembelian'];
  $idPelanggan = $_POST['id_pelanggan'];
  $tanggalPembelian = $_POST['tanggal_pembelian'];
  $totalPembelian = $_POST['total_pembelian'];

  // Query untuk update data pembelian
  $query = "UPDATE pembelian SET id_pelanggan = '$idPelanggan', tanggal_pembelian = '$tanggalPembelian', total_pembelian = '$totalPembelian' WHERE id_pembelian = $idPembelian";
  $result = $conn->query($query);

  if ($result) {
    // Data berhasil diupdate, lakukan redirect atau tampilkan pesan sukses
    header("Location: list_pembelian.php");
    exit;
  } else {
    // Terjadi kesalahan saat mengupdate data, tampilkan pesan error
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
                    <h1>Edit Pembelian</h1>
                    </div>
                  <div class="card-body">
                    <?php if (isset($error)) { ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                      </div>
                    <?php } ?>
                    <form method="POST" action="">
                      <input type="hidden" name="id_pembelian" value="<?php echo $dataPembelian['id_pembelian']; ?>">
                      <div class="form-group">
                        <label for="id_pelanggan">Pelanggan</label>
                        <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                          <option value="">Pilih Pelanggan</option>
                          <?php while ($rowPelanggan = $resultPelanggan->fetch_assoc()) { ?>
                            <option value="<?php echo $rowPelanggan['id_pelanggan']; ?>" <?php if ($rowPelanggan['id_pelanggan'] == $dataPembelian['id_pelanggan']) echo 'selected'; ?>>
                              <?php echo $rowPelanggan['nama_pelanggan']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="tanggal_pembelian">Tanggal Pembelian</label>
                        <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="<?php echo $dataPembelian['tanggal_pembelian']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="total_pembelian">Total Pembelian</label>
                        <input type="number" class="form-control" id="total_pembelian" name="total_pembelian" value="<?php echo $dataPembelian['total_pembelian']; ?>" required>
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
