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

            
            <form action="<?= route_to('manage-input-laporan-update') ?>" method="post"  enctype="multipart/form-data">
              <?= csrf_field() ?>
              <input type="hidden" value="<?= $lap["random"] ?>" name="random">
              <input type="hidden" value="<?= $lap["dokumentasi"] ?>" name="imgdokumentasiedit">
              <div class="form-group required mb-1">
                <label class="starlabel">Nama Broker</label>
                <input class="form-control <?php if(session('errors.namabroker')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $lap["broker"] ?>" name="namabroker" placeholder="Nama Broker">
                <small class="form-control-feedback text-danger"><?= session('errors.namabroker') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Nama Pendamping</label>
                <input class="form-control <?php if(session('errors.namapendamping')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $lap["pendamping"] ?>" name="namapendamping" placeholder="Nama Pendamping">
                <small class="form-control-feedback text-danger"><?= session('errors.namapendamping') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Nama Calon Nasabah</label>
                <input class="form-control <?php if(session('errors.namanasabah')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $lap["namanasabah"] ?>" name="namanasabah" placeholder="Nama Calon Nasabah">
                <small class="form-control-feedback text-danger"><?= session('errors.namanasabah') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Nomor WhatsApp</label>
                <input class="form-control <?php if(session('errors.nomorwa')){ echo "form-control-danger";}else{} ?>" type="number" value="<?= $lap['nomorwa'] ?>" name="nomorwa" placeholder="Nomor WhatsApp">
                <small class="form-control-feedback text-danger"><?= session('errors.nomorwa') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Pekerjaan</label>
                <input class="form-control <?php if(session('errors.pekerjaan')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $lap["pekerjaan"] ?>" name="pekerjaan" placeholder="Pekerjaan">
                <small class="form-control-feedback text-danger"><?= session('errors.pekerjaan') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Alamat</label>
                <input class="form-control <?php if(session('errors.alamat')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $lap["alamat"] ?>" name="alamat" placeholder="Alamat">
                <small class="form-control-feedback text-danger"><?= session('errors.alamat') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Hasil</label>
                <textarea class="form-control <?php if(session('errors.hasil')){ echo "form-control-danger";}else{} ?>" type="text"  name="hasil" placeholder="Hasil"><?= $lap["hasil"] ?></textarea>
                <small class="form-control-feedback text-danger"><?= session('errors.hasil') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Dokumentasi Foto</label>   
                <span class="text-primary font-weight-bold">Format image : jpg | jpeg | png - ukuran max image 200 kb</span>      
                <input type="file" id="file-input-img2" accept="image/*" name="dokumentasi" class="form-control-file form-control height-auto  <?php if(session('errors.dokumentasi')){ echo "form-control-danger";}else{} ?>">
                <small class="form-control-feedback text-danger"><?= session('errors.dokumentasi') ?></small>
                <div id="previewimg2" class="mt-3"></div>
                <?php if ($lap['dokumentasi'] <> ''){ ?>
                  <img src="<?= base_url("assets/images/dokumentasi/".$lap['dokumentasi']) ?>" id="imgsekarang2" style="max-width:200px" >
                <?php } ?>
              </div>

              <button type="submit" class="btn btn-sm btn-success mt-3 ">Update Laporan</button>
              <a href="<?= base_url("manage-nasabah") ?>" class="btn btn-sm btn-dark text-light mt-3" >Kembali</a>
            </form>

				</div>
        


    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
