
<?= $this->extend('Modules\Login\Views\layout') ?>

<?= $this->section('content') ?>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <img src="<?php echo base_url()?>/vendors/admin/images/forgot-password.png" alt="">
      </div>
      <div class="col-md-6">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-primary"><?= $title ?></h2>
          </div>
          <h6 class="mb-20">Masukkan password baru Anda, konfirmasi dan kirim</h6>
					<?= view('Myth\Auth\Views\_message_block') ?>
          <form action="<?= route_to($ket1) ?>" method="post">
            <?= csrf_field() ?>
      		<?php $random = sha1(time().rand(111111,999999)); ?>
              <div class="input-group custom">
                <input type="text" name="token" class="form-control form-control-lg <?php if(session('errors.token')) : ?>is-invalid<?php endif ?>" placeholder="Token Reset Password" value="<?= $token ?>">
                <div class="input-group-append custom">
                  <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
                <div class="invalid-feedback text-left">
                    <?= session('errors.token') ?>
                </div>
              </div>
             <div class="input-group custom">
              <input type="text" name="email" class="form-control form-control-lg <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="Email" value="<?= $email ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.email') ?>
              </div>
            </div>
            <div class="input-group custom">
              <input type="text" name="password" class="form-control form-control-lg <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="New Password" value="<?= old('password') ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.password') ?>
              </div>
            </div>
            <div class="input-group custom">
              <input type="text" name="pass_confirm" class="form-control form-control-lg <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Confirm New Password" value="<?= old('pass_confirm') ?>">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.pass_confirm') ?>
              </div>
            </div>
            <div class="row align-items-center">
              <div class="col-5">
                <div class="input-group mb-0">

                    <!-- use code for form submit -->
                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">

                  <!-- <a class="btn btn-primary btn-lg btn-block" href="index.html">Submit</a> -->
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
