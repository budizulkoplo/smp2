<?php
include "../../config/koneksi.php";

if (isset($_POST["submit"])) {
	$file_name = "";
	$a = $_POST;
	//echo $a["submit"];
	if (isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0) {
		function resizeImage($image_path, $max_width)
		{
			list($width, $height, $type) = getimagesize($image_path);

			$new_width = $max_width;
			$new_height = ($height / $width) * $new_width;

			$new_image = imagecreatetruecolor($new_width, $new_height);
			$source_image = imagecreatefromjpeg($image_path);

			imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

			return $new_image;
		}
	}

	if (isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0) {
		// Tentukan ukuran maksimum lebar
		$max_width = 300;
		$file_name = $_FILES['gambar']['name'];
		$file_size = $_FILES['gambar']['size'];
		$file_tmp = $_FILES['gambar']['tmp_name'];
		$file_type = $_FILES['gambar']['type'];

		// Pindahkan gambar yang diunggah ke direktori tujuan
		move_uploaded_file($file_tmp, "../../image/" . $file_name);

		// Resize gambar
		$resized_image = resizeImage("../../image/" . $file_name, 300);

		// Simpan gambar yang diresize ke direktori tujuan
		$resized_image_path = "../../image/rz_" . $file_name;
		imagejpeg($resized_image, $resized_image_path);

		// Hapus gambar sumber yang tidak diresize
		unlink("../../image/" . $file_name);

		// echo "Gambar berhasil diunggah dan diresize!";
	}




	switch ($a["submit"]) {
		case 'new':
			if ($file_name <> "") {
				$menuimg = "rz_" . $file_name;
				$insert_query = "INSERT INTO tblpegawai(nip,nik,nama,alamat,foto) 
								SELECT 
									'" . $a["txtnip"] . "','" . $a["txtnik"] . "','" . $a["txtnama"] . "','" . $a["txtalamat"] . "','" . $menuimg . "' ";

				$exec = mysqli_query($koneksi, $insert_query);		
			} else {
				$insert_query = "INSERT INTO tblpegawai(nip,nik,nama,alamat) 
								SELECT 
									'" . $a["txtnip"] . "','" . $a["txtnik"] . "','" . $a["txtnama"] . "','" . $a["txtalamat"] . "' ";
				$exec = mysqli_query($koneksi, $insert_query);
			}
			echo "INSERT INTO tblpegawai(nins,nik,nama,alamat) 
SELECT 
	'" . $a["txtnip"] . "','" . $a["txtnis"] . "','" . $a["txtnama"] . "','" . $a["txtalamat"] . "' ";

			header('Location: ../../home.php?module=pegawai');

			break;

		case 'edit':

			if ($file_name <> "") {
				$menuimg = "rz_" . $file_name;
				$exec = mysqli_query($koneksi, "UPDATE tblpegawai 
					SET nip = '" . $a["txtnip"] . "', nik = '" . $a["txtnik"] . "', nama = '" . $a["txtnama"] . "', alamat = '" . $a["txtalamat"] . "', 
				 	foto = '" . $menuimg . "'        
					WHERE idpegawai = '" . $a["txtid"] . "'");
			} else {
				$exec = mysqli_query($koneksi, "UPDATE tblpegawai 
					SET nip = '" . $a["txtnip"] . "', nik = '" . $a["txtnik"] . "', nama = '" . $a["txtnama"] . "', alamat = '" . $a["txtalamat"] . "'            
					WHERE idpegawai = '" . $a["txtid"] . "'");
			}

			header('location: ../../home.php?module=pegawai');
			break;
	}
}

if (isset($_GET["idpegawai"])) {
	$exec = mysqli_query($koneksi, "DELETE FROM tblpegawai WHERE idpegawai = '" . $_GET["idpegawai"] . "'");

	header('location: ../../home.php?module=pegawai');
}
