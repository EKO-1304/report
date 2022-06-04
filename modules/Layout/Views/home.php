<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>

<?php $db = \Config\Database::connect(); ?>
    <?php
        $fullname = strtolower(user()->fullname);

        if($fullname <> ''){
            $nama = $fullname;
        }else{
            $nama = strtolower(user()->username);
        }
    ?>
<div class="main-container">
  <div class="pd-ltr-20">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="" >
        <?= $this->include('Modules\Layout\Views\alert') ?>
        </div>
      <div class="row align-items-center">
        
        <div class="col-md-3">
          <img src="<?php echo base_url()?>/vendors/admin/images/banner-img.png" alt="">
        </div>
        <div class="col-md-9">
          <?php  
            
            $ur = $db
            ->table('auth_groups')
            ->select('auth_groups.name,auth_groups.description')
            ->join('auth_groups_users','auth_groups_users.group_id=auth_groups.id','left')
            ->where('auth_groups_users.user_id', user()->id)
            ->get()
            ->getRowArray();

          ?>
          <h4 class="font-20 weight-500 mb-10 text-capitalize">
            Welcome back <div class="weight-600 font-30 text-blue"><?= $ur["description"] ?>!</div>
          </h4>
          <p class="font-18 max-width-600">Selamat datang di Dashboard <?= $ur["description"] ?>.</b></p>
        </div>
      </div>
    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
        <a href="<?= base_url() ?>" target="_blank">SELLER</a>
    </div> 
  </div>
</div>
   

<?= $this->endSection() ?>