<?php

include "koneksi.php";

$query = "SELECT * FROM tugas ORDER BY deadline ASC";

$result = mysqli_query($koneksi, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

?>