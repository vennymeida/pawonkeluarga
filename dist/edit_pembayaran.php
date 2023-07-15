<?php
require 'function.php';

if (isset($_POST['submit'])) {
  // Ambil data dari form
  $idPembayaran = $_POST['id_pembayaran'];
  $idPembelian = $_POST['id_pembelian'];
  $totalPembayaran = $_POST['total_pembayaran'];
  $metodePembayaran = $_POST['metode_pembayaran'];
  $tanggalPembayaran = $_POST['tanggal_pembayaran'];

  // Query untuk mengupdate data pembayaran
  $query = "UPDATE pembayaran SET id_pembelian = '$idPembelian', total_pembayaran = '$totalPembayaran', metode_pembayaran = '$metodePembayaran', tanggal_pembayaran = '$tanggalPembayaran' WHERE id_pembayaran = $idPembayaran";
  $result = $conn->query($query);

  if ($result) {
    // Data berhasil diupdate, lakukan redirect atau tampilkan pesan sukses
    header("Location: pembayaran.php");
    exit;
  } else {
    // Terjadi kesalahan saat mengupdate data, tampilkan pesan error
    $error = "Terjadi kesalahan saat mengupdate data. Silakan coba lagi.";
    echo "Error: " . $query . "<br>" . $conn->error;
  }
}

// Ambil id_pembayaran dari URL
$idPembayaran = $_GET['id'];

// Query untuk mendapatkan data pembayaran berdasarkan id_pembayaran
$queryPembayaran = "SELECT * FROM pembayaran WHERE id_pembayaran = $idPembayaran";
$resultPembayaran = $conn->query($queryPembayaran);
$dataPembayaran = $resultPembayaran->fetch_assoc();

// Query untuk mendapatkan daftar pembelian
$queryPembelian = "SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan";
$resultPembelian = $conn->query($queryPembelian);

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
                    <h1>Edit Pembayaran</h1>
                    </div>
                  <div class="card-body">
                    <?php if (isset($error)) { ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                      </div>
                    <?php } ?>
                    <form method="POST" action="">
                      <input type="hidden" name="id_pembayaran" value="<?php echo $dataPembayaran['id_pembayaran']; ?>">
                      <div class="form-group">
                        <label for="id_pembelian">Nama Pelanggan</label>
                        <select class="form-control" id="id_pembelian" name="id_pembelian" required>
                          <option value="">Pilih Nama Pelanggan</option>
                          <?php while ($rowPembelian = $resultPembelian->fetch_assoc()) { ?>
                            <option value="<?php echo $rowPembelian['id_pembelian']; ?>" <?php if ($rowPembelian['id_pembelian'] == $dataPembayaran['id_pembelian']) echo 'selected'; ?>>
                              <?php echo $rowPembelian['nama_pelanggan']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="total_pembayaran">Total Pembayaran</label>
                        <input type="number" class="form-control" id="total_pembayaran" name="total_pembayaran" required value="<?php echo $dataPembayaran['total_pembayaran']; ?>">
                      </div>
                      <div class="form-group">
                        <label for="metode_pembayaran">Metode Pembayaran</label>
                        <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" required value="<?php echo $dataPembayaran['metode_pembayaran']; ?>">
                      </div>
                      <div class="form-group">
                        <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" required value="<?php echo $dataPembayaran['tanggal_pembayaran']; ?>">
                      </div>
                      <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                    </form>
                  </div>
                </div>
              </div>
        </section>
      </div>
      <footer class="main-footer">
        <!-- ... -->
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
 
  <!-- JS Libraies -->
  <script src="assets/modules/jquery-ui/jquery-ui.min.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
