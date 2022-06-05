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
                    <div class="col-xl-12 mb-1"  style="float:right">
                      <a class="btn btn-sm btn-primary" href="#" data-toggle="modal"  data-backdrop="static" data-target="#tambahdata"  style="width:100%;"><i class="icon-copy dw dw-add"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
          </div>

          <!-- Tambah data -->
          <div class="modal fade" id="tambahdata"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Edit Data Sub-Sub Menu</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                    </div>
                    <form action="<?= route_to('manage-tambah-sub-sub-menu') ?>" method="post">
                      <?= csrf_field() ?>


                      <div class="form-group  required">
                        <label class="starlabel">Nama Sub Menu</label>
                        <select class="custom-select2 form-control <?php if(session('errors.namasubmenu')){ echo "form-control-danger";}else{} ?>" name="namasubmenu" style="width: 100%; height: 38px;">
                            <option value="">-- Select Nama Sub Menu --</option>
                          <?php foreach($sub_menu as $gr){ ?>
                            <option value="<?= $gr['id'] ?>" <?php if(old('namasubmenu') == $gr['id']){ echo "selected";}else{} ?> ><?= $gr['nama_sub_menu'] ?></option>
                          <?php } ?>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.namasubmenu') ?></small>
                      </div>
                      <div class="form-group required">
                        <label class="starlabel">Nama Sub-Sub Menu</label>
                        <input class="form-control <?php if(session('errors.namasubsubmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('namasubsubmenu') ?>" name="namasubsubmenu" placeholder="Nama Sub-Sub Menu">
                        <small class="form-control-feedback text-danger"><?= session('errors.namasubsubmenu') ?></small>
                      </div>
                      <div class="form-group required">
                        <label class="starlabel">Link Sub-Sub Menu</label>
                        <input class="form-control <?php if(session('errors.linksubsubmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('linksubsubmenu') ?>" name="linksubsubmenu" placeholder="Link Sub-Sub Menu">
                        <small class="form-control-feedback text-danger"><?= session('errors.linksubsubmenu') ?></small>
                      </div>
                      <div class="form-group required">
                        <label class="starlabel">Manage Sub-Sub Menu</label>
                        <input class="form-control <?php if(session('errors.managesubsubmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('managesubsubmenu') ?>" name="managesubsubmenu" placeholder="Manage Sub-Sub Menu">
                        <small class="form-control-feedback text-danger"><?= session('errors.managesubsubmenu') ?></small>
                      </div>
                      <div class="form-group  required">
                        <label class="starlabel">Status Sub-Sub Menu</label>
                        <select class="custom-select2 form-control <?php if(session('errors.statussubsubmenu')){ echo "form-control-danger";}else{} ?>" name="statussubsubmenu" style="width: 100%; height: 38px;">
                          <option value="">-- Select Status Sub-Sub Menu --</option>
                          <option value="0" <?php if(old('statussubsubmenu') == 0){ echo "selected";}else{} ?> >Active</option>
                          <option value="1" <?php if(old('statussubsubmenu') == 1){ echo "selected";}else{} ?> >Non Active</option>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.statussubsubmenu') ?></small>
                      </div>
                      <div class="form-group required">
                        <label class="starlabel ">No Urut (a-z)</label>
                        <input class="form-control <?php if(session('errors.nourut')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('nourut') ?>" name="nourut" placeholder="No Urut">
                        <small class="form-control-feedback text-danger"><?= session('errors.nourut') ?></small>
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
              <tr  class="text-center">
                <th style="width:50px">No</th>
                <th>Nama Sub Menu</th>
                <th>Nama Sub-Sub Menu</th>
                <th>Link Sub-Sub Menu</th>
                <th>Manage Sub-Sub Menu</th>
                <th>Status Sub-Sub Menu</th>
                <th>No Urut</th>
                <th style="width:200px">Action</th>
              </tr>
            </thead>
            <tbody>

                <?php
                  $no=1;
                  foreach($query as $row){
                  $random = $row["random_sub_sub"];
                  $active = $row["status_sub_sub"];
                  if($active == 0){
                    $act = "Active";
                    $bg = "bg-primary";
                  }else{
                    $act = "Non Active";
                    $bg = "bg-danger";
                  }
                ?>

                <tr>
                  <td class="text-center" style="widtd:50px"><?= $no ?></td>
                  <td ><?= $row["nama_sub_menu"] ?></td>
                  <td ><?= $row["nama_sub_sub_menu"] ?></td>
                  <td ><?= $row["link_sub_sub_menu"] ?></td>
                  <td ><?= $row["manage"] ?></td>
                  <td class="text-center"><span class="badge badge-danger  text-light <?= $bg ?>"><?= $act ?> </span></td>
                  <td class="text-center"><?= $row["no_urut_sub_sub"]  ?></td>
                  <td class="text-center" style="width:200px">

                    <div class="dropdown">
                      <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="dw dw-more"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="#" data-toggle="modal"  data-backdrop="static" data-target="#editdata<?= $random ?>"><i class="dw dw-edit2"></i> Edit</a>
                        <a class="dropdown-item" href="#" data-toggle="modal"  data-backdrop="static" data-target="#delete<?= $random ?>"><i class="dw dw-delete-3"></i> Delete</a>
                      </div>

                    </div>

                  </td>
                </tr>


                <!-- Confirmation modal -->
                <div class="modal fade" id="delete<?= $random ?>"  role="dialog" aria-hidden="true">
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
                            <form action="<?= route_to('manage-delete-sub-sub-menu') ?>" method="post">
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
                <div class="modal fade" id="editdata<?= $random ?>"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Edit Data Sub-Sub Menu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      </div>
                      <div class="modal-body text-left">
                          <div  class="mb-2" >
                              <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                          </div>
                          <form action="<?= route_to('manage-edit-sub-sub-menu') ?>" method="post">
                            <?= csrf_field() ?>

                            <input type="hidden" name="random" value="<?= $random ?>" >

                            <div class="form-group  required">
                              <label class="starlabel">Nama Sub Menu</label>
                              <select class="custom-select2 form-control <?php if(session('errors.namasubmenu')){ echo "form-control-danger";}else{} ?>" name="namasubmenu" style="width: 100%; height: 38px;">
                                  <option value="">-- Select Nama Sub Menu --</option>
                                <?php foreach($sub_menu as $gr){ ?>
                                  <option value="<?= $gr['id'] ?>" <?php if($row['id_sub_menu'] == $gr['id']){ echo "selected";}else{} ?>><?= $gr['nama_sub_menu'] ?></option>
                                <?php } ?>
                              </select>
                              <small class="form-control-feedback text-danger"><?= session('errors.namasubmenu') ?></small>
                            </div>
                						<div class="form-group required">
                							<label class="starlabel">Nama Sub-Sub Menu</label>
                							<input class="form-control <?php if(session('errors.namasubsubmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['nama_sub_sub_menu'] ?>" name="namasubsubmenu" placeholder="Nama Sub-Sub Menu">
                              <small class="form-control-feedback text-danger"><?= session('errors.namasubsubmenu') ?></small>
                						</div>
                						<div class="form-group required">
                							<label class="starlabel">Link Sub-Sub Menu</label>
                							<input class="form-control <?php if(session('errors.linksubsubmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['link_sub_sub_menu'] ?>" name="linksubsubmenu" placeholder="Link Sub-Sub Menu">
                              <small class="form-control-feedback text-danger"><?= session('errors.linksubsubmenu') ?></small>
                						</div>
                						<div class="form-group required">
                							<label class="starlabel">Manage Sub-Sub Menu</label>
                							<input class="form-control <?php if(session('errors.managesubsubmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['manage'] ?>" name="managesubsubmenu" placeholder="Manage Sub-Sub Menu">
                              <small class="form-control-feedback text-danger"><?= session('errors.managesubsubmenu') ?></small>
                						</div>
                            <div class="form-group  required">
                              <label class="starlabel">Status Sub-Sub Menu</label>
                              <select class="custom-select2 form-control <?php if(session('errors.statussubsubmenu')){ echo "form-control-danger";}else{} ?>" name="statussubsubmenu" style="width: 100%; height: 38px;">
                                <option value="">-- Select Status Sub-Sub Menu --</option>
                                <option value="0" <?php if($row['status_sub_sub'] == 0){ echo "selected";}else{} ?> >Active</option>
                                <option value="1" <?php if($row['status_sub_sub'] == 1){ echo "selected";}else{} ?> >Non Active</option>
                              </select>
                              <small class="form-control-feedback text-danger"><?= session('errors.statussubsubmenu') ?></small>
                            </div>
                						<div class="form-group required">
                							<label class="starlabel">No Urut (a-z)</label>
                							<input class="form-control <?php if(session('errors.nourut')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['no_urut_sub_sub'] ?>" name="nourut" placeholder="No Urut">
                              <small class="form-control-feedback text-danger"><?= session('errors.nourut') ?></small>
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

<?= $this->endSection(); ?>
