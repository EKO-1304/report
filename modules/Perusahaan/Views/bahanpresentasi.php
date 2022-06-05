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
      

      <!-- Checkbox select Datatable start -->
      <div class="card-box mb-30">
          <div class="row">
            <div class="col-sm-8">
              <div class="pd-20">
                <h4 class="text-blue h4"><?= $title ?></h4>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="pd-20">
              <?php if(has_permission("manage-bahan-presentasi-tambah")){ ?>              
                <div class="col-xl-12 mb-1"  style="float:right">
                  <a class="btn btn-sm btn-success" href="<?= base_url("manage-bahan-presentasi/tambah") ?>" style="width:100%;"><i class="icon-copy dw dw-add"></i> Tambah Data</a>
                </div>
                <?php } ?> 
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
          <table class="table-dataku-bahan table table-sm table-bordered stripe hover " style="width:100%">
            <thead>
              <tr class="text-center">
                <th style="width:30px">No</th>
                <th>Nama Bahan</th>
                <th>Oleh Staf</th>
                <th>Tanggal</th>
                <th style="width:100px">Action</th>
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
      
      table = $('.table-dataku-bahan').DataTable({
          "order": [[3, 'desc']],
          "lengthMenu": [[25, 50, 100], [25, 50, 100]],
          processing: true,
          serverSide: true,
          bDestroy: true,
          responsive: true,
          // scrollX: true,
          ajax: {
              url: "<?php echo base_url('manage-bahan-presentasi-json'); ?>",
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
                  "targets": [0,4],
                  "orderable": false,
                  "searchable": false,
              },
              {
                  "targets": [0,3,4],
                  "className": "text-center",
              }
          ],

      });
      table.on('xhr.dt', function ( e, settings, json, xhr ) {
          token = json.<?= csrf_token() ?>;
      } );

      
    });

    function deletemodal(random){
      document.getElementById("randomdelete").value=random; 
      $('#deletelaporan').modal({backdrop: 'static',keyboard: false,show: true});
    }
    function deletebahan(){ 

      var formData = new FormData($('#formdeletedata')[0]);
      
      $.ajax({
        url: "<?= base_url('manage-bahan-presentasi-delete'); ?>",
        type: 'POST',
        data: formData, 
        contentType: false,
        processData: false,
        dataType: "JSON",              
        success: function(data) {

          $('.txt_csrfname').val(data.csrf_token_name);     
          
          $('#deletelaporan').modal('hide');

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
          $('.table-dataku-bahan').DataTable().ajax.reload(null, false);   

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

                    <div class="modal fade" id="deletelaporan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
    						                  <button type="button" onclick="deletebahan()" class="ml-3 btn btn-sm btn-danger">Delete</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
<?= $this->endSection() ?>
