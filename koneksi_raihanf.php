<?php
$koneksiraihanf = mysqli_connect("localhost", "root", "", "raport_raihanf");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
}
?>