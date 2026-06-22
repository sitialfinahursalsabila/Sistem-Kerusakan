<?php
$conn = mysqli_connect("localhost", "root", "", "db_kerusakan_bangunan");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
