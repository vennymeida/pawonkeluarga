<?php
require 'function.php';

// Define available metode pembayaran options
$metodePembayaranOptions = array(
  'transfer' => 'Transfer',
  'cash' => 'Cash',
  'debit' => 'Debit',
  'qrcode' => 'QR Code',
);

if (isset($_POST['submit'])) {
  // Ambil data dari form
  $idPembelian = $_POST['id_pembelian'];
  $totalPembayaran = $_POST['total_pembayaran'];
  $metodePembayaran = $_POST['metode_pembayaran'];
  $tanggalPembayaran = $_POST['tanggal_pembayaran'];

  // Query untuk menyimpan data ke tabel pembayaran
  $query = "INSERT INTO pembayaran (id_pembelian, total_pembayaran, metode_pembayaran, tanggal_pembayaran) 
  VALUES ('$idPembelian', '$totalPembayaran', '$metodePembayaran', '$tanggalPembayaran')";
  $result = $conn->query($query);

  if ($result) {
    header("Location: pembayaran.php");
    exit;
  } else {
    $error = "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.";
    echo "Error: " . $query . "<br>" . $conn->error; 
  }
}

$queryPembelian = "SELECT p.id_pembelian, pel.nama_pelanggan FROM pembelian p INNER JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan";
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
  <div class="main-content">
      <section class="section">
        <div class="section-body">
          <div class="row">
            <div class="col-6">
              <div class="card">
               <div class="card-body d-flex justify-content-center">
                <form method="POST" action="">
                    <div class="text-center">
                    <h1>Tambah Pembayaran</h1>
                    </div>
                  <div class="card-body">
                    <?php if (isset($error)) { ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                      </div>
                    <?php } ?>
                    <form method="POST" action="">
                      <div class="form-group">
                        <label for="id_pembelian">Nama Pelanggan</label>
                        <select class="form-control" id="id_pembelian" name="id_pembelian" required>
                          <option value="">Pilih Nama Pelanggan</option>
                          <?php while ($rowPembelian = $resultPembelian->fetch_assoc()) { ?>
                            <option value="<?php echo $rowPembelian['id_pembelian']; ?>">
                              <?php echo $rowPembelian['nama_pelanggan']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="total_pembayaran">Total Pembayaran</label>
                        <input type="number" class="form-control" id="total_pembayaran" name="total_pembayaran" required>
                      </div>
                      <div class="form-group">
          <label for="metode_pembayaran">Metode Pembayaran</label>
          <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
            <option value="">Pilih Metode Pembayaran</option>
            <?php foreach ($metodePembayaranOptions as $key => $value) { ?>
              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } ?>
          </select>
        </div>
                      <div class="form-group">
                        <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" required>
                      </div>
                      <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                    </form>
                  </div>
                </div>
              </div>
        </section>
      </div>
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