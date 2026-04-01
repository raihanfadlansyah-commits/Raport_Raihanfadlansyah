<?php
include 'koneksi_raihanf.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nilai</title>
    <link rel="stylesheet" href="1.css">
</head>

<body>
    <center>
        <div class="container">
            <form action="" method="POST">
                <td><input type="hidden" name="id_nilairaihanf"></td>
                <table>
                    <tr>
                        <h2>Tambah Data Nilai</h2>
                    </tr>

                    <tr>
                        <th>Nis</th>
                        <td><select class="input" name="nisraihanf">
                                <option value="">-- Pilih Siswa --</option>
                                <?php
                                $datasiswa = mysqli_query($koneksiraihanf, "SELECT * FROM siswa_raihanf");
                                while ($s = mysqli_fetch_array($datasiswa)) {
                                    echo "<option value='" . $s['nis'] . "'>" . $s['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>ID Mapel</th>
                        <td><select class="input" name="id_mapelraihanf">
                                <option value="">-- Pilih Mapel --</option>
                                <?php
                                $datamapel = mysqli_query($koneksiraihanf, "SELECT * FROM mapel_raihanf");
                                while ($m = mysqli_fetch_array($datamapel)) {
                                    echo "<option value='" . $m['id_mapel'] . "'>" . $m['nama_mapel'] . "</option>";
                                }
                                ?>
                            </select></td>
                    </tr>
                    <tr>
                        <th>Nilai Tugas</th>
                        <td><input class="input" type="number" name="tugasraihanf" placeholder="Masukan Nilai Harian" required></td>
                    </tr>
                    <tr>
                        <th>Nilai UTS</th>
                        <td><input class="input" type="number" name="utsraihanf" placeholder="Masukkan Nilai UTS" required></td>
                    </tr>
                    <tr>
                        <th>Nilai UAS</th>
                        <td><input class="input" type="number" name="uasraihanf" placeholder="Masukkan Nilai UAS" required></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td><input class="input" type="text" name="deskraihanf" placeholder="Masukkan Deskripsi" required></td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td><select class="input" name="semesterraihanf">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select></td>
                    </tr>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <td><select class="input" name="taraihanf">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select></td>
                    </tr>
                </table>
                <br><button type="submit" name="raihanfsimpan" class="button">Simpan</button><br><br>
                <a href="read_raport_raihanf.php" class="a">&larr; Kembali ke daftar nilai</a>
            </form>
        </div>
    </center>
    <?php


    if (isset($_POST['raihanfsimpan'])) {
        $id_nilairaihanf = $_POST['id_nilairaihanf'];
        $nisraihanf = $_POST['nisraihanf'];
        $id_mapelraihanf = $_POST['id_mapelraihanf'];
        $nilaitugasraihanf = $_POST['tugasraihanf'];
        $nilaiutsraihanf = $_POST['utsraihanf'];
        $nilaiuasraihanf = $_POST['uasraihanf'];
        $naraihanf = ($nilaitugasraihanf + $nilaiutsraihanf + $nilaiuasraihanf) / 3;
        $deskraihanf = $_POST['deskraihanf'];
        $semesterraihanf = $_POST['semesterraihanf'];
        $taraihanf = $_POST['taraihanf'];
        $queryid = mysqli_query($koneksiraihanf, "SELECT id_nilai FROM nilai_raihanf ORDER BY id_nilai
        DESC LIMIT 1");
        $dataid = mysqli_fetch_assoc($queryid);
        if ($dataid) {
            $no = (int) substr($dataid['id_nilai'], 2, 3);
            $no++;
            
        } else {
            $no = 1;
        }
        $id_nilairaihanf = "NI" . str_pad($no, 3, "0", STR_PAD_LEFT);



        $cekraihanf = mysqli_query($koneksiraihanf, "SELECT * FROM nilai_raihanf WHERE id_nilai='$id_nilairaihanf'");
        if (mysqli_num_rows($cekraihanf) > 0) {
            echo "<script>alert('Nilai Siswa tersebut sudah terdaftar, silakan isi dengan Siswa lain!');
            window.location='create_raport_raihanf.php';</script>";
        } else {
            $sql = "INSERT INTO nilai_raihanf (id_nilai, nis, id_mapel, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir, deskripsi, semester, tahun_ajaran) VALUES ('$id_nilairaihanf', '$nisraihanf', '$id_mapelraihanf', '$nilaitugasraihanf', '$nilaiutsraihanf', '$nilaiuasraihanf', '$naraihanf', '$deskraihanf', '$semesterraihanf', '$taraihanf')";
            if (mysqli_query($koneksiraihanf, $sql)) {
                echo "<script>alert('Data Berhasil Disimpan!');
                window.location='read_raport_raihanf.php';</script>";
            } else {
                echo "<script>alert('Data Gagal Disimpan!');
                window.location='create_raport_raihanf.php';</script>";
            }
        }
    }
    ?>
</body>

</html>