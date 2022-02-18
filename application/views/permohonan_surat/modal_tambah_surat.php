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
                    <input type="hidden" value="" name="id_permohonan_surat" id="id_permohonan_surat" />
                    <div class="form-group row">
                        <label for="perihal" class="col-sm-2 col-form-label">Perihal</label>
                        <div class="col-sm-10 kosong">
                            <textarea class="form-control" name="perihal" id="perihal" rows="5" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_berangkat" class="col-sm-2 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-3 kosong">
                            <input type="date" class="form-control" name="tanggal_berangkat" id="tanggal_berangkat">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_pulang" class="col-sm-2 col-form-label">Tanggal Selesai</label>
                        <div class="col-sm-3 kosong">
                            <input type="date" class="form-control" name="tanggal_pulang" id="tanggal_pulang" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="isCheck">
                                <label class="custom-control-label" for="isCheck" style="font-weight: 400;">Kegiatan Berlangsung Lebih Dari 1 Hari</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="lokasi" id="lokasi">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="isi_surat" class="col-sm-2 col-form-label">Isi Surat</label>
                        <div class="col-sm-10">
                            <div id="isi_surat">
                                <p name="isi_surat"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tembusan" class="col-sm-2 col-form-label">Tembusan</label>
                        <div class="col-sm-10">
                            <div id="tembusan">
                                <p name="tembusan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="judul_lampiran" class="col-sm-2 col-form-label">Judul Lampiran</label>
                        <div class="col-sm-10 kosong">
                            <textarea class="form-control" name="judul_lampiran" id="judul_lampiran" rows="5" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isi_lampiran" class="col-sm-2 col-form-label">Isi Lampiran</label>
                        <div class="col-sm-10">
                            <div id="isi_lampiran">
                                <p name="isi_lampiran"></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" id="btnCancel" class="btn btn-danger" onclick="tutup()" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script>
    let getIsiSurat;
    let getTembusan;
    let getJudulLampiran;
    let getIsiLampiran;
    ClassicEditor
        .create(document.querySelector('#isi_surat'))
        .then(isiSuratBaru => {
            getIsiSurat = isiSuratBaru;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#tembusan'))
        .then(tembusanBaru => {
            getTembusan = tembusanBaru;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#judul_lampiran'))
        .then(judulLampiranBaru => {
            getJudulLampiran = judulLampiranBaru;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#isi_lampiran'))
        .then(isiLampiranBaru => {
            getIsiLampiran = isiLampiranBaru;
        })
        .catch(error => {
            console.error(error);
        });
</script>