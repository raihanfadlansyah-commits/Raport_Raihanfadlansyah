<?php 
include 'koneksi_raihanf.php';
$nilai = $_GET['id_nilai'];
mysqli_query($koneksiraihanf, "DELETE FROM nilai_raihanf WHERE id_nilai='$nilai'");

echo "<script>alert('Data Berhasil Dihapus!');window.location='read_raport_raihanf.php';</script>";
?>