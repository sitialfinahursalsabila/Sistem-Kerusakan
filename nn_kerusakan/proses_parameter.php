<?php
include 'koneksi.php';

$kode = isset($_GET['kode']) ? trim($_GET['kode']) : '';

if ($kode === '') {
    echo 'Kode parameter tidak ditemukan. <a href="index.php">Kembali</a>';
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM parameter WHERE kode_parameter=?");
mysqli_stmt_bind_param($stmt, "s", $kode);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    echo 'Data tidak ditemukan. <a href="index.php">Kembali</a>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Parameter</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="content">
    <div class="table-container">

        <h2>Proses Input Parameter - <?= htmlspecialchars($data['kode_parameter']) ?></h2>

        <div class="card">
            <h3>Data Parameter yang Disimpan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kode Parameter</th>
                        <th>Nama Parameter</th>
                        <th>Nilai Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($data['kode_parameter']) ?></td>
                        <td><?= htmlspecialchars($data['nama_parameter']) ?></td>
                        <td><?= number_format($data['nilai_bobot'], 1) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Semua Bobot yang Tersimpan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Parameter</th>
                        <th>Nilai Bobot (w)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $all = mysqli_query($conn, "SELECT * FROM parameter ORDER BY kode_parameter ASC");
                    while ($p = mysqli_fetch_assoc($all)):
                    ?>
                        <tr <?= $p['kode_parameter'] == $kode ? 'style="background:#000;color:#fff;"' : '' ?>>
                            <td><?= htmlspecialchars($p['kode_parameter']) ?></td>
                            <td><?= htmlspecialchars($p['nama_parameter']) ?></td>
                            <td><?= number_format($p['nilai_bobot'], 1) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="btn-link-block" style="margin-bottom:10px;">Kembali ke Form Input</a>
        <a href="record.php" class="btn-link-block">Lihat Semua Parameter</a>

    </div>
</div>

</body>
</html>
