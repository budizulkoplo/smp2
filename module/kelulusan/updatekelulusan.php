<?php
include "../../config/koneksi.php";

// Ambil data dari AJAX
$status = $_POST['status'];
$nisn = $_POST['nisn'];

// Query untuk update data
$exec = mysqli_query($koneksi,"UPDATE kelulusan SET statuskelulusan = '$status' WHERE nisn = '$nisn'");
echo "UPDATE kelulusan SET statuskelulusan = '$status' WHERE nisn = '$nisn'";

?>
