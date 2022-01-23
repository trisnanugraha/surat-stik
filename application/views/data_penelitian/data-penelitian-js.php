<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var anggaran;

    $(document).ready(function() {

        table = $("#tabelajuan").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Penelitian Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('datapenelitian/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, 4, 5, 6],
                "className": 'text-center'
            }, {
                "targets": [4], //status lppm
                "render": function(data, type, row) {
                    if (row[4] == "On Process") {
                        return "<div class=\"badge bg-info text-white text-wrap\">" + row[4] + "</div>"
                    } else if (row[4] == "On Review") {
                        return "<div class=\"badge bg-primary text-white text-wrap\">" + row[4] + "</div>"
                    } else if (row[4] == "Need Revision") {
                        return "<div class=\"badge bg-warning text-white text-wrap\">" + row[4] + "</div>"
                    } else if (row[4] == "Approve") {
                        return "<div class=\"badge bg-success text-white text-wrap\">" + row[4] + "</div>"
                    } else if (row[4] == "Decline") {
                        return "<div class=\"badge bg-danger text-white text-wrap\">" + row[4] + "</div>"
                    }
                }
            }, {
                "targets": [5], //status reviewer
                "render": function(data, type, row) {
                    if (row[5] == "On Process") {
                        return "<div class=\"badge bg-info text-white text-wrap\">" + row[5] + "</div>"
                    } else if (row[5] == "On Review") {
                        return "<div class=\"badge bg-primary text-white text-wrap\">" + row[5] + "</div>"
                    } else if (row[5] == "Need Revision") {
                        return "<div class=\"badge bg-warning text-white text-wrap\">" + row[5] + "</div>"
                    } else if (row[5] == "Approve") {
                        return "<div class=\"badge bg-success text-white text-wrap\">" + row[5] + "</div>"
                    } else if (row[5] == "Decline") {
                        return "<div class=\"badge bg-danger text-white text-wrap\">" + row[5] + "</div>"
                    }
                }
            }, {
                "targets": [-1], //last column
                "render": function(data, type, row) {
                    return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"edit(" + row[6] + ")\"><i class=\"fas fa-eye\"></i> Detail</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"del(" + row[6] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>"

                },
                "orderable": false, //set not orderable
            }, {
                "searchable": false,
                "orderable": false,
                "targets": 0
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
        $("select").not('.selectpicker').change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        // $('#priode').select2({
        //     // placeholder: "-- Pilih Priode --"
        // });
        // filter();
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
                    url: "<?php echo site_url('datapenelitian/delete'); ?>",
                    type: "POST",
                    data: "id_ajuan_penelitian=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Dihapus!'
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
        $('.modal-title').text('Tambah Skema Penelitian'); // Set Title to Bootstrap modal title
    }

    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('datapenelitian/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_ajuan_penelitian"]').val(data.id_ajuan_penelitian);
                $('[name="priode"]').text(data.judul);
                $('[name="judul"]').text(data.judul_penelitian);
                $('[name="skema"]').text(data.nama_skema);
                $('[name="ketua"]').text(data.ketua);
                $('[name="anggota1"]').text(data.anggota1);
                $('[name="anggota2"]').text(data.anggota2);
                $('[name="anggota3"]').text(data.anggota3);
                $('[name="anggota4"]').text(data.anggota4);
                $('[name="anggota5"]').text(data.anggota5);
                $('[name="anggaran"]').text(data.anggaran);
                $('[name="lokasi"]').text(data.lokasi);
                $('[name="jurnal"]').text(data.nama_jurnal);
                $('[name="peringkat"]').text(data.peringkat_jurnal);
                $('[name="link"]').attr("href", data.link_jurnal);
                $('[name="link"]').text(data.link_jurnal);
                $('[name="eissn"]').text(data.e_issn);
                if (data.berkas_laporan != '' && data.berkas_jurnal != '') {
                    var lokasiLaporan = "<?php echo base_url('upload/penelitian/laporan/') ?>"
                    var lokasiJurnal = "<?php echo base_url('upload/penelitian/jurnal/') ?>"
                    $('#view_laporan').attr("href", lokasiLaporan + data.berkas_laporan);
                    $('#view_jurnal').attr("href", lokasiJurnal + data.berkas_jurnal);
                    $('[name="filelaporan"]').val(data.berkas_laporan);
                    $('[name="filejurnal"]').val(data.berkas_jurnal);
                } else {
                    $('#view_laporan').attr("href", '');
                    $('#view_jurnal').attr("href", '');
                }
                $('[name="status"]').val(data.status);
                $('[name="komentar_lppm"]').val(data.komentar_lppm);
                // $('[name="reviewer"]').val(data.reviewer);
                $('.selectpicker[name="reviewer"]').selectpicker('val', data.reviewer);

                if (!data.nama_reviewer && !data.status_reviewer) {
                    $('[name="nama_reviewer"]').text('Reviewer Belum Dipilih');
                    $('[name="status_reviewer"]').text('Status Reviewer Belum Tersedia');
                } else {
                    $('[name="nama_reviewer"]').text(data.nama_reviewer);
                    $('[name="status_reviewer"]').text(data.status_reviewer);
                }
                $('[name="komentar_reviewer"]').val(data.komentar_reviewer);
                if (data.berkas_review != '') {
                    var lokasiBerkas = "<?php echo base_url('upload/review/penelitian/') ?>"
                    $('#berkas_review').attr("href", lokasiBerkas + data.berkas_review);
                } else {
                    $('#berkas_review').attr("href", '');
                }
                $('.selectpicker').selectpicker('refresh');
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Detail Data Penelitian'); // Set title to Bootstrap modal title

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

        if (save_method == 'add') {
            url = "<?php echo site_url('datapenelitian/insert') ?>";
        } else {
            url = "<?php echo site_url('datapenelitian/update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                    if (save_method == 'add') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Penelitian Berhasil Disimpan!'
                        });
                    } else if (save_method == 'update') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Penelitian Berhasil Diubah!'
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
        reload_table();
        $('.selectpicker').selectpicker('val', '');
        $('.selectpicker').selectpicker("refresh");
    }

    // function exportData() {
    //     $('#form')[0].reset(); // reset form on modals
    //     $('.form-group').removeClass('has-error'); // clear error class
    //     $('.help-block').empty(); // clear error string
    //     $('#modal_export').modal('show'); // show bootstrap modal
    //     $('.modal-title').text('Export Data Penelitian'); // Set Title to Bootstrap modal title
    // }

    // function dataExport(id) {
    //     $('#btnExport').text('Exporting...'); //change button text
    //     $('#btnExport').attr('disabled', true); //set button disable 
    //     var url = "<?php echo site_url('datapenelitian/export') ?>";

    //     // ajax adding data to database
    //     $.ajax({
    //         url: "<?php echo site_url('datapenelitian/export') ?>/" + id,
    //         type: "POST",
    //         // data: $('#form_export').serialize(),
    //         // dataType: "JSON",
    //         success: function(data) {

    //             if (data.status) //if success close modal and reload ajax table
    //             {
    //                 $('#modal_export').modal('hide');
    //                 // reload_table();
    //                 // if (save_method == 'add') {
    //                 //     Toast.fire({
    //                 //         icon: 'success',
    //                 //         title: 'Data Penelitian Berhasil Disimpan!'
    //                 //     });
    //                 // } else if (save_method == 'update') {
    //                 //     Toast.fire({
    //                 //         icon: 'success',
    //                 //         title: 'Data Penelitian Berhasil Diubah!'
    //                 //     });
    //                 // }
    //             }
    //             // $('#btnSave').text('Simpan'); //change button text
    //             $('#btnCancel').text('Batal'); //change button text
    //             $('#btnExport').attr('disabled', false); //set button enable 
    //         },
    //         // error: function(jqXHR, textStatus, errorThrown) {
    //         //     alert('Error exporting data');
    //         //     // $('#btnExport').text('Simpan'); //change button text
    //         //     $('#btnCancel').text('Batal'); //change button text
    //         //     $('#btnExport').attr('disabled', false); //set button enable 

    //         // }
    //     });
    // }
</script>