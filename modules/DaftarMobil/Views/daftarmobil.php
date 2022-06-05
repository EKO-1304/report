<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>

<?php $db = \Config\Database::connect(); ?>

<div class="main-container">
  <div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <h4><?= $pretitle ?></h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <div class="page-header">
        <span class="font-weight-bold">Status Pengajuan : </span>
        <div class="row">
          <div class="col-md-12 col-sm-12">            
                <div class="btn-group-toggle" data-toggle="buttons">
                      <span class="badge badge-warning text-dark py-1"><i class="icon-copy dw dw-notification1"></i> Pending</span>                      
                      <span class="badge badge-primary text-light py-1"><i class="icon-copy dw dw-notification1"></i> Di Jalan</span>                   
                      <span class="badge badge-danger text-dark py-1"><i class="icon-copy dw dw-notification1"></i> Di Batalkan</span>
                      <span class="badge badge-success text-dark py-1"><i class="icon-copy dw dw-notification1"></i> Selesai</span>   
                </div>
          </div>
        </div>
      </div>

      <!-- Checkbox select Datatable start -->
      <div class="card-box mb-30">
          <div class="row">
            <div class="col-sm-9">
              <div class="pd-20">
                <h4 class="text-blue h4"><?= $title ?></h4>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="pd-20">
                    <div class="col-xl-12 mb-1"  style="float:right">
                      <a class="btn btn-sm btn-success" href="<?= base_url("manage-mobil/tambah") ?>" style="width:100%;"><i class="icon-copy dw dw-add"></i> Tambah Data</a>
                    </div>
              </div>
            </div>
          </div>

        <div class="pb-20">


        <!-- CSRF token --> 
        <input type="hidden" class="txt_csrfname form-control" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

        <!-- <div class="table-responsive"> -->
          <div class="px-3" >
          <?= $this->include('Modules\Layout\Views\alert') ?>
          </div>
          <table class="table-dataku-mobil table table-sm table-bordered stripe hover " style="width:100%">
            <thead>
              <tr class="text-center">
                <th style="width:30px">No</th>
                <th>Nama Staf</th>
                <th>Sesi</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        <!-- </div> -->
        </div>
      </div>
      <!-- Checkbox select Datatable End -->


    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {


      var table;
      var token = $('.txt_csrfname').val(); // CSRF hash
      
      table = $('.table-dataku-mobil').DataTable({
          "order": [[4, 'desc']],
          "lengthMenu": [[25, 50, 100], [25, 50, 100]],
          processing: true,
          serverSide: true,
          bDestroy: true,
          responsive: true,
          // scrollX: true,
          ajax: {
              url: "<?php echo base_url('manage-mobil-json'); ?>",
              type: "POST",
              dataType: 'JSON',
              data: function (d) {
                  {d.<?= csrf_token() ?> = token};
              }
          },
          "language": {
            "info": "_START_-_END_ of _TOTAL_ entries",
            searchPlaceholder: "Search",
            paginate: {
              next: '<i class="ion-chevron-right"></i>',
              previous: '<i class="ion-chevron-left"></i>'
            }
          },
          "columnDefs": [
              {
                  "targets": [0,6],
                  "orderable": false,
                  "searchable": false,
              },
              {
                  "targets": [0,5,6],
                  "className": "text-center",
              }
          ],

      });
      table.on('xhr.dt', function ( e, settings, json, xhr ) {
          token = json.<?= csrf_token() ?>;
      } );

      
    });
    
    function selesaimodal(random){
      document.getElementById("randomselesai").value=random; 
      $('#selesai').modal({backdrop: 'static',keyboard: false,show: true});
    }
    
    function selesai(){ 

    var formData = new FormData($('#formselesaidata')[0]);

      $.ajax({
      url: "<?= base_url('manage-mobil-selesai'); ?>",
        type: 'POST',
        data: formData, 
        contentType: false,
        processData: false,
        dataType: "JSON",                  
      success: function(data) {

        $('.txt_csrfname').val(data.csrf_token_name);     
        
        $('#selesai').modal('hide');

        if(data.status == true){
          $('.alert-status').text('Success!');
          $('.alert-pesan').text(data.pesan);
          $(".alert-color-success").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-color-success").slideUp(500);
          });
        }else{
          $('.alert-status').text('Gagal !');
          $('.alert-pesan').text(data.pesan);
          $(".alert-color-gagal").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-color-gagal").slideUp(500);
          });
        }

        $('#formselesaidata')[0].reset();

        $('.table-dataku-mobil').DataTable().ajax.reload(null, false);   

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        $('.alert-status').text('Error!');
        $('.alert-pesan').text('delete data error');
        $(".alert-color-danger").fadeTo(2000, 500).slideUp(500, function() {
          $(".alert-color-danger").slideUp(500);
        });

      }
      });

    }
    function batalmodal(random){
      document.getElementById("randombatal").value=random; 
      $('#batal').modal({backdrop: 'static',keyboard: false,show: true});
    }
    function batal(){ 

    var formData = new FormData($('#formbataldata')[0]);

      $.ajax({
      url: "<?= base_url('manage-mobil-batal'); ?>",
        type: 'POST',
        data: formData, 
        contentType: false,
        processData: false,
        dataType: "JSON",                  
      success: function(data) {

        $('.txt_csrfname').val(data.csrf_token_name);     
        
        $('#batal').modal('hide');

        if(data.status == true){
          $('.alert-status').text('Success!');
          $('.alert-pesan').text(data.pesan);
          $(".alert-color-success").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-color-success").slideUp(500);
          });
        }else{
          $('.alert-status').text('Gagal !');
          $('.alert-pesan').text(data.pesan);
          $(".alert-color-gagal").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-color-gagal").slideUp(500);
          });
        }

        $('#formbataldata')[0].reset();

        $('.table-dataku-mobil').DataTable().ajax.reload(null, false);   

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        $('.alert-status').text('Error!');
        $('.alert-pesan').text('delete data error');
        $(".alert-color-danger").fadeTo(2000, 500).slideUp(500, function() {
          $(".alert-color-danger").slideUp(500);
        });

      }
      });

    }
    function serahkanmodal(random){
      document.getElementById("randomserahkan").value=random; 
      $('#serahkan').modal({backdrop: 'static',keyboard: false,show: true});
    }
    function serahkan(){ 

      var formData = new FormData($('#formserahkandata')[0]);

    $.ajax({
      url: "<?= base_url('manage-mobil-serahkan'); ?>",
        type: 'POST',
        data: formData, 
        contentType: false,
        processData: false,
        dataType: "JSON",                  
      success: function(data) {

        $('.txt_csrfname').val(data.csrf_token_name);     
        
        $('#serahkan').modal('hide');

        if(data.status == true){
          $('.alert-status').text('Success!');
          $('.alert-pesan').text(data.pesan);
          $(".alert-color-success").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-color-success").slideUp(500);
          });
        }else{
          $('.alert-status').text('Gagal !');
          $('.alert-pesan').text(data.pesan);
          $(".alert-color-gagal").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-color-gagal").slideUp(500);
          });
        }

        $('#formserahkandata')[0].reset();

        $('.table-dataku-mobil').DataTable().ajax.reload(null, false);   

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        $('.alert-status').text('Error!');
        $('.alert-pesan').text('delete data error');
        $(".alert-color-danger").fadeTo(2000, 500).slideUp(500, function() {
          $(".alert-color-danger").slideUp(500);
        });

      }
    });

    }
    function deletemodal(random){
      document.getElementById("randomdelete").value=random; 
      $('#deletemobil').modal({backdrop: 'static',keyboard: false,show: true});
    }
    function deletemobil(){ 

      var formData = new FormData($('#formdeletedata')[0]);
      
      $.ajax({
        url: "<?= base_url('manage-mobil-delete'); ?>",
        type: 'POST',
        data: formData, 
        contentType: false,
        processData: false,
        dataType: "JSON",                
        success: function(data) {

          $('.txt_csrfname').val(data.csrf_token_name);     
          
          $('#deletemobil').modal('hide');

          if(data.status == true){
            $('.alert-status').text('Success!');
            $('.alert-pesan').text(data.pesan);
            $(".alert-color-success").fadeTo(2000, 500).slideUp(500, function() {
              $(".alert-color-success").slideUp(500);
            });
          }else{
            $('.alert-status').text('Gagal !');
            $('.alert-pesan').text(data.pesan);
            $(".alert-color-gagal").fadeTo(2000, 500).slideUp(500, function() {
              $(".alert-color-gagal").slideUp(500);
            });
          }


          $('#formdeletedata')[0].reset();
          $('.table-dataku-mobil').DataTable().ajax.reload(null, false);   

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          $('.alert-status').text('Error!');
          $('.alert-pesan').text('delete data error');
          $(".alert-color-danger").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-color-danger").slideUp(500);
          });

        }
      });

    }

