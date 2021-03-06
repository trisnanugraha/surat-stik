<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        $('.sekretaris').hide();
        $('.staffkorwa').hide();
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
                "url": "<?php echo site_url('validasisurat/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, 1, 3, 5, 6],
                "className": 'text-center'
            }, {
                "searchable": false,
                "orderable": false,
                "targets": 0
            }, {
                "targets": [-2], //status lppm
                "render": function(data, type, row) {
                    if (row[5] == "Disetujui") {
                        return "<div class=\"badge bg-success text-white text-wrap\">" + row[5] + "</div>"
                    } else if (row[5] == "Ditolak") {
                        return "<div class=\"badge bg-danger text-white text-wrap\">" + row[5] + "</div>"
                    } else if (row[5] == "Diproses") {
                        return "<div class=\"badge bg-info text-white text-wrap\">" + row[5] + "</div>"
                    } else if (row[5] == "Butuh Perbaikan") {
                        return "<div class=\"badge bg-warning text-white text-wrap\">" + row[5] + "</div>"
                    }
                }
            }, {
                "targets": [-1], //last column
                "render": function(data, type, row) {
                    if (row[5] == "Disetujui") {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Print\" onclick=\"print(" + row[7] + ")\"><i class=\"fas fa-print\"></i> Print</a></div>"
                    } else {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail(" + row[7] + ")\"><i class=\"fas fa-file-signature\"></i> Validasi</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Print\" onclick=\"print(" + row[7] + ")\"><i class=\"fas fa-print\"></i> Print</a></div>"
                    }
                },
                "orderable": false, //set not orderable
            }],
        });
        $("input").change(function() {
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

        $('select.validasi_sekretaris').change(function() {
            var val = $(this).val();
            if (val === "Disetujui") {
                $('.sekretaris').show();
                // $('.subkategori-buku-umum').hide();
            } else{
                $('.sekretaris').hide();

            }
        });

        $('select.validasi_kakorwa').change(function() {
            var val = $(this).val();
            if (val === "Disetujui") {
                $('.staffkorwa').show();
                // $('.subkategori-buku-umum').hide();
            } else{
                $('.staffkorwa').hide();

            }
        });
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
        var go_to_url = '<?php echo base_url('validasisurat/print/'); ?>' + id;
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
            url: "<?php echo site_url('sindikat/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id_sindikat"]').val(data.id_sindikat);
                $('[name="nama_sindikat"]').val(data.nama_sindikat);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Sindikat'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function detail(id) {
        save_method = 'detail';
        $('#form_detail')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('validasisurat/detail') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_permohonan_surat"]').val(data.id_permohonan_surat);
                $('[name="perihal"]').text(data.perihal);
                $('[name="tanggal"]').text(data.tanggal);
                $('[name="lokasi"]').text(data.lokasi);
                $('[name="tanggal_akhir"]').text(data.tanggal_akhir);
                if (data.level == 'Sekretaris') {
                    $('[name="id_validasi_sekretaris"]').val(data.id_validasi_sekretaris);
                    $('[name="status_sekretaris"]').val(data.status_sekretaris);
                    $('[name="catatan_sekretaris"]').val(data.catatan_sekretaris);
                } else if (data.level == 'Kasenat') {
                    $('[name="id_validasi_kasenat"]').val(data.id_validasi_kasenat);
                    $('[name="status_kasenat"]').val(data.status_kasenat);
                    $('[name="catatan_kasenat"]').val(data.catatan_kasenat);
                } else if (data.level == 'Kakorwa') {
                    $('[name="id_validasi_kakorwa"]').val(data.id_validasi_kakorwa);
                    $('[name="status_kakorwa"]').val(data.status_kakorwa);
                    $('[name="catatan_kakorwa"]').val(data.catatan_kakorwa);
                }

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
        var dataform;

        if (save_method == 'add') {
            url = "<?php echo site_url('permohonansurat/insert') ?>";
            dataform = '#form';
        }

        if (save_method == 'update') {
            url = "<?php echo site_url('sindikat/update') ?>";
            dataform = '#form';
        }

        if (save_method == 'detail') {
            url = "<?php echo site_url('validasisurat/validasi') ?>";
            dataform = '#form_detail';
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $(dataform).serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    if (save_method == 'add' || save_method == 'update') {
                        $('#modal_form').modal('hide');
                    }
                    if (save_method == 'detail') {
                        $('#modal_detail').modal('hide');
                    }
                    reload_table();
                    if (save_method == 'add') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Permohonan Surat Berhasil Disimpan!'
                        });
                    } else if (save_method == 'update') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Sindikat Berhasil Diubah!'
                        });
                    } else if (save_method == 'detail') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Permohonan Surat Telah Divalidasi!'
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
        $('#form_detail')[0].reset();
        $('[name="perihal"]').text('');
        reload_table();
    }
</script>