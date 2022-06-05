<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>

<?php
    $db = \Config\Database::connect(); 

      $backlink = "manage-laporan-club";
      $tambahlink = "manage-laporan-club-tambah";
      
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

         
            <form action="<?= route_to('manage-bahan-presentasi-tambah') ?>" method="post"  enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="form-group required mb-1">
                <label class="starlabel">Nama Bahan Presentasi</label>
                <input class="form-control <?php if(session('errors.namabahan')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('namabahan') ?>" name="namabahan" placeholder="Nama Bahan Presentasi">
                <small class="form-control-feedback text-danger"><?= session('errors.namabahan') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Dokumen Bahan Presentasi</label>   
                <span class="text-primary font-weight-bold">Format : jpg | jpeg | png | pdf | xlsx - ukuran max 1 mb</span>      
                <input type="file" name="dokumentasi" class="form-control-file form-control height-auto  <?php if(session('errors.dokumentasi')){ echo "form-control-danger";}else{} ?>">
                <small class="form-control-feedback text-danger"><?= session('errors.dokumentasi') ?></small>
              </div>

              <button type="submit" class="btn btn-sm btn-success mt-3 savedata">Tambah Bahan</button>
            </form>

				</div>
        


    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
