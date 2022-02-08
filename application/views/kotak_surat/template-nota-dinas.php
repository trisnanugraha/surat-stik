<html>

<head>
    <title>Print Nota Dinas</title>
    <style>
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
            margin: 50px auto 30px auto;
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
            padding: 10px 0;
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
            margin-top: 200px;
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
                <td>Yth. Dir. Prog. Sarjana STIK</td>
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
        <table id="isi-surat">
            <tr>
                <td>1.</td>
                <td>Rujukan :</td>
            </tr>
            <tr>
                <td></td>
                <td>a. Peraturan Ketua STIK Nomor 14 tahun 2011 tanggal 31 Desember 2011 tentang Tata Tertib Civitas Akademika STIK-PTIK;</td>
            </tr>
            <tr>
                <td></td>
                <td>b. Kalender Akademik Mahasiswa STIK Angkatan ke-79/WTP.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>
                    Sehubungan dengan kegiatan penelitian mahasiswa angkatan ke-79/WTP yang
                    dijadwalkan pada tanggal 24 Januari 2022 s.d. 4 Februari 2022 sesuai Kalender
                    Akademik, maka diperlukan waktu bagi mahasiswa untuk melaksanakan persiapan
                    pemberangkatan ke lokasi penelitian.
                </td>
            </tr>
            <tr>
                <td>3.</td>
                <td>
                    Dimohonkan kepada Ka berkenan untuk memberikan izin pemberangkatan ke lokasi
                    penelitian kepada mahasiswa angkatan ke-79/WTP pada hari Jumat, 21 Januari 2022,
                    namun demikian keputusan diserahkan kepada Ka.
                </td>
            </tr>
            <tr>
                <td>4.</td>
                <td>
                    Demikian untuk menjadi maklum.
                </td>
            </tr>
        </table>
        <table id="penutup-surat">
            <tr>
                <td>Jakarta, 29 Januari 2022</td>
            </tr>
            <tr>
                <td>KETUA SENAT PMIK</td>
            </tr>
            <tr>
                <td><img style="width: 100px;" src="<?php echo base_url() . '/assets/qr-code/1.png'; ?>"></td>
            </tr>
        </table>
        <table id="tembusan">
            <tr>
                <td colspan="2">Tembusan</td>
            </tr>
            <tr>
                <td>1.</td>
                <td>Ketua STIK.</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Waket Bid Minwa STIK.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Waket Bid Minwa STIK.</td>
            </tr>
        </table>
    </div>
</body>

</html>