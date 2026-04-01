<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="1.css">
</head>
<body>
    <center>
    <div class="container">
    <?php
        include 'koneksi_raihanf.php';
        $nilai = $_GET['id_nilai'];
        $datanilai = mysqli_query($koneksiraihanf, "SELECT * FROM nilai_raihanf WHERE id_nilai='$nilai'");
        $datasiswa = mysqli_query($koneksiraihanf, "SELECT * FROM siswa_raihanf");
        $datamapel = mysqli_query($koneksiraihanf, "SELECT * FROM mapel_raihanf");
        while ($data_nilai_raihanf = mysqli_fetch_array($datanilai)) {
    ?>
    <form action="" method="POST">
        <table>
            <tr>
                <h2>Edit Data Nilai</h2>
            </tr>
            <tr>
                <td>ID Nilai:</td>
                <td> <input class="input" readonly type="text" name="id_nilairaihanf" value="<?php echo $data_nilai_raihanf['id_nilai']?>" required></td>
            </tr>
            <tr>
                <td>Nis:</td>
                <td>
                    <select class="input" name="nisraihanf" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php 
                        mysqli_data_seek($datasiswa, 0);
                        while($ds = mysqli_fetch_array($datasiswa)) { 
                            $selected = ($ds['nis'] == $data_nilai_raihanf['nis']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $ds['nis']; ?>" <?php echo $selected; ?>>
                                <?php echo $ds['nama']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>ID Mapel:</td>
                <td>
                    <select class="input" name="mapelraihanf" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php 
                        mysqli_data_seek($datamapel, 0);
                        while($dm = mysqli_fetch_array($datamapel)) { 
                            $selected = ($dm['id_mapel'] == $data_nilai_raihanf['id_mapel']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $dm['id_mapel']; ?>" <?php echo $selected; ?>>
                                <?php echo $dm['nama_mapel']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nilai Tugas:</td>
                <td><input class="input" type="number" name="tugasraihanf" placeholder="Masukan Nilai Tugas" value="<?php echo $data_nilai_raihanf['nilai_tugas']?>" required></td>
            </tr>
            <tr>
                <td>Nilai UTS:</td>
                <td><input class="input" type="number" name="utsraihanf" placeholder="Masukkan Nilai UTS" value="<?php echo $data_nilai_raihanf['nilai_uts']?>" required></td>
            </tr>
            <tr>
                <td>Nilai UAS:</td>
                <td><input class="input" type="number" name="uasraihanf" placeholder="Masukkan Nilai UAS" value="<?php echo $data_nilai_raihanf['nilai_uas']?>" required></td>
            </tr>
            <tr>
                <td>Deskripsi:</td>
                <td><input class="input" type="text" name="deskraihanf" placeholder="Masukkan Deskripsi" value="<?php echo $data_nilai_raihanf['deskripsi']?>" required></td>
            </tr>
            <tr>
                <td>Semester:</td>
                <td>
                    <select class="input" name="semesterraihanf" required>
                        <option value="">-- Pilih Semester --</option>
                        <?php
                        $semesterraihanf = ["1","2"];
                        for ($i = 0; $i < count($semesterraihanf); $i++) {
                            $semester = $semesterraihanf[$i];
                            $selected = ($data_nilai_raihanf['semester'] == $semester) ? 'selected' : '';
                            echo "<option value= '$semester' $selected>$semester</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tahun Ajaran:</td>
                <td>
                    <select class="input" name="taraihanf" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <?php
                        $taraihanf = ["2024","2025","2026"];
                        for ($i = 0; $i < count($taraihanf); $i++) {
                            $tahun = $taraihanf[$i];
                            $selected = ($data_nilai_raihanf['tahun_ajaran'] == $tahun) ? 'selected' : '';
                            echo "<option value= '$tahun' $selected>$tahun</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
            <br><button type="submit" name="raihanfupdate" class="button">Update</button><br><br>
            <a href="read_raport_raihanf.php" class="a">&larr; kembali ke daftar nilai</a>
        
    </form>
    <?php
        }
    ?>
    </div>
    </center>
    <?php 
        include 'koneksi_raihanf.php';
        if (isset($_POST['raihanfupdate'])) {
            $id_nilairaihanf = $_POST['id_nilairaihanf'];
            $nisraihanf = $_POST['nisraihanf'];
            $id_mapelraihanf = $_POST['mapelraihanf'];
            $tugasraihanf = $_POST['tugasraihanf'];
            $utsraihanf = $_POST['utsraihanf'];
            $uasraihanf = $_POST['uasraihanf'];
            $naraihanf = ($tugasraihanf + $utsraihanf + $uasraihanf) / 3;
            $deskraihanf = $_POST['deskraihanf'];
            $semesterraihanf = $_POST['semesterraihanf'];
            $taraihanf = $_POST['taraihanf'];


            $updateraihanf = "UPDATE nilai_raihanf SET id_nilai='$id_nilairaihanf', nis='$nisraihanf', id_mapel='$id_mapelraihanf', nilai_tugas='$tugasraihanf', nilai_uts='$utsraihanf', nilai_uas='$uasraihanf', nilai_akhir='$naraihanf', deskripsi='$deskraihanf',semester='$semesterraihanf',tahun_ajaran='$taraihanf'
                WHERE id_nilai='$id_nilairaihanf'";
            if (mysqli_query($koneksiraihanf, $updateraihanf)) {
                echo "<script>alert('Data Berhasil Diupdate!');
                    window.location='read_raport_raihanf.php';</script>";
            }
            exit;
        }
    ?>
</body>
</html>