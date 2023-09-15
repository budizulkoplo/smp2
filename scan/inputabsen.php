<?php
session_start();
include "../config/koneksi.php";

if (isset($_GET['barcode'])) {
	// echo $_POST['txtUser'];


	$query = "SELECT nisn as barcode1,nik as barcode2,nama, foto, CURRENT_TIMESTAMP() as waktu,
    DATE_FORMAT(NOW(), '%h:%i:%s %p') as jam_sekarang,CASE
    WHEN TIME(NOW()) < '12:00:00' THEN 'Absen Masuk'
    ELSE 'Absen Pulang'
  END AS status_absen, CASE
    WHEN TIME(NOW()) < '12:00:00' THEN 'in'
    ELSE 'out'
  END AS `status`  FROM `tblsiswa` 
	where nisn='" . $_GET['barcode'] . "'
	union
	SELECT nip,nik,nama, foto, CURRENT_TIMESTAMP() as waktu,
    DATE_FORMAT(NOW(), '%h:%i:%s %p') as jam_sekarang,CASE
    WHEN TIME(NOW()) < '12:00:00' THEN 'Absen Masuk'
    ELSE 'Absen Pulang'
  END AS status_absen, CASE
  WHEN TIME(NOW()) < '12:00:00' THEN 'in'
  ELSE 'out'
END AS `status`  FROM `tblpegawai` 
	where nip='" . $_GET['barcode'] . "'";


	$exec = mysql_query($query);

	$cnt = mysql_num_rows($exec);
	$rs = mysql_fetch_assoc($exec);
	if ($rs['status'] == "in") {
		$absenmasuk = "update kehadiran set jammasuk=TIME(NOW()) where tanggal=CURDATE() and barcode='" . $_GET['barcode'] . "'";
		$exec = mysql_query($absenmasuk);
		// echo $absenmasuk;
	}
	if ($rs['status'] == "out") {
		$absenpulang = "update kehadiran set jampulang=TIME(NOW()) where tanggal=CURDATE() and barcode='" . $_GET['barcode'] . "'";
		$exec = mysql_query($absenpulang);
	}

	if ($cnt > 0) {
		$data["isError"] = "0";
		$data["Alert"] = "Absensi Berhasil";
		$data["barcode"] = $rs['barcode1'];
		$data["nama"] = $rs['nama'];
		$data["foto"] = $rs['foto'];
		$data["waktu"] = $rs['waktu'];
		$data["jam_sekarang"] = $rs['jam_sekarang'];
		$data["status_absen"] = $rs['status_absen'];
	} else {
		$data["isError"] = "1";
		$data["Alert"] = "Absensi Gagal!";
	}

	echo json_encode($data);
}
