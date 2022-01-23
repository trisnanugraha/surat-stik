<h2>
    <center>Data Penelitian</center>
</h2>
<table border="1" width="100%" style="border-collapse: collapse;">
    <tr>
        <th style="text-align:center; height: 30px;">No</th>
        <th>Ketua Peneliti</th>
        <th>Anggota</th>
        <th>Skema</th>
        <th>Judul Penelitian</th>
        <th>Komentar LPPM</th>
        <th>Komentar Reviewer</th>
    </tr>
    <?php
    $no = 1;
    foreach ($penelitian as $row) {
    ?>
        <tr>
            <td style="text-align:center;"><?php echo $no++; ?></td>
            <td style="padding: 0 10px;"><?php echo $row['ketua']; ?></td>
            <td style="padding: 0 10px;"><?php if ($row['anggota1'] != '') {
                                                echo $row['anggota1'];
                                            } ?>
                <?php if ($row['anggota2'] != '') {
                    echo '<br>' . $row['anggota2'];
                } ?>
                <?php if ($row['anggota3'] != '') {
                    echo '<br>' . $row['anggota3'];
                } ?>
                <?php if ($row['anggota4'] != '') {
                    echo '<br>' . $row['anggota4'];
                } ?>
                <?php if ($row['anggota5'] != '') {
                    echo '<br>' . $row['anggota5'];
                } ?>
            </td>
            <td style="padding: 0 10px;"><?php echo $row['skema']; ?></td>
            <td style="padding: 0 10px;"><?php echo $row['judul_penelitian']; ?></td>
            <td style="padding: 0 10px;"><?php echo $row['komentar_lppm']; ?></td>
            <td style="padding: 0 10px;"><?php echo $row['komentar_reviewer']; ?></td>
        </tr>
    <?php
    }
    ?>
</table>