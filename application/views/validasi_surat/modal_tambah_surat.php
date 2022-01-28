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
                    <input type="hidden" value="" name="id_permohonan_surat" />
                    <div class="form-group row ">
                        <label for="perihal" class="col-sm-3 col-form-label">Perihal</label>
                        <div class="col-sm-9 kosong">
                            <textarea class="form-control" name="perihal" id="perihal" rows="5" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_berangkat" class="col-sm-3 col-form-label">Tanggal Berangkat</label>
                        <div class="col-sm-9 kosong">
                            <input type="date" class="form-control" name="tanggal_berangkat">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_pulang" class="col-sm-3 col-form-label">Tanggal Pulang</label>
                        <div class="col-sm-9 kosong">
                            <input type="date" class="form-control" name="tanggal_pulang">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="lokasi" class="col-sm-3 col-form-label">Lokasi</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="lokasi" id="lokasi">
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