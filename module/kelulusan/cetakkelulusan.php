<?php
session_start();
include('../../config/koneksi.php');
include('../../config/fungsi_indotgl.php');
include('../../config/bar128kartuanggota.php');

$kode = $_GET['kode'];
$tahunlalu=date('Y') - 1;

$execconfig = mysqli_query($koneksi, "SELECT * FROM config limit 1");
$r = mysqli_fetch_assoc($execconfig);

$exec = mysqli_query($koneksi, "SELECT * FROM tblsiswa a join kelulusan b on a.nisn=b.nisn where idsiswa='" . $kode . "'");
$arr = mysqli_fetch_assoc($exec);

require_once __DIR__ . '/../../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);

$html = "
<!DOCTYPE html>
<html>
<head>
  <title>Pengumuman Kelulusan</title>
  <style>
    body {
      font-family: sans-serif;
    }
    .card-container {
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      box-sizing: border-box;
    }
    .card {
    width: 100%;
      background-color: #fff;
    }
    .card-title {
      font-size: 10pt;
      text-align: center;
    }
    .card-center {
        font-size: 10pt;
        text-align: center;
      }
    .card-logo {
      float: left;
      width: 60px;
      height: 60px;
      margin-right: 10px;
    }
    .card-kiri {
      float: left;
      margin-left: 30px;
      width: 60px;
      margin-right: 10px;
      font-size: 9pt;
    }
    .card-info {
      float: left;
    }
    .card-info-item {
      margin-bottom: 5px;
      margin-left: 30px;
      font-size: 9pt;
    }
    .card-info-dtl {
        margin-bottom: 5px;
        margin-left: 130px;
        font-size: 9pt;
      }
  </style>
</head>
<body>
  <div class='card-container'>
    <div class='card'>
      <div class='card-logo'>
        <img src='logokendal.jpg' />
      </div>
      <div class='card-title'>
      <h4>PEMERINTAH KABUPATEN KENDAL<br>
      DINAS PENDIDIKAN DAN KEBUDAYAAN<br>
      SMP NEGERI 2 KALIWUNGU</h4>
      Alamat : Jl. Srogo Ds. Plantaran Kec. Kaliwungu Selatan  Kab. Kendal, Kode Pos 51372<br>
      </div>
      <hr>
      
      <div class='card-info'>
        <div class='card-center'>
        PENGUMUMAN KELULUSAN<br>
        Nomor : 423.7/249/SMP2Klw<br>
        <h3>SMP NEGERI 2 KALIWUNGU<br>
        TAHUN PELAJARAN ".$tahunlalu."/".date('Y')."</h3>
        </div>
        Yang bertanda tangan di bawah ini, Kepala Sekolah SMP Negeri 2 Kaliwungu Kabupaten Kendal, Provinsi Jawa Tengah menerangkan bahwa: <br>
        <br>
        <div class='card-kiri'><strong>Nama</strong> </div><div class='card-info-dtl'>: " . htmlspecialchars($arr['nama']) . "</div>
        <div class='card-kiri'><strong>Tgl Lahir</strong> </div><div class='card-info-dtl'>: " . htmlspecialchars($arr['tgllahir']) . "</div>
        <div class='card-kiri'><strong>NISN</strong> </div><div class='card-info-dtl'>: " . htmlspecialchars($arr['nisn']) . "</div>
        <div class='card-kiri'><strong>Kelas</strong> </div><div class='card-info-dtl'>: " . htmlspecialchars($arr['rombel']) . "</div>
        <div class='card-kiri'><strong>Alamat</strong> </div><div class='card-info-dtl'>: " . htmlspecialchars($arr['alamat']) . "</div>
        <br>
        <div class='card-center'>
        DINYATAKAN<br>
        <h1>".strtoupper($arr['statuskelulusan'])."</h1>
        </div><br>
        Dari satuan pendidikan berdasarkan kriteria kelulusan SMP Negeri 2 Kaliwungu Kabupaten Kendal Tahun Pelajaran ".$tahunlalu."/".date('Y').".
        <br><br>
        Demikian pengumuman kelulusan ini diberikan. Untuk surat keterangan lulus dan ijazah akan disampaikan dikemudian hari.<br><br>
        
        <div class='card-center'>
        Kendal, ".date('d/m/Y')."
        <br>
        Kepala Sekolah<br><br><br><br><br>
        <STRONG><u>" . $r['kepalasekolah'] . "</u></STRONG><br>
        " . $r['pangkat'] . "<br>
        " . $r['nip'] . "
      </div>
      <div style='clear: both;'></div>
    </div>
  </div>
</body>
</html>
";

// echo $html;

$mpdf->setFooter('halaman {PAGENO}');
$mpdf->SetDisplayMode('fullpage');
 $mpdf->WriteHTML($html);
 $mpdf->Output('PengumumanKelulusan.pdf', 'I');

exit;
?>
