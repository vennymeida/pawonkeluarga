<?php
session_start();
require 'function.php';
$queryKategori = "SELECT * FROM kategori_menu";
$resultKategori = $conn->query($queryKategori);

if (isset($_POST['simpan_data'])) {
    $id_menu = $_POST['id_menu'];
    $kategori = $_POST['kategori'];
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok_makanan'];
    
    // Check if a new file is uploaded
    if ($_FILES['foto']['name'] !== '') {
        $foto = $_FILES['foto']['name'];
        $target_dir = "assets/img";
        $target_file = $target_dir . basename($foto);
        // Hapus file foto lama jika ada
        $query = "SELECT foto FROM menu WHERE id_menu = $id_menu";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $oldFoto = $row['foto'];
        if (!empty($oldFoto) && file_exists($oldFoto)) {
            unlink($oldFoto);
          }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $update = $conn->query("UPDATE menu SET id_kategori_menu = '$kategori', nama_menu = '$nama_menu', harga = '$harga', foto = '$target_file',stok_makanan = '$stok'  WHERE id_menu = '$id_menu'");

            if ($update) {
              $_SESSION['create_status'] = 'success';
              $success_message = "Data berhasil diupdate.";
                // header("Location: list_menu.php");
                // exit;
            } else {
                $error = "Terjadi kesalahan saat mengupdate data. Silakan coba lagi."  .  $conn->error;
            }
        } else {
            $error = "Gagal meng-upload foto.";
        }
    } else {
        // If no new file is uploaded, update the data without changing the existing foto
        $update = $conn->query("UPDATE menu SET id_kategori_menu = '$kategori', nama_menu = '$nama_menu', harga = '$harga',stok_makanan = '$stok'  WHERE id_menu = '$id_menu'");

        if ($update) {
            header("Location: list_menu.php");
            exit;
        } else {
            $error = "Terjadi kesalahan saat mengupdate data. Silakan coba lagi.";
        }
    }
}

// Retrieve the menu data for editing
if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];
    $queryMenu = "SELECT * FROM menu WHERE id_menu = '$id_menu'";
    $resultMenu = $conn->query($queryMenu);
    $menuData = $resultMenu->fetch_assoc();
} else {
    header("Location: list_menu.php");
    exit;
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
    <div class="main-content">
      <section class="section">
        <div class="section-body">
          <div class="row">
          <div class="col-6 offset-3">
            <div class="section-header">
              <h1 class="text-center mb-4">Edit Menu</h1></div>
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
                    window.location.href = "list_menu.php";
                  }, 1000); 
                </script>
              <?php } ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="text-center">
                    <h1>Edit Menu</h1>
                    <input type="hidden" name="id_menu" value="<?php echo $menuData['id_menu']; ?>">
                    <div class="form-group">
          <label for="kategori">Kategori:</label>
          <select id="kategori" name="kategori" required>
            <?php while ($kategori = $resultKategori->fetch_assoc()) { ?>
              <option value="<?php echo $kategori['id_kategori_menu']; ?>" <?php if ($kategori['id_kategori_menu'] === $menuData['id_kategori_menu']) echo 'selected'; ?>><?php echo $kategori['nama_kategori']; ?></option>
            <?php } ?>
          </select>
        </div>
                <div class="form-group">
                  <label for="nama_menu">Nama Menu</label>
                  <input type="text" class="form-control" id="nama_menu" name="nama_menu" required value="<?php echo $menuData['nama_menu']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="harga">Harga</label>
                  <input type="text" class="form-control" id="harga" name="harga" required value="<?php echo $menuData['harga']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="foto">Foto</label>
                  <input type="file" class="form-control" id="foto" name="foto" accept=".jpg, .jpeg, .png" onchange="validateFile()">
                </div>
                <div class="form-group">
                  <label for="stok_makanan">Stok Makanan</label>
                  <input type="text" class="form-control" id="stok_makanan" name="stok_makanan" required value="<?php echo $menuData['stok_makanan']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="simpan_data">Simpan</button>
                <a href="list_menu.php" class="btn btn-secondary">Batal</a>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <script>
function validateFile() {
  var fileInput = document.getElementById('foto');
  var filePath = fileInput.value;
  var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i; // Hanya izinkan ekstensi file jpg, jpeg, png
  var maxSize = 5 * 1024 * 1024; // Ukuran maksimal file dalam bytes (contoh: 5 MB)

  // Mengecek apakah ekstensi file sesuai dengan yang diizinkan
  if (!allowedExtensions.exec(filePath)) {
    alert('File yang diunggah harus dalam format JPG, JPEG, PNG.');
    fileInput.value = ''; // Menghapus nilai file input
    return false;
  }

  // Mengecek ukuran file
  if (fileInput.files[0].size > maxSize) {
    alert('Ukuran file terlalu besar. Maksimal ukuran file adalah 5 MB.');
    fileInput.value = ''; // Menghapus nilai file input
    return false;
  }
}
</script>

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
