<?php
include 'koneksi.php';

$id_data = $_POST['id_data'];
$A = $_POST['A'];
$B = $_POST['B'];
$C = $_POST['C'];
$D = $_POST['D'];
$E = $_POST['E'];


$cek = mysqli_query(
    $conn,
    "SELECT id_data FROM data_kerusakan WHERE id_data='$id_data'"
);

if(mysqli_num_rows($cek) > 0){

    header("Location: index.php?status=duplikat");
    exit;
}

$sql = "INSERT INTO data_kerusakan (id_data, A, B, C, D, E)
        VALUES ('$id_data', '$A', '$B', '$C', '$D', '$E')";

if(mysqli_query($conn, $sql)){
        header("Location: proses.php?id=".$id_data);
}else{
    header("Location: index.php?status=gagal");
}

exit;
?>