<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form_detail" class="form-horizontal">
                    <input type="hidden" value="" name="id_permohonan_surat" />
                    <div class="form-group row ">
                        <label for="perihal" class="col-sm-3 col-form-label">Perihal</label>
                        <div class="col-sm-9">
                            <p class="form-control my-0" name="perihal" id="perihal"></p>
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
                    <?php
                    if ($level == 'Admin') { ?>
                        <div class="form-group row ">
                            <label for="status_sekretaris" class="col-sm-3 col-form-label">Validasi Sekretaris</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status_sekretaris" id="status_sekretaris">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan_sekretaris" class="col-sm-3 col-form-label">Keterangan Sekretaris</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="keterangan_sekretaris" id="keterangan_sekretaris" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <?php
                    if ($level == 'Kasenat') { ?>
                        <div class="form-group row ">
                            <label for="status_kasenat" class="col-sm-3 col-form-label">Validasi Kasenat</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status_kasenat" id="status_kasenat">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan_kasenat" class="col-sm-3 col-form-label">Keterangan Kasenat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="keterangan_kasenat" id="keterangan_kasenat" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <?php
                    if ($level == 'Kakorwa') { ?>
                        <div class="form-group row ">
                            <label for="status_kakorwa" class="col-sm-3 col-form-label">Validasi Kakorwa</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status_kakorwa" id="status_kakorwa">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan_kakorwa" class="col-sm-3 col-form-label">Keterangan Kakorwa</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="keterangan_kakorwa" id="keterangan_kakorwa" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    <?php }
                    ?>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                    <button class="btn btn-outline-secondary" onclick="tutup()" data-dismiss="modal"> Tutup</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->