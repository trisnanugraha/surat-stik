<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_ibl" id="id_ibl" />
                    <div class="form-group row ">
                        <label for="no_surat" class="col-sm-4 col-form-label">Nomor Surat</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="no_surat" id="no_surat" placeholder="Contoh : SIJ/123/IX/2022/STIK">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="angkatan" class="col-sm-4 col-form-label">Angkatan</label>
                        <div class="col-sm-8 kosong">
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
                        <label for="tanggal" class="col-sm-4 col-form-label">Tanggal Cuti</label>
                        <div class="input-group col-sm-8 kosong">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            <input type="text" class="form-control float-right" name="tgl_cuti" id="tgl_cuti">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keperluan" class="col-sm-4 col-form-label">Keperluan</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="keperluan" id="keperluan">
                                <option value="" selected disabled>Pilih Keperluan</option>
                                <option value="Cuti Mahasiswa">Cuti Mahasiswa</option>
                                <option value="IBL Mahasiswa">IBL Mahasiswa</option>
                            </select>
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