<?php
session_start();
include "../config/koneksi.php";
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ABSENSI">


  <!-- Title -->
  <title>ABSENSI</title>

  <!-- Favicon icon -->
  <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">

  <link href="../css/sweetalert.min.css" rel="stylesheet">
  <link href="../css/animate.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <!-- Font -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet"> -->

  <!-- Custom Style -->
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    #waktu {
      color: darkgreen;
      /* Atur warna font menjadi hijau tua */
    }
  </style>

</head>

<body class="d-flex flex-column h-100">
  <?php
  $a = $_GET;
  if (!isset($a["barcode"])) {
    $barcode = "";
  } else {
    $barcode = $a["barcode"];
  }

  if ($barcode <> "") {
    $absen = "SELECT nisn as barcode1,nik as barcode2,nama, foto,CURRENT_TIMESTAMP() as waktu,
    DATE_FORMAT(NOW(), '%h:%i:%s %p') as jam_sekarang  FROM `tblsiswa` 
                  where nisn='" . $_GET['barcode'] . "'
                  union
                  SELECT nip,nik,nama, foto,CURRENT_TIMESTAMP() as waktu,
                  DATE_FORMAT(NOW(), '%h:%i:%s %p') as jam_sekarang  FROM `tblpegawai` 
                  where nip='" . $_GET['barcode'] . "'";
    $exec = mysql_query($absen);
    while ($r = mysql_fetch_assoc($exec)) {
      $nama = $r['nama'];
      $foto = $r['foto'];
      $jam = $r['jam_sekarang'];
    }
  } else {
    $nama = "";
    $foto = "";
    $jam = "";
  }
  // echo $absen;
  ?>

  <main class="flex-shrink-0">
    <div class="container pt-5">
      <div class="row justify-content-lg-center">
        <div class="col-lg-8 mb-4">
          <div class="px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
            <!-- judul halaman -->
            <div class="d-flex align-items-center me-md-auto">
              <div class="col-md-1">
                <img height='40px' src='../img/logopng.png' alt='Gambar' />
              </div>
              <div class="col-md-9">
                <h1 class="h5 pt-2">ABSENSI SMP NEGERI 2 KALIWUNGU</h1>
              </div>
              <div class="col-md-2">
                <strong><span id="waktu"></span></strong>
              </div>
            </div>
          </div>

          <div class="card border-0 shadow-sm">
            <div class="card-body text-left d-grid p-5">
              <div class="border border-success rounded-2 py-2 mb-5">
                <center>
                  <h5>Info Absensi</h5>
                </center>
                <div class="row">
                  <div class="col-md-3" style="padding-left: 20px;">Nama:</div>
                  <div class="col-md-8"><?= $nama ?></div>
                  <div class="col-md-3" style="padding-left: 20px;">Jam Absensi:</div>
                  <div class="col-md-8"><?= $jam ?></div>
                  <div class="col-md-3" style="padding-left: 20px;">Keterangan:</div>
                  <div class="col-md-8"></div>
                </div>
                <h1 id="antrian" class="display-1 fw-bold text-success text-center lh-1 pb-2"></h1>
              </div>
              <!-- button pengambilan nomor antrian -->
              <form onsubmit="absensi(event)">
                <input type="text" autocomplete="off" id="barcodescan" style="text-align: center;width: 100%;height: 80px;font-size: 20pt;font-family: fantasy;" placeholder="scan barcode absensi">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer mt-auto py-4">
    <div class="container-fluid">
      <!-- copyright -->
      <div class="copyright text-center mb-2 mb-md-0">
        &copy; 2023 - <a href="https://smpn2kaliwungu.sch.id" target="_blank" class="text-danger text-decoration-none">SMP Negeri 2 Kaliwungu</a>. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- jQuery Core -->
  <script src="../js/jquery-2.1.1.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="../js/plugins/datatables/jquery.datatables.js"></script>
  <script src="../js/plugins/datatables/datatables.bootstrap.js"></script>
  <script src="../js/plugins/datapicker/bootstrap-datepicker.js"></script>

  <!-- Custom and plugin javascript -->
  <script src="../js/inspinia.js"></script>
  <script src="../js/plugins/pace/pace.min.js"></script>
  <link href="../css/select2.min.css" rel="stylesheet" />
  <script src="../js/sweetalert.all.min.js"></script>
  <script src="../js/select2.min.js"></script>

  <!-- kode js nya disini -->
  <script type="text/javascript">
    function absensi(event) {
      event.preventDefault(); // Mencegah pengiriman form
      var barcode = document.getElementById("barcodescan");

      $.ajax({
        url: "inputabsen.php?barcode=" + barcode.value,
        type: "post",
        data: $(this).serialize(),
        success: function(msg) {
          data = $.parseJSON(msg);
          console.log(data);

          if (data["isError"] == 1) {
            Swal.fire({
              title: 'Error!',
              text: 'Barcode salah mohon periksa kembali',
              icon: 'error',
              confirmButtonText: 'Cool'
            })
            setInterval(function() {
              location.href = "index.php";
              barcodebuku.focus();
            }, 1000);
          } else {
            Swal.fire({
              title: 'Absen Berhasil!',
              text: data["Alert"],
              icon: 'success',
              confirmButtonText: 'Cool'
            })

            setInterval(function() {
              location.href = "index.php?barcode=" + barcode.value;
              barcodebuku.focus();
            }, 500);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
      });

      return false;
    }


    $(document).ready(function() {
      // tampilkan jumlah antrian
      $('#antrian').load('get_antrian.php');

      // proses insert data
      $('#insert').on('click', function() {
        $.ajax({
          type: 'POST', // mengirim data dengan method POST
          url: 'insert.php', // url file proses insert data
          success: function(result) { // ketika proses insert data selesai
            // jika berhasil
            if (result === 'Sukses') {
              // tampilkan jumlah antrian
              $('#antrian').load('get_antrian.php').fadeIn('slow');
            }
          },
        });
      });
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("barcodescan").focus();
    });


    function updateClock() {
      var now = new Date();
      var waktuElement = document.getElementById('waktu');
      waktuElement.innerHTML = now.toLocaleTimeString();
    }

    setInterval(updateClock, 1000); // Mengupdate setiap detik
  </script>
</body>

</html>