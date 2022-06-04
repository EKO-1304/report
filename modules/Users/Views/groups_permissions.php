<?= $this->extend('Modules\Layout\Views\layout') ?>

<?= $this->section('content') ?>

  <?php $db = \Config\Database::connect(); ?>

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
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Edit Data Groups Permissions</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text-left">
                    <div  class="mb-2" >
                        <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                    </div>
                    <form action="<?= route_to('manage-tambah-groups-permissions') ?>" method="post">
                      <?= csrf_field() ?>

          						<div class="form-group required">
          							<label class="font-weight-bold starlabel">Groups</label>
                        <div class="row">
                        <?php

                            $i = 1;
                            foreach($groups as $rr):

                        ?>
                            <div class="col-sm-4">
                              <div class="custom-control custom-radio mb-5">
                                <input type="radio" id="customRadio<?= $i ?>" <?php if(old("groups") == $rr['id']){echo "checked";}else{}; ?> name="groups" class="custom-control-input" value="<?= $rr['id'] ?>">
                                <label class="custom-control-label" for="customRadio<?= $i ?>"><?= $rr['description'] ?></label>
                              </div>
                            </div>

                        <?php
                            $i++;
                            endforeach;
                        ?>
                        </div>
                        <small class="form-control-feedback text-danger"><?= session('errors.groups') ?></small>
          						</div>
          						<div class="form-group required">
          							<label class="font-weight-bold starlabel">Permissions</label>
                        <?php

                            $no = 1;
                            foreach($permissions as $rr):
                            
                            
                              
                                      if(cek_manage_group_menu($rr['name'])){
                                          $bg = 'bg-primary rounded text-light';
                                          $style = "";
                                      }else{

                                          if(carikarakter($rr['description'],array("A1"))){
                                          $bg = 'bg-success rounded text-light';
                                            $style = "margin-left:30px";
                                          }else{
                                              
                                            if(carikarakter($rr['description'],array("A2"))){
                                                $bg = '';
                                                $style = "margin-left:60px";
                                            }else{
                                                if(carikarakter($rr['description'],array("A3"))){
                                                $bg = '';
                                                $style = "margin-left:90px";
                                              }else{
                                                  $bg = '';
                                                  $style = "";
                                              }
                                            }
                                          }

                                      }
                            $rand = rand(0,99999999);
                        ?>
                              <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" id="permission<?= $rand.$no ?>" name="permissions[]" class="custom-control-input" value="<?= $rr['id'] ?>">
                                <label style="<?= $style ?>" class="custom-control-label  <?= $bg ?> px-2" for="permission<?= $rand.$no ?>"><?= $rr['description'] ?> ( <?= $rr['name'] ?> )</label>
                              </div>

                        <?php
                            $no++;
                            endforeach;
                        ?>
                        <small class="form-control-feedback text-danger"><?= session('errors.permissions') ?></small>
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
                <th>Nama Groups Permissions</th>
                <th>Total Permissions</th>
                <th style="width:200px">Action</th>
              </tr>
            </thead>
            <tbody>

              <?php
                $nomor=1;
                foreach($query as $row){
                $random = $row["g_id"];

                $total = $db->table("auth_groups_permissions")->where("group_id", $random)->countAllResults();

              ?>

              <tr>
                <td class="text-center" style="widtd:50px"><?= $nomor ?></td>
                <td ><?= $row["description_groups"] ?></td>
                <td class="text-center" ><?= $total ?></td>
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
                            <form action="<?= route_to('manage-delete-groups-permissions') ?>" method="post">
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
                      <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Edit Data Groups Permissions</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          </div>
                          <div class="modal-body text-left">
                              <div  class="mb-2" >
                                  <span class="" style="color:red">Yang Bertanda [*] wajib di isi !!!</span>
                              </div>
                              <form action="<?= route_to('manage-edit-groups-permissions') ?>" method="post">
                                <?= csrf_field() ?>

                                <input type="hidden" name="random" value="<?= $random ?>" >

                    						<div class="form-group required">
                    							<label class="font-weight-bold starlabel">Groups</label>
                                  <div class="row">
                                  <?php

                                      $i = 1;
                                      foreach($groups as $rr):
                                  ?>
                                      <div class="col-sm-4">
                                        <div class="custom-control custom-radio mb-5">
                                          <input type="radio" id="customRadio<?= $random.$i ?>" <?php if($rr['id'] == $row['g_id']){echo "checked";}else{}; ?> name="groups" class="custom-control-input" value="<?= $rr['id'] ?>">
                                          <label class="custom-control-label" for="customRadio<?= $random.$i ?>"><?= $rr['description'] ?></label>
                                        </div>
                                      </div>

                                  <?php
                                      $i++;
                                      endforeach;
                                  ?>
                                  </div>
                                  <small class="form-control-feedback text-danger"><?= session('errors.groups') ?></small>
                    						</div>
                    						<div class="form-group required">
                    							<label class="font-weight-bold starlabel">Permissions</label>
                                  <?php

                                      $no = 1;
                                      foreach($permissions as $rr):

                                      if(cek_manage_group_menu($rr['name'])){
                                          $bg = 'bg-primary rounded text-light';
                                          $style = "";
                                      }else{

                                          if(carikarakter($rr['description'],array("A1"))){
                                          $bg = 'bg-success rounded text-light';
                                            $style = "margin-left:30px";
                                          }else{
                                              
                                            if(carikarakter($rr['description'],array("A2"))){
                                          $bg = '';
                                                $style = "margin-left:60px";
                                            }else{
                                                if(carikarakter($rr['description'],array("A3"))){
                                                $bg = '';
                                                $style = "margin-left:90px";
                                              }else{
                                                  $bg = '';
                                                  $style = "";
                                              }
                                            }
                                          }

                                      }
                                      $checked = $db->table('auth_groups_permissions')->where('group_id', $random )->where('permission_id', $rr['id'])->countAllResults();
                                  ?>
                                        <div class="custom-control custom-checkbox mb-5" >
                                          <input type="checkbox" id="permission<?= $random.$no ?>" <?php if($checked == 1){echo "checked";}else{}; ?> name="permissions[]" class="custom-control-input" value="<?= $rr['id'] ?>">
                                          <label style="<?= $style ?>" class="custom-control-label  <?= $bg ?> px-2" for="permission<?= $random.$no ?>"><?= $rr['description'] ?> ( <?= $rr['name'] ?> )</label>
                                        </div>

                                  <?php
                                      $no++;
                                      endforeach;
                                  ?>
                                  <small class="form-control-feedback text-danger"><?= session('errors.permissions') ?></small>
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

              <?php $nomor++; } ?>

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
