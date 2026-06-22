<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Record & Hasil NN</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="content">
    <div class="table-container">

        <div class="card">
            <h2>Tabel 1 - Data Parameter & Bobot</h2>
            <table>
                <thead>
                    <tr>
                        <th>Parameter (x)</th>
                        <th>Nilai Bobot (w)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM parameter ORDER BY kode_parameter");
                    while ($row = mysqli_fetch_assoc($q)):
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_parameter']) ?></td>
                            <td><?= htmlspecialchars($row['nilai_bobot']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Tabel 2 - Data Kerusakan Bangunan</h2>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>
                        <th>Target</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q2 = mysqli_query($conn, "SELECT * FROM kerusakan ORDER BY kode_data");
                    while ($row = mysqli_fetch_assoc($q2)):
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_data']) ?></td>
                            <td><?= htmlspecialchars($row['param_A']) ?></td>
                            <td><?= htmlspecialchars($row['param_B']) ?></td>
                            <td><?= htmlspecialchars($row['param_C']) ?></td>
                            <td><?= htmlspecialchars($row['param_D']) ?></td>
                            <td><?= htmlspecialchars($row['param_E']) ?></td>
                            <td><?= htmlspecialchars($row['target']) ?></td>
                            <td><a href="proses.php?id=<?= urlencode($row['kode_data']) ?>" style="color:#000;font-weight:bold;">Lihat Proses</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Hasil Neural Network</h2>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Net Input</th>
                        <th>Aktivasi</th>
                        <th>Output</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q3 = mysqli_query($conn, "SELECT * FROM view_hasil_nn ORDER BY kode_data");
                    while ($row = mysqli_fetch_assoc($q3)):
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_data']) ?></td>
                            <td><?= htmlspecialchars($row['net_input']) ?></td>
                            <td><?= htmlspecialchars($row['aktivasi']) ?></td>
                            <td><?= htmlspecialchars($row['output_nn']) ?></td>
                            <td><?= $row['output_nn'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
