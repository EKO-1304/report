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
        <div class="row">
          <div class="col-md-12 col-sm-12" >            
                <div class="btn-group-toggle pb-1" data-toggle="buttons" >
                      <label class="btn btn-outline-success mb-1 p-1">
                        <input type="radio" name="tahun" id="semua"  onclick="tahuninput(this.id)" value="semua" >Semua
                      </label>
                    <?php 
                          foreach($tahun as $th){ 
                            $thn = explode("-",$th["tanggal"]);
                      
                      ?>
                        <label class="btn btn-outline-success mb-1 text-capitalize p-1">
                          <input type="radio" name="tahun" id="<?= $thn[0] ?>" <?php if($thn[0] == date("Y")){echo "checked";}else{} ?>  onclick="tahuninput(this.id)" ><?= $thn[0] ?> </span>
                        </label>
                    <?php } ?>
                </div>      
                <div class="btn-group-toggle pb-1" data-toggle="buttons" >
                      <label class="btn btn-outline-success mb-1 p-1">
                        <input type="radio" name="bulan" id="semua"  onclick="bulaninput(this.id)" value="semua" >Semua
                      </label>
                    <?php 
                          for($i=1;$i <= 12;$i++){
                            if($i < 10){ $bulan = '0'.$i;}else{$bulan = $i;}
                      ?>
                        <label class="btn btn-outline-success mb-1 text-capitalize p-1">
                          <input type="radio" name="bulan" <?php if($bulan == date("m")){echo "checked";}else{} ?> id="<?= $bulan ?>"  onclick="bulaninput(this.id)" ><?= bulan_pendek($bulan) ?> </span>
                        </label>
                    <?php } ?>
                </div>     
                <div class="btn-group-toggle pb-1" data-toggle="buttons" >
                      <label class="btn btn-outline-success mb-1 p-1">
                        <input type="radio" name="bulan" id="semua"  onclick="mingguinput(this.id)" value="semua" >Semua
                      </label>
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
                        <label class="btn btn-outline-success mb-1 text-capitalize p-1">
                          <input type="radio" name="bulan" <?php if($m == $i){echo "checked";}else{} ?> id="<?= $i ?>"  onclick="mingguinput(this.id)" >Minggu - <?= $i ?> </span>
                        </label>
                    <?php } ?>
                </div>
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
              <?php /* if(has_permission("manage-nasabah-cetak-excel")){ ?>
              <a class="btn btn-sm btn-warning text-dark font-weight-bold" style="float:right" onclick="cetak()" href="javascript:void(0)" data-toggle="modal" ><i class="icon-copy dw dw-print"></i> Cetak Excel</a>
              <?php } ?> <?php /*
                <a href="<?= base_url("manage-input-laporan") ?>" class="btn btn-primary btn-sm ml-2 mt-2" style="float:right" >Tambah </a> */ ?>
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
          <table class="table-dataku-nasabah table table-sm table-bordered stripe hover " style="width:100%">
            <thead>
              <tr class="text-center">
                <th style="width:30px">No</th>
                <th>Nama Staf</th>
                <th>Total Nasabah</th>
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

<?php 
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
 <!-- CSRF token --> 
  <input type="hidden" class="txt_csrfname form-control" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
  <input type="hidden" class="form-control" id="resulttahun" value="<?= date("Y") ?>" >
  <input type="hidden" class="form-control" id="resultbulan" value="<?= date("m") ?>" > 
  <input type="hidden" class="form-control" id="resultminggu" value="<?= $m ?>" >
<script>
    $(document).ready(function() {


      var table;
      var token = $('.txt_csrfname').val(); // CSRF hash
      
      table = $('.table-dataku-nasabah').DataTable({
          "order": [[2, 'desc']],
          "lengthMenu": [[25, 50, 100], [25, 50, 100]],
          processing: true,
          serverSide: true,
          bDestroy: true,
          responsive: true,
          // scrollX: true,
          ajax: {
              url: "<?php echo base_url('rekap-data-staf-json'); ?>",
              type: "POST",
              dataType: 'JSON',
              data: function (d) {
                
                  var tahun = document.getElementById("resulttahun").value;
                  var bulan = document.getElementById("resultbulan").value;
                  var minggu = document.getElementById("resultminggu").value;
                  

                  {d.<?= csrf_token() ?> = token,d.tahun = tahun,d.bulan = bulan,d.minggu = minggu};
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
                  "targets": [0],
                  "orderable": false,
                  "searchable": false,
              },
              {
                  "targets": [0,2],
                  "className": "text-center",
              }
          ],

      });
      table.on('xhr.dt', function ( e, settings, json, xhr ) {
          token = json.<?= csrf_token() ?>;
      } );

      
    });

    function bulaninput(bulan){ 
      document.getElementById("resultbulan").value=bulan; 
      $('.table-dataku-nasabah').DataTable().ajax.reload(null, false);
    }
    function tahuninput(tahun){ 
      document.getElementById("resulttahun").value=tahun; 
      $('.table-dataku-nasabah').DataTable().ajax.reload(null, false);
    }
    function mingguinput(minggu){ 
      document.getElementById("resultminggu").value=minggu; 
      $('.table-dataku-nasabah').DataTable().ajax.reload(null, false);
    }
    function cetak(){ 

      var tahun = document.getElementById("resulttahun").value;
      var bulan = document.getElementById("resultbulan").value;

      window.location.href = "<?= base_url("rekap-nasabah-cetak-excel?bulan=") ?>"+bulan+"&tahun="+tahun;
      
    }

    function deletelaporan(random){ 

      var token = $('.txt_csrfname').val();   
      
      $.ajax({
        url: "<?= base_url('manage-input-laporan-delete'); ?>",
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

<?= $this->endSection() ?>
