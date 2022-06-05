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

      <!-- Checkbox select Datatable start -->
      <div class="card-box mb-20">
          <div class="row">
            <div class="col-sm-8">
              <div class="pd-20">
                <h4 class="text-blue h4"><?= $title ?></h4>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="pd-20">
                <?php 
                  $uri = service('uri');
                ?>
                <a href="<?= base_url($uri->getSegment(1)) ?>" class="btn btn-dark text-light btn-sm ml-2 mt-2" style="float:right" >Kembali</a>
              </div>
            </div>
          </div>
          
				<div class="pd-20">
          
          
          <div class="row" style="font-size:14px">
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold" >Nama Broker</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["broker"] ?></span>
              </div>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Nama Pendamping</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["pendamping"] ?></span>
              </div>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Nama Staf</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["fullname"] ?></span>
              </div>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Nama Nasabah</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["namanasabah"] ?></span>
              </div>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Nomor Wa</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["nomorwa"] ?></span>
              </div>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Alamat</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["alamat"] ?></span>
              </div>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Pekerjaan</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["pekerjaan"] ?></span>
              </div>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Hasil</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <?= $dt["hasil"] ?></span>
              </div>
              <?php if($dt["dokumentasi"] <> ""){ ?>
              <div class="col-sm-3 col-4 mb-1">
                  <span class="font-weight-bold">Dokumentasi Foto</span>
              </div>
              <div class="col-sm-9 col-8 mb-1">
                  <span>: <img src="<?= base_url("assets/images/dokumentasi/".$dt["dokumentasi"]) ?>" style="width:200px" ></span>
              </div>
              <?php } ?>

            </div>

				</div>
        
              </div>

    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
