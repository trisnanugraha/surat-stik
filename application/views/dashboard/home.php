<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo $user; ?></h3>

                        <p>Total User</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?php echo base_url('user'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?php echo $pendinguser; ?></h3>

                        <p>Total Aktivasi User</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <a href="<?php echo base_url('aktivasi-user'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $mahasiswa; ?></h3>

                        <p>Total Mahasiswa</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-id-card"></i>
                    </div>
                    <a href="<?php echo base_url('daftar-mahasiswa'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo $angkatan; ?></h3>

                        <p>Total Angkatan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <a href="<?php echo base_url('angkatan'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List Total Mahasiswa / Sindikat</h3>
                                <div class="card-tools">
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Sindikat</th>
                                            <th style="text-align: center;">Total Mahasiswa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($totalMahasiswa as $total) {
                                        ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $total->nama_sindikat; ?></td>
                                                <td style="text-align: center;"><?php echo $total->total; ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Log Activity System</h3>
                                <div class="card-tools">
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Run As</th>
                                            <th style="text-align: center;">IP Address</th>
                                            <th style="text-align: center;">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</section>