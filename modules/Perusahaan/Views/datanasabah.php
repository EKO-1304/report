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
              <?php if(has_permission("manage-nasabah-cetak-excel")){ ?>
              <a class="btn btn-sm btn-warning text-dark font-weight-bold" style="float:right" href="javascript:void(0)" data-toggle="modal"  data-backdrop="static" data-target="#cetakexcel"><i class="icon-copy dw dw-print"></i> Cetak Excel</a>
              <?php } ?> <?php /*
                <a href="<?= base_url("manage-input-laporan") ?>" class="btn btn-primary btn-sm ml-2 mt-2" style="float:right" >Tambah </a> */ ?>
              </div>
            </div>
          </div>

          <!-- Tambah data -->
          <div class="modal fade" id="cetakexcel"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Cetak Data Excel</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">Tentukan Filter Cetak</span>
                    </div>
                    <form action="<?= route_to('manage-nasabah-cetak-excel') ?>" method="post">
                      <?= csrf_field() ?>

                      <div class="form-group  required">
                        <select class="custom-select2 form-control <?php if(session('errors.minggu')){ echo "form-control-danger";}else{} ?>" name="minggu" style="width: 100%; height: 38px;">
                            <option value="semua">-- Semua --</option>
                        <?php 
                              for($i=1;$i <= 4;$i++){

                                $minggu = date("d");

                                if($minggu >= 1 && $minggu <= 7){
                                  $m = 1;
                                }elseif($minggu >= 8 && $minggu <= 14){
                                  $m = 2;
                                }elseif($minggu >= 15 && $minggu <= 21){
                                  $m = 3;
                                }else{
                                  $m = 4;
                                }
                          ?>
                            <option value="<?= $i ?>" <?php if($m == $i){echo "selected";}else{} ?>>Minggu <?= $i ?></option>
                          <?php } ?>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.minggu') ?></small>
                      </div>
                      <div class="form-group  required">
                        <select class="custom-select2 form-control <?php if(session('errors.bulan')){ echo "form-control-danger";}else{} ?>" name="bulan" style="width: 100%; height: 38px;">
                            <option value="semua">-- Semua --</option>
                          <?php foreach($bulan as $mt){ 
                            $tglmth = explode("-",$mt["tanggal"]);  
                          ?>
                            <option value="<?= $tglmth[1] ?>" <?php if(date("m") == $tglmth[1]){ echo "selected";}else{} ?>><?= bulan_panjang($tglmth[1]) ?></option>
                          <?php } ?>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.bulan') ?></small>
                      </div>
                      <div class="form-group  required">
                        <select class="custom-select2 form-control <?php if(session('errors.tahun')){ echo "form-control-danger";}else{} ?>" name="tahun" style="width: 100%; height: 38px;">
                            <option value="semua">-- Semua --</option>
                          <?php foreach($tahun as $thn){ 
                            $tglthn = explode("-",$thn["tanggal"]);  
                          ?>
                            <option value="<?= $tglthn[0] ?>" <?php if(date("Y") == $tglthn[0]){ echo "selected";}else{} ?>><?= $tglthn[0] ?></option>
                          <?php } ?>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.tahun') ?></small>
                      </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Cetak Excel</button>
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
          <table class="table-dataku-nasabah  table table-sm table-bordered stripe hover " style="width:100%">
            <thead>
              <tr class="text-center">
                <th style="width:30px">No</th>
                <th>Nama Nasabah</th>
                <th>Nama Staf (input laporan)</th>
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
      
      table = $('.table-dataku-nasabah').DataTable({
          "order": [[3, 'desc']],
          "lengthMenu": [[25, 50, 100], [25, 50, 100]],
          processing: true,
          serverSide: true,
          bDestroy: true,
          responsive: true,
          // scrollX: true,
          ajax: {
              url: "<?php echo base_url('manage-nasabah-json'); ?>",
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
    function deletelaporan(){ 

      var formData = new FormData($('#formdeletedata')[0]);

      $.ajax({
        url: "<?= base_url('manage-input-laporan-delete'); ?>",
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
          $('.table-dataku-nasabah').DataTable().ajax.reload(null, false);   

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
    						                  <button type="button" onclick="deletelaporan()" class="ml-3 btn btn-sm btn-danger">Delete</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="viewdata" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                           
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">View Data Nasabah : '.$lists->namanasabah.'</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body text-left">
                                    <div class="row">
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Broker</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->broker.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Pendamping</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->pendamping.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Staf (input laporan)</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->fullname.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Nasabah</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->namanasabah.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nomor Wa</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->nomorwa.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Alamat</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->alamat.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Pekerjaan</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->pekerjaan.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Hasil</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->hasil.'</span>
                                        </div>';
                                        if($lists->dokumentasi <> ""){
                             $action .= '<div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Dokumntasi Foto</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: <img src="'.base_url("assets/images/dokumentasi/".$lists->dokumentasi).'" style="width:200px" ></span>
                                        </div>';
                                        }

                        $action .= '</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                            </div>

                        </div>
                    </div>';
<?= $this->endSection() ?>
