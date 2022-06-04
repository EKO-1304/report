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

         
            <form action="<?= route_to('update-produk') ?>" method="post">
              <?= csrf_field() ?>
              <?php                 
                $nama_s = $produk["nama_s"];                                                
                $nama_t = $produk["nama_t"];
                if(trim($nama_s) <> ""){
                    $namaproduk = $nama_s;
                }else{
                    $namaproduk = $nama_t;
                }

                
                $image_s = $produk["img_s"];
                $image_t = $produk["img_t"]; 
                if(trim($image_s) <> ""){
                    if(carikarakter($image_s,["http","https"])){
                        $image = $image_s;
                    }else{
                        $image = base_url("assets/images/fotoproduk/".$image_s);
                    }
                }else{                                                    
                    if(carikarakter($image_t,["http","https"])){
                        $image = $image_t;
                    }else{
                        $image = base_url("assets/images/fotoproduk/".$image_t);
                    }
                }
              ?>
              <div class="text-center">
                <img src="<?= $image ?>" style="width:200px;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;border-radius:5px" alt="">
              </div>
              <input class="form-control" type="hidden" name="random" value="<?= $produk["random"] ?>">
              <div class="form-group required mb-1">
                <label class="starlabel">Nama Produk</label>
                <input class="form-control" readonly type="text" value="<?= $namaproduk ?>">
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Link Produk Shopee</label>
                <input class="form-control <?php if(session('errors.linkprodukshopee')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $produk["url_s"] ?>" name="linkprodukshopee" placeholder="Link Produk Shopee">
                <small class="form-control-feedback text-danger"><?= session('errors.linkprodukshopee') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">CashBack Produk Shopee</label>
                <input class="form-control <?php if(session('errors.cashbackprodukshopee')){ echo "form-control-danger";}else{} ?>" type="number" value="<?= $produk["cashback_s"] ?>" name="cashbackprodukshopee" placeholder="CashBack Produk Shopee">
                <small class="form-control-feedback text-danger"><?= session('errors.cashbackprodukshopee') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">Link Produk Tokopedia</label>
                <input class="form-control <?php if(session('errors.linkproduktokopedia')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $produk["url_t"] ?>" name="linkproduktokopedia" placeholder="Link Produk Tokopedia">
                <small class="form-control-feedback text-danger"><?= session('errors.linkproduktokopedia') ?></small>
              </div>
              <div class="form-group required mb-1">
                <label class="starlabel">CashBack Produk Tokopedia</label>
                <input class="form-control <?php if(session('errors.cashbackproduktokopedia')){ echo "form-control-danger";}else{} ?>" type="number" value="<?= $produk["cashback_t"] ?>" name="cashbackproduktokopedia" placeholder="CashBack Produk Tokopedia">
                <small class="form-control-feedback text-danger"><?= session('errors.cashbackproduktokopedia') ?></small>
              </div>
              <div class="form-group required">
                <label class="starlabel">Kategori Produk</label>
                <select class="custom-select2 form-control <?php if(session('errors.kategoriproduk')){ echo "form-control-danger";}else{} ?>" name="kategoriproduk" style="width: 100%; height: 38px;">
                    <option value="">-- Select Kategori --</option>
                  <?php 
                    foreach($kategori as $kat){ 
                  ?>

                    <option value="<?= $kat['id'].'/'.$kat['idsub'] ?>" <?php if($produk["kategori"].'/'.$produk["kategorisub"] == $kat['id'].'/'.$kat['idsub']){ echo "selected";}else{} ?> ><?= '[ '.$kat['namakategori'].' ] - '.$kat['namakategorisub'] ?></option>
                  <?php } ?>
                </select>
                <small class="form-control-feedback text-danger"><?= session('errors.kategoriproduk') ?></small>
              </div>

              <button type="submit" class="btn btn-sm btn-success mt-3 savedata">Edit Produk</button>
              <a href="<?= base_url("produk-saya") ?>" class="btn btn-sm btn-secondary mt-3 savedata">Kembali</a>
            </form>

				</div>
        


    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
