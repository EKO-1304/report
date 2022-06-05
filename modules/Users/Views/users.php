<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>
<?php
    if(in_groups("super_administrator")){
      $userstat = 1;
    }else{
      $userstat = 0;
    }
?>
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
                <div class="pd-20" >
                    <div class="col-xl-12 mb-1"  style="float:right">
                      <a class="btn btn-sm btn-primary" href="<?= base_url("manage-users/tambah") ?>" style="width:100%;"><i class="icon-copy dw dw-add"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
          </div>

          
        <div class="px-3" >
        <?= $this->include('Modules\Layout\Views\alert') ?>
        </div>

        <div class="pb-20">


          <table class="table-data-ku table  stripe hover nowrap " style="width:100%">
            <thead>
              <tr class="text-center">
                <th style="width:50px">No</th>
                <th>Nama User</th>
                <th>Groups User</th>
                <th>Jenis User</th>
                <th>Nomor Wa</th>
                <th>Status</th>
                <th style="width:200px">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Checkbox select Datatable End -->


    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

 <!-- CSRF token --> 
<input type="hidden" class="txt_csrfname form-control" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

<script>
    $(document).ready(function() {


      var table;
      var token = $('.txt_csrfname').val(); // CSRF hash
      
      table = $('.table-data-ku').DataTable({
          "order": [],
          "lengthMenu": [[25, 50, 100], [25, 50, 100]],
          processing: true,
          serverSide: true,
          bDestroy: true,
          responsive: true,
          // scrollX: true,
          ajax: {
              url: "<?php echo base_url('manage-users-json'); ?>",
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
                  "targets": [0,4,5,6],
                  "orderable": false,
                  "searchable": false,
              },
              {
                  // "targets":0,
                  "orderable": false,
                  "searchable": false,
                  'className': 'dt-body-center',
              },
              {
                  "targets": [0,3,4,5,6],
                  "className": "text-center",
              }
          ],

      });
      table.on('xhr.dt', function ( e, settings, json, xhr ) {
          token = json.<?= csrf_token() ?>;
      } );

      
    });

    function deletedata(random)
    {
      $('[name="random"]').val(random);
      $('#deletedata').modal({backdrop: 'static',keyboard: false,show: true});

    }
</script>


      <div class="modal fade" id="deletedata" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content  text-white">
            <div class="modal-body bg-danger text-center " style="border-top-left-radius:5px;border-top-right-radius:5px;">
              <h4 class="text-white mb-15"><i class="fa fa-exclamation-triangle"></i> Apakah anda yakin ?</h4>
              <p>Apakah anda benar-benar ingin menghapus data ini? Apa yang telah anda lakukan tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer mx-auto py-1">
                  <button type="button" class="mr-3 btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
              <form action="<?= route_to('manage-delete-users') ?>" method="post">
                <?= csrf_field() ?>
                  <input type="hidden" name="random" >
                  <button type="submit" class="ml-3 btn btn-sm btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>

<?= $this->endSection() ?>
