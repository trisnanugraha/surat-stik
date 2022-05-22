<html>

<head>
    <title>Print Nota Dinas</title>
    <style>
        @font-face {
            font-family: 'OpenSans-Regular';
            font-style: normal;
            font-weight: normal;
            src: url(<?php echo base_url() . '/assets/fonts/OpenSans-Regular.ttf'; ?>) format('truetype');
        }

        body {
            font-family: 'OpenSans-Regular';
            font-size: 10pt;
            margin-left: 20px;
            margin-right: 20px;
        }

        .kop-surat {
            border-bottom: 0.5px solid black;
        }

        .kop-surat td {
            text-align: center;
        }

        .body-surat {
            width: 100%;
        }

        #kepala-surat {
            margin: 5px auto 10px auto;
        }

        #kepala-surat td {
            text-align: center;
        }

        #kepala-surat tr:nth-child(2) td {
            border-top: 0.5px solid black;
        }

        #tujuan-surat {
            margin-left: 10%;
            width: 90%;
        }

        #tujuan-surat td {
            padding: 5px 0;
        }

        #tujuan-surat tr td:first-child {
            /* width: 100px; */
        }

        #tujuan-surat tr td:nth-child(2) {
            padding-right: 10px;
        }

        #tujuan-surat tr:nth-child(3) td:nth-child(3) {
            text-decoration: underline;
        }

        #isi-surat {
            width: 90%;
            margin: 50px 10px 10px 50px;
            text-align: justify;
        }

        #isi-surat td {
            padding: 10px 0;
        }

        .penutup-surat {
            float: right;
            margin-right: 50px;
        }

        .penutup-surat td {
            padding: 10px 0;
            text-align: center;
        }

        #tembusan {
            position: relative;
            top: 120px;
        }

        #tembusan p {
            padding: 0;
            margin: 0;
        }

        #list-tembusan {
            margin-top: -10px;
            width: 200px;
            border-bottom: 0.5px solid black;
        }

        .page {
            height: 100%;
        }

        .judul-lampiran {
            text-align: center;
            margin: 20px auto 10px auto;

        }

        .judul-lampiran tr td p {
            padding: 0;
            margin: 0;
        }

        .judul-lampiran td:last-child {
            padding-top: 0;
            padding-bottom: 0;
            margin-top: 0;
            margin-bottom: 0;
            border-bottom: 0.5px solid black;
        }

        .isi-lampiran {
            width: 100%;
            font-family: 'OpenSans-Regular';
        }

        .isi-lampiran table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .isi-lampiran thead th {
            font-family: 'OpenSans-Regular';
            padding-top: 10px;
            padding-bottom: 10px;
            border: 1px solid black;
            border-collapse: collapse;
            font-weight: 400;
        }

        .isi-lampiran tbody tr td {
            border: 1px solid black;
            border-collapse: collapse;
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: center;
        }

        .isi-lampiran tbody tr td:nth-child(2) {
            text-align: left;
        }

        .isi-lampiran tbody tr td p {
            margin: 5px auto;
        }

        .isi-lampiran tbody tr td:nth-child(2) {
            padding-left: 5px;
        }
    </style>
</head>

<body>
    <div class="page">
        <table class="kop-surat">
            <tr>
                <td>KORPS MAHASISWA</td>
            </tr>
            <tr>
                <td>SENAT PMIK</td>
            </tr>
        </table>
        <div class="body-surat">
            <table id="kepala-surat">
                <tr>
                    <td>NOTA DINAS</td>
                </tr>
                <tr>
                    <td>Nomor : <?php echo $surat->nomor_nota; ?></td>
                </tr>
            </table>
            <table id="tujuan-surat">
                <tr>
                    <td>Kepada</td>
                    <td>:</td>
                    <td>Yth. Kakorwa Bid Minwa STIK</td>
                </tr>
                <tr>
                    <td>Dari</td>
                    <td>:</td>
                    <td>Ketua Senat PMIK</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td><?php echo $surat->perihal; ?></td>
                </tr>
            </table>
            <div style="text-align: justify;"><?php echo $surat->isi_surat; ?></div>
            <div style="position: relative;">
                <table class="penutup-surat">
                    <tr>
                        <td>Jakarta, <?php echo $surat->tgl_diubah; ?></td>
                    </tr>
                    <tr>
                        <td><img style="width: 100px;" src="<?php echo base_url() . '/assets/qr-code/' . $surat->qr_nota; ?>"></td>
                    </tr>
                </table>
                <div id="tembusan">
                    <p>Tembusan</p>
                    <div id="list-tembusan">
                        <?php echo $surat->tembusan; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page" style="margin-bottom: 150px;">
        <table class="kop-surat">
            <tr>
                <td>KORPS MAHASISWA</td>
            </tr>
            <tr>
                <td>SENAT PMIK</td>
            </tr>
        </table>
        <table class="judul-lampiran">
            <tr>
                <td><?php echo $surat->judul_lampiran; ?></td>
            </tr>
        </table>
        <br>
        <div class="isi-lampiran">
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA LENGKAP</th>
                        <th>NIM</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($lampiran as $lp) {
                    ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $lp->nama_mhs ?></td>
                            <td><?php echo $lp->nim ?></td>
                            <td><?php echo $lp->keterangan ?></td>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>
        </div>
        <br>
        <table class="penutup-surat">
            <tr>
                <td>Jakarta, <?php echo $surat->tgl_diubah; ?></td>
            </tr>
            <tr>
                <td><img style="width: 100px;" src="<?php echo base_url() . '/assets/qr-code/' . $surat->qr_nota; ?>"></td>
            </tr>
        </table>
    </div>
</body>

</html>