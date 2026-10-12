<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$folder = __DIR__ . "/uploads/";

if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}

// Membaca file foto yang dikirim sebagai data mentah
$dataFoto = file_get_contents("php://input");

if ($dataFoto === false || strlen($dataFoto) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Foto belum diterima"
    ]);
    exit;
}

// Memeriksa ukuran maksimal 5 MB
if (strlen($dataFoto) > 5 * 1024 * 1024) {
    echo json_encode([
        "status" => "error",
        "message" => "Ukuran foto maksimal 5 MB"
    ]);
    exit;
}

// Memeriksa format foto
$infoFoto = getimagesizefromstring($dataFoto);

if ($infoFoto === false) {
    echo json_encode([
        "status" => "error",
        "message" => "File bukan gambar yang valid"
    ]);
    exit;
}

$format = [
    IMAGETYPE_JPEG => "jpg",
    IMAGETYPE_PNG => "png"
];

if (!isset($format[$infoFoto[2]])) {
    echo json_encode([
        "status" => "error",
        "message" => "Foto harus berformat JPG atau PNG"
    ]);
    exit;
}

// Membuat nama file unik
$namaFoto = uniqid("foto_", true) . "." .
    $format[$infoFoto[2]];

$lokasi = $folder . $namaFoto;

if (file_put_contents($lokasi, $dataFoto) === false) {
    echo json_encode([
        "status" => "error",
        "message" => "Foto gagal disimpan"
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "message" => "Foto berhasil diunggah",
    "foto" => $namaFoto
]);
?>
