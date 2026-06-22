<?php
include 'header.php';
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM data_kerusakan WHERE id_data='$id'")
);

$parameter = ['A','B','C','D','E'];

$nilai = [];
$sum = [];
$akar = [];
$r = [];

$q = mysqli_query($conn, "SELECT * FROM data_kerusakan");

while($d = mysqli_fetch_assoc($q)){

    foreach($parameter as $k){

        $nilai[$k][] = $d[$k];

        if(!isset($sum[$k])){
            $sum[$k] = 0;
        }

        $sum[$k] += pow($d[$k], 2);
    }
}

foreach($parameter as $k){

    $akar[$k] = sqrt($sum[$k]);

    $r[$k] = $data[$k] / $akar[$k];
}
?>

<div class="container">

    <h2>Proses Normalisasi Data <?= $id; ?></h2>

    <!-- DATA INPUT -->
    <div class="card">

        <h3>Data yang Dinormalisasi</h3>

        <table>

            <thead>
                <tr>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><?= $data['A']; ?></td>
                    <td><?= $data['B']; ?></td>
                    <td><?= $data['C']; ?></td>
                    <td><?= $data['D']; ?></td>
                    <td><?= $data['E']; ?></td>
                </tr>
            </tbody>

        </table>

    </div>

    <!-- TABEL PROSES -->
    <div class="card">

        <table>

            <thead>

                <tr>

                    <th>parameter</th>

                    <th>
                        x<sub>ij</sub>
                    </th>

                    <th>
                        ∑<sup>m</sup><sub>i=1</sub>
                        x<sub>ij</sub><sup>2</sup>
                    </th>

                    <th>
                        √(
                        ∑<sup>m</sup><sub>i=1</sub>
                        x<sub>ij</sub><sup>2</sup>
                        )
                    </th>

                    <th>
                        x<sub>ij</sub> /
                        √(
                        ∑<sup>m</sup><sub>i=1</sub>
                        x<sub>ij</sub><sup>2</sup>
                        )
                    </th>

                    <th>
                        r<sub>ij</sub>
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($parameter as $k){ ?>

                <?php

                $kuadrat = [];

                foreach($nilai[$k] as $v){
                    $kuadrat[] = $v . "<sup>2</sup>";
                }

                $sigmaText = implode(" + ", $kuadrat);

                ?>

                <tr>

                    <td><?= $k; ?></td>

                    <td>
                        <?= $data[$k]; ?>
                    </td>

                    <td style="text-align:left;">
                        <?= $sigmaText; ?>
                        =
                        <?= $sum[$k]; ?>
                    </td>

                    <td>
                        √<?= $sum[$k]; ?>
                        =
                        <?= number_format($akar[$k],6); ?>
                    </td>

                    <td>
                        <?= $data[$k]; ?>
                        /
                        <?= number_format($akar[$k],6); ?>
                    </td>

                    <td>
                        <strong>
                            <?= number_format($r[$k],6); ?>
                        </strong>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

    <input
        type="submit"
        value="Lihat Tabel Normalisasi"
        onclick="window.location.href='record.php';"
    >

</div>