<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="text-left">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="add()" title="Add Data"><i class="fas fa-plus"></i> Tambah Mahasiswa</button>
                            <button class="btn btn-sm btn-outline-success" title="Import Data" data-toggle="modal" data-target="#import-mahasiswa"><i class="fas fa-file-import"></i> Import Data</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelmhs" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info text-center">
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIM</th>
                                    <th>Sindikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<?php echo $modal_tambah_mahasiswa; ?>

<?php
$data['judul'] = 'Customer Data';
$data['url'] = 'mahasiswa/import';
$data['link'] = 'assets/template_import/Customer Template.xlsx';
$data['filename'] = 'Customer Template.xlsx';
echo show_my_modal('modals/modal_import', $data);
?>