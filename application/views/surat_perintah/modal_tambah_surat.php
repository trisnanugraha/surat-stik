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
                    <input type="hidden" value="" name="id_surat_perintah" id="id_surat_perintah" />
                    <div class="form-group row">
                        <label for="nomor_surat" class="col-sm-2 col-form-label">Nomor Surat</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nomor_surat" id="nomor_surat" placeholder="Contoh : Sprin/123/III/HUK.1.1/2022">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pertimbangan" class="col-sm-2 col-form-label">Pertimbangan</label>
                        <div class="col-sm-10">
                            <div id="pertimbangan">
                                <p name="pertimbangan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dasar" class="col-sm-2 col-form-label">Dasar</label>
                        <div class="col-sm-10">
                            <div id="dasar">
                                <p name="dasar"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kepada" class="col-sm-2 col-form-label">Kepada</label>
                        <div class="col-sm-10">
                            <div id="kepada">
                                <p name="kepada"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="untuk" class="col-sm-2 col-form-label">Untuk</label>
                        <div class="col-sm-10">
                            <div id="untuk">
                                <p name="untuk"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tempat_terbit" class="col-sm-2 col-form-label">Dikeluarkan di</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="tempat_terbit" id="tempat_terbit">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_terbit" class="col-sm-2 col-form-label">Tanggal Terbit</label>
                        <div class="col-sm-3 kosong">
                            <input type="date" class="form-control" name="tanggal_terbit" id="tanggal_terbit">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="atas_nama" class="col-sm-2 col-form-label">Atas Nama</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="atas_nama" id="atas_nama">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="pangkat" class="col-sm-2 col-form-label">Pangkat</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="pangkat" id="pangkat">
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
                        <div class="col-sm-10">
                            <textarea class="form-control" name="judul_lampiran" id="judul_lampiran" rows="5" style="resize: none;"></textarea>
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
    let getPertimbangan;
    let getDasar;
    let getKepada;
    let getUntuk;
    let getTembusan;
    let getJudulLampiran;
    ClassicEditor
        .create(document.querySelector('#pertimbangan'))
        .then(pertimbanganBaru => {
            getPertimbangan = pertimbanganBaru;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#dasar'))
        .then(dasarBaru => {
            getDasar = dasarBaru;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#kepada'))
        .then(kepadaBaru => {
            getKepada = kepadaBaru;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#untuk'))
        .then(untukBaru => {
            getUntuk = untukBaru;
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
</script>