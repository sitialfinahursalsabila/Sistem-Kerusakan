<?php
include 'koneksi.php';

$submit = $_POST['submit_aksi'] ?? '';

if ($submit == 'Simpan Bobot') {

    $bobot_input = [
        'A' => trim($_POST['bobot_A'] ?? ''),
        'B' => trim($_POST['bobot_B'] ?? ''),
        'C' => trim($_POST['bobot_C'] ?? ''),
        'D' => trim($_POST['bobot_D'] ?? ''),
        'E' => trim($_POST['bobot_E'] ?? ''),
    ];

    foreach ($bobot_input as $nilai) {
        if ($nilai === '' || !is_numeric($nilai)) {
            header("Location: index.php?status=parameter_kosong");
            exit;
        }
    }

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO parameter (kode_parameter, nilai_bobot) VALUES (?, ?)
         ON DUPLICATE KEY UPDATE nilai_bobot = VALUES(nilai_bobot)"
    );

    $sukses = true;
    foreach ($bobot_input as $kode => $nilai) {
        $nilai_f = (float) $nilai;
        mysqli_stmt_bind_param($stmt, "sd", $kode, $nilai_f);
        if (!mysqli_stmt_execute($stmt)) {
            $sukses = false;
        }
    }

    if ($sukses) {
        header("Location: index.php?status=bobot_sukses");
    } else {
        header("Location: index.php?status=parameter_gagal");
    }
    exit;

} elseif ($submit == 'Simpan Data & Lihat Proses NN') {

    $kode_data = trim($_POST['kode_data'] ?? '');
    $A         = trim($_POST['param_A'] ?? '');
    $B         = trim($_POST['param_B'] ?? '');
    $C         = trim($_POST['param_C'] ?? '');
    $D         = trim($_POST['param_D'] ?? '');
    $E         = trim($_POST['param_E'] ?? '');
    $target    = trim($_POST['target'] ?? '');

    $fields_to_check = [$A, $B, $C, $D, $E, $target];
    $valid = ($kode_data !== '');
    if ($valid) {
        foreach ($fields_to_check as $f) {
            if ($f === '' || !is_numeric($f) || $f < 1 || $f > 3) {
                $valid = false;
                break;
            }
        }
    }

    if (!$valid) {
        header("Location: index.php?status=data_kosong");
        exit;
    }

    $A = (int) $A; $B = (int) $B; $C = (int) $C; $D = (int) $D; $E = (int) $E; $target = (int) $target;

    $cek = mysqli_prepare($conn, "SELECT kode_data FROM kerusakan WHERE kode_data=?");
    mysqli_stmt_bind_param($cek, "s", $kode_data);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        header("Location: index.php?status=duplikat");
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO kerusakan (kode_data, param_A, param_B, param_C, param_D, param_E, target) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "siiiiii", $kode_data, $A, $B, $C, $D, $E, $target);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: proses.php?id=" . urlencode($kode_data));
    } else {
        header("Location: index.php?status=gagal");
    }
    exit;
} else {
    header("Location: index.php");
    exit;
}
