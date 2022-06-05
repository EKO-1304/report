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
            <div class="col-sm-9">
              <div class="pd-20">
                <h4 class="text-blue h4"><?= $title ?></h4>
              </div>
            </div>
            <div class="col-sm-3">
                <div class="pd-20" >
                    <div class="col-xl-12 mb-1"  style="float:right">
                      <a class="btn btn-sm btn-success" href="#" data-toggle="modal"  data-backdrop="static" data-target="#tambahdata"  style="width:100%;"><i class="icon-copy dw dw-add"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
          </div>

          <!-- Tambah data -->
          <div class="modal fade" id="tambahdata" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Tambah Data Tujuan Mobil</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                    </div>
                    <form action="<?= route_to('manage-tujuan-mobil-save') ?>" method="post" enctype="multipart/form-data">
                      <?= csrf_field() ?>

                      <div class="form-group required">
                        <label class="starlabel">Tujuan Daerah Mobil</label>
                        <input class="form-control <?php if(session('errors.tujuan')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= old('tujuan') ?>" name="tujuan" placeholder="Tujuan Daerah Mobil">
                        <small class="form-control-feedback text-danger"><?= session('errors.tujuan') ?></small>
                      </div>
                      <div class="form-group  required">
                        <label class="starlabel">Jenis Tujuan</label>
                        <select class="custom-select2 form-control <?php if(session('errors.jenis')){ echo "form-control-danger";}else{} ?>" name="jenis" style="width: 100%; height: 38px;">
                            <option value="">-- Select Status Kategori --</option>
                            <option value="dalam" <?php if(old('jenis') == "dalam"){ echo "selected";}else{} ?> >Dalam Kota</option>
                            <option value="luar" <?php if(old('jenis') == "luar"){ echo "selected";}else{} ?> >Luar Kota</option>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.jenis') ?></small>
                      </div>
                      <div class="form-group  required">
                        <label class="starlabel">Status Tujuan</label>
                        <select class="custom-select2 form-control <?php if(session('errors.status')){ echo "form-control-danger";}else{} ?>" name="status" style="width: 100%; height: 38px;">
                            <option value="">-- Select Status Tujuan --</option>
                            <option value="0" <?php if(old('status') == 0){ echo "selected";}else{} ?> >Active</option>
                            <option value="1" <?php if(old('status') == 1){ echo "selected";}else{} ?> >Non Active</option>
                        </select>
                        <small class="form-control-feedback text-danger"><?= session('errors.status') ?></small>
                      </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Tambah Data</button>
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
                <th>Tujuan</th>
                <th>Jenis</th>
                <th>Status</th>
                <th style="width:200px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no=1;foreach($query as $row){

                $random = $row["random"];
                $active = $row["status"];
                if($active == 0){
                  $act = "Active";
                  $bg = "bg-success";
                }else{
                  $act = "Non Active";
                  $bg = "bg-danger";
                }
              ?>

              <tr>
                <td class="text-center" style="widtd:50px"><?= $no ?></td>
                <td ><?= $row["tujuan"] ?></td>
                <td class="text-center" ><?= $row["jenis"] ?></td>
                <td class="text-center"><span class="badge badge-danger  text-light <?= $bg ?> badge-pill"><?= $act ?> </span></td>
                <td class="text-center" style="width:200px">

               
                    <div class="">
                      <a class="btn btn-sm btn-success px-2 py-1" href="#" data-toggle="modal"  data-backdrop="static" data-target="#editdata<?= $random ?>"><i class="dw dw-edit2"></i></a>
                      <a class="btn btn-sm btn-danger px-2 py-1" href="#" data-toggle="modal"  data-backdrop="static" data-target="#delete<?= $random ?>"><i class="dw dw-delete-3"></i></a>
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
                        <form action="<?= route_to('manage-tujuan-mobil-delete') ?>" method="post">
                          <?= csrf_field() ?>
                            <input type="hidden" name="random" value="<?= $random ?>" >
                            <button type="submit" class="ml-3 btn btn-sm btn-danger">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                
              <!-- Edit data -->
              <div class="modal fade" id="editdata<?= $random ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myLargeModalLabel">Edit Data Tujuan Mobil</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body text-left">
                        <div  class="mb-2" >
                            <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                        </div>
                        <form action="<?= route_to('manage-tujuan-mobil-update') ?>" method="post" enctype="multipart/form-data">
                          <?= csrf_field() ?>

                          <input type="hidden" name="random" value="<?= $random ?>" >

              					
                          <div class="form-group required">
                            <label class="starlabel">Tujuan Daerah Mobil</label>
                            <input class="form-control <?php if(session('errors.tujuan')){ echo "form-control-danger";}else{} ?>" type="text" value="<?= $row['tujuan'] ?>" name="tujuan" placeholder="Tujuan Daerah Mobil">
                            <small class="form-control-feedback text-danger"><?= session('errors.tujuan') ?></small>
                          </div>
                          <div class="form-group  required">
                            <label class="starlabel">Jenis Tujuan</label>
                            <select class="custom-select2 form-control <?php if(session('errors.jenis')){ echo "form-control-danger";}else{} ?>" name="jenis" style="width: 100%; height: 38px;">
                                <option value="">-- Select Status Kategori --</option>
                                <option value="dalam" <?php if($row['jenis'] == "dalam"){ echo "selected";}else{} ?> >Dalam Kota</option>
                                <option value="luar" <?php if($row['jenis'] == "luar"){ echo "selected";}else{} ?> >Luar Kota</option>
                            </select>
                            <small class="form-control-feedback text-danger"><?= session('errors.jenis') ?></small>
                          </div>
                          <div class="form-group  required">
                            <label class="starlabel">Status Tujuan</label>
                            <select class="custom-select2 form-control <?php if(session('errors.status')){ echo "form-control-danger";}else{} ?>" name="status" style="width: 100%; height: 38px;">
                                <option value="">-- Select Status Tujuan --</option>
                                <option value="0" <?php if($row['status'] == 0){ echo "selected";}else{} ?> >Active</option>
                                <option value="1" <?php if($row['status'] == 1){ echo "selected";}else{} ?> >Non Active</option>
                            </select>
                            <small class="form-control-feedback text-danger"><?= session('errors.status') ?></small>
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
