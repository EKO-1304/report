<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>

<?php
    $db = \Config\Database::connect(); 

      
?>
<div class="main-container mx-auto" style="max-width:1200px;">
  <div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <h4><?= $title ?></h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><?= $pretitle ?></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
              </ol>
            </nav>
          </div>
        </div>
      </div>

				<div class="pd-20 card-box mb-20">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4"><?= $title ?></h4>
							<p class="mb-30"><span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span></p>
						</div>
						<div class="pull-right">
						</div>
					</div>
          
            <div class="" >
            <?= $this->include('Modules\Layout\Views\alert') ?>
            </div>

         
            <form action="<?= route_to('manage-mobil-save') ?>" method="post"  enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="form-group  required mb-1">
                <label class="starlabel">Sesi Mobil</label>
                <select class="custom-select2 form-control <?php if(session('errors.sesi')){ echo "form-control-danger";}else{} ?>" name="sesi" style="width: 100%; height: 38px;">
                    <option value="">-- Select Sesi Mobil --</option>
                    <?php foreach($sesi as $se){ ?>
                    <option  value="<?= $se["id"] ?>" <?php if(old('sesi') == $se["id"]){ echo "selected";}else{} ?> ><?= $se["sesi"] ?></option>
                    <?php } ?>
                </select>
                <small class="form-control-feedback text-danger"><?= session('errors.sesi') ?></small>
              </div>
              <div class="form-group  required mb-1">
                <label class="starlabel">Tujuan Mobil</label>
                <select id="resulttujuan" class="custom-select2 form-control <?php if(session('errors.tujuan')){ echo "form-control-danger";}else{} ?>" name="tujuan" style="width: 100%; height: 38px;">
                    <option value="">-- Select Tujuan --</option>
                    <option value="dalam" <?php if(old('tujuan') == "dalam"){ echo "selected";}else{} ?> >Dalam Kota</option>
                    <option value="luar" <?php if(old('tujuan') == "luar"){ echo "selected";}else{} ?> >Luar Kota</option>
                </select>
                <small class="form-control-feedback text-danger"><?= session('errors.tujuan') ?></small>
              </div>
              <div class="form-group  required mb-1">
                <label class="starlabel">Daerah</label>
                <select id="resultdaerah" class="custom-select2 form-control <?php if(session('errors.daerah')){ echo "form-control-danger";}else{} ?>" name="daerah" style="width: 100%; height: 38px;">
                    <option value="">-- Select Daerah --</option>
                </select>
                <small class="form-control-feedback text-danger"><?= session('errors.daerah') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Hari, Tanggal, Jam</label>
                <input class="form-control <?php if(session('errors.tanggal')){ echo "form-control-danger";}else{} ?>" type="datetime-local" value="<?= old('tanggal') ?>" name="tanggal">
                <small class="form-control-feedback text-danger"><?= session('errors.tanggal') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Nama Broker</label>
                <input class="form-control <?php if(session('errors.namabroker')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('namabroker') ?>" name="namabroker" placeholder="Nama Broker">
                <small class="form-control-feedback text-danger"><?= session('errors.namabroker') ?></small>
              </div>
              <div class="form-group  mb-1">
                <label class="starlabel">Nama Pendamping</label>
                <input class="form-control <?php if(session('errors.namapendamping')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('namapendamping') ?>" name="namapendamping" placeholder="Nama Pendamping">
                <small class="form-control-feedback text-danger"><?= session('errors.namapendamping') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Nama Calon Nasabah</label>
                <input class="form-control <?php if(session('errors.namanasabah')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('namanasabah') ?>" name="namanasabah" placeholder="Nama Calon Nasabah">
                <small class="form-control-feedback text-danger"><?= session('errors.namanasabah') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Alamat</label>
                <input class="form-control <?php if(session('errors.alamat')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('alamat') ?>" name="alamat" placeholder="Alamat">
                <small class="form-control-feedback text-danger"><?= session('errors.alamat') ?></small>
              </div>
              <div class="form-group  required">
                <label class="starlabel">Status</label>
                <select class="custom-select2 form-control <?php if(session('errors.status')){ echo "form-control-danger";}else{} ?>" name="status" style="width: 100%; height: 38px;">
                    <option value="">-- Select Status Tujuan --</option>
                    <option value="0" <?php if(old('status') == 0){ echo "selected";}else{} ?> >Active</option>
                    <option value="3" <?php if(old('status') == 1){ echo "selected";}else{} ?> >Batalkan</option>
                </select>
                <small class="form-control-feedback text-danger"><?= session('errors.status') ?></small>
              </div>

              <button type="submit" class="btn btn-sm btn-success mt-3">Pengajuan Mobil</button>
            </form>

				</div>
        


    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

 <!-- CSRF token --> 
 <input type="hidden" class="txt_csrfname form-control" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
 
 <script>
        $(document).ready(function(){
            $('#resulttujuan').on('change',function(){
                var resulttujuan = $(this).val();
                var token = $('.txt_csrfname').val();   
                $.ajax({
                    url:"<?= base_url('manage-tujuan-mobil-json'); ?>",
                    type:"POST",
                    data:{<?= csrf_token() ?>:token,jenis:resulttujuan},
                    success:function(respond){
                        $("#resultdaerah").html(respond);
                    },
                    error:function(){
                        alert("Gagal Mengambil Data");
                    }
                })
            })
        });

    </script>


<?= $this->endSection() ?>
