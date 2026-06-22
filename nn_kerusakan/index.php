<!-- index.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input - Data Kerusakan Bangunan</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="content">

<?php
if (isset($_GET['status'])) {
    $messages = [
        'bobot_sukses'     => ['sukses', 'Bobot parameter berhasil disimpan!'],
        'parameter_kosong' => ['error', 'Semua nilai bobot (A-E) wajib diisi dengan angka!'],
        'parameter_gagal'  => ['error', 'Gagal menyimpan data bobot parameter.'],
        'data_kosong'      => ['error', 'Semua field data kerusakan wajib diisi dengan nilai numerik 1-3!'],
        'duplikat'         => ['error', 'ID Data sudah ada! Silakan gunakan ID lain.'],
        'gagal'            => ['error', 'Terjadi kesalahan saat menyimpan data.'],
    ];
    if (isset($messages[$_GET['status']])) {
        [$tipe, $pesan] = $messages[$_GET['status']];
        echo '<div class="notif ' . $tipe . '">' . htmlspecialchars($pesan) . ' <span class="close" onclick="this.parentElement.style.display=\'none\'">&times;</span></div>';
    }
}
?>

<div class="container">
    <h2>Form Input Data Kerusakan Bangunan & Parameter</h2>
    <form action="aksi_insert.php" method="POST">

        <div class="input-row">
            <div class="input-field">
                <label for="bobot_A">Bobot A (w<sub>A</sub>)</label>
                <input type="number" id="bobot_A" name="bobot_A" placeholder="3.0" step="0.1" min="0">
            </div>
            <div class="input-field">
                <label for="bobot_B">Bobot B (w<sub>B</sub>)</label>
                <input type="number" id="bobot_B" name="bobot_B" placeholder="2.5" step="0.1" min="0">
            </div>
            <div class="input-field">
                <label for="bobot_C">Bobot C (w<sub>C</sub>)</label>
                <input type="number" id="bobot_C" name="bobot_C" placeholder="2.0" step="0.1" min="0">
            </div>
            <div class="input-field">
                <label for="bobot_D">Bobot D (w<sub>D</sub>)</label>
                <input type="number" id="bobot_D" name="bobot_D" placeholder="1.5" step="0.1" min="0">
            </div>
            <div class="input-field">
                <label for="bobot_E">Bobot E (w<sub>E</sub>)</label>
                <input type="number" id="bobot_E" name="bobot_E" placeholder="1.0" step="0.1" min="0">
            </div>
        </div>

        <div class="btn-group">
            <input type="submit" name="submit_aksi" value="Simpan Bobot">
            <input type="reset" value="Reset">
        </div>

        <hr style="margin: 25px 0; border: 0; border-top: 1px dashed #ccc;">

        <label for="kode_data">ID Data:</label>
        <input type="text" id="kode_data" name="kode_data" placeholder="Contoh: D6" maxlength="5">

        <label for="param_A">Parameter A:</label>
        <input type="number" id="param_A" name="param_A" placeholder="Masukkan nilai (1-3)" min="1" max="3">

        <label for="param_B">Parameter B:</label>
        <input type="number" id="param_B" name="param_B" placeholder="Masukkan nilai (1-3)" min="1" max="3">

        <label for="param_C">Parameter C:</label>
        <input type="number" id="param_C" name="param_C" placeholder="Masukkan nilai (1-3)" min="1" max="3">

        <label for="param_D">Parameter D:</label>
        <input type="number" id="param_D" name="param_D" placeholder="Masukkan nilai (1-3)" min="1" max="3">

        <label for="param_E">Parameter E:</label>
        <input type="number" id="param_E" name="param_E" placeholder="Masukkan nilai (1-3)" min="1" max="3">

        <label for="target">Target:</label>
        <input type="number" id="target" name="target" placeholder="Masukkan nilai target (1-3)" min="1" max="3">

        <div class="btn-group">
            <input type="submit" name="submit_aksi" value="Simpan Data & Lihat Proses NN">
            <input type="reset" value="Reset">
        </div>

    </form>
</div>

</div>
</body>
</html>
