<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <?php
        $a = $_GET;
        if (!isset($a["tanggal1"])) {
            $tanggal1 = date('Y-m-d', strtotime('-1 day'));
        } else {
            $tanggal1 = $a["tanggal1"];
        }
        if (!isset($a["tanggal2"])) {
            $tanggal2 = date('Y-m-d');
        } else {
            $tanggal2 = $a["tanggal2"];
        }

        if (empty($_GET['bulan'])) {
            $currentDate = date('Y-m-d');
            list($currentYear, $currentMonth) = explode('-', $currentDate);

            $bulan = $currentMonth;
            $tahun = $currentYear;
        } else {
            $bulan = substr($_GET['bulan'], -2);
            $tahun = substr($_GET['bulan'], 0, 4);
        }

        $ico = "SELECT * from menu where SUBSTRING_INDEX(link, '=', -1)='" . $a["module"] . "'";
        $exec = mysql_query($ico);
        while ($rico = mysql_fetch_assoc($exec)) {
            echo "<h2><i class='$rico[icon]'></i> Laporan $rico[namamenu]</h2>";
        }
        ?>
        <style>
            #laporan-absensi {
                max-width: 100%;
            }
        </style>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li class="active">
                <strong><?php echo $a["module"]; ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Laporan Abseni</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <label class="col-xs-1">Bulan</label>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <input type="month" class="form-control" id="bulan" name="bulan" onchange="tampildata()" autocomplete="off" value="<?php echo $tahun . '-' . $bulan; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <?php
                            $query = "CALL LaporanAbsensiSiswa($bulan,$tahun)";

                            $result = mysqli_query($koneksi, $query);
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered' id='laporan-absensi'>";
                                echo "<thead><tr><th>Barcode</th><th>Nama</th>";

                                // Tampilkan tanggal 1 hingga 30 sebagai header kolom
                                for ($i = 1; $i <= 30; $i++) {
                                    echo "<th>" . str_pad($i, 2, '0', STR_PAD_LEFT) . "</th>";
                                }

                                echo "</tr></thead>";

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['barcode'] . "</td>";
                                    echo "<td nowrap>" . $row['nama'] . "</td>";

                                    // Tampilkan data tanggal 1 hingga 30
                                    for ($i = 1; $i <= 30; $i++) {
                                        echo "<td align='center'>" . $row[str_pad($i, 2, '0', STR_PAD_LEFT)] . "</td>";
                                    }

                                    echo "</tr>";
                                }

                                echo "</table>";
                            } else {
                                echo "Tidak ada data absensi.";
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const bulan = document.querySelector('#bulan');

    function tampildata() {
        location.href = "home.php?module=lapabsensisiswa&bulan=" + $('input[name="bulan"]').val();
    }



    $(document).ready(function() {
        $('#laporan-absensi').DataTable({
            "scrollX": true,
            "pageLength": 100, // Jumlah default baris per halaman
            "ordering": false // Menghilangkan sorting
        });
    });
</script>