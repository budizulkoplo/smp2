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
    <a href="../../home.php?module=pegawai" id="back" class="btn btn-default">Kembali ke data pegawai</a><br><br>
  </div>
  <?php
  session_start();
  include('../../config/koneksi.php');
  include('../../config/fungsi_indotgl.php');
  include('../../config/bar128kartupegawai.php');

  $kode = $_GET['kode'];

  $exec = mysql_query("SELECT * FROM tblpegawai where idpegawai='" . $kode . "'");

  // Tentukan jumlah kartu dalam satu kolom
  $kartuPerKolom = 2;
  $counter = 0;

  echo '<div class="kartu-kolom">'; // Mulai kolom pertama

  while ($arr = mysql_fetch_assoc($exec)) {
    $html = "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Kartu Absensi Pegawai</title>
        <style>
    .kartu {
      width: 300px;
      height: 200px;
      border: 1px solid black;
      padding: 10px;
      float: left; /* Mengatur kartu menjadi satu baris mendatar */
      margin-right: 10px; /* Jarak antara kartu */
      margin-bottom: 10px; /* Jarak antara baris kartu */
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
  <div class='kartu'>
  <div class='card-logo'>
  <img height='40px' src='../../img/logopng.png' alt='Gambar' />
  </div>
    <h2 class='card-title'>
    Kartu Absensi Pegawai<br>SMP Negeri 2 Kaliwungu</h2>
    <br>
    <div class='card-photo'>
    <img height='60px' src='../../image/" . $arr['foto'] . "' alt='Gambar' />
    </div>
    <div class='card-info'>
      <div class='card-info-item'><strong>Nama:</strong> " . $arr['nama'] . "</div>
    </div>
    <br><br><br><br><br>
    <div class='card-info-item'>" . bar128(stripslashes($arr['nip'])) . "</div>
  </div>
</body>
    </html>
    ";

    echo $html;
    $counter++;

    // Tutup kolom dan mulai kolom baru setelah mencapai jumlah kartu per kolom
    if ($counter % $kartuPerKolom == 0) {
      echo '</div>'; // Tutup kolom sebelumnya
      echo '<div class="kartu-kolom">'; // Mulai kolom baru
    }
  }

  // Tutup kolom terakhir jika belum ditutup
  if ($counter % $kartuPerKolom != 0) {
    echo '</div>';
  }
