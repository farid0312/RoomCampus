<?php
// Konfigurasi koneksi database
$host     = "localhost";
$username = "root";
$password = "";
$database = "roomcampus";

// Membuat koneksi ke database menggunakan MySQLi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil atau gagal
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
