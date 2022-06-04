
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
            <h2 class="text-center text-primary"><?=lang('Auth.forgotPassword')?></h2>
          </div>
          <?= view('Myth\Auth\Views\_message_block') ?>
          <p><?=lang('Auth.enterEmailForInstructions')?></p>
          <!-- <h6 class="mb-20">Enter your email address to reset your password</h6> -->
          <form action="<?= route_to('forgot') ?>" method="post">
          <?= csrf_field() ?>

            <div class="input-group custom">
              <input type="text" name="email" class="form-control form-control-lg <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="Email">
              <div class="input-group-append custom">
                <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
              </div>
              <div class="invalid-feedback text-left">
                  <?= session('errors.email') ?>
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
              <div class="col-2">
                <div class="font-16 weight-600 text-center" data-color="#707373">OR</div>
              </div>
              <div class="col-5">
                <div class="input-group mb-0">
                  <a class="btn btn-outline-primary btn-lg btn-block" href="<?= base_url($ket2) ?>">Login</a>
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
