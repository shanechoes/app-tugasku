<?php
require_once "koneksi.php";

$query = "SELECT
            pengumpulan.id,
            users.nama,
            tugas.judul,
            tugas.mata_pelajaran,
            pengumpulan.keterangan,
            pengumpulan.waktu_kumpul
          FROM pengumpulan
          JOIN users ON pengumpulan.siswa_id = users.id
          JOIN tugas ON pengumpulan.tugas_id = tugas.id
          ORDER BY pengumpulan.id DESC";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Header agar browser mengunduh file Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header('Content-Disposition: attachment; filename="rekap_pengumpulan_tugas.xls"');

echo "\xEF\xBB\xBF";
?>

<table border="1">
    <tr>
        <th>No.</th>
        <th>Nama Siswa</th>
        <th>Judul Tugas</th>
        <th>Mata Pelajaran</th>
        <th>Keterangan</th>
        <th>Waktu Pengumpulan</th>
    </tr>

    <?php
    $no = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['mata_pelajaran'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['keterangan'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['waktu_kumpul'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }
    ?>
</table>