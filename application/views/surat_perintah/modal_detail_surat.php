<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" onclick="tutup()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_kompetisi" />
                    <div class="form-group row ">
                        <label for="perihal" class="col-sm-3 col-form-label">Perihal</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="perihal" id="perihal" style="height: 100px;"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="tanggal" id="tanggal"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="lokasi" class="col-sm-3 col-form-label">Lokasi</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="lokasi" id="lokasi"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="status_sekretaris" class="col-sm-3 col-form-label">Validasi Sekretaris</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="status_sekretaris" id="status_sekretaris"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan_sekretaris" class="col-sm-3 col-form-label">Catatan Sekretaris</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="keterangan_sekretaris" id="keterangan_sekretaris" style="height: 100px;"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="status_kasenat" class="col-sm-3 col-form-label">Validasi Kasenat</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="status_kasenat" id="status_kasenat"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan_kasenat" class="col-sm-3 col-form-label">Keterangan Kasenat</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="keterangan_kasenat" id="keterangan_kasenat" style="height: 100px;"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="status_kakorwa" class="col-sm-3 col-form-label">Validasi Kakorwa</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="status_kakorwa" id="status_kakorwa"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan_kakorwa" class="col-sm-3 col-form-label">Keterangan Kakorwa</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="keterangan_kakorwa" id="keterangan_kakorwa" style="height: 100px;"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button class="btn btn-primary" onclick="tutup()" data-dismiss="modal"> Tutup</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->