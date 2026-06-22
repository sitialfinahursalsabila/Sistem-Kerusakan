<?php include 'header.php';
if (isset($_GET['status'])) {

    if ($_GET['status'] == 'duplikat') {
        echo '<div class="notif error">
                ID Data sudah ada! Silakan gunakan ID lain.
                <span class="close" onclick="this.parentElement.style.display=\'none\'">&times;</span>
              </div>';
    } elseif ($_GET['status'] == 'gagal') {
        echo '<div class="notif error">
                Terjadi kesalahan saat menyimpan data.
                <span class="close" onclick="this.parentElement.style.display=\'none\'">&times;</span>
              </div>';
    }
}
?>

<div class="container">
    <h2>Form Input Data Kerusakan Bangunan</h2>

    <form action="aksi_insert.php" method="POST">
        <label for="id_data">ID Data:</label>
        <input type="text" id="id_data" name="id_data" placeholder="Contoh: D6" required>

        <label for="A">Parameter A:</label>
        <input type="number" id="A" name="A" placeholder="Masukkan nilai A" min="1" max="3" required>

        <label for="B">Parameter B:</label>
        <input type="number" id="B" name="B" placeholder="Masukkan nilai B" min="1" max="3" required>

        <label for="C">Parameter C:</label>
        <input type="number" id="C" name="C" placeholder="Masukkan nilai C" min="1" max="3" required>

        <label for="D">Parameter D:</label>
        <input type="number" id="D" name="D" placeholder="Masukkan nilai D" min="1" max="3" required>

        <label for="E">Parameter E:</label>
        <input type="number" id="E" name="E" placeholder="Masukkan nilai E" min="1" max="3" required>

        <div class="btn-group">
            <input type="submit" value="Simpan">
            <input type="reset" value="Reset">
        </div>
    </form>
</div>