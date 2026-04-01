<?php
require('fpdf.php');
require_once '../koneksi_raihanf.php';

if (!isset($_GET['nis']) || !isset($_GET['semester']) || !isset($_GET['tahun_ajaran'])) {
    die('Parameter nis dan semester diperlukan.');
}

$nis = $_GET['nis'];
$semester = $_GET['semester'];
$tahun_ajaranraihanf = isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '';

$dataSiswaraihanf = mysqli_query($koneksiraihanf, "SELECT nilai_raihanf.*, siswa_raihanf.nama, siswa_raihanf.tempat_lahir, siswa_raihanf.tgl_lahir, siswa_raihanf.alamat, kelas_raihanf.*, absensi_raihanf.id_absen, absensi_raihanf.sakit, absensi_raihanf.izin, absensi_raihanf.alfa, mapel_raihanf.nama_mapel FROM nilai_raihanf INNER JOIN siswa_raihanf ON nilai_raihanf.nis = siswa_raihanf.nis INNER JOIN kelas_raihanf ON siswa_raihanf.id_kelas = kelas_raihanf.id_kelas INNER JOIN absensi_raihanf ON siswa_raihanf.nis = absensi_raihanf.nis INNER JOIN mapel_raihanf ON nilai_raihanf.id_mapel = mapel_raihanf.id_mapel WHERE nilai_raihanf.nis = '$nis' AND nilai_raihanf.semester = '$semester' AND nilai_raihanf.tahun_ajaran = '$tahun_ajaranraihanf' ORDER BY nilai_raihanf.id_nilai ASC");
// Check if data exists before fetching
if ($dataSiswaraihanf->num_rows == 0) {
    die('Data siswa tidak ditemukan.');
}

$dataraihanf = mysqli_fetch_array($dataSiswaraihanf);

class RaportPDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,6,'DINAS PENDIDIKAN KOTA CIMAHI',0,1,'C');
        $this->SetFont('Arial','B',13);
        $this->Cell(0,5,'SMK NEGERI 2 CIMAHI',0,1,'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0,4,'Jl. Kamarung KM. 1,5 No. 69, Citeureup, Kec. Cimahi Utara, Kota Cimahi, Jawa Barat',0,1,'C');
        $this->Ln(3);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(2);
    }
    
    function Footer() {
        $this->SetY(-30);
        $this->SetFont('Arial','',9);
        $this->Cell(0,4,'Page '.$this->PageNo(),0,0,'C');
    }
}

$pdf = new RaportPDF();
$pdf->AddPage();
$pdf->SetMargins(10, 20, 10);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,6,'LAPORAN HASIL BELAJAR PESERTA DIDIK',0,1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,5,'SEMESTER '.$semester.' TAHUN PELAJARAN '.$tahun_ajaranraihanf,0,1,'C');
$pdf->Ln(4);

$pdf->SetFont('Arial','',10);
$pdf->Cell(50,5,'Nama Peserta Didik',0,0,'L');
$pdf->Cell(0,5,': '.$dataraihanf['nama'],0,1,'L');

$pdf->Cell(50,5,'Nomor Induk Siswa',0,0,'L');
$pdf->Cell(0,5,': '.$dataraihanf['nis'],0,1,'L');

$pdf->Cell(50,5,'Kelas',0,0,'L');
$pdf->Cell(0,5,': '.$dataraihanf['nama_kelas'],0,1,'L');

$pdf->Cell(50,5,'Tempat, Tanggal Lahir',0,0,'L');
$pdf->Cell(0,5,': '.$dataraihanf['tempat_lahir'].', '.$dataraihanf['tgl_lahir'],0,1,'L');

$pdf->Ln(3);

$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(220,220,220);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0.3);

$tableWidth = 190;
$pdf->Cell(12,6,'NO',1,0,'C',true);
$pdf->Cell(55,6,'MATA PELAJARAN',1,0,'C',true);
$pdf->Cell(25,6,'KKM',1,0,'C',true);
$pdf->Cell(30,6,'NILAI',1,0,'C',true);
$pdf->Cell(68,6,'KETERANGAN',1,1,'C',true);

$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(245,245,245);
$no = 1;

if ($dataSiswaraihanf->num_rows > 0) {
    $dataQueryraihanf = mysqli_query($koneksiraihanf, "SELECT nilai_raihanf.*, mapel_raihanf.nama_mapel FROM nilai_raihanf INNER JOIN mapel_raihanf ON nilai_raihanf.id_mapel = mapel_raihanf.id_mapel WHERE nilai_raihanf.nis = '$nis' AND nilai_raihanf.semester = '$semester' AND nilai_raihanf.tahun_ajaran = '$tahun_ajaranraihanf' ORDER BY nilai_raihanf.id_nilai ASC");
    
    while ($dataGraderaihanf = mysqli_fetch_array($dataQueryraihanf)) {
        $pdf->Cell(12,6,$no,1,0,'C',true);
        $pdf->Cell(55,6,$dataGraderaihanf['nama_mapel'],1,0,'L',true);
        $pdf->Cell(25,6,'70',1,0,'C',true);
        $pdf->Cell(30,6,$dataGraderaihanf['nilai_akhir'],1,0,'C',true);
        $pdf->Cell(68,6,$dataGraderaihanf['deskripsi'],1,1,'C',true);
        $no++;
    }
} else {
    $pdf->Cell(190,6,'Data tidak ditemukan',1,1,'C',true);
}

$pdf->Ln(3);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,'KETIDAKHADIRAN',0,1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(220,220,220);
$pdf->Cell(95,6,'KETERANGAN',1,0,'C',true);
$pdf->Cell(95,6,'JUMLAH',1,1,'C',true);

$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(245,245,245);
$pdf->Cell(95,6,'Sakit',1,0,'L',true);
$pdf->Cell(95,6,$dataraihanf['sakit'],1,1,'C',true);

$pdf->Cell(95,6,'Izin',1,0,'L',true);
$pdf->Cell(95,6,$dataraihanf['izin'],1,1,'C',true);

$pdf->Cell(95,6,'Tanpa Keterangan (Alfa)',1,0,'L',true);
$pdf->Cell(95,6,$dataraihanf['alfa'],1,1,'C',true);

$pdf->Ln(8);

$pdf->SetFont('Arial','',9);
$pageWidth = 210;
$margin = 10;
$usableWidth = $pageWidth - (2 * $margin);
$colWidth = ($usableWidth - 10) / 2;

$currentY = $pdf->GetY() + 12;
$col1X = $margin + 5;
$col2X = $margin + $colWidth + 10;

$pdf->SetXY($col1X, $currentY);
$pdf->Cell($colWidth,5,'Orang Tua/Wali Siswa',0,0,'C');
$pdf->SetXY($col2X, $currentY);
$pdf->Cell($colWidth,5,'Wali Kelas',0,1,'C');

$currentY = $currentY + 12;
$pdf->SetXY($col1X, $currentY);
$pdf->Cell($colWidth,4,'(_____________________)',0,0,'C');
$pdf->SetXY($col2X, $currentY);
$pdf->Cell($colWidth,4,'(_____________________)',0,1,'C');

$pdf->SetXY($col2X, $currentY + 4);
$pdf->SetFont('Arial','',8);
$pdf->Cell($colWidth,4,'Cimahi, '.date('d F Y'),0,1,'C');

$pdf->Output('I', 'Raport.pdf');
?>