
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "koneksi.php";

$tugas_id = isset($_POST['tugas_id'])
    ? intval($_POST['tugas_id']) : 0;

$siswa_id = isset($_POST['siswa_id'])
    ? intval($_POST['siswa_id']) : 0;

$keterangan = isset($_POST['keterangan'])
    ? trim($_POST['keterangan']) : "";

$namaFoto = isset($_POST['foto'])
    ? basename($_POST['foto']) : "";

if ($tugas_id <= 0 || $siswa_id <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "ID tugas atau siswa tidak valid"
    ]);
    exit;
}

// Foto wajib sudah diunggah terlebih dahulu
if ($namaFoto === "") {
    echo json_encode([
        "status" => "error",
        "message" => "Nama foto belum diterima"
    ]);
    exit;
}

// Pastikan file foto memang ada di folder uploads
$lokasiFoto = __DIR__ . "/uploads/" . $namaFoto;

if (!is_file($lokasiFoto)) {
    echo json_encode([
        "status" => "error",
        "message" => "File foto tidak ditemukan"
    ]);
    exit;
}

$query = "INSERT INTO pengumpulan
          (tugas_id, siswa_id, keterangan, foto)
          VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Query database gagal disiapkan"
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "iiss",
    $tugas_id,
    $siswa_id,
    $keterangan,
    $namaFoto
);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success",
        "message" => "Tugas berhasil dikumpulkan",
        "foto" => $namaFoto
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Tugas gagal disimpan ke database"
    ]);
}

mysqli_stmt_close($stmt);
?>
