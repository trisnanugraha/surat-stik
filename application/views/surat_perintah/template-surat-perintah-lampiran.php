<html>

<head>
    <title>Print Surat Perintah</title>
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
            float: left;
        }

        .kop-surat td {
            text-align: center;
        }

        .body-surat {
            width: 100%;
        }

        #kepala-surat {
            margin: 70px auto 10px auto;
        }

        #kepala-surat td {
            text-align: center;
        }

        #kepala-surat tr:nth-child(3) td {
            border-top: 0.5px solid black;
        }

        #tujuan-surat {
            /* margin-left: 10%; */
            /* width: 90%; */
            text-align: justify;
        }

        #tujuan-surat tr td p {
            padding: 0;
            margin: 0;
        }

        #tujuan-surat tr td ol {
            padding: 0;
            margin: 0;
            padding-left: 20px;
        }

        /* #tujuan-surat td {
            padding: 5px 0;
        } */

        #tujuan-surat tr td:first-child {
            padding-right: 0;
        }

        #tujuan-surat tr td:nth-child(2) {
            padding-right: 5px;
        }

        /* #tujuan-surat tr:nth-child(3) td:nth-child(3) {
            text-decoration: underline;
        } */

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
            /* margin-right: 50px; */
        }

        .penutup-surat td:nth-child(2) {
            /* padding: 10px 0; */
            padding-right: 30px;
            padding-left: 10px;
        }

        .penutup-surat tr:nth-child(3) td {
            border-top: 0.5px solid black;
        }

        .penutup-surat td {
            /* padding: 10px 0; */
            text-align: left;
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
            /* width: 150px; */
            border-bottom: 0.5px solid black;
        }

        .page {
            height: 100%;
        }

        .judul-lampiran {
            text-align: center;
            margin: 120px auto 10px auto;

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

        .kop-lampiran-surat {
            float: right;
            width: 40%;
        }

        .underline {
            border-bottom: 0.5px solid black;
        }

        /* .kop-lampiran-surat tr td:nth-child(3) {
            padding-left: 20px;
        } */
    </style>
</head>

<body>
    <div class="page">
        <table class="kop-surat">
            <tr>
                <td>LEMBAGA PENDIDIKAN DAN PELATIHAN POLRI</td>
            </tr>
            <tr>
                <td>SEKOLAH TINGGI ILMU KEPOLISIAN</td>
            </tr>
        </table>
        <div class="body-surat">
            <table id="kepala-surat">
                <tr>
                    <td><img style="width: 70px;" src="<?php echo base_url() . '/assets/foto/tri-brata.png' ?>"></td>
                </tr>
                <tr>
                    <td>SURAT PERINTAH</td>
                </tr>
                <tr>
                    <?php
                    if ($surat->nomor_surat != null) { ?>
                        <td>Nomor : <?php echo $surat->nomor_surat; ?></td>
                    <?php } else { ?>
                        <td>Nomor: .................................................................</td>
                    <?php }
                    ?>
                </tr>
            </table>
            <table id="tujuan-surat" border="0">
                <tr>
                    <td valign="top">Pertimbangan</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $surat->pertimbangan; ?></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Dasar</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="vertical-align: top;"><?php echo $surat->dasar; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center; padding-bottom: 10px;">DIPERINTAHKAN</td>
                </tr>

                <tr>
                    <td style="vertical-align: top;">Kepada</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="vertical-align: top;"><?php echo $surat->kepada; ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 5px;"></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Untuk</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="padding: 0; margin: 0;"><?php echo $surat->untuk; ?></td>
                </tr>
                <tr>
                    <td colspan="3">Selesai.</td>
                </tr>
            </table>
            <!-- <div style="text-align: justify;"><?php echo $surat->isi_surat; ?></div> -->
            <div style="position: relative;">
                <table class="penutup-surat" border="0">
                    <tr>
                        <td>Dikeluarkan di</td>
                        <td>:</td>
                        <td><?php echo $surat->tempat_terbit; ?></td>
                    </tr>
                    <tr>
                        <td>pada tanggal</td>
                        <td>:</td>
                        <td><?php echo $surat->tanggal_terbit; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <?php
                    if ($surat->status == 'Selesai') { ?>
                        <tr>
                            <td style="text-align: center; padding-top: 10px;" colspan="3"><img style="width: 100px;" src="<?php echo base_url() . '/assets/qr-code-sprin/' . $surat->qr_surat; ?>"></td>
                        </tr>
                    <?php }
                    ?>
                </table>
                <div id="tembusan">
                    <p>Tembusan :</p>
                    <div id="list-tembusan" style="padding-top: 20px; display: inline-block;">
                        <?php echo $surat->tembusan; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page" style="margin-bottom: 150px;">
        <table class="kop-surat">
            <tr>
                <td>LEMBAGA PENDIDIKAN DAN PELATIHAN POLRI</td>
            </tr>
            <tr>
                <td>SEKOLAH TINGGI ILMU KEPOLISIAN</td>
            </tr>
        </table>
        <table class="kop-lampiran-surat" border="0">
            <tr style="padding: 0; margin: 0;">
                <td colspan="3" style="padding: 0; margin: 0;">LAMPIRAN SPRIN KETUA STIK</td>
            </tr>
            <tr style="padding: 0; margin: 0;">
                <td colspan="3" class="underline" style="padding: 0; margin: 0;"></td>
            </tr>
            <tr style="padding: 0; margin: 0;">
                <td style="padding: 0; margin: 0;">NOMOR</td>
                <td style="padding: 0; margin: 0;">:</td>
                <td style="padding: 0; margin: 0;"><?php echo $surat->nomor_surat; ?></td>
            </tr>
            <tr style="padding: 0; margin: 0;">
                <td colspan="3" class="underline" style="padding: 0; margin: 0;"></td>
            </tr>
            <tr style="padding: 0; margin: 0;">
                <td style="padding: 0; margin: 0;">TANGGAL</td>
                <td style="padding: 0; margin: 0;">:</td>
                <td style="padding: 0; margin: 0;"><?php echo $surat->tanggal_terbit; ?></td>
            </tr>
            <tr style="padding: 0; margin: 0;">
                <td colspan="3" class="underline" style="padding: 0; margin: 0;"></td>
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
        <table class="penutup-surat" border="0">
            <tr>
                <td>Dikeluarkan di</td>
                <td>:</td>
                <td><?php echo $surat->tempat_terbit; ?></td>
            </tr>
            <tr>
                <td>pada tanggal</td>
                <td>:</td>
                <td><?php echo $surat->tanggal_terbit; ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <?php
            if ($surat->status == 'Selesai') { ?>
                <tr>
                    <td style="text-align: center; padding-top: 10px;" colspan="3"><img style="width: 100px;" src="<?php echo base_url() . '/assets/qr-code-sprin/' . $surat->qr_surat; ?>"></td>
                </tr>
            <?php }
            ?>
        </table>
    </div>
</body>

</html>