
<?php 
$prepare = "INSERT IGNORE INTO kelulusan (nisn, nama, statuskelulusan)
SELECT nisn, nama, 'Lulus' FROM tblsiswa WHERE kelas='9';";
$exec = mysqli_query($koneksi, $prepare);
?>

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

                        <div class="col-xs-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NISN</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Kelulusan</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php
                    $query = "SELECT * from tblsiswa a join kelulusan b on a.nisn=b.nisn where kelas='9' order by a.nisn asc";
                    $exec = mysqli_query($koneksi, $query);


                    while ($rs = mysqli_fetch_assoc($exec)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($rs["nisn"]); ?></td>
                            <td><?php echo htmlspecialchars($rs["nik"]); ?></td>
                            <td><?php echo htmlspecialchars($rs["nama"]); ?></td>
                            <td><?php echo htmlspecialchars($rs["alamat"]); ?></td>
                            <td align='center'>
                                <select name='txtkelas' class='form-control' onchange='updatekelulusan(this.value, "<?php echo htmlspecialchars($rs["nisn"]); ?>")' id='txtkelas'>
                                <?php
                                    $querys = "SELECT statuskelulusan FROM statuskelulusan";
                                    $execStatus = mysqli_query($koneksi, $querys) or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                    while ($ros = mysqli_fetch_assoc($execStatus)) {
                                        echo "<option value='" . htmlspecialchars($ros['statuskelulusan']) . "' " . ($ros['statuskelulusan'] === $rs['statuskelulusan'] ? 'selected' : '') . ">" . htmlspecialchars($ros['statuskelulusan']) . "</option>";
                                    }
                                ?>
                                </select>
                            </td>
                            <td align='center' nowrap>
                                <a href='module/kelulusan/cetakkelulusan.php?kode=<?php echo htmlspecialchars($rs["idsiswa"]); ?>' target="_blank" class='btn btn-warning'>
                                    <i class='fa fa-file'></i> Cetak Pengumuman
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    
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
function updatekelulusan(value, nisn) {
    // Buat objek XMLHttpRequest
    var xhr = new XMLHttpRequest();
    var url = "module/kelulusan/updatekelulusan.php"; // Nama file PHP yang akan memproses permintaan

    // Buka koneksi
    xhr.open("POST", url, true);

    // Atur header permintaan
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Buat handler untuk respon
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Log respon dari server
        }
    };

    // Kirim data
    var data = "status=" + value + "&nisn=" + nisn;
    xhr.send(data);
}

function myFunction(value, nisn) {
    console.log("Value: " + value);
    console.log("NISN: " + nisn);
    // Lakukan sesuatu dengan nilai ini
}
    $(document).ready(function() {
        $(".table").dataTable({
            "autoWidth": false,
            "lengthChange": true,
            "pageLength": 100
        });
    })
</script>
