<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        table = $("#tabelsurat").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Permohonan Surat Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('permohonansurat/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, 3, 4, 5],
                "className": 'text-center'
            }, {
                "searchable": false,
                "orderable": false,
                "targets": 0
            }, {
                "targets": [-2],
                "render": function(data, type, row) {
                    if (row[4] == "Diproses") {
                        return "<div class=\"badge bg-info text-white text-wrap\">" + row[4] + "</div>"
                    } else if (row[4] == "Butuh Perbaikan") {
                        return "<div class=\"badge bg-warning text-white text-wrap\">" + row[4] + "</div>"
                    } else if (row[4] == "Disetujui") {
                        return "<div class=\"badge bg-success text-white text-wrap\">" + row[4] + "</div>"
                    } else if (row[4] == "Ditolak") {
                        return "<div class=\"badge bg-danger text-white text-wrap\">" + row[4] + "</div>"
                    }
                }
            }, {
                "targets": [-1], //last column
                "render": function(data, type, row) {
                    if (row[4] == "Diproses") {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail(" + row[5] + ")\"><i class=\"fas fa-eye\"></i> Detail</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[5] + ")\"><i class=\"fas fa-print\"></i> Preview</a></div>"
                    } else if (row[4] == "Butuh Perbaikan") {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[5] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail(" + row[5] + ")\"><i class=\"fas fa-eye\"></i> Detail</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[5] + ")\"><i class=\"fas fa-print\"></i> Preview</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"del(" + row[5] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>"
                    } else if (row[4] == "Ditolak") {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail(" + row[5] + ")\"><i class=\"fas fa-eye\"></i> Detail</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[5] + ")\"><i class=\"fas fa-print\"></i> Preview</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"del(" + row[5] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>"
                    } else if (row[4] == "Disetujui") {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail(" + row[5] + ")\"><i class=\"fas fa-eye\"></i> Detail</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[5] + ")\"><i class=\"fas fa-print\"></i> Preview</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Print\" onclick=\"generate(" + row[5] + ")\"><i class=\"fas fa-print\"></i> Print</a></div>"
                    }

                },
                "orderable": false, //set not orderable
            }],
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
        $("select").change(function() {
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
        var go_to_url = '<?php echo base_url('permohonansurat/print/'); ?>' + id;
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

    function add() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('[id="perihal"]').val('');
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Permohonan Surat'); // Set Title to Bootstrap modal title
    }

    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('permohonansurat/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id_permohonan_surat"]').val(data.id_permohonan_surat);
                $('[name="perihal"]').val(data.perihal);
                $('[name="tanggal_berangkat"]').val(data.tanggal_berangkat);
                if (data.tanggal_pulang != data.tanggal_berangkat) {
                    $("#tanggal_pulang").prop("disabled", false);
                    $('[name="tanggal_pulang"]').val(data.tanggal_pulang);
                    $("#isCheck").prop("checked", true);
                }
                $('[name="lokasi"]').val(data.lokasi);
                // if (data.isi_surat != '') {
                //     getIsiSurat.setData(data.isi_surat);
                // }

                if (data.isi_surat != null) {
                    getIsiSurat.setData(data.isi_surat);
                }

                if (data.tembusan != null) {
                    getTembusan.setData(data.tembusan);
                }

                if (data.judul_lampiran != null) {
                    getJudulLampiran.setData(data.judul_lampiran);
                }

                if (data.isi_lampiran != null) {
                    getIsiLampiran.setData(data.isi_lampiran);
                }

                //     $('[name="isi_surat"]').val(data.isi_surat);
                // $('[name="tembusan"]').val(data.tembusan);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Permohonan Surat'); // Set title to Bootstrap modal title

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
                $('[name="keterangan_sekretaris"]').val(data.keterangan_sekretaris);
                $('[name="keterangan_kasenat"]').val(data.keterangan_kasenat);
                $('[name="keterangan_kakorwa"]').val(data.keterangan_kakorwa);

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

        const isi_surat = getIsiSurat.getData();
        const tembusan = getTembusan.getData();
        const judul_lampiran = getJudulLampiran.getData();
        const isi_lampiran = getIsiLampiran.getData();

        let isChecked = $('#isCheck')[0].checked

        var formData = {
            id_permohonan_surat: $("#id_permohonan_surat").val(),
            perihal: $("#perihal").val(),
            tanggal_berangkat: $("#tanggal_berangkat").val(),
            tanggal_pulang: $("#tanggal_pulang").val(),
            lokasi: $("#lokasi").val(),
            isi_surat: isi_surat,
            tembusan: tembusan,
            judul_lampiran: judul_lampiran,
            isi_lampiran: isi_lampiran,
            isCheck: isChecked
        };

        if (save_method == 'add') {
            url = "<?php echo site_url('permohonansurat/insert') ?>";
        } else {
            url = "<?php echo site_url('permohonansurat/update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('[id="perihal"]').val('');
                    getIsiSurat.setData('');
                    getTembusan.setData('');
                    getJudulLampiran.setData('');
                    getIsiLampiran.setData('');
                    $('#modal_form').modal('hide');
                    reload_table();
                    if (save_method == 'add') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Permohonan Surat Berhasil Disimpan!'
                        });
                    } else if (save_method == 'update') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Permohonan Surat Berhasil Diubah!'
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