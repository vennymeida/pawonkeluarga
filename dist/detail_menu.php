<?php
require 'function.php';

if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];
    
    // Fetch menu data from the database
    $queryMenu = "SELECT * FROM menu WHERE id_menu = '$id_menu'";
    $resultMenu = $conn->query($queryMenu);
    $menuData = $resultMenu->fetch_assoc();

    if (!$menuData) {
        // Menu with the specified ID doesn't exist
        header("Location: list_menu.php");
        exit;
    }
} else {
    // No menu ID specified
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
    <div class="main-content">
      <section class="section">
        <div class="section-body">
          <div class="row">
            <div class="col-6">
              <div class="card">
               <div class="card-body d-flex justify-content-center">
                <form>
                    <div class="text-center">
                    <h1>Detail Menu</h1>
                    <div class="form-group">
                        <label for="kategori">Kategori:</label>
                        <input type="text" class="form-control" value="<?php echo $menuData['id_kategori_menu']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu:</label>
                        <input type="text" class="form-control" value="<?php echo $menuData['nama_menu']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga:</label>
                        <input type="text" class="form-control" value="<?php echo $menuData['harga']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto:</label>
                        <br>
                        <img src="<?php echo $menuData['foto']; ?>" alt="" style="width: 300px; height: auto;">
                    </div>
                    <a href="list_menu.php" class="btn btn-secondary">Kembali</a>
                </form>
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
