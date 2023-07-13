<?php
session_start();
session_destroy();

// Redirect ke halaman login atau halaman lainnya setelah logout
header("Location: index.php");
exit;
?>