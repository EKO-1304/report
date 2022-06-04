<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>

<?php
    $db = \Config\Database::connect(); 

      $backlink = "manage-laporan-club";
      $tambahlink = "manage-laporan-club-tambah";
      
?>
<div class="main-container mx-auto" style="width:1200px;">
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

         
            <form action="<?= route_to('manage-input-laporan-save') ?>" method="post">
              <?= csrf_field() ?>

              <div class="form-group required mb-1">
                <label class="starlabel">Nama Broker</label>
                <select class="custom-select2 form-control <?php if(session('errors.namabroker')){ echo "form-control-danger";}else{} ?>" name="namabroker" style="width: 100%; height: 38px;">
                    <option value="">-- Select Broker --</option>
                  <?php foreach($broker as $bk){ ?>
                    <option value="<?= $bk['id'] ?>" <?php if(old('namabroker') == $bk['id']){ echo "selected";}else{} ?> ><?= $bk['fullname'] ?></option>
                  <?php } ?>
                </select>
                <small class="form-control-feedback text-danger"><?= session('errors.namabroker') ?></small>
              </div>
              <div class="form-group mb-1">
                <label class="starlabel">Pendamping</label>
                <select class="custom-select2 form-control <?php if(session('errors.namapendamping')){ echo "form-control-danger";}else{} ?>" name="namapendamping" style="width: 100%; height: 38px;">
                    <option value="">-- Select Pendamping --</option>
                  <?php foreach($senior as $pen){ ?>
                    <option value="<?= $pen['id'] ?>" <?php if(old('namapendamping') == $pen['id']){ echo "selected";}else{} ?> ><?= $pen['fullname'] ?></option>
                  <?php } ?>
                </select>
                <small class="form-control-feedback text-danger"><?= session('errors.namapendamping') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Nama Calon Nasabah</label>
                <input class="form-control <?php if(session('errors.namanasabah')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('namanasabah') ?>" name="namanasabah" placeholder="Nama Calon Nasabah">
                <small class="form-control-feedback text-danger"><?= session('errors.namanasabah') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Pekerjaan</label>
                <input class="form-control <?php if(session('errors.pekerjaan')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('pekerjaan') ?>" name="pekerjaan" placeholder="Pekerjaan">
                <small class="form-control-feedback text-danger"><?= session('errors.pekerjaan') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Alamat</label>
                <input class="form-control <?php if(session('errors.alamat')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('alamat') ?>" name="alamat" placeholder="Alamat">
                <small class="form-control-feedback text-danger"><?= session('errors.alamat') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Hasil</label>
                <textarea class="form-control <?php if(session('errors.hasil')){ echo "form-control-danger";}else{} ?>" type="text"  name="hasil" placeholder="Hasil"><?= old('hasil') ?></textarea>
                <small class="form-control-feedback text-danger"><?= session('errors.hasil') ?></small>
              </div>

              <button type="submit" class="btn btn-sm btn-primary mt-3 savedata">Tambah Laporan</button>
            </form>

				</div>
        


    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
