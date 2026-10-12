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

$total = mysqli_num_rows($result);

function aman($data)
{
    return htmlspecialchars((string)$data, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | TugasKu</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fc;
            color: #243047;
        }

        .header {
            background: #2457a7;
            color: white;
            padding: 24px 5%;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .header p {
            margin: 0;
            color: #e0eaff;
        }

        .container {
            width: 92%;
            max-width: 1400px;
            margin: 25px auto;
        }

        .summary {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .summary .label {
            color: #65748b;
            font-size: 14px;
        }

        .summary .number {
            font-size: 32px;
            font-weight: bold;
            color: #2457a7;
            margin-top: 8px;
        }

        .panel {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        }

        .panel h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            border: none;
            border-radius: 7px;
            padding: 12px 16px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            background: #2457a7;
            color: white;
        }

        .button:hover {
            opacity: 0.9;
        }

        .button.excel {
            background: #16834a;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e3e8f0;
            border-radius: 8px;
        }

        table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px 12px;
            text-align: left;
            border-bottom: 1px solid #e7ebf2;
            font-size: 14px;
            vertical-align: top;
        }

        th {
            background: #edf3ff;
            color: #2457a7;
            white-space: nowrap;
        }

        tbody tr:hover {
            background: #f8faff;
        }

        .photo-link {
            color: #2457a7;
            font-weight: bold;
            text-decoration: none;
        }

        .photo-link:hover {
            text-decoration: underline;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #65748b;
        }

        .footer {
            text-align: center;
            padding: 22px;
            color: #718096;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .header {
                padding: 22px 5%;
            }

            .header h1 {
                font-size: 22px;
            }

            .container {
                width: 94%;
                margin: 16px auto;
            }

            .summary,
            .panel {
                padding: 16px;
                border-radius: 10px;
            }

            .summary .number {
                font-size: 28px;
            }

            .actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
                text-align: center;
                padding: 13px;
            }

            th,
            td {
                padding: 10px;
                font-size: 13px;
            }
        }

        @media print {
            body {
                background: white;
            }

            .header {
                background: white;
                color: black;
                padding: 10px 0;
            }

            .header p {
                color: black;
            }

            .container {
                width: 100%;
                margin: 10px 0;
            }

            .summary,
            .panel {
                box-shadow: none;
                padding: 10px 0;
            }

            .actions,
            .footer {
                display: none;
            }

            .table-wrapper {
                overflow: visible;
                border: none;
            }

            table {
                min-width: 0;
                width: 100%;
            }

            th,
            td {
                font-size: 10px;
                padding: 6px;
            }

            th {
                background: #eee !important;
                color: black;
            }

            tr {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <h1>Dashboard Admin TugasKu</h1>
        <p>Sistem Pengumpulan Tugas Siswa</p>
    </header>

    <main class="container">

        <section class="summary">
            <div class="label">Total Pengumpulan Tugas</div>
            <div class="number"><?php echo $total; ?></div>
        </section>

        <section class="panel">
            <h2>Rekapitulasi Pengumpulan</h2>

            <div class="actions">
                <button class="button" onclick="window.print()">
                    Cetak Laporan
                </button>

                <a class="button excel" href="export_excel.php">
                    Ekspor Excel
                </a>

            </div>

            <div class="table-wrapper">
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
                        <?php if ($total > 0) { ?>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo aman($row['nama']); ?></td>
                                    <td><?php echo aman($row['judul']); ?></td>
                                    <td><?php echo aman($row['mata_pelajaran']); ?></td>
                                    <td><?php echo aman($row['keterangan']); ?></td>
                                    <td>
                                        <?php if (!empty($row['foto'])) { ?>
                                            <a class="photo-link"
                                                href="uploads/<?php echo rawurlencode(basename($row['foto'])); ?>"
                                                target="_blank" rel="noopener">
                                                Lihat Foto
                                            </a>
                                        <?php } else { ?>
                                            Tidak ada foto
                                        <?php } ?>
                                    </td>
                                    <td><?php echo aman($row['waktu_kumpul']); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="empty">
                                    Belum ada pengumpulan tugas.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <footer class="footer">
        TugasKu &copy; <?php echo date("Y"); ?> — Sistem Pengumpulan Tugas Siswa
    </footer>

</body>

</html>