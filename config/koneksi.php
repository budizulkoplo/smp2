<?php
$server = "localhost";
$username = "zul";
$password = "masuk";
$database = "absensi";

// Koneksi dan memilih database di server
mysql_connect($server, $username, $password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");

$koneksi = new mysqli($server, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
