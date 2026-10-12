<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "tugasku_asts_mit";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>