</script>


                    <div class="modal fade" id="deletemobil" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content  text-white">
                            <div class="modal-body bg-danger text-center " style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                <h4 class="text-white mb-15"><i class="fa fa-exclamation-triangle"></i> Apakah anda yakin ?</h4>
                                <p>Apakah anda benar-benar ingin menghapus data ini? Apa yang telah anda lakukan tidak dapat dibatalkan.</p>
                            
                            <form action="#" id="formdeletedata" class="form-horizontal">
                              <?= csrf_field() ?>
                              <input type="hidden" name="random" id="randomdelete" >
                            </div>
                            <div class="modal-footer mx-auto py-1">
                                  <button type="button" class="mr-3 btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
    						                  <button type="button" onclick="deletemobil()" class="ml-3 btn btn-sm btn-danger">Delete</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="serahkan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content  text-white">
                            <div class="modal-body bg-warning text-dark text-center " style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                <h4 class="text-white mb-15"><i class="fa fa-exclamation-triangle"></i> Apakah anda yakin ?</h4>
                                <p>Apakah anda benar-benar ingin menyerahkan kunci mobil? Apa yang telah anda lakukan tidak dapat dibatalkan.</p>
                            
                            <form action="#" id="formserahkandata" class="form-horizontal">
                              <?= csrf_field() ?>
                              <input type="hidden" name="random" id="randomserahkan" >
                            </div>
                            <div class="modal-footer mx-auto py-1">
                                  <button type="button" class="mr-3 btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
    						                  <button type="button" onclick="serahkan()" class="ml-3 btn btn-sm btn-warning text-dark">Serahkan</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="selesai" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content  text-white">
                            <div class="modal-body bg-success text-center " style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                <h4 class="text-white mb-15"><i class="fa fa-exclamation-triangle"></i> Apakah anda yakin ?</h4>
                                <p>Apakah anda benar-benar yakin mobil telah kembali ke kantor? Apa yang telah anda lakukan tidak dapat dibatalkan.</p>
                            
                            <form action="#" id="formselesaidata" class="form-horizontal">
                              <?= csrf_field() ?>
                              <input type="hidden" name="random" id="randomselesai" >
                            </div>
                            <div class="modal-footer mx-auto py-1">
                                  <button type="button" class="mr-3 btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
    						                  <button type="button" onclick="selesai()" class="ml-3 btn btn-sm btn-success">Selesai</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="batal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content  text-white">
                            <div class="modal-body bg-danger text-center " style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                <h4 class="text-white mb-15"><i class="fa fa-exclamation-triangle"></i> Apakah anda yakin ?</h4>
                                <p>Apakah anda benar-benar ingin membatalkan data ini? Apa yang telah anda lakukan tidak dapat dibatalkan.</p>
                            
                            <form action="#" id="formbataldata" class="form-horizontal">
                              <?= csrf_field() ?>
                              <input type="hidden" name="random" id="randombatal" >
                            </div>
                            <div class="modal-footer mx-auto py-1">
                                  <button type="button" class="mr-3 btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
    						                  <button type="button" onclick="batal()" class="ml-3 btn btn-sm btn-danger">Batal</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
<?= $this->endSection() ?>
