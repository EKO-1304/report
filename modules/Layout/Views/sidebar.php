
<?php
  $db = \Config\Database::connect();
  $tema = $db
  ->table('temaku')
  ->select('class,font_color')
  ->where('status', 0)
  ->get()
  ->getRowArray();
  $ur = $db
  ->table('auth_groups')
  ->select('auth_groups.name,auth_groups.description')
  ->join('auth_groups_users','auth_groups_users.group_id=auth_groups.id','left')
  ->where('auth_groups_users.user_id', user()->id)
  ->get()
  ->getRowArray();

  if($ur['name'] == 'super_administrator'){
      $bg = 'bg-purple-lt';
  }elseif($ur['name'] == 'administrator'){
      $bg = 'bg-green-lt';
  }else{
      $bg = 'bg-blue-lt';
  }

?>
<div class="left-side-bar ">
  <div class="brand-logo">
    <a href="<?php echo base_url('manage-home') ?>" class="d-flex justify-content-center">
      <h2 class="text-light">
        <?php 
          if(user()->jenisuser == "seller"){
            echo "SELLER";
          }else{
            echo "OPERATOR";
          }
        ?>  

      </h2>
    </a>
    <div class="close-sidebar" data-toggle="left-sidebar-close">
      <i class="ion-close-round"></i>
    </div>
  </div>

  <div class="menu-block customscroll">

      
      <div id="sidebaruser" class="profile-photo mt-2" style="width:80px;height:80px">
        <img src="<?= base_url('assets/')?>/images/profile/<?= user()->user_image ?>" style="" alt="" class="avatar-photo">
      </div> 
      <h6 id="sidebaruser" class="text-center h6 mb-0" style="color:#00ECCF"><?= user()->fullname ?></h6>
      <p id="sidebaruser" class="text-center text-muted font-14"><?= $ur['description']; ?></p>

    <div class="sidebar-menu" style="margin-bottom:100px">
      <ul id="accordion-menu">
        <?php

          if(in_groups("super_administrator")){
            $bagianmenu = 1;
          }else{
            $bagianmenu = 0;
          }

          $group_menu = $db
          ->table('menu_group')
          ->select('id,manage,new,nama_group,linkgroup')
          ->where('deleted_at', null)
          ->orderBy('no_urut', 'asc')
          ->get()
          ->getResultArray();

          foreach($group_menu as $mg){

            if(has_permission($mg['manage'])){
              if($mg["new"] == 1){
                $newm = '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">new</span>';
              }elseif($mg["new"] == 2){
                $newm = '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">update</span>';
              }elseif($mg["new"] == 3){
                $newm = '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">coming soon</span>';
              }else{
                $newm = '';
              }
              
            $menu= $db
            ->table('menu')
            ->select('nama_menu,new,manage,link_menu,id')
            ->where('id_group', $mg['id'])
            ->where('deleted_at', null)
            ->where('status', 0)
            ->orderBy('no_urut', 'asc')
            ->get()
            ->getResultArray();

        if($menu <> null){
        ?>
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-right-arrow-5"></span><span class="mtext"><?= $mg['nama_group']; ?> <?= $newm ?></span>
          </a>
          <ul class="submenu">

            <?php

            foreach($menu as $m){

            if(has_permission($m['manage'])){

              if($m["new"] == 1){
                $new = '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">new</span>';
              }elseif($m["new"] == 2){
                $new = '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">update</span>';
              }elseif($m["new"] == 3){
                $new = '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">coming soon</span>';
              }else{
                $new = '';
              }

              $count = $db
              ->table('sub_menu')
              ->select('nama_sub_menu,link_sub_menu,id')
              ->where('id_menu', $m['id'])
              ->where('deleted_at', null)
              ->where('status', 0)
              ->orderBy('no_urut', 'asc')
              ->countAllResults();

              $menuall = $db
              ->table('menu')
              ->select('menu.id as menu_id')
              ->join('sub_menu','sub_menu.id_menu=menu.id','left')
              ->join('sub_sub_menu','sub_sub_menu.id_sub_menu=sub_menu.id','left')
              ->where('menu.link_menu', $seg[0])
              ->orWhere('sub_menu.link_sub_menu', $seg[0])
              ->orWhere('sub_sub_menu.link_sub_sub_menu', $seg[0])
              ->get()
              ->getRowArray();
              
              if($menuall <> null){
                if($menuall['menu_id'] == $m['id']){
                  $show = 'active';
                  $bold = 'font-weight-bold';
                }else{
                  $show = '';
                  $bold = '';
                }
              }else{
                  $show = '';
                  $bold = '';
              }

            ?>

            <?php if($count > 0){ ?>
                <li class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle  <?= $show ?>">
                    <span class="micon dw dw-right-arrow-4"></span><span class="mtext"><?= $m['nama_menu'] ?> <?= $new ?></span>
                  </a>
                  <ul class="submenu">
                    <?php
                        $db = \Config\Database::connect();

                        $sub_menu = $db
                        ->table('sub_menu')
                        ->select('new,nama_sub_menu,link_sub_menu,id,manage,')
                        ->where('id_menu', $m['id'])
                        ->where('deleted_at', null)
                        ->where('status', 0)
                        ->orderBy('no_urut', 'asc')
                        ->get()
                        ->getResultArray();
                    ?>

                    <?php
                      foreach($sub_menu as $sub){
                        

                      if($sub['link_sub_menu'] == $seg[0]){
                          $act = 'active';
                      }else{
                          $act = '';
                      }

                        if( has_permission($sub['manage'])){
                          
                      if($sub["new"] == 1){
                        $news = '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">new</span>';
                      }elseif($sub["new"] == 2){
                        $news= '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">update</span>';
                      }elseif($sub["new"] == 3){
                        $news= '<span class="badge badge-pill py-1 bg-light" data-bgcolor="#e7ebf5" data-color="#265ed7">coming soon</span>';
                      }else{
                        $news = '';
                      }

                        $countsub = $db
                        ->table('sub_sub_menu')
                        ->select('nama_sub_sub_menu,link_sub_sub_menu,id')
                        ->where('id_sub_menu', $sub['id'])
                        ->where('deleted_at', null)
                        ->where('status', 0)
                        ->orderBy('no_urut', 'asc')
                        ->countAllResults();

                        // $submenuall = $db
                        // ->table('sub_menu')
                        // ->select('sub_menu.id as sub_menu_id')
                        // ->join('sub_sub_menu','sub_sub_menu.id_sub_menu=sub_menu.id','left')
                        // ->where('sub_menu.link_sub_menu', $seg[0])
                        // ->orWhere('sub_sub_menu.link_sub_sub_menu', $seg[0])
                        // ->get()
                        // ->getRowArray();
                        
                        $submenuall = $db
                        ->table('menu')
                        ->select('sub_menu.id as sub_menu_id')
                        ->join('sub_menu','sub_menu.id_menu=menu.id','left')
                        ->join('sub_sub_menu','sub_sub_menu.id_sub_menu=sub_menu.id','left')
                        ->where('menu.link_menu', $seg[0])
                        ->orWhere('sub_menu.link_sub_menu', $seg[0])
                        ->orWhere('sub_sub_menu.link_sub_sub_menu', $seg[0])
                        ->get()
                        ->getRowArray();

                        if($submenuall <> null){
                          if($submenuall['sub_menu_id'] == $sub['id']){
                            $showsub = 'active';
                            $bold = 'font-weight-bold';
                          }else{
                            $showsub = '';
                            $bold = '';
                          }
                        }else{
                            $showsub = '';
                            $bold = '';
                        }


                        if($countsub > 0){ 

                    ?>

                        <li class="dropdown">
                          <a href="javascript:;" class="dropdown-toggle <?= $showsub ?>">
                            <span class="micon ddw dw-down-arrow-4"></span><span class="mtext"><?= $sub['nama_sub_menu'] ?> <?= $news ?></span>
                          </a>
                          <ul class="submenu child">
                            <?php 
                            
                                $sub_sub_menu = $db
                                ->table('sub_sub_menu')
                                ->select('nama_sub_sub_menu,link_sub_sub_menu,id,manage,')
                                ->where('id_sub_menu', $sub['id'])
                                ->where('deleted_at', null)
                                ->where('status', 0)
                                ->orderBy('no_urut', 'asc')
                                ->get()
                                ->getResultArray();
                              foreach($sub_sub_menu as $ss){

                                if($ss['link_sub_sub_menu'] == $seg[0]){
                                    $act = 'active';
                                }else{
                                    $act = '';
                                }

                                if( has_permission($ss['manage'])){
                            ?>
                            <li><a href="<?php echo base_url($ss['link_sub_sub_menu']) ?>" class="<?= $act ?>"><?= $ss['nama_sub_sub_menu'] ?></a></li>
                            <?php 
                                }
                              } 
                            
                            ?>
                          </ul>
                        </li>
                    <?php }else{ ?>
                      <li><a href="<?php echo base_url($sub['link_sub_menu']) ?>" class="<?= $act ?>"><?= $sub['nama_sub_menu'] ?>  <?= $news ?></a></li>
                    <?php
                          }
                        }
                      }
                    ?>
                  </ul>
                </li>
            <?php }else{ ?>
                <li>
                  <a href="<?= base_url($m['link_menu']) ?>" class="dropdown-toggle no-arrow <?= $show ?>">
                    <span class=""></span><span class="mtext"><?= $m['nama_menu'] ?>  <?= $new ?></span>
                  </a>
                </li>
             <?php
                  }
                }
              }
            
              ?>
            </ul>
          </li>
        <?php }else{ 
        
        ?>
        <li class="dropdown">
          <a href="<?= base_url($mg['linkgroup']) ?>" class="dropdown-toggle no-arrow <?php if($seg[0] == $mg['linkgroup']){echo "active";}else{} ?>">
            <span class="micon dw dw-right-arrow-5"></span><span class="mtext"><?= $mg['nama_group']; ?></span>
          </a> </li>
        <?php }}} ?>
      </ul>
     
   
    <?php 
      if(in_groups("seller")){
        $linkredirect = "logout-seller";
      }else{								
        $linkredirect = "logout";
      }
    ?>
    <?php if(in_groups("seller")){ ?>
    <div class="text-center mx-2" style="margin-top:10px">
        <a href="<?= base_url() ?>" target="_blank" style="width:100%" class="btn btn-success"><i class="icon-copy dw dw-internet-2"></i> Website Utama</a>
    </div>
    <div class="text-center mx-2" style="margin-top:10px">
        <a href="<?= base_url("faq") ?>" target="_blank" style="width:100%" class="btn btn-warning text-dark"><i class="icon-copy dw dw-information"></i> Bantuan / FAQ</a>
    </div>
    <?php } ?>
    <div class="text-center mx-2" style="margin-top:10px">
        <a href="<?= base_url($linkredirect) ?>"  style="width:100%" class="btn btn-dark text-light"><span class="dw dw-logout"></span> Log Out</a>
    </div>
    </div>
  </div>
</div>
<div class="mobile-menu-overlay"></div>
