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

    // Query untuk mendapatkan daftar menu
    $queryMenu = "SELECT * FROM menu";
    $resultMenu = $conn->query($queryMenu);
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
  $idMenu = $_POST['id_menu'];
  $tanggalPembelian = $_POST['tanggal_pembelian'];
  $totalPembelianBaru = $_POST['total_pembelian'];
  $totalHarga = $_POST['total_harga'];

  // Dapatkan total pembelian sebelumnya
  $queryPembelianLama = "SELECT total_pembelian FROM pembelian WHERE id_pembelian = $idPembelian";
  $resultPembelianLama = $conn->query($queryPembelianLama);
  $rowPembelianLama = $resultPembelianLama->fetch_assoc();
  $totalPembelianLama = $rowPembelianLama['total_pembelian'];

  // Dapatkan stok menu saat ini
  $queryStokMenu = "SELECT stok_makanan FROM menu WHERE id_menu = '$idMenu'";
  $resultStokMenu = $conn->query($queryStokMenu);
  $rowStokMenu = $resultStokMenu->fetch_assoc();
  $stokMenu = $rowStokMenu['stok_makanan'];

  // Periksa apakah total pembelian baru melebihi stok yang tersedia
  if ($totalPembelianBaru > $stokMenu) {
    $error = "Error: Jumlah pembelian melebihi stok yang tersedia.";
  } else {
    // Hitung stok menu baru
    if ($totalPembelianLama > $totalPembelianBaru) {
      $stokMenuBaru = $stokMenu + ($totalPembelianLama - $totalPembelianBaru);
    } else {
      $stokMenuBaru = $stokMenu - ($totalPembelianBaru - $totalPembelianLama);
    }

    // Query untuk update data pembelian
    $query = "UPDATE pembelian SET id_pelanggan = '$idPelanggan', id_menu = '$idMenu', tanggal_pembelian = '$tanggalPembelian', total_pembelian = '$totalPembelianBaru', total_harga = '$totalHarga' WHERE id_pembelian = $idPembelian";
    $result = $conn->query($query);

    if ($result) {
      // Update stok menu
      $queryUpdateStokMenu = "UPDATE menu SET stok_makanan = '$stokMenuBaru' WHERE id_menu = '$idMenu'";
      $resultUpdateStokMenu = $conn->query($queryUpdateStokMenu);

      $_SESSION['create_status'] = 'success';
      $success_message = "Data berhasil diupdate.";
    } else {
      // Terjadi kesalahan saat mengupdate data, tampilkan pesan error
      $error = "Terjadi kesalahan saat mengupdate data: " . $conn->error;
    }
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
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>

        </form>
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, Admin</div>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">Pawon Keluarga</div>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item has-icon text-danger">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="dashboard.php">Pawon Keluarga</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="dashboard.php">St</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown">
              <a href="dashboard.php"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">User</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>User</span></a>
              <ul class="dropdown-menu">
                <li><a href="table_pelanggan.php">Data Pelanggan</a></li>
                <li><a href="table_admin.php">Data Admin</a></li>
              </ul>
            </li>
            <li class="menu-header">Food</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Menu</span></a>
              <ul class="dropdown-menu">
                <li><a href="kategori_menu.php">Kategori Menu</a></li>
                <li><a href="list_menu.php">Menu Makanan</a></li>
              </ul>
            </li>
            <li class="menu-header">Order</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Order Item</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="list_pembelian.php">List Pembelian</a></li>
                <li><a class="nav-link" href="pembayaran.php">Pembayaran</a></li>
                <li><a class="nav-link" href="pembelian_item.php">History Pembelian</a></li>
              </ul>
            </li>
        </aside>
      </div>
      <div class="main-wrapper main-wrapper-1">
        <div class="main-content">
          <section class="section">
            <div class="section-body">
              <div class="row">
                < <div class="col-6 offset-3">
                  <div class="section-header">
                    <h1 class="text-center mb-4">Edit Pembelian</h1>
                  </div>
                  <?php if (isset($error)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <?php echo $error; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php } ?>
                  <?php if (isset($success_message)) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <?php echo $success_message; ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <script>
                      setTimeout(function() {
                        window.location.href = "list_pembelian.php";
                      }, 1000);
                    </script>
                  <?php } ?>
                  <form method="POST" action="">
                    <div class="card-body">
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
                          <label for="total_pembelian">Total Pembelian</label>
                          <input type="number" class="form-control" id="total_pembelian" name="total_pembelian" value="<?php echo $dataPembelian['total_pembelian']; ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="id_menu">Menu Makanan Tersedia</label>
                          <select class="form-control" id="id_menu" name="id_menu" required>
                            <option value="">Pilih Makanan</option>
                            <?php while ($rowMenu = $resultMenu->fetch_assoc()) { ?>
                              <option value="<?php echo $rowMenu['id_menu']; ?>" data-harga="<?php echo $rowMenu['harga']; ?>" <?php if ($rowMenu['id_menu'] == $dataPembelian['id_menu']) echo 'selected'; ?>>
                                <?php echo $rowMenu['nama_menu']; ?>
                              </option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="tanggal_pembelian">Tanggal Pembelian</label>
                          <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="<?php echo $dataPembelian['tanggal_pembelian']; ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="total_harga">Total Harga</label>
                          <input type="number" class="form-control" id="total_harga" name="total_harga" value="<?php echo $dataPembelian['total_harga']; ?>" readonly>
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
  <script>
    var dropdownMenu = document.getElementById("id_menu");
    var totalHargaInput = document.getElementById("total_harga");
    dropdownMenu.addEventListener("change", function() {
      var hargaMenu = dropdownMenu.options[dropdownMenu.selectedIndex].getAttribute("data-harga");

      var totalPembelian = parseFloat(document.getElementById("total_pembelian").value);
      var totalHarga = hargaMenu * totalPembelian;
      totalHargaInput.value = totalHarga;
    });
  </script>
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