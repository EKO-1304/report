<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>

<div class="main-container">
  <div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <h4><?= $pretitle ?></h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
              </ol>
            </nav>
          </div>
        </div>
      </div>

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4"><?= $title ?></h4>
							<p class="mb-30"><span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span></p>
						</div>
						<div class="pull-right">
              <a href="<?= base_url("manage-staf") ?>" class="btn btn-dark btn-sm" style="width:100%" ><span class="icon-copy ti-back-left mr-2"></span>Kembali</a>
						</div>
					</div>
          
            <div class="px-3" >
            <?= $this->include('Modules\Layout\Views\alert') ?>
            </div>

              <form action="<?= route_to('manage-tambah-staf') ?>" method="post">
                <?= csrf_field() ?>

                
                  <div class="row">
                      <div class="col-sm-6">

                        <div class="form-group required">
                          <label class="starlabel">Nama Lengkap</label>
                          <input class="form-control <?php if(session('errors.fullname')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('fullname') ?>" name="fullname" placeholder="Nama Lengkap">
                          <small class="form-control-feedback text-danger"><?= session('errors.fullname') ?></small>
                        </div>
                        <div class="form-group required">
                          <label class="starlabel">E-mail</label>
                          <input class="form-control  <?php if(session('errors.email')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('email') ?>" name="email" placeholder="E-mail">
                          <small class="form-control-feedback text-danger"><?= session('errors.email') ?></small>
                        </div>
                        <div class="form-group required">
                          <label class="starlabel">Username</label>
                          <input class="form-control  <?php if(session('errors.username')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('username') ?>" name="username" placeholder="Username">
                          <small class="form-control-feedback text-danger"><?= session('errors.username') ?></small>
                        </div>
                        
                      </div>
                      <div class="col-sm-6">

                      <div class="form-group required">
                          <label class="starlabel">Password</label>
                          <input class="form-control  <?php if(session('errors.password')){ echo "form-control-danger";}else{} ?>" type="password" name="password" placeholder="Kosongi Passsword Jika Tidak Ubah Password">
                          <small class="form-control-feedback text-danger"><?= session('errors.password') ?></small>
                        </div>
                        <div class="form-group required">
                          <label class="starlabel">Confirm Password</label>
                          <input class="form-control  <?php if(session('errors.confirm_password')){ echo "form-control-danger";}else{} ?>" type="password"  name="confirm_password" placeholder="Confirm Password">
                          <small class="form-control-feedback text-danger"><?= session('errors.confirm_password') ?></small>
                        </div>
                        <div class="form-group  required">
                          <label class="starlabel">Groups Access</label>
                          <select class="custom-select2 form-control <?php if(session('errors.groups_access')){ echo "form-control-danger";}else{} ?>" name="groups_access" style="width: 100%; height: 38px;">
                              <option value="">-- Select Groups Access --</option>
                            <?php foreach($groups as $gr){ 
                                if(! carikarakter($gr["description"],["super administrator"])){
                            ?>
                              <option value="<?= $gr['id'] ?>" <?php if(old('groups_access') == $gr['id']){echo "selected";}else{} ?> ><?= $gr['description'] ?></option>
                            <?php }} ?>
                          </select>
                          <small class="form-control-feedback text-danger"><?= session('errors.groups_access') ?></small>
                        </div>
                        <div class="form-group  required">
                          <label class="starlabel">Status User</label>
                          <select class="custom-select2 form-control <?php if(session('errors.status_user')){ echo "form-control-danger";}else{} ?>" name="status_user" style="width: 100%; height: 38px;">
                            <option value="" >-- Select Status User --</option>
                            <option value="1" selected <?php if(old('status_user') == 1){ echo "selected";}else{} ?> >Active</option>
                            <option value="0" <?php if(old('status_user') == 0){ echo "selected";}else{} ?> >Non Active</option>
                          </select>
                          <small class="form-control-feedback text-danger"><?= session('errors.status_user') ?></small>
                        </div>
                        
                      </div>
                  </div>

                  <button type="submit" class="btn btn-primary">Tambah Data</button>
                      
              </form>

				</div>


    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>


<?= $this->endSection() ?>
