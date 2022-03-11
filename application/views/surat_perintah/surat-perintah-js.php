<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var i = 1;

    $(document).ready(function() {

        table = $("#tabelsuratperintah").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Surat Perintah Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('suratperintah/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0, 1, 2, 3],
                    "className": 'text-center'
                }, {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },
                {
                    "targets": [-2],
                    "render": function(data, type, row) {
                        if (row[2] == 'Belum Terbit') {
                            return "<div class=\"badge bg-warning text-white text-wrap\">" + row[2] + "</div>"
                        } else if (row[2] == 'Diproses') {
                            return "<div class=\"badge bg-info text-white text-wrap\">" + row[2] + "</div>"
                        } else if (row[2] == 'Selesai') {
                            return "<div class=\"badge bg-success text-white text-wrap\">" + row[2] + "</div>"
                        }
                    }
                },
                {
                    "targets": [-1], //last column
                    "render": function(data, type, row) {
                        if (row[2] == "Belum Terbit") {
                            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Add\" onclick=\"add(" + row[3] + ")\"><i class=\"fas fa-plus\"></i> Tambah Surat Perintah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"generate(" + row[4] + ")\"><i class=\"fas fa-print\"></i> Nota Dinas</a></div>"
                        } else if (row[2] == "Diproses") {
                            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Send\" onclick=\"send(" + row[3] + ")\"><i class=\"fas fa-envelope\"></i> Kirim Surat</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[3] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[4] + ")\"><i class=\"fas fa-print\"></i> Surat Perintah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"generate(" + row[4] + ")\"><i class=\"fas fa-print\"></i> Nota Dinas</a></div>"
                        } else if (row[2] == "Selesai") {
                            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[4] + ")\"><i class=\"fas fa-print\"></i> Surat Perintah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"generate(" + row[4] + ")\"><i class=\"fas fa-print\"></i> Nota Dinas</a></div>"
                        }

                    },
                    "orderable": false, //set not orderable
                }
            ],
        });
        $("input[type=text]").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("input[type=date]").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        // $("select").change(function() {
        //     $(this).parent().parent().removeClass('has-error');
        //     $(this).next().empty();
        //     $(this).removeClass('is-invalid');
        // });
        $("select").not(".select2").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });

        var changeStatus = function() {
            var fne = $("#isCheck").prop("checked");
            $("#tanggal_pulang").prop("disabled", !fne);
        };

        $("#isCheck").on("change", changeStatus);
    });

    function tambah_data() {
        var new_id = i++;
        var html = '';
        html += '<tr id="' + new_id + '">';
        html += '<td class="id_mhs' + new_id + '" hidden>' + $("#nama_mhs").val() + '</td>';
        html += '<td class="mahasiswa' + new_id + '">' + $("#nama_mhs option:selected").text() + '</td>';
        html += '<td class="keterangan' + new_id + '">' + $("#keterangan").val() + '</td>';
        html += '<td><button type="button" onclick="hapus_data(this)" class="btn btn-md btn-danger btn_remove">Hapus</button></td>';
        html += '</tr>'
        $('#dynamic_field').append(html);
        $("#nama_mhs").val("disabled").change();
        $("#keterangan").val('');
    }

    function hapus_data(id) {
        id.closest('tr').remove();
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function print(id) {
        var go_to_url = '<?php echo base_url('suratperintah/print/'); ?>' + id;
        window.open(go_to_url, '_blank');
    }

    function generate(id) {
        var go_to_url = '<?php echo base_url('permohonansurat/generate/'); ?>' + id;
        window.open(go_to_url, '_blank');
    }

    //delete
    function del(id) {

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data Ini!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('permohonansurat/delete'); ?>",
                    type: "POST",
                    data: "id_permohonan_surat=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Permohonan Surat Berhasil Dihapus!'
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Delete Error!!.'
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

    function add(id) {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('[name="id_surat_perintah"]').val(id);
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Surat Perintah'); // Set Title to Bootstrap modal title
    }

    function send(id) {
        Swal.fire({
            title: 'Kirim Surat Perintah',
            text: "Pastikan Bahwa Surat Perintah Sudah Sesuai",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('surat-perintah/send'); ?>",
                    type: "POST",
                    data: "id_surat_perintah=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Surat Perintah Berhasil Terkirim!'
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Delete Error!!.'
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('suratperintah/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id_surat_perintah"]').val(data.id_surat_perintah);
                $('[name="nomor_surat"]').val(data.nomor_surat);
                if (data.pertimbangan != null) {
                    getPertimbangan.setData(data.pertimbangan);
                }
                if (data.dasar != null) {
                    getDasar.setData(data.dasar);
                }
                if (data.kepada != null) {
                    getKepada.setData(data.kepada);
                }
                if (data.untuk != null) {
                    getUntuk.setData(data.untuk);
                }
                $('[name="tempat_terbit"]').val(data.tempat_terbit);
                $('[name="tanggal_terbit"]').val(data.tanggal_terbit);
                $('[name="atas_nama"]').val(data.atas_nama);
                $('[name="nama_lengkap"]').val(data.nama_lengkap);
                $('[name="pangkat"]').val(data.pangkat);

                if (data.tembusan != null) {
                    getTembusan.setData(data.tembusan);
                }
                if (data.judul_lampiran != null) {
                    getJudulLampiran.setData(data.judul_lampiran);
                }
                // $('[name="judul_lampiran"]').val(data.judul_lampiran);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Surat Perintah'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function detail(id) {
        save_method = 'detail';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('permohonansurat/detail') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_permohonan_surat"]').val(data.id_permohonan_surat);
                $('[name="perihal"]').text(data.perihal);
                $('[name="tanggal"]').text(data.tanggal);
                $('[name="lokasi"]').text(data.lokasi);
                $('[name="tanggal_akhir"]').text(data.tanggal_akhir);
                $('[name="status_sekretaris"]').text(data.status_sekretaris);
                $('[name="status_kasenat"]').text(data.status_kasenat);
                $('[name="status_kakorwa"]').text(data.status_kakorwa);
                $('[name="keterangan_sekretaris"]').text(data.keterangan_sekretaris);
                $('[name="keterangan_kasenat"]').text(data.keterangan_kasenat);
                $('[name="keterangan_kakorwa"]').text(data.keterangan_kakorwa);

                $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Detail Permohonan Surat'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function save() {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        const pertimbangan = getPertimbangan.getData();
        const dasar = getDasar.getData();
        const kepada = getKepada.getData();
        const untuk = getUntuk.getData();
        const tembusan = getTembusan.getData();
        const judul_lampiran = getJudulLampiran.getData();

        var formData = {
            id_surat_perintah: $("#id_surat_perintah").val(),
            nomor_surat: $("#nomor_surat").val(),
            tempat_terbit: $("#tempat_terbit").val(),
            tanggal_terbit: $("#tanggal_terbit").val(),
            atas_nama: $("#atas_nama").val(),
            nama_lengkap: $("#nama_lengkap").val(),
            pangkat: $("#pangkat").val(),
            pertimbangan: pertimbangan,
            dasar: dasar,
            kepada: kepada,
            untuk: untuk,
            tembusan: tembusan,
            judul_lampiran: judul_lampiran
        };

        url = "<?php echo site_url('suratperintah/update') ?>";

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    getPertimbangan.setData('');
                    getDasar.setData('');
                    getKepada.setData('');
                    getUntuk.setData('');
                    getTembusan.setData('');
                    getJudulLampiran.setData('');
                    i = 1;
                    $('#modal_form').modal('hide');
                    reload_table();
                    if (save_method == 'add') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Surat Perintah Berhasil Disimpan!'
                        });
                    } else if (save_method == 'update') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Surat Perintah Berhasil Diubah!'
                        });
                    }
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function tutup() {
        $('#form')[0].reset();
        $('[id="perihal"]').val('');
        $("#tanggal_pulang").prop("disabled", true);
        $("#isCheck").prop("checked", false);
        getIsiSurat.setData('');
        getTembusan.setData('');
        getJudulLampiran.setData('');
        getIsiLampiran.setData('');
    }
</script>