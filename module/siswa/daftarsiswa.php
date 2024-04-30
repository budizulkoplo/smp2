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
                <strong>Siswa</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar Siswa</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-12"><a href="home.php?module=formsiswa&submit=new" class="btn btn-primary"><i class="fa fa-save (alias)"></i> Tambah Siswa</a>
                            <a href="module/siswa/cetakkartuALL.php" class="btn btn-warning"><i class="fa fa-print (alias)"></i> Cetak Kartu All</a>
                        </div>
                        <div class="col-xs-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NISN</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * from tblsiswa";
                                    $exec = mysqli_query($koneksi, $query);

                                    while ($rs = mysqli_fetch_assoc($exec)) {
                                        echo "
                                    <tr>
                                    <td>" . $rs["nisn"] . "</td>
                                        <td>" . $rs["nik"] . "</td>
                                        <td>" . $rs["nama"] . "</td>
                                        <td>" . $rs["alamat"] . "</td>
                                        <td align='center' nowrap>
                                        <a href='module/siswa/cetakkartu.php?kode=" . $rs["idsiswa"] . "' class='btn btn-warning'><i class='fa fa-barcode'></i> Cetak Kartu<a>
                                        <a href='home.php?module=formsiswa&submit=edit&idsiswa=" . $rs["idsiswa"] . "' class='btn btn-info'><i class='fa fa-pencil-square'></i> Edit<a>
                                            <button onclick=hapus('" . $rs["idsiswa"] . "') class='btn btn-danger'><i class='fa fa-trash'></i> Hapus</button>
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
    function hapus(idsiswa) {
        var r = confirm("Hapus Data Siswa dengan id: '" + idsiswa + "' ?")

        if (r === true) {
            window.location.href = "module/siswa/simpansiswa.php?idsiswa=" + idsiswa;
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