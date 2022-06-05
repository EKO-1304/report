
<?= $this->extend('Modules\Login\Views\layout') ?>

<?= $this->section('content') ?>

<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
  <div class="container">
    <div class="row align-items-center">
      
      <div class="col-md-6 col-lg-5 mx-auto">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-success"><?= $title ?></h2>
          </div>
          <form action="<?= route_to($ket1) ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>

            <?php $random = sha1(time().rand(111111,999999)); ?>
            <input type="hidden" name="random" value="<?= $random ?>" >
            <input type="hidden" name="jenisuser" value="staf" >
            <div class="input-group custom mb-1">
              <input type="text"  name="fullname"  style="border-radius:20px" class="form-control <?php if(session('errors.fullname')) : ?>is-invalid<?php endif ?>" placeholder="fullname" value="<?= old('fullname') ?>">
              <div class="invalid-feedback text-left">
                  <?= session('errors.fullname') ?>
              </div>
            </div>
            <div class="input-group custom mb-1">
              <input type="text"  name="username" style="border-radius:20px" style="border-radius:20px" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" placeholder="Username" value="<?= old('username') ?>">
              <div class="invalid-feedback text-left">
                  <?= session('errors.username') ?>
              </div>
            </div>
            <div class="input-group custom mb-1">
              <input type="text"  name="email" style="border-radius:20px" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="Email" value="<?= old('email') ?>">
              <div class="invalid-feedback text-left">
                  <?= session('errors.email') ?>
              </div>
            </div>
            <div class="input-group custom mb-1">
              <input type="password" name="password" style="border-radius:20px" class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password" value="<?= old('password') ?>">
             <div class="invalid-feedback text-left">
                  <?= session('errors.password') ?>
              </div>
            </div>
            <div class="input-group custom mb-1">
              <input type="password" name="pass_confirm" style="border-radius:20px" class="form-control <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Password Confirm" value="<?= old('pass_confirm') ?>">
              <div class="invalid-feedback text-left">
                  <?= session('errors.pass_confirm') ?>
              </div>
            </div>
            <?php 
            $db = \Config\Database::connect();
            $group = $db->table("auth_groups")->select("name,description")->get()->getResultArray();
            ?>
            <div class="input-group custom mb-2">
              <select class="custom-select2 form-control <?php if(session('errors.group')){ echo "is-invalid";}else{} ?>" name="group" style="width: 100%; height: 38px;border-radius:20px">
                  <option value="">-- Select Jabatan --</option>
                <?php foreach($group as $gr){ 
                    if(! carikarakter($gr["description"],["super administrator","Admin Master"])){
                ?>
                  <option value="<?= $gr['name'] ?>" <?php if(old('group') == $gr['name']){ echo "selected";}else{} ?> ><?= $gr['description'] ?></option>
                <?php }} ?>
              </select>
              <div class="invalid-feedback text-left">
                  <?= session('errors.group') ?>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="input-group mb-2">

                    <!-- use code for form submit -->
                    <input class="btn btn-success btn-lg btn-block" style="border-radius:20px" type="submit" value="Daftar Akun">

                  <!-- <a class="btn btn-success btn-lg btn-block" href="index.html">Sign In</a> -->
                </div>
                <!-- <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div> -->
                <div class="input-group mb-0">
                  <a class="btn btn-outline-success btn-lg btn-block" style="border-radius:20px" href="<?= $ket2 ?>">Back Login</a>
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
