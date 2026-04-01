<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai raport</title>
    <link rel="stylesheet" href="1.css">
    </style>
</head>
<body>
    <center>
    <h2>Daftar Data Nilai</h2>
    <table>
        <tr>
            <th>ID-NILAI</th>
            <th>NIS</th>
            <th>NAMA</th>
            <th>Mapel</th>
            <th>Nilai Tugas</th>
            <th>Nilai UTS</th>
            <th>Nilai UAS</th>
            <th>Nilai Akhir</th>
            <th>Deskripsi</th>
            <th>Semester</th>
            <th>Tahun Ajaran</th>
            <th>Aksi</th>
        </tr>
    
    <?php
    include 'koneksi_raihanf.php';

    $datanilai = mysqli_query($koneksiraihanf,"SELECT nilai_raihanf.id_nilai, siswa_raihanf.nis, siswa_raihanf.nama, mapel_raihanf.nama_mapel AS id_mapel, nilai_raihanf.nilai_tugas, nilai_raihanf.nilai_uts, nilai_raihanf.nilai_uas, nilai_raihanf.nilai_akhir, nilai_raihanf.deskripsi, nilai_raihanf.semester, nilai_raihanf.tahun_ajaran
    FROM nilai_raihanf 
    JOIN siswa_raihanf ON nilai_raihanf.nis = siswa_raihanf.nis 
    JOIN mapel_raihanf ON nilai_raihanf.id_mapel = mapel_raihanf.id_mapel ORDER BY id_nilai");
    while($data_nilai_raihanf = mysqli_fetch_array($datanilai)){
        $rata_rata =number_format(($data_nilai_raihanf['nilai_tugas'] + $data_nilai_raihanf['nilai_uts'] + $data_nilai_raihanf['nilai_uas']) / 3, 2);
        ?>
        <tr>
            <td><?php echo $data_nilai_raihanf['id_nilai'];?></td>
            <td><?php echo $data_nilai_raihanf['nis'];?></td>
            <td><?php echo $data_nilai_raihanf['nama'];?></a></td>
            <td><?php echo $data_nilai_raihanf['id_mapel'];?></a></td>
            <td><?php echo $data_nilai_raihanf['nilai_tugas'];?></td>
            <td><?php echo $data_nilai_raihanf['nilai_uts'];?></td>
            <td><?php echo $data_nilai_raihanf['nilai_uas'];?></td>
            <td style="color: red;"><?php echo $rata_rata;?></td>
            <td><?php echo $data_nilai_raihanf['deskripsi'];?></td>
            <td><?php echo $data_nilai_raihanf['semester'];?></td>
            <td><?php echo $data_nilai_raihanf['tahun_ajaran'];?></td>
            <td>
                <a class="aa" href="update_raport_raihanf.php?id_nilai=<?php echo $data_nilai_raihanf['id_nilai'];?>">EDIT</a>|<a class="aa" href="delete_raport_raihanf.php?id_nilai=<?php echo $data_nilai_raihanf['id_nilai'];?>"
                   onclick="return confirm('Yakin ingin menghapus data ini?')">HAPUS</a>|<a class="aa" href="pdf/cetak.php?nis=<?php echo $data_nilai_raihanf['nis']?> &semester=<?php echo $data_nilai_raihanf['semester']?> &tahun_ajaran=<?php echo $data_nilai_raihanf['tahun_ajaran']?>">CETAK</a>

                
            </td>
        </tr>
        <?php
    }
    ?>
    
    </table>
    <?php
    ?>
    <br><br><a href="create_raport_raihanf.php" class="aaa">+ Nilai Baru</a>
    
    </center>

</body>
</html>