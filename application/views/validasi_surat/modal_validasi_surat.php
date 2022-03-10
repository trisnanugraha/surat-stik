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
                    <!-- <div class="form-group row ">
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
                    </div> -->
                    <?php
                    if ($level == 'Sekretaris') { ?>
                        <input type="hidden" value="" name="id_validasi_sekretaris" />
                        <div class="form-group row">
                            <label for="status_sekretaris" class="col-sm-3 col-form-label">Validasi Sekretaris</label>
                            <div class="col-sm-9">
                                <select class="form-control validasi_sekretaris" name="status_sekretaris" id="status_sekretaris">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row sekretaris">
                            <label for="nomor_nota" class="col-sm-3 col-form-label">Nomor Nota Dinas</label>
                            <div class="col-sm-9">
                                <input type="text" name="nomor_nota" id="nomor_nota" class="form-control" placeholder="Contoh : B-ND/174/XII/2021/Senat PMIK" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_sekretaris" class="col-sm-3 col-form-label">Catatan Sekretaris</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan_sekretaris" id="catatan_sekretaris" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <?php
                    if ($level == 'Kasenat') { ?>
                        <input type="hidden" value="" name="id_validasi_kasenat" />
                        <div class="form-group row ">
                            <label for="status_kasenat" class="col-sm-3 col-form-label">Validasi Kasenat</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status_kasenat" id="status_kasenat">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_kasenat" class="col-sm-3 col-form-label">Catatan Kasenat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan_kasenat" id="catatan_kasenat" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <?php
                    if ($level == 'Kakorwa') { ?>
                        <input type="hidden" value="" name="id_validasi_kakorwa" />
                        <div class="form-group row ">
                            <label for="status_kakorwa" class="col-sm-3 col-form-label">Validasi Kakorwa</label>
                            <div class="col-sm-9">
                                <select class="form-control validasi_kakorwa" name="status_kakorwa" id="status_kakorwa">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_kakorwa" class="col-sm-3 col-form-label">Keterangan Kakorwa</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan_kakorwa" id="catatan_kakorwa" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                        <div class="form-group row staffkorwa">
                            <label for="kirim_ke" class="col-sm-3 col-form-label">Kirim Ke</label>
                            <div class="col-sm-9">
                                <select name="kirim_ke" id="kirim_ke" class="form-control select2 selectpicker" data-live-search="true">
                                    <option value="disabled" selected disabled>-- Pilih Staff --</option>
                                    <?php
                                    foreach ($staffkorwa as $staff) { ?>
                                        <option value="<?= $staff->id_user; ?>"><?= $staff->full_name; ?></option>
                                    <?php } ?>
                                </select>
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