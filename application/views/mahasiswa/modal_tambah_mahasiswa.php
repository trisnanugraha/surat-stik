<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_mhs" />
                    <div class="form-group row ">
                        <label for="nama_mhs" class="col-sm-3 col-form-label">Nama Mahasiswa</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="nama_mhs" id="nama_mhs" placeholder="Contoh : John Doe">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="nim" id="nim" placeholder="Contoh : 12345789">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="angkatan" class="col-sm-3 col-form-label">Angkatan</label>
                        <div class="col-sm-9 kosong">
                            <select class="form-control" name="angkatan" id="angkatan">
                                <option value="" selected disabled>Pilih Angkatan</option>
                                <?php
                                foreach ($angkatan as $a) { ?>
                                    <option value="<?= $a->id_angkatan; ?>"><?= $a->nama_angkatan; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sindikat" class="col-sm-3 col-form-label">Sindikat</label>
                        <div class="col-sm-9 kosong">
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
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9 kosong">
                            <textarea class="form-control" name="alamat" id="alamat" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="telepon" class="col-sm-3 col-form-label">No. HP</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="telepon" id="telepon" placeholder="Contoh : 08123456789">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" id="btnCancel" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->