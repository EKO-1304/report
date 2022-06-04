
<?= $this->extend('Modules\Login\Views\layout') ?>

<?= $this->section('content') ?>

<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 col-lg-7">
        <img src="<?php echo base_url()?>/vendors/admin/images/register-page-img.png" alt="">
      </div>
      <div class="col-md-6 col-lg-5">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-primary"><?= $title ?></h2>
          </div>
          <form action="<?= route_to($ket1) ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>

            <?php $random = sha1(time().rand(111111,999999)); ?>
            <input type="hidden" name="random" value="<?= $random ?>" >
            <input type="hidden" name="jenisuser" value="<?= $ket0 ?>" >
            <div class="input-group custom">
              <input type="text"  name="fullname" class="form-control form-control-lg <?php if(session('errors.fullname')) : ?>is-invalid<?php endif ?>" placeholder="fullname" value="<?= old('fullname') ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.fullname') ?>
              </div>
            </div>
            <div class="input-group custom">
              <input type="text"  name="username" class="form-control form-control-lg <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" placeholder="Username" value="<?= old('username') ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.username') ?>
              </div>
            </div>
            <div class="input-group custom">
              <input type="text"  name="email" class="form-control form-control-lg <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="Email" value="<?= old('email') ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.email') ?>
              </div>
            </div>
            <div class="input-group custom">
              <input type="password" name="password" class="form-control form-control-lg <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password" value="<?= old('password') ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.password') ?>
              </div>
            </div>
            <div class="input-group custom">
              <input type="password" name="pass_confirm" class="form-control form-control-lg <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Password Confirm" value="<?= old('pass_confirm') ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.pass_confirm') ?>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="input-group mb-0">

                    <!-- use code for form submit -->
                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Daftar Akun">

                  <!-- <a class="btn btn-primary btn-lg btn-block" href="index.html">Sign In</a> -->
                </div>
                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                <div class="input-group mb-0">
                  <a class="btn btn-outline-primary btn-lg btn-block" href="<?= $ket2 ?>">Back Login</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
