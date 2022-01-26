<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">User Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" value="" name="id_user" />
                <div class="card-body">
                    <div class="form-group row ">
                        <label for="username" class="col-sm-4 col-form-label">Username</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="username" id="username" placeholder="contoh : johndoe">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="full_name" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="full_name" id="full_name" placeholder="contoh : John Doe">
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="password" class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8 kosong">
                            <input type="password" class="form-control " name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="kelas" class="col-sm-4 col-form-label">Kelas</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="kelas" id="kelas">
                                <option value="" selected disabled>Pilih Kelas</option>
                                <?php
                                foreach ($kelas as $k) { ?>
                                    <option value="<?= $k->id_kelas; ?>"><?= $k->nama_kelas; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="sindikat" class="col-sm-4 col-form-label">Sindikat</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="sindikat" id="sindikat">
                                <option value="" selected disabled>Pilih Sindikat</option>
                                <?php
                                foreach ($sindikat as $s) { ?>
                                    <option value="<?= $s->id_sindikat; ?>"><?= $s->nama_sindikat; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="jabatan" class="col-sm-4 col-form-label">Jabatan</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="jabatan" id="jabatan">
                                <option value="" selected disabled>Pilih Jabatan</option>
                                <?php
                                foreach ($jabatan as $j) { ?>
                                    <option value="<?= $j->id_jabatan; ?>"><?= $j->nama_jabatan; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="is_active" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="is_active" id="is_active">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Y">Aktif</option>
                                <option value="N">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="level" class="col-sm-4 col-form-label">Hak Akses</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="level" id="level">
                                <option value="" selected disabled>Pilih Hak Akses</option>
                                <?php
                                foreach ($user_level as $level) { ?>
                                    <option value="<?= $level->id_level; ?>"><?= $level->nama_level; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="batal()" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->