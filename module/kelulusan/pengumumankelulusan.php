<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h3>SISFO | SMP Negeri 02 Kaliwungu</h3>
        <ol class="breadcrumb">
            <li>
                <a href="home.php">Home</a>
            </li>
            <li class="active">
                <strong>Welcome</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <!-- <center><img alt="image" width="800" src="img/logo.png" /></center> -->
            <div class="middle-box text-center animated fadeInRightBig">
                <h3 class="font-bold">SISTEM INFORMASI KELULUSAN</h3>
                <div class="error-desc">
                    SMP Negeri 02 Kaliwungu
                    <br /><br>
                    <a href='module/kelulusan/cetakkelulusan.php?kode=<?php echo htmlspecialchars($_SESSION['iduser']); ?>' target="_blank" class='btn btn-primary btn-lg'>
                                    <i class='fa fa-file'></i> Cetak Pengumuman
                                </a>
                </div>
            </div>
        </div>
    </div>