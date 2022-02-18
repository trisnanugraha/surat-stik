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
        }

        #kop-surat {
            border-bottom: 0.5px solid black;
        }

        #kop-surat td {
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
            margin-left: 100px;
        }

        #tujuan-surat td {
            padding: 5px 0;
        }

        #tujuan-surat tr td:first-child {
            width: 100px;
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

        #penutup-surat {
            float: right;
            margin-right: 50px;
        }

        #penutup-surat td {
            padding: 10px 0;
            text-align: center;
        }

        #tembusan {
            float: left;
            margin-top: 100px;
        }

        #tembusan p {
            padding: 0;
            margin: 0;
        }

        #list-tembusan {
            margin-top: -10px;
            border-bottom: 0.5px solid black;
        }
    </style>
</head>

<body>
    <table id="kop-surat">
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
                <td>Nomor: B-ND/ 14 /I/2022/Senat PMIK</td>
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
                <td><?php echo $perihal; ?></td>
            </tr>
        </table>
        <div style="text-align: justify;"><?php echo $isi_surat; ?></div>
        <table id="penutup-surat">
            <tr>
                <td>Jakarta, ..................................</td>
            </tr>
        </table>
        <div id="tembusan">
            <p>Tembusan</p>
            <div id="list-tembusan">
                <?php echo $tembusan; ?>
            </div>
        </div>
    </div>
</body>

</html>