<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "smp2";

// Koneksi dan memilih database di server
$koneksi = mysqli_connect($server, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
