<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <?php
        $a = $_GET;
        $ico = "SELECT * from menu where SUBSTRING_INDEX(link, '=', -1)='" . $a["module"] . "'";
        $exec = mysqli_query($koneksi, $ico);
        while ($rico = mysqli_fetch_assoc($exec)) {
            echo "<h2><i class='$rico[icon]'></i> $rico[namamenu]</h2>";
        }
        ?>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li class="active">
                <strong>Pegawai</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Pegawai</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-12"><a href="home.php?module=formpegawai&submit=new" class="btn btn-primary"><i class="fa fa-save (alias)"></i> Tambah Pegawai</a>
                            <a href="module/pegawai/cetakkartuALL.php" class="btn btn-warning"><i class="fa fa-print (alias)"></i> Cetak Kartu All</a>
                        </div>
                        <div class="col-xs-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * from tblpegawai";
                                    $exec = mysqli_query($koneksi, $query);

                                    while ($rs = mysqli_fetch_assoc($exec)) {
                                        echo "
                                    <tr>
                                    <td>" . $rs["nip"] . "</td>
                                        <td>" . $rs["nik"] . "</td>
                                        <td>" . $rs["nama"] . "</td>
                                        <td>" . $rs["alamat"] . "</td>
                                        <td align='center' nowrap>
                                        <a href='module/pegawai/cetakkartu.php?kode=" . $rs["idpegawai"] . "' class='btn btn-warning'><i class='fa fa-barcode'></i> Cetak Kartu<a>
                                        <a href='home.php?module=formpegawai&submit=edit&idpegawai=" . $rs["idpegawai"] . "' class='btn btn-info'><i class='fa fa-pencil-square'></i> Edit<a>
                                            <button onclick=hapus('" . $rs["idpegawai"] . "') class='btn btn-danger'><i class='fa fa-trash'></i> Hapus</button>
                                        </td>
                                    </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function hapus(idpegawai) {
        var r = confirm("Hapus Data Pegawai dengan id: '" + idpegawai + "' ?")

        if (r === true) {
            window.location.href = "module/pegawai/simpanpegawai.php?idpegawai=" + idpegawai;
        }
    }

    $(document).ready(function() {
        $(".table").dataTable({
            "autoWidth": false,
            "lengthChange": true,
            "pageLength": 100
        });
    })
</script>