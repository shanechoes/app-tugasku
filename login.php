<?php

include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users 
          WHERE username = '$username' 
          AND password = '$password'";

$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {

    $data = mysqli_fetch_assoc($result);

    echo json_encode([
        "status" => "success",
        "message" => "Login berhasil",
        "id" => $data['id'],
        "nama" => $data['nama'],
        "role" => $data['role']
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Username atau password salah"
    ]);

}
?>