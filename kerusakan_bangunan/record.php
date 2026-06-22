<?php 
include 'header.php';
include 'koneksi.php';

if(isset($_GET['status']) && $_GET['status']=='berhasil'){
    echo '<div class="notif sukses">
            Data berhasil ditambahkan!
            <span class="close" onclick="this.parentElement.style.display=\'none\'">&times;</span>
          </div>';
}
?>

<div class="container">

    <div class="card">
        <h2>Tabel 1 - Data Nilai Kerusakan Bangunan</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Parameter A</th>
                    <th>Parameter B</th>
                    <th>Parameter C</th>
                    <th>Parameter D</th>
                    <th>Parameter E</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM data_kerusakan");
                while ($data = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $data['id_data'] . "</td>";
                    echo "<td>" . $data['A'] . "</td>";
                    echo "<td>" . $data['B'] . "</td>";
                    echo "<td>" . $data['C'] . "</td>";
                    echo "<td>" . $data['D'] . "</td>";
                    echo "<td>" . $data['E'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Hasil Normalisasi - Persamaan (1)</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>r_A</th>
                    <th>r_B</th>
                    <th>r_C</th>
                    <th>r_D</th>
                    <th>r_E</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_norm = mysqli_query($conn, "SELECT * FROM view_normalisasi");
                while ($norm = mysqli_fetch_assoc($query_norm)) {
                    echo "<tr>";
                    echo "<td>" . $norm['id_data'] . "</td>";
                    echo "<td>" . number_format($norm['A'], 6) . "</td>";
                    echo "<td>" . number_format($norm['B'], 6) . "</td>";
                    echo "<td>" . number_format($norm['C'], 6) . "</td>";
                    echo "<td>" . number_format($norm['D'], 6) . "</td>";
                    echo "<td>" . number_format($norm['E'], 6) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
