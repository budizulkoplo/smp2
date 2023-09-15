<body onload=window.print()>
  <script>
    function cetak() {
      window.print();
    }
  </script>
  <style>
    @media print {
      #print {
        display: none;
      }

      body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-size: 9px;
      }


    }
  </style>
  <div id="print">
    <button type="button" class="btn btn-default" onclick="cetak()">Print</button>
    <a href="../../home.php?module=siswa" id="back" class="btn btn-default">Kembali Ke Data Siswa</a><br><br>
  </div>
  <?php
  session_start();
  include('../../config/koneksi.php');
  include('../../config/fungsi_indotgl.php');
  include('../../config/bar128kartuanggota.php');

  $kode = $_GET['kode'];

  $exec = mysql_query("SELECT * FROM tblsiswa where idsiswa='" . $kode . "'");
  $arr = mysql_fetch_assoc($exec);


  $html = "
    
<!DOCTYPE html>
<html>
<head>
  <title>Kartu Absensi</title>
  <style>
    .card {
      width: 300px;
      height: 200px;
      border: 1px solid black;
      padding: 10px;
    }
    .card-title {
      font-size: 10pt;
      text-align: center;
      margin-bottom: 10px;
    }
    .card-logo {
      float: left;
      width: 40;
      height: 40px;
      margin-right: 10px;
    }
    .card-photo {
      float: left;
      width: 60;
      height: 80px;
      margin-right: 10px;
    }
    .card-info {
      float: left;
    }
    .card-info-item {
      margin-bottom: 5px;
      margin-left: 30px;
      font-size: 9pt;
    }
  </style>
</head>
<body>
  <div class='card'>
  <div class='card-logo'>
  <img height='40px' src='../../img/logopng.png' alt='Gambar' />
  </div>
    <h2 class='card-title'>
    KARTU ABSENSI<br>SMP Negeri 2 Kaliwungu</h2>
    <br>
    <div class='card-photo'>
    <img height='80px' src='../../image/" . $arr['foto'] . "' alt='Gambar' />
    </div>
    <div class='card-info'>
      <div class='card-info-item'><strong>NISN:</strong> " . $arr['nisn'] . "</div>
      <div class='card-info-item'><strong>Nama:</strong> " . $arr['nama'] . "</div>
      <div class='card-info-item'><strong>Alamat:</strong> " . $arr['alamat'] . "</div>
      <div class='card-info-item'>" . bar128(stripslashes($arr['nisn'])) . "</div>
      
    </div>
   
    <div style='clear: both;'></div>
  </div>
</body>
</html>
";

  echo $html;
  ?>