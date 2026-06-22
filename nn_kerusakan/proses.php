<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

if ($id === '') {
    echo 'ID Data tidak ditemukan. <a href="index.php">Kembali</a>';
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM kerusakan WHERE kode_data=?");
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    echo 'Data tidak ditemukan. <a href="index.php">Kembali</a>';
    exit;
}

// Ambil bobot parameter — hanya untuk menampilkan rincian x * w per parameter
$bobot = [];
$parameter = [];
$q_param = mysqli_query($conn, "SELECT * FROM parameter ORDER BY kode_parameter ASC");
while ($p = mysqli_fetch_assoc($q_param)) {
    $bobot[$p['kode_parameter']] = $p['nilai_bobot'];
    $parameter[] = $p['kode_parameter'];
}
$aktivasi_threshold = 1;

// Hasil akhir NN (net input, aktivasi, output) diambil dari VIEW —
// satu-satunya sumber kebenaran, sinkron dengan yang ditampilkan record.php
$stmt2 = mysqli_prepare($conn, "SELECT * FROM view_hasil_nn WHERE kode_data=?");
mysqli_stmt_bind_param($stmt2, "s", $id);
mysqli_stmt_execute($stmt2);
$hasil = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt2));

if (!$hasil) {
    echo 'Hasil NN untuk data ini belum tersedia di view_hasil_nn. <a href="index.php">Kembali</a>';
    exit;
}

$net_input = $hasil['net_input'];
$output_nn = $hasil['output_nn'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Neural Network</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="content">
    <div class="table-container">

        <h2>Proses Neural Network - <?= htmlspecialchars($id) ?></h2>

        <div class="card">
            <h3>Step 1 — Data Input (x)</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Data</th>
                        <?php foreach ($parameter as $k): ?>
                            <th><?= htmlspecialchars($k) ?></th>
                        <?php endforeach; ?>
                        <th>Target</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($id) ?></td>
                        <?php foreach ($parameter as $k): ?>
                            <td><?= htmlspecialchars($data['param_' . $k]) ?></td>
                        <?php endforeach; ?>
                        <td><?= htmlspecialchars($data['target']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Step 2 — Bobot (w)</h3>
            <table>
                <thead>
                    <tr>
                        <?php foreach ($parameter as $k): ?>
                            <th>w<sub><?= htmlspecialchars($k) ?></sub></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($parameter as $k): ?>
                            <td><?= number_format($bobot[$k], 1) ?></td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Langkah Perhitungan Net Input & Aktivasi</h3>
            <table>
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>x<sub>i</sub></th>
                        <th>w<sub>i</sub></th>
                        <th>x<sub>i</sub> &times; w<sub>i</sub></th>
                        <th>Net Input (&#931; x &times; w)</th>
                        <th>Aktivasi (&#8805; <?= $aktivasi_threshold ?>)</th>
                        <th>Output Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $is_first = true; ?>
                    <?php foreach ($parameter as $k): ?>
                        <tr>
                            <td><?= htmlspecialchars($k) ?></td>
                            <td><?= htmlspecialchars($data['param_' . $k]) ?></td>
                            <td><?= number_format($bobot[$k], 1) ?></td>
                            <td><?= number_format($data['param_' . $k] * $bobot[$k], 1) ?></td>
                            <?php if ($is_first): ?>
                                <td rowspan="<?= count($parameter) ?>" align="center" valign="middle">
                                    <strong><?= number_format($net_input, 1) ?></strong>
                                </td>
                                <td rowspan="<?= count($parameter) ?>" align="center" valign="middle">
                                    <strong><?= ($net_input >= $aktivasi_threshold) ? 'YA' : 'TIDAK' ?></strong>
                                </td>
                                <td rowspan="<?= count($parameter) ?>" align="center" valign="middle">
                                    <strong><?= htmlspecialchars($output_nn) ?></strong><br>
                                    <small><?= $output_nn == 1 ? 'AKTIF (Rusak)' : 'TIDAK AKTIF' ?></small>
                                </td>
                                <?php $is_first = false; ?>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <input type="submit" value="Lihat Semua Record & Hasil NN" onclick="window.location.href='record.php';">

    </div>
</div>

</body>
</html>
