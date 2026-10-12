<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "koneksi.php";

$siswa_id = isset($_GET['siswa_id']) ? intval($_GET['siswa_id']) : 0;

if ($siswa_id <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "ID siswa tidak valid"
    ]);
    exit;
}

$query = "SELECT
            pengumpulan.id,
            tugas.judul,
            pengumpulan.keterangan,
            pengumpulan.foto,
            pengumpulan.waktu_kumpul
        FROM pengumpulan
        JOIN tugas ON pengumpulan.tugas_id = tugas.id
        WHERE pengumpulan.siswa_id = ?
        ORDER BY pengumpulan.id DESC";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $siswa_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);
