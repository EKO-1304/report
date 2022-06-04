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
                <a href="<?= base_url("tambah-produk-baru") ?>" class="btn btn-primary btn-sm ml-2 mt-2" style="float:right" >Tambah Produk Baru</a>
                <?php //if(user()->id == 191){ ?>
                <a href="#" data-toggle="modal"  data-backdrop="static" data-target="#editdataexcel" class="btn btn-success text-light btn-sm mt-2 ml-2" style="float:right" >Edit Produk Excel</a>
                <a href="#" data-toggle="modal"  data-backdrop="static" data-target="#tambahdataexcel" class="btn btn-warning text-dark btn-sm mt-2" style="float:right" >Tambah Produk Excel</a>
                  <?php //} ?>
              </div>
            </div>
          </div>

          
          <!-- Tambah data -->
          <div class="modal fade" id="tambahdataexcel"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Tambah Data Excel</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">INFO : Wajib Download Templete Sebelum Tambah Data Produk !!!</span>
                    </div>
                    <div  class="mb-3 text-center" >
                      <a href="<?= base_url("manage-tambah-export-excel") ?>" class="badge badge-primary badge-pill">Download Templete Tambah Data</a>
                    </div>
                    <form action="<?= route_to('manage-tambah-produk-excel') ?>" method="post"  enctype="multipart/form-data">
                      <?= csrf_field() ?>

                        <div class="form-group required">  
                            <span class="text-primary font-weight-bold" style="font-size:13px">Format Excel : xlsx</span>  
                            <input type="file" id="" name="fileexcel"  class="form-control-file form-control height-auto <?php if(session('errors.fileexcel')){ echo "form-control-danger";}else{} ?>">          
                            <small class="form-control-feedback text-danger"><?= session('errors.fileexcel') ?></small>      
                        </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
                  </form>
              </div>
            </div>
          </div>
          
          <!-- Edit data -->
          <div class="modal fade" id="editdataexcel"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Edit Data Excel</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">INFO : Wajib Download Templete Sebelum Edit Data Produk !!!</span>
                    </div>
                    <div  class="mb-3 text-center" >
                      <a href="<?= base_url("manage-edit-export-excel") ?>" class="badge badge-primary badge-pill">Download Data Edit</a>
                    </div>
                    <form action="<?= route_to('manage-edit-produk-excel') ?>" method="post"  enctype="multipart/form-data">
                      <?= csrf_field() ?>

                        <div class="form-group required">  
                            <span class="text-primary font-weight-bold" style="font-size:13px">Format Excel : xlsx</span>  
                            <input type="file" id="" name="fileexcel"  class="form-control-file form-control height-auto <?php if(session('errors.fileexcel')){ echo "form-control-danger";}else{} ?>">          
                            <small class="form-control-feedback text-danger"><?= session('errors.fileexcel') ?></small>      
                        </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Update Data</button>
                </div>
                  </form>
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
          <table class="table-dataku-produk table table-sm table-bordered stripe hover " style="width:100%">
            <thead>
              <tr class="text-center">
                <th rowspan="2" style="width:30px">No</th>
                <th rowspan="2">Nama Produk</th>
                <th rowspan="2">Kategori</th>
                <th colspan="3">Shopee</th>
                <th colspan="3">Tokopedia</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Action</th>
              </tr>
              <tr class="text-center">
                <th>URL</th>
                <th style="min-width:70px">Harga</th>
                <th style="min-width:70px">Cashback</th>
                <th>URL</th>
                <th style="min-width:70px">Harga</th>
                <th style="min-width:70px">Cashback</th>
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
      
      table = $('.table-dataku-produk').DataTable({
          "order": [],
          "lengthMenu": [[25, 50, 100], [25, 50, 100]],
          processing: true,
          serverSide: true,
          bDestroy: true,
          responsive: true,
          // scrollX: true,
          ajax: {
              url: "<?php echo base_url('produk-saya-json'); ?>",
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
                  "targets": [0,10],
                  "orderable": false,
                  "searchable": false,
              },
              {
                  "targets": [0,3,6,9,10],
                  "className": "text-center",
              }
          ],

      });
      table.on('xhr.dt', function ( e, settings, json, xhr ) {
          token = json.<?= csrf_token() ?>;
      } );

      
    });

    function status(random){ 

      var token = $('.txt_csrfname').val();   
      
      $.ajax({
        url: "<?= base_url('update-produk-status'); ?>",
        type: 'POST',
        dataType: 'JSON',
        data:{<?= csrf_token() ?>:token,random:random},             
        success: function(data) {

          $('.txt_csrfname').val(data.csrf_token_name);     
          $('.table-dataku-produk').DataTable().ajax.reload(null, false);   

        }
      });

    }
    function deleteproduk(random){ 

      var token = $('.txt_csrfname').val();   
      
      $.ajax({
        url: "<?= base_url('delete-produk'); ?>",
        type: 'POST',
        dataType: 'JSON',
        data:{<?= csrf_token() ?>:token,random:random},             
        success: function(data) {

          $('.txt_csrfname').val(data.csrf_token_name);     
          
          $('#delete'+random).modal('hide');

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


          $('.table-dataku-produk').DataTable().ajax.reload(null, false);   

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

<?= $this->endSection() ?>
