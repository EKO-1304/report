
<?= $this->extend('Modules\Login\Views\layout') ?>

<?= $this->section('content') ?>

<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 col-lg-7">
        <img src="<?php echo base_url()?>/vendors/admin/images/login-page-img.png" alt="">
      </div>
      <div class="col-md-6 col-lg-5">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-primary"><?= $title ?></h2>
          </div>
					<?= view('Myth\Auth\Views\_message_block') ?>
          <form action="<?= route_to($ket1) ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>

            <?php if ($config->validFields === ['email']): ?>

            <div class="input-group custom">
              <input type="text"  name="login" class="form-control form-control-lg <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="Email">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.login') ?>
              </div>
            </div>

            <?php else: ?>

            <div class="input-group custom">
              <input type="text" class="form-control form-control-lg <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="Username">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.login') ?>
              </div>
            </div>

            <?php endif; ?>

            <div class="input-group custom">
              <input type="password" name="password" class="form-control form-control-lg <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.password') ?>
              </div>
            </div>
            <div class="row pb-30">
              <div class="col-6">
                <?php if ($config->allowRemembering): ?>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="checkbox1" <?php if(old('remember')) : ?> checked <?php endif ?>>
                  <label class="custom-control-label" for="checkbox1">Remember</label>
                </div>
                <?php endif; ?>
              </div>
              <div class="col-6">
                <?php 
                    if ($config->activeResetter): 
                    if($ket0 == ""){
                      $forgot = "";
                    }else{
                      $forgot = "-".$ket0;
                    }
                ?>
                <div class="forgot-password"><a href="<?= route_to('forgot'.$forgot) ?>" class="font-weight-bold text-danger">Lupa Password</a></div>
                <?php endif; ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="input-group mb-0">
                    <!-- use code for form submit -->
                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                </div>
                <?php if($ket1 <> "login"){ ?>
                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                <div class="input-group mb-0">
                  <a class="btn btn-outline-primary btn-lg btn-block" href="<?= base_url($ket2) ?>">Daftar Akun <?= ucwords($ket0) ?></a>
                </div>
                <?php } ?>
                
                
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
