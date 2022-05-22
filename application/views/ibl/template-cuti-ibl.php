<html>

<head>
    <title>IBL - Cuti.pdf</title>
    <style>
        @font-face {
            font-family: 'OpenSans-Regular';
            font-style: normal;
            font-weight: normal;
            src: url(<?php echo base_url() . '/assets/fonts/OpenSans-Regular.ttf'; ?>) format('truetype');
        }

        body {
            font-family: 'OpenSans-Regular';
            font-size: 8pt;
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
            position: absolute;
            bottom: 20px;
        }

        #tembusan p {
            padding: 0;
            margin: 0;
        }

        #list-tembusan {
            margin-top: -10px;
            border-bottom: 0.5px solid black;
        }

        .page {
            height: 100%;
        }

        .rata-atas {
            vertical-align: top;
        }

        .rata-atas-tengah {
            vertical-align: top;
            text-align: center;
        }

        .rata-atas-20 {
            vertical-align: top;
            width: 20px;
        }
    </style>
</head>

<body>
    <?php
    foreach ($mahasiswa as $mhs) { ?>

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
                        <td><img src="<?php echo base_url() . '/assets/foto/tri-brata.png' ?>"></td>
                    </tr>
                    <tr>
                        <td>SURAT IJIN JALAN</td>
                    </tr>
                    <tr>
                        <?php
                        if ($surat->no_surat != null) { ?>
                            <td>Nomor : <?php echo $surat->no_surat; ?></td>
                        <?php } else { ?>
                            <td>Nomor: .................................................................</td>
                        <?php }
                        ?>
                    </tr>
                </table>
                <table id="tujuan-surat" border="0">
                    <tr>
                        <td colspan="4" valign="top">Diberikan kepada :</td>
                    </tr>
                    <tr>
                        <td class="rata-atas">1.</td>
                        <td class="rata-atas">Nama</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo $mhs->nama_mhs; ?></td>
                    </tr>
                    <tr>
                        <td class="rata-atas">2.</td>
                        <td class="rata-atas">No.Mhs/Sin</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo $mhs->nim; ?>/<?php echo $mhs->nama_sindikat; ?></td>
                    </tr>
                    <tr>
                        <td class="rata-atas">3.</td>
                        <td class="rata-atas">Jabatan</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas">Mahasiswa S1 STIK Angkatan Ke-<?php echo $mhs->nama_angkatan; ?></td>
                    </tr>
                    <tr>
                        <td class="rata-atas">4.</td>
                        <td class="rata-atas">Kesatuan/Alamat</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas">STIK Jl. Tirtayasa Raya No.6 Kebayoran Baru, Jakarta Selatan</td>
                    </tr>
                    <tr>
                        <td class="rata-atas">5.</td>
                        <td class="rata-atas">Berpergian Dari</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas">Jakarta</td>
                    </tr>
                    <tr>
                        <td class="rata-atas">6.</td>
                        <td class="rata-atas">Ke (Alamat Lengkap)</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo $mhs->alamat; ?></td>
                    </tr>
                    <tr>
                        <td class="rata-atas">7.</td>
                        <td class="rata-atas">Lamanya Ijin</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo $surat->total_cuti; ?> (<?php echo $surat->terbilang; ?>) Hari</td>
                    </tr>
                    <tr>
                        <td class="rata-atas"></td>
                        <td class="rata-atas">- Berangkat</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo tgl_indonesia_ibl($surat->tgl_berangkat); ?></td>
                    </tr>
                    <tr>
                        <td class="rata-atas"></td>
                        <td class="rata-atas">- Kembali</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo tgl_indonesia_ibl($surat->tgl_kembali); ?></td>
                    </tr>
                    <tr>
                        <td class="rata-atas">8.</td>
                        <td class="rata-atas">Keperluan</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo $surat->keperluan; ?></td>
                    </tr>
                    <tr>
                        <td class="rata-atas">9.</td>
                        <td class="rata-atas">Menggunakan Angkutan</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas">Darat dan Udara</td>
                    </tr>
                    <tr>
                        <td class="rata-atas">10.</td>
                        <td class="rata-atas">No. Telepon</td>
                        <td class="rata-atas-tengah">:</td>
                        <td class="rata-atas"><?php echo $mhs->no_hp; ?></td>
                    </tr>
                </table>
                <br>
                <table id="keterangan-surat" border="0">
                    <tr>
                        <td colspan="2"><u>PERHATIAN :</u></td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">1.</td>
                        <td class="rata-atas">Segera melapor ke kantor Polisi terdekat setelah tiba di tempat tujuan dan berangkat dari tempat tujuan;</td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">2.</td>
                        <td class="rata-atas">Jika mendapat halangan, harap segera melaporkan kepada Waket Bid Minwa STIK u.p. Kakorwa Bid Minwa STIK pada kesempatan pertama;</td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">3.</td>
                        <td class="rata-atas">Selama berada di alamat tujuan, mahasiswa tetap menjaga tata tertib sebagai Mahasiswa STIK;</td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">4.</td>
                        <td class="rata-atas">Mahasiswa yang izin meninggalkan jam kuliah, diwajibkan membuat resume mata kuliah yang tidak diikuti;</td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">5.</td>
                        <td class="rata-atas">Dilarang membawa senjata api;</td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">6.</td>
                        <td class="rata-atas">Menerapkan protokol kesehatan yang berlaku secara ketat</td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">7.</td>
                        <td class="rata-atas">Surat Ijin Jalan ini berlaku hanya untuk anggota yang tersebut dalam Surart Ijin Jalan ini;</td>
                    </tr>
                    <tr>
                        <td class="rata-atas-20">8.</td>
                        <td class="rata-atas">Surat Ijin Jalan ini diserahkan ke Korps Mahasiswa Bid Minwa STIK, setelah kembali dari melaksanakan ijin.</td>
                    </tr>
                </table>
                <br>
                <table class="penutup-surat" border="0">
                    <tr>
                        <td>Dikeluarkan di</td>
                        <td>:</td>
                        <td>Jakarta</td>
                    </tr>
                    <tr>
                        <td>pada tanggal</td>
                        <td>:</td>
                        <td><?php echo $surat->tgl_dibuat; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding-top: 10px;" colspan="3"><img style="width: 100px;" src="<?php echo base_url() . '/assets/qr-code-ibl/' . $surat->id_ibl . '.png'; ?>"></td>
                    </tr>
                </table>
                <div id="tembusan">
                    <p>Tembusan :</p>
                    <div id="list-tembusan" style="padding-top: 20px;">
                        <div>1. Ketua STIK.</div>
                        <div>2. Waket Bidminwa STIK.</div>
                        <div>3. Dir. Program Sarjana STIK.</div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    ?>
</body>

</html>