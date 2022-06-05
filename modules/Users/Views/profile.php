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


      <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
          <div class="pd-20 card-box height-100-p">

            <div class="profile-photo">
              <a href="modal" data-toggle="modal" data-target="#modalimguser" class="edit-avatar"><i class="fa fa-pencil"></i></a>
              <img id="profile_img" src="<?= base_url("assets/images/profile/".$profile['user_image']) ?>" alt="" class="avatar-photo">
              <div class="modal fade" id="modalimguser" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-body pd-5">
                      <form action="<?= route_to('manage-img-user-edit') ?>" method="post" class="p-3" enctype="multipart/form-data" >  
                        <?= csrf_field() ?>
                        <input type="hidden" name="random" value="<?= $profile['random_users'] ?>" >   
                        <input type="hidden" name="img" value="<?= $profile['user_image'] ?>" >    
                         <span class="text-primary font-weight-bold">Format image : jpg | jpeg | png - ukuran max image 200 kb</span>      
                        <input type="file" id="file-input-img" accept="image/*" name="user_image" class="form-control-file form-control height-auto  <?php if(session('errors.user_image')){ echo "form-control-danger";}else{} ?>">
                        <small class="form-control-feedback text-danger"><?= session('errors.user_image') ?></small>
                        <div id="previewimg" class="mt-3"></div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Update</button>
                    </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>

            <h5 class="text-center h5 mb-0" id="profile_namalengkap"><?= strtoupper($profile['fullname']) ?></h5>
            <p class="text-center text-muted font-14" id="profile_groupuser"><?= $profile['description'] ?></p>
            <div class="profile-info">

              <h5 class="mb-20 h5 text-blue">Contact Information</h5>
              <ul>
                <li>
                  <span>Email Address:</span>
                  <span class="text-dark" id="profile_email"><?= $profile['email'] ?><span>
                </li>
                <li>
                  <span>Phone Number:</span>
                  <span class="text-dark" id="profile_notelp"><?= $profile['no_telp'] ?><span>
                </li>
                <li>
                  <span>Jenis Kelamin:</span>
                  <span class="text-dark" id="profile_jeniskelamin"><?= $profile['jenis_kelamin'] ?><span>
                </li>
                <li>
                  <span>Alamat:</span>
                  <span class="text-dark" id="profile_alamat"><?= $profile['alamat'] ?><span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
          <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
              <div class="tab height-100-p">
                <ul class="nav nav-tabs customtab" role="tablist">
                  <!-- <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Timeline</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tasks" role="tab">Tasks</a>
                  </li> -->
                  <li class="nav-item">
                    <a class="nav-link <?php if(session()->getFlashdata('tapprofile') <> 'gantipassword' ){echo "active";}else{} ?>" data-toggle="tab" href="#setting" role="tab">Profile Setting</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if(session()->getFlashdata('tapprofile') == 'gantipassword' ){echo "active";}else{} ?>" data-toggle="tab" href="#gantipass" role="tab">Ganti Password</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <!-- Setting Tab End -->
                  <div class="tab-pane fade height-100-p <?php if(session()->getFlashdata('tapprofile') <> 'gantipassword' ){echo "show active";}else{} ?>" id="setting" role="tabpanel">
                    <div class="profile-setting" id="div-to-refresh">
                      <div class="px-3 mt-2" >
                      <?= $this->include('Modules\Layout\Views\alert') ?>
                      </div>

                      <form action="<?= route_to('manage-users-profile-edit') ?>" method="post">
                        <?= csrf_field() ?>

                        <ul class="profile-edit-list row">
                          <li class="weight-500 col-md-12 py-0">
                            <!-- <h4 class="text-blue h5 mb-20">Edit Your Personal Setting</h4> -->

                            <input class="form-control" type="hidden" value="<?= $profile['random_users'] ?>" name="random">

                            <div class="form-group">
                              <label>Username</label>
                              <input class="form-control<?php if(session('errors.username')){ echo "form-control-danger";}else{} ?>" value="<?= $profile['username'] ?>" name="username" type="text">
                              <small class="form-control-feedback text-danger"><?= session('errors.username') ?></small>
                            </div>
                            <div class="form-group">
                              <label>Full Name</label>
                              <input class="form-control <?php if(session('errors.fullname')){ echo "form-control-danger";}else{} ?>" value="<?= $profile['fullname'] ?>" name="fullname" type="text">
                              <small class="form-control-feedback text-danger"><?= session('errors.fullname') ?></small>
                            </div>
                            <div class="form-group">
                              <label>Tanggal lahir</label>
                              <input class="form-control <?php if(session('errors.tanggallahir')){ echo "form-control-danger";}else{} ?> date-picker" value="<?= $profile['tanggal_lahir'] ?>" name="tanggallahir" type="text">
                              <small class="form-control-feedback text-danger"><?= session('errors.tanggallahir') ?></small>
                            </div>
                            <div class="form-group">
                              <label>Jenis Kelamin</label>
                              <div class="d-flex">
                              <?php foreach($jenis_kelamin as $js){ ?>
                              <div class="custom-control custom-radio mb-5 mr-20">
                                <input type="radio" id="jk<?= $js['id'] ?>" <?php if($profile['idjenis_kelamin'] == $js['id'] ){echo "checked";}else{} ?> name="jeniskelamin" value="<?= $js['id'] ?>" class="custom-control-input">
                                <label class="custom-control-label weight-400" for="jk<?= $js['id'] ?>"><?= $js['jenis_kelamin'] ?></label>
                              </div>
                              <?php } ?>
                              <small class="form-control-feedback text-danger"><?= session('errors.jeniskelamin') ?></small>
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Email</label>
                              <input class="form-control <?php if(session('errors.email')){ echo "form-control-danger";}else{} ?>"  value="<?= $profile['email'] ?>" type="text" name="email">
                              <small class="form-control-feedback text-danger"><?= session('errors.email') ?></small>
                            </div>
                            <div class="form-group">
                              <label>Nomor Telp</label>
                              <input class="form-control <?php if(session('errors.nomortelp')){ echo "form-control-danger";}else{} ?>" value="<?= $profile['no_telp'] ?>" type="text" name="nomortelp">
                              <small class="form-control-feedback text-danger"><?= session('errors.nomortelp') ?></small>
                            </div>
                            <div class="form-group">
                              <label>Alamat</label>
                              <textarea class="form-control <?php if(session('errors.alamat')){ echo "form-control-danger";}else{} ?>" name="alamat"><?= $profile['alamat'] ?></textarea>
                              <small class="form-control-feedback text-danger"><?= session('errors.alamat') ?></small>
                            </div>
                            <div class="form-group mb-0">
                  						<button type="submit" class="btn btn-primary">Update Information</button>
                            </div>
                              <div class="mt-3" >
                              <?= $this->include('Modules\Layout\Views\alert') ?>
                              </div>
                          </li>
                        </ul>
                      </form>
                    </div>
                  </div>
                  <!-- Ganti Password Tab End -->
                  <div class="tab-pane fade height-100-p <?php if(session()->getFlashdata('tapprofile') == 'gantipassword' ){echo "show active";}else{} ?>" id="gantipass" role="tabpanel">
                    <div class="profile-setting" id="div-to-refresh">
                      <div class="px-3 mt-2" >
                      <?= $this->include('Modules\Layout\Views\alert') ?>
                      </div>

                      <form action="<?= route_to('manage-users-profile-password') ?>" method="post">
                        <?= csrf_field() ?>

                        <ul class="profile-edit-list row">
                          <li class="weight-500 col-md-6 py-0">
                            <!-- <h4 class="text-blue h5 mb-20">Edit Your Password</h4> -->

                            <input class="form-control" type="hidden" value="<?= $profile['random_users'] ?>" name="random">
                            <?php /*<input class="form-control" type="hidden" value="<?= $profile['password_hash'] ?>" name="passlama">

                            <div class="form-group">
                              <label>Password Lama</label>
                              <input class="form-control <?php if(session('errors.passwordlama')){ echo "form-control-danger";}else{} ?>" value="<?= old('passwordlama') ?>" name="passwordlama" type="password">
                              <small class="form-control-feedback text-danger"><?= session('errors.passwordlama') ?></small>
                            </div> */ ?>
                            <div class="form-group">
                              <label>Password Baru</label>
                              <input class="form-control <?php if(session('errors.passwordbaru')){ echo "form-control-danger";}else{} ?>" value="<?= old('passwordbaru') ?>" name="passwordbaru" type="password">
                              <small class="form-control-feedback text-danger"><?= session('errors.passwordbaru') ?></small>
                            </div>
                            <div class="form-group">
                              <label>Confirm Password Lama</label>
                              <input class="form-control <?php if(session('errors.confirmpasswordbaru')){ echo "form-control-danger";}else{} ?>" value="<?= old('confirmpasswordbaru') ?>" name="confirmpasswordbaru" type="password">
                              <small class="form-control-feedback text-danger"><?= session('errors.confirmpasswordbaru') ?></small>
                            </div>
                            <div class="form-group mb-0">
                  						<button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                          </li>
                          <li class="weight-500 col-md-6">

                          </li>
                        </ul>
                      </form>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>





<?= $this->endSection() ?>
