<script type="text/javascript">
  var save_method; //for save method string
  var table;

  $(document).ready(function() {

    $('.kelas').hide();
    $('.sindikat').hide();
    $('.jabatan').hide();
    $('.angkatan').hide();

    table = $("#tabeluser").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "sEmptyTable": "Data User Masih Kosong"
      },
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('user/ajax_list') ?>",
        "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [0, 1, 2, 3, 4, 5, 6],
        "className": 'text-center'
      }, {
        "targets": [-1], //last column
        "render": function(data, type, row) {
          if (row[5] == "N") {
            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[6] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\"  onclick=\"del(" + row[6] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>"
          } else {
            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[6] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-warning\" href=\"javascript:void(0)\" title=\"Reset Password\" onclick=\"reset(" + row[6] + ")\"><i></i> Reset Password</a></div>";
          }
        },
        "orderable": false, //set not orderable
      }, {
        "targets": [-2], //last column
        "render": function(data, type, row) {
          if (row[5] == "N") {
            return "<div class=\"badge bg-danger text-white text-wrap\">Non-Aktif</div>"
          } else {
            return "<div class=\"badge bg-success text-white text-wrap\">Aktif</div>";
          }
        }
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
    $("select").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
      $(this).removeClass('is-invalid');
    });
    $('select.level').change(function() {
      var val = $(this).val();
      if (val === "11" || val === "12" || val === "13" || val === "14" || val === "15") {
        $('.kelas').hide();
        $('.angkatan').hide();
        $('.sindikat').hide();
        $('.jabatan').show();
        // $('.subkategori-buku-umum').hide();
      } else if (val === "6") {
        $('.kelas').show();
        $('.sindikat').show();
        $('.angkatan').show();
        $('.jabatan').hide();

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

  // Button Tabel

  function reset(id) {

    Swal.fire({
      title: 'Anda Yakin Ingin Mengatur Ulang Password ?',
      text: "Default Password : password123",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Atur Ulang Password!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "<?php echo site_url('user/reset'); ?>",
          type: "POST",
          data: "id=" + id,
          cache: false,
          dataType: 'json',
          success: function(respone) {
            if (respone.status == true) {
              reload_table();
              Swal.fire({
                icon: 'success',
                title: 'Password Berhasil Diatur Ulang!',
              });
            } else {
              Toast.fire({
                icon: 'error',
                title: 'Reset password Error!!.'
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

  //delete
  function del(id) {
    Swal.fire({
      title: 'Konfirmasi Hapus User',
      text: "Apakah Anda Yakin Ingin Menghapus User Ini ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus User Ini!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "<?php echo site_url('user/delete'); ?>",
          type: "POST",
          data: "id=" + id,
          cache: false,
          dataType: 'json',
          success: function(respone) {
            if (respone.status == true) {
              Swal.fire({
                icon: 'success',
                title: 'User Berhasil Dihapus!'
              });
              reload_table();
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
    $('.modal-title').text('Tambah User'); // Set Title to Bootstrap modal title
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('user/edit') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        val = data.id_level
        $('[name="id_user"]').val(data.id_user);
        $('[name="username"]').val(data.username);
        $('[name="full_name"]').val(data.full_name);
        $('[name="angkatan"]').val(data.id_angkatan);
        $('[name="kelas"]').val(data.id_kelas);
        $('[name="sindikat"]').val(data.id_sindikat);
        $('[name="jabatan"]').val(data.id_jabatan);
        $('[name="is_active"]').val(data.is_active);
        $('[name="level"]').val(data.id_level);

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ubah User'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;
    if (save_method == 'add') {
      url = "<?php echo site_url('user/insert') ?>";
    } else {
      url = "<?php echo site_url('user/update') ?>";
    }
    var formdata = new FormData($('#form')[0]);
    $.ajax({
      url: url,
      type: "POST",
      data: formdata,
      dataType: "JSON",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {

        if (data.status) //if success close modal and reload ajax table
        {
          $('#modal_form').modal('hide');
          reload_table();
          if (save_method == 'add') {
            Toast.fire({
              icon: 'success',
              title: 'User Berhasil Disimpan!'
            });
          } else if (save_method == 'update') {
            Toast.fire({
              icon: 'success',
              title: 'User Berhasil Diubah!'
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
        $('#btnSave').attr('disabled', false); //set button enable 


      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(textStatus);
        // alert('Error adding / update data');
        Toast.fire({
          icon: 'error',
          title: 'Error!!.'
        });
        $('#btnSave').text('Simpan'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      }
    });
  }

  function batal() {
    $('#form')[0].reset();
    reload_table();
    var image = document.getElementById('v_image');
    image.src = "";
  }
</script>