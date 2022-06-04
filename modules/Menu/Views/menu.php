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
                    <div class="col-xl-4 mb-1"  style="float:right">
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
                  <h4 class="modal-title" id="myLargeModalLabel">Tambah Data Menu</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                    </div>
                    <form action="<?= route_to('manage-tambah-menu') ?>" method="post">
                      <?= csrf_field() ?>

                      <div class="form-group  required">
                        <label class="starlabel">Groups Menu</label>
                        <select class="custom-select2 form-control <?php if(session('errors.namagroups')){ echo "form-control-danger";}else{} ?>" name="namagroups" style="width: 100%; height: 38px;">
                            <option value="">-- Select Groups Menu --</option>
                          <?php foreach($group_menu as $gr){ ?>
                            <option value="<?= $gr['id'] ?>" <?php if(old("namagroups") == $gr['id']){ echo "selected";}else{} ?>><?= $gr['nama_group'] ?></option>
                          <?php } ?>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.namagroups') ?></small>
                      </div>
          						<div class="form-group required">
          							<label class="starlabel">Nama Menu</label>
          							<input class="form-control <?php if(session('errors.namamenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('namamenu') ?>" name="namamenu" placeholder="Nama Menu">
                        <small class="form-control-feedback text-danger"><?= session('errors.namamenu') ?></small>
          						</div>
          						<div class="form-group required">
          							<label class="starlabel">Link Menu</label>
          							<input class="form-control <?php if(session('errors.linkmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('linkmenu') ?>" name="linkmenu" placeholder="Link Menu">
                        <small class="form-control-feedback text-danger"><?= session('errors.linkmenu') ?></small>
          						</div>
          						<div class="form-group required">
          							<label class="starlabel">Manage Menu</label>
          							<input class="form-control <?php if(session('errors.managemenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('managemenu') ?>" name="managemenu" placeholder="Manage Sub Menu">
                        <small class="form-control-feedback text-danger"><?= session('errors.managemenu') ?></small>
          						</div>
                      <div class="form-group  required">
                        <label class="starlabel">Status New</label>
                        <select class="custom-select2 form-control <?php if(session('errors.new')){ echo "form-control-danger";}else{} ?>" name="new" style="width: 100%; height: 38px;">
                            <option value="">-- Select Status New --</option>
                            <option value="1" <?php if(old('new') == 1){ echo "selected";}else{} ?> >New</option>
                            <option value="2" <?php if(old('new') == 2){ echo "selected";}else{} ?> >Update</option>
                            <option value="3" <?php if(old('new') == 3){ echo "selected";}else{} ?> >Coming Soon</option>
                            <option value="0" <?php if(old('new') == 0){ echo "selected";}else{} ?> >Old</option>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.new') ?></small>
                      </div>
                      <div class="form-group  required">
                        <label class="starlabel">Status Menu</label>
                        <select class="custom-select2 form-control <?php if(session('errors.statusmenu')){ echo "form-control-danger";}else{} ?>" name="statusmenu" style="width: 100%; height: 38px;">
                            <option value="">-- Select Status Menu --</option>
                            <option value="0" <?php if(old('statusmenu') == 0){ echo "selected";}else{} ?> >Active</option>
                            <option value="1" <?php if(old('statusmenu') == 1){ echo "selected";}else{} ?> >Non Active</option>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.statusmenu') ?></small>
                      </div>
          						<div class="form-group required">
          							<label class="starlabel">No Urut (a-z)</label>
          							<input class="form-control <?php if(session('errors.nourut')){ echo "form-control-danger";}else{} ?>" type="text"  value="<?= old('no_urut') ?>" name="nourut" placeholder="No Urut">
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
              <tr class="text-center">
                <th style="width:50px">No</th>
                <th>Groups Menu</th>
                <th>Nama Menu</th>
                <th>Link Menu</th>
                <th>Manage Menu</th>
                <th>Status New</th>
                <th>Status Menu</th>
                <th>No Urut</th>
                <th style="width:200px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no=1;foreach($query as $row){

                $random = $row["random"];
                $active = $row["status"];
                $new = $row["new"];
                if($active == 0){
                  $act = "Active";
                  $bg = "bg-primary";
                }else{
                  $act = "Non Active";
                  $bg = "bg-danger";
                }
                if($new == 1){
                  $actn = "new";
                  $bgn = "badge-success";
                }elseif($new == 2){
                  $actn = "update";
                  $bgn = "badge-info";
                }elseif($new == 3){
                  $actn = "coming soon";
                  $bgn = "badge-warning text-dark";
                }else{
                  $actn = "";
                  $bgn = "";
                }
              ?>

              <tr>
                <td class="text-center" style="widtd:50px"><?= $no ?></td>
                <td ><?= $row["nama_group"] ?></td>
                <td ><?= $row["nama_menu"] ?></td>
                <td ><?= $row["link_menu"] ?></td>
                <td ><?= $row["manage"] ?></td>
                <td class="text-center"><span class="badge  text-light <?= $bgn ?> badge-pill"><?= $actn ?> </span></td>
                <td class="text-center"><span class="badge badge-danger  text-light <?= $bg ?> badge-pill"><?= $act ?> </span></td>
                <td class="text-center"><?= $row["no_urut"]  ?></td>
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
                <div class="modal fade" id="delete<?= $random ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content  text-white">
                      <div class="modal-body bg-danger text-center " style="border-top-left-radius:5px;border-top-right-radius:5px;">
                        <h4 class="text-white mb-15"><i class="fa fa-exclamation-triangle"></i> Apakah anda yakin ?</h4>
                        <p>Apakah anda benar-benar ingin menghapus data ini? Apa yang telah anda lakukan tidak dapat dibatalkan.</p>
                      </div>
                      <div class="modal-footer mx-auto py-1">
                            <button type="button" class="mr-3 btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="<?= route_to('manage-delete-menu') ?>" method="post">
                          <?= csrf_field() ?>
                            <input type="hidden" name="random" value="<?= $random ?>" >
                            <button type="submit" class="ml-3 btn btn-sm btn-danger">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              <!-- Edit data -->
              <div class="modal fade" id="editdata<?= $random ?>"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myLargeModalLabel">Edit Data Menu</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body text-left">
                        <div  class="mb-2" >
                            <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                        </div>
                        <form action="<?= route_to('manage-edit-menu') ?>" method="post">
                          <?= csrf_field() ?>

                          <input type="hidden" name="random" value="<?= $random ?>" >

                          <div class="form-group  required">
                            <label class="starlabel">Groups Menu</label>
                            <select class="custom-select2 form-control <?php if(session('errors.namamenu')){ echo "form-control-danger";}else{} ?>" name="namagroups" style="width: 100%; height: 38px;">
                                <option value="">-- Select Groups Menu --</option>
                              <?php foreach($group_menu as $gr){ ?>
                                <option value="<?= $gr['id'] ?>" <?php if($row['id_group'] == $gr['id']){ echo "selected";}else{} ?>><?= $gr['nama_group'] ?></option>
                              <?php } ?>
                            </select>
                            <small class="form-control-feedback text-danger"><?= session('errors.namagroups') ?></small>
                          </div>
              						<div class="form-group required">
              							<label class="starlabel">Nama Menu</label>
              							<input class="form-control <?php if(session('errors.namamenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['nama_menu'] ?>" name="namamenu" placeholder="Nama Menu">
                            <small class="form-control-feedback text-danger"><?= session('errors.namamenu') ?></small>
              						</div>
              						<div class="form-group required">
              							<label class="starlabel">Link Menu</label>
              							<input class="form-control <?php if(session('errors.linkmenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['link_menu'] ?>" name="linkmenu" placeholder="Link Menu">
                            <small class="form-control-feedback text-danger"><?= session('errors.linkmenu') ?></small>
              						</div>
              						<div class="form-group required">
              							<label class="starlabel">Manage Menu</label>
              							<input class="form-control <?php if(session('errors.managemenu')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['manage'] ?>" name="managemenu" placeholder="Manage Sub Menu">
                            <small class="form-control-feedback text-danger"><?= session('errors.managemenu') ?></small>
              						</div>
                        <div class="form-group  required">
                          <label class="starlabel">Status New</label>
                          <select class="custom-select2 form-control <?php if(session('errors.new')){ echo "form-control-danger";}else{} ?>" name="new" style="width: 100%; height: 38px;">
                              <option value="">-- Select Status New --</option>
                            <option value="1" <?php if($row['new'] == 1){ echo "selected";}else{} ?> >New</option>
                            <option value="2" <?php if($row['new'] == 2){ echo "selected";}else{} ?> >Update</option>
                            <option value="3" <?php if($row['new'] == 3){ echo "selected";}else{} ?> >Coming Soon</option>
                            <option value="0" <?php if($row['new'] == 0){ echo "selected";}else{} ?> >Old</option>
                          </select>
                          <small class="form-control-feedback text-danger"><?= session('errors.new') ?></small>
                        </div>
                          <div class="form-group  required">
                            <label class="starlabel">Status Menu</label>
                            <select class="custom-select2 form-control <?php if(session('errors.statusmenu')){ echo "form-control-danger";}else{} ?>" name="statusmenu" style="width: 100%; height: 38px;">
                                <option value="">-- Select Status Menu --</option>
                                <option value="0" <?php if($row['status'] == 0){ echo "selected";}else{} ?> >Active</option>
                                <option value="1" <?php if($row['status'] == 1){ echo "selected";}else{} ?> >Non Active</option>
                            </select>
                            <small class="form-control-feedback text-danger"><?= session('errors.statusmenu') ?></small>
                          </div>
              						<div class="form-group required">
              							<label class="starlabel">No Urut (a-z)</label>
              							<input class="form-control <?php if(session('errors.nourut')){ echo "form-control-danger";}else{} ?>" type="text"  value="<?= $row['no_urut'] ?>" name="nourut" placeholder="No Urut">
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


<?= $this->endSection() ?>
