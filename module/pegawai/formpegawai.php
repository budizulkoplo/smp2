<?php
$submit = $_GET['submit'];

$idpegawai = isset($_GET["idpegawai"]) ? $_GET["idpegawai"] : "";

$exec = mysqli_query($koneksi, "SELECT * FROM tblpegawai where idpegawai = '" . $idpegawai . "'");

if ($submit == 'new') {
    $title = "Tambah Data Pegawai";

    $arr = mysqli_fetch_assoc($exec);
    $tgllahir = "";
    $read = "";
} else {
    $title = "Edit Data Pegawai dengan ID '" . $_GET["idpegawai"] . "'";
    $arr = mysqli_fetch_assoc($exec);

    $read = "";
}
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="home.php">Home</a>
            </li>
            <li class="active">
                <strong>Data pegawai</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $title; ?></h5>
                </div>
                <div class="ibox-content">
                    <form method="post" enctype="multipart/form-data" action="module/pegawai/simpanpegawai.php">
                        <div class="row">


                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type='hidden' name="txtid" class="form-control" value="<?php if ($arr) { echo $arr["idpegawai"]; } ?>" required />
                                    <input name="txtnip" class="form-control" value="<?php if ($arr) { echo $arr["nip"]; } ?>" />
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input name="txtnik" class="form-control" value="<?php if ($arr) { echo $arr["nik"]; } ?>" autocomplete="off" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input name="txtnama" class="form-control" value="<?php if ($arr) { echo $arr["nama"]; } ?>" autocomplete="off" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="txtalamat" rows="4" class="form-control" required><?php if ($arr) { echo $arr["alamat"]; } ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*" maxlength="1048576">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="btn-group">
                                    <a href="home.php?module=pegawai" class="btn btn-danger">Kembali</a>
                                    <button type="submit" name="submit" value="<?php echo $submit; ?>" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
        });
    })

    const fileInput = document.getElementById('gambar');
    fileInput.addEventListener('change', function() {
        const file = fileInput.files[0];
        const maxSize = 1048576; // 1MB
        if (file.size > maxSize) {
            alert('File terlalu besar. Maksimum 1MB.');
            fileInput.value = ''; // Menghapus file yang telah dipilih
        }
    });
</script>