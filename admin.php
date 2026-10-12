<?php
require_once "koneksi.php";

$query = "SELECT
            pengumpulan.id,
            users.nama,
            tugas.judul,
            tugas.mata_pelajaran,
            pengumpulan.keterangan,
            pengumpulan.foto,
            pengumpulan.waktu_kumpul
          FROM pengumpulan
          JOIN users ON pengumpulan.siswa_id = users.id
          JOIN tugas ON pengumpulan.tugas_id = tugas.id
          ORDER BY pengumpulan.id DESC";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

function aman($data) {
    return htmlspecialchars((string)$data, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin TugasKu</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f3f6fb;
            color: #243047;
        }

        h1 {
            color: #2457a7;
        }

        .panel {
            background: white;
            padding: 20px;
            border-radius: 10px;
            overflow-x: auto;
        }

        .tombol {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px 5px 15px 0;
            background: #2457a7;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #2457a7;
            color: white;
        }

        tr:nth-child(even) {
            background: #f5f7fa;
        }

        @media print {
            .tombol {
                display: none;
            }

            body {
                margin: 10px;
                background: white;
            }
        }
    </style>
</head>

<body>
    <h1>Dashboard Admin TugasKu</h1>
    <p>Rekapitulasi pengumpulan tugas siswa.</p>

    <div class="panel">
        <h3>Total pengumpulan:
            <?php echo mysqli_num_rows($result); ?> data
        </h3>

        <button class="tombol" onclick="window.print()">
            Cetak Laporan
        </button>

        <a class="tombol" href="export_excel.php">
            Ekspor Excel
        </a>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Judul Tugas</th>
                    <th>Mata Pelajaran</th>
                    <th>Keterangan</th>
                    <th>Foto</th>
                    <th>Waktu Pengumpulan</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo aman($row['nama']); ?></td>
                        <td><?php echo aman($row['judul']); ?></td>
                        <td><?php echo aman($row['mata_pelajaran']); ?></td>
                        <td><?php echo aman($row['keterangan']); ?></td>
                        <td>
                            <?php if (!empty($row['foto'])) { ?>
                                <a href="uploads/<?php echo rawurlencode(basename($row['foto'])); ?>"
                                   target="_blank">Lihat Foto</a>
                            <?php } else { ?>
                                Tidak ada foto
                            <?php } ?>
                        </td>
                        <td><?php echo aman($row['waktu_kumpul']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>