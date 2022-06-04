<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>
<?php
    if(in_groups("super_administrator")){
      $userstat = 1;
    }else{
      $userstat = 0;
    }
?>
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

      <!-- Checkbox select Datatable start -->
      <div class="card-box mb-30">
          <div class="row">
            <div class="col-sm-8">
              <div class="pd-20">
                <h4 class="text-blue h4"><?= $title ?></h4>
              </div>
            </div>
            <div class="col-sm-4">
                <div class="pd-20" >
                    <div class="col-xl-4 mb-1"  style="float:right">
                      <a class="btn btn-sm btn-primary" href="#" data-toggle="modal"  data-backdrop="static" data-target="#tambahdata"  style="width:100%;"><i class="icon-copy dw dw-add"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
          </div>

          <!-- Tambah data -->
          <div class="modal fade" id="tambahdata" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Tambah Data Users</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                    </div>
                    <form action="<?= route_to('manage-tambah-users') ?>" method="post">
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
                                <?php foreach($groups as $gr){ ?>
                                  <option value="<?= $gr['id'] ?>" <?php if(old('groups_access') == $gr['id']){echo "selected";}else{} ?> ><?= $gr['description'] ?></option>
                                <?php } ?>
                              </select>
                              <small class="form-control-feedback text-danger"><?= session('errors.groups_access') ?></small>
                            </div>
                            <div class="form-group  required">
                              <label class="starlabel">Status User</label>
                              <select class="custom-select2 form-control <?php if(session('errors.status_user')){ echo "form-control-danger";}else{} ?>" name="status_user" style="width: 100%; height: 38px;">
                                <option value="" selected>-- Select Status User --</option>
                                <option value="1" <?php if(old('status_user') == 1){ echo "selected";}else{} ?> >Active</option>
                                <option value="0" <?php if(old('status_user') == 0){ echo "selected";}else{} ?> >Non Active</option>
                              </select>
                              <small class="form-control-feedback text-danger"><?= session('errors.status_user') ?></small>
                            </div>
                            
                          </div>
                      </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
                  </form>
              </div>
            </div>
          </div>
        <div class="px-3" >
        <?= $this->include('Modules\Layout\Views\alert') ?>
        </div>

        <div class="pb-20">


          <table class="table-dataku table  stripe hover nowrap " style="width:100%">
            <thead>
              <tr class="text-center">
                <th style="width:50px">No</th>
                <th>Nama User</th>
                <th>Groups User</th>
                <th>Jenis User</th>
                <th>Nomor Wa</th>
                <th>Status</th>
                <th style="width:200px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $db = \Config\Database::connect(); 
                $no=1;
                foreach($query as $row){

                $random = $row["random"];
                $active = $row["active"];
                if($active == 1){
                  $act = "Active";
                  $bg = "badge-primary";
                }else{
                  $act = "Non Active";
                  $bg = "badge-danger";
                }
                $jenisuser = $row["jenisuser"];
                if($jenisuser == 'adm'){
                  $actjenisuser = '<span class="badge badge-success text-light text-uppercase">'.$row["jenisuser"].'</span>';
                }elseif($jenisuser == 'aspri'){
                  $actjenisuser = '<span class="badge badge-warning text-dark text-uppercase">'.$row["jenisuser"].'</span>';
                }elseif($jenisuser == 'magang'){
                  $actjenisuser = '<span class="badge badge-info text-dark text-uppercase">'.$row["jenisuser"].'</span>';
                }else{
                  $actjenisuser = '';
                }
                
                $pro = $db->table("profile_user")->select("no_telp")->where("random",$row["random"])->get()->getRowArray();
                if($pro <> null){

                  $notelp1 = substr($pro["no_telp"],0,2);
                  $notelp = str_replace(" ","",str_replace("+","",str_replace("-","",$pro["no_telp"])));
                  if($notelp1 == '08'){
                    $notelp2 = substr($pro["no_telp"],1);
                    $nowa = '62'.$notelp2;
                  }elseif($notelp1 == '62'){
                    $notelp2 = substr($pro["no_telp"],2);
                    $nowa = '62'.$notelp2;
                  }else{
                    $nowa = $notelp;
                  }

                  $nomorwa = '<a href="https://wa.me/'.$nowa.'" target="_BLANK" class="btn btn-success btn-sm py-1"><i class="icon-copy ion-social-whatsapp"></i> '.$nowa.'</a>';
                }else{
                  $nomorwa ='';
                }

              ?>
              <tr>
                <td class="text-center" style="widtd:50px"><?= $no ?></td>
                <td ><span class="font-weight-bold text-primary"><?= $row["fullname"] ?></span> 
                    <br><span><i class="icon-copy fa fa-user-circle-o" style="width:20px" aria-hidden="true"></i><?= $row["username"] ?></span> 
                    <br><i class="icon-copy fa fa-envelope-o" style="width:20px" aria-hidden="true"></i><?= $row["email"] ?></span>
                </td>
                <td ><?= $row["description"] ?></td>
                <td class="text-center" ><?= $actjenisuser ?></td>
                <td class="text-center" ><?= $nomorwa ?></td> 
                <td class="text-center" ><span class="badge text-light <?= $bg ?>"><?= $act ?></span></td>
                <td class="text-center" style="width:200px">

                  <div class="dropdown">
                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                      <i class="dw dw-more"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                      <a class="dropdown-item" href="<?= base_url('manage-users/profile/'.$random) ?>"><i class="icon-copy dw dw-user-12"></i> Profile</a>
                      <a class="dropdown-item" href="#" data-toggle="modal"  data-backdrop="static" data-target="#editdata<?= $random ?>"><i class="dw dw-edit2"></i> Edit</a>
                      <a class="dropdown-item" href="#" data-toggle="modal"  data-backdrop="static" data-target="#delete<?= $random ?>"><i class="dw dw-delete-3"></i> Delete</a>
                    </div>

                  </div>

                </td>
              </tr>

              <!-- Confirmation modal -->
              <div class="modal fade" id="delete<?= $random ?>" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-body text-center font-18">
                      <h4 class="padding-top-30 mb-30 weight-500">Are you sure you want to continue?</h4>
                      <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto;">
                        <div class="col-6">
                          <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal"><i class="fa fa-times"></i></button>
                          NO
                        </div>
                        <div class="col-6">
                          <form action="<?= route_to('manage-delete-users') ?>" method="post">
                              <?= csrf_field() ?>
                            <input type="hidden" name="random" value="<?= $random ?>" >
                            <button type="submit" class="btn btn-primary border-radius-100 btn-block confirmation-btn"><i class="fa fa-check"></i></button>
                            YES
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Edit data -->
              <div class="modal fade" id="editdata<?= $random ?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myLargeModalLabel">Edit Data Users</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body text-left">
                        <div  class="mb-2" >
                            <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                        </div>
                        <form action="<?= route_to('manage-edit-users') ?>" method="post">
                          <?= csrf_field() ?>

                          <input type="hidden" name="random" value="<?= $random ?>" >
                          
                          <div class="row">
                              <div class="col-sm-6">

                                <div class="form-group required">
                                  <label class="starlabel">Nama Lengkap</label>
                                  <input class="form-control <?php if(session('errors.fullname')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['fullname'] ?>" name="fullname" placeholder="Nama Lengkap">
                                  <small class="form-control-feedback text-danger"><?= session('errors.fullname') ?></small>
                                </div>
                                <div class="form-group required">
                                  <label class="starlabel">E-mail</label>
                                  <input class="form-control  <?php if(session('errors.email')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['email'] ?>" name="email" placeholder="E-mail">
                                  <small class="form-control-feedback text-danger"><?= session('errors.email') ?></small>
                                </div>
                                <div class="form-group required">
                                  <label class="starlabel">Username</label>
                                  <input class="form-control  <?php if(session('errors.username')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['username'] ?>" name="username" placeholder="Username">
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
                                    <?php foreach($groups as $gr){ ?>
                                      <option value="<?= $gr['id'] ?>" <?php if($row['group_id'] == $gr['id']){echo "selected";}else{} ?> ><?= $gr['description'] ?></option>
                                    <?php } ?>
                                  </select>
                                  <small class="form-control-feedback text-danger"><?= session('errors.groups_access') ?></small>
                                </div>
                                <div class="form-group  required">
                                  <label class="starlabel">Status User</label>
                                  <select class="custom-select2 form-control <?php if(session('errors.status_user')){ echo "form-control-danger";}else{} ?>" name="status_user" style="width: 100%; height: 38px;">
                                    <option value="">-- Select Status User --</option>
                                    <option value="1" <?php if($row['active'] == 1){ echo "selected";}else{} ?> >Active</option>
                                    <option value="0" <?php if($row['active'] == 0){ echo "selected";}else{} ?> >Non Active</option>
                                  </select>
                                  <small class="form-control-feedback text-danger"><?= session('errors.status_user') ?></small>
                                </div>

                              </div>
                          </div>


                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Edit Data</button>
                    </div>
                      </form>
                  </div>
                </div>
              </div>

              <?php $no++;} ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Checkbox select Datatable End -->


    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
      <?= $this->include('Modules\Layout\Views\footer') ?>
    </div>
  </div>
</div>




<?= $this->endSection() ?>
