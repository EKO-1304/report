<?php

  $db = \Config\Database::connect();

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
	<div class="header ">
		<div class="header-left  header-dark ">
			<div class="menu-icon dw dw-menu"></div>
			<!-- <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search">
				<form>
					<div class="form-group mb-0">
						<i class="dw dw-search2 search-icon"></i>
						<input type="text" class="form-control search-input" placeholder="Search Here">
						<div class="dropdown">
							<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
								<i class="ion-arrow-down-c"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">From</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">To</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">Subject</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text">
									</div>
								</div>
								<div class="text-right">
									<button class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div> -->
		</div>
		<?php 
			/*

		<div class="header-right ">
			<div class="user-notification ">
				<div class="dropdown ">
					<a class="dropdown-toggle no-arrow font-weight-bold " id="notifid1"  style="border-radius:5px" href="#" role="button" data-toggle="dropdown">
						NOTIFIKASI &nbsp;<i class="icon-copy dw dw-notification text-warning"></i>
						<span class="badge " id="notifid2"></span>
					</a>
					<div class="dropdown-menu  dropdown-menu-right" id="shownotif"> 
						<div class="notification-list mx-h-350 customscroll" >
							<ul id="notifikasilist">

							</ul>
						</div>
					</div>
				</div>
			</div>
		*/ ?>

			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="<?= base_url('assets/')?>/images/profile/<?= user()->user_image ?>" alt="">
						</span>
						<span class="user-name"><?= user()->fullname ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
					<?php if(! in_groups("seller")){ ?> 
						<a class="dropdown-item" href="<?= base_url('manage-users/profile').'/'.user()->random; ?>"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="<?= base_url('manage-users/profile').'/'.user()->random; ?>"><i class="dw dw-settings2"></i> Setting</a>
						<!-- <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a> -->
				     <?php } ?>
					 <?php 							
								$linkredirect = "logout";
						?>
						<a class="dropdown-item" href="<?php echo base_url($linkredirect) ?>"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
		</div>
	</div>
