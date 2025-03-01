<header id="page-topbar" style="background-image: url('../images/demo-cryptocurrency-hero-bg.jpg');">
  <div class="layout-width">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box horizontal-logo"> <a href="index" class="logo logo-dark"> <span class="logo-sm"> <img src="../assets/images/logo-icon.png" alt="" height="22"> </span> <span class="logo-lg"> <img src="../assets/images/logo-icon.png" alt="" height="17"> </span> </a> <a href="index" class="logo logo-light"> <span class="logo-sm"> <img src="assets/images/logo-sm.png" alt="" height="22"> </span> <span class="logo-lg"> <img src="../assets/images/logo-icon" alt="" height="17"> </span> </a> </div>
        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon"> <span class="hamburger-icon" > <span></span> <span></span> <span></span> </span> </button>
        <!-- App Search-->
        <?php /*?><div class="position-relative">
            <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
            <span class="mdi mdi-magnify search-widget-icon"></span> <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span> </div>
          <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
            <div data-simplebar style="max-height: 320px;">
              <!-- item-->
              <div class="dropdown-header">
                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
              </div>
              <div class="dropdown-item bg-transparent text-wrap"> <a href="index" class="btn btn-soft-primary btn-sm btn-rounded">how to setup <i class="mdi mdi-magnify ms-1"></i></a> <a href="index" class="btn btn-soft-primary btn-sm btn-rounded">buttons <i class="mdi mdi-magnify ms-1"></i></a> </div>
              <!-- item-->
              <div class="dropdown-header mt-2">
                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
              </div>
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item notify-item"> <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i> <span>Analytics Dashboard</span> </a>
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item notify-item"> <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i> <span>Help Center</span> </a>
              <!-- item-->
              <a href="javascript:void(0);" class="dropdown-item notify-item"> <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i> <span>My account settings</span> </a>
              <!-- item-->
              <div class="dropdown-header mt-2">
                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
              </div>
              <div class="notification-list">
                <!-- item -->
                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                <div class="d-flex"> <img src="assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                  <div class="flex-1">
                    <h6 class="m-0">Angela Bernier</h6>
                    <span class="fs-11 mb-0 text-muted">Manager</span> </div>
                </div>
                </a>
                <!-- item -->
                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                <div class="d-flex"> <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                  <div class="flex-1">
                    <h6 class="m-0">David Grasso</h6>
                    <span class="fs-11 mb-0 text-muted">Web Designer</span> </div>
                </div>
                </a>
                <!-- item -->
                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                <div class="d-flex"> <img src="assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                  <div class="flex-1">
                    <h6 class="m-0">Mike Bunch</h6>
                    <span class="fs-11 mb-0 text-muted">React Developer</span> </div>
                </div>
                </a> </div>
            </div>
            <div class="text-center pt-3 pb-1"> <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a> </div>
          </div> <?php */?>
      </div> Ref&nbsp;Link&nbsp; <input style="width:55%; float:left;" class="form-control" id="copyTarget" value="<?=SITE_WS_PATH.'/?ref='. $_SESSION['sess_username'];?>">
      <a style="cursor:pointer; padding:.6rem .9rem; margin-left:0px; margin-top:2px;margin-right:10px; float:right;" title="Copy Link" onClick="myFunctionCopy()" class="badge btn-primary"><i class="bx bx-copy text-dark"></i> </a>
      <!--<script>
                        function myFunctionCopy() {
                            var copyText = document.getElementById("copyTarget");
                            copyText.select();
                            copyText.setSelectionRange(0, 99999);
                            document.execCommand("copy");
                             var tooltip = document.getElementById("myTooltip");
                            // tooltip.innerHTML = "Copied: " + copyText.value;
                            tooltip.innerHTML = "Copied";
							// playSound();
                        }
                         function outFunc() {
                            var tooltip = document.getElementById("myTooltip");
                            tooltip.innerHTML = "Copy to clipboard";
                        }
   </script>-->
      <div class="d-flex align-items-center">
        <!--<div class="dropdown d-md-none topbar-head-dropdown header-item">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="bx bx-search fs-22"></i> </button>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
           
              <div class="form-group m-0">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                  <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                </div>
              </div>
            
          </div>
        </div>-->
        <?php /*?><div class="dropdown ms-1 topbar-head-dropdown header-item">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img id="header-lang-img" src="assets/images/flags/us.svg" alt="Header Language" height="20" class="rounded"> </button>
          <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="en" title="English"> <img src="assets/images/flags/us.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">English</span> </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Spanish"> <img src="assets/images/flags/spain.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">Española</span> </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr" title="German"> <img src="assets/images/flags/germany.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">Deutsche</span> </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it" title="Italian"> <img src="assets/images/flags/italy.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">Italiana</span> </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru" title="Russian"> <img src="assets/images/flags/russia.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">русский</span> </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ch" title="Chinese"> <img src="assets/images/flags/china.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">中国人</span> </a>
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="fr" title="French"> <img src="assets/images/flags/french.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">français</span> </a> </div>
        </div><?php */?>
        <?php /*?><div class="dropdown topbar-head-dropdown ms-1 header-item">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class='bx bx-category-alt fs-22'></i> </button>
          <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
            <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="m-0 fw-semibold fs-15"> Web Apps </h6>
                </div>
                <div class="col-auto"> <a href="#!" class="btn btn-sm btn-soft-info"> View All Apps <i class="ri-arrow-right-s-line align-middle"></i></a> </div>
              </div>
            </div>
            <div class="p-2">
              <div class="row g-0">
                <div class="col"> <a class="dropdown-icon-item" href="#!"> <img src="assets/images/brands/github.png" alt="Github"> <span>GitHub</span> </a> </div>
                <div class="col"> <a class="dropdown-icon-item" href="#!"> <img src="assets/images/brands/bitbucket.png" alt="bitbucket"> <span>Bitbucket</span> </a> </div>
                <div class="col"> <a class="dropdown-icon-item" href="#!"> <img src="assets/images/brands/dribbble.png" alt="dribbble"> <span>Dribbble</span> </a> </div>
              </div>
              <div class="row g-0">
                <div class="col"> <a class="dropdown-icon-item" href="#!"> <img src="assets/images/brands/dropbox.png" alt="dropbox"> <span>Dropbox</span> </a> </div>
                <div class="col"> <a class="dropdown-icon-item" href="#!"> <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp"> <span>Mail Chimp</span> </a> </div>
                <div class="col"> <a class="dropdown-icon-item" href="#!"> <img src="assets/images/brands/slack.png" alt="slack"> <span>Slack</span> </a> </div>
              </div>
            </div>
          </div>
        </div><?php */?>
        <?php /*?><div class="dropdown topbar-head-dropdown ms-1 header-item">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"> <i class='bx bx-shopping-bag fs-22'></i> <span class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-info">5</span> </button>
          <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" aria-labelledby="page-header-cart-dropdown">
            <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="m-0 fs-16 fw-semibold"> My Cart</h6>
                </div>
                <div class="col-auto"> <span class="badge badge-soft-warning fs-13"><span class="cartitem-badge">7</span> items</span> </div>
              </div>
            </div>
            <div data-simplebar style="max-height: 300px;">
              <div class="p-2">
                <div class="text-center empty-cart" id="empty-cart">
                  <div class="avatar-md mx-auto my-3">
                    <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle"> <i class='bx bx-cart'></i> </div>
                  </div>
                  <h5 class="mb-3">Your Cart is Empty!</h5>
                  <a href="apps-ecommerce-products.html" class="btn btn-success w-md mb-3">Shop Now</a> </div>
                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                  <div class="d-flex align-items-center"> <img src="assets/images/products/img-1.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                    <div class="flex-1">
                      <h6 class="mt-0 mb-1 fs-14"> <a href="apps-ecommerce-product-details.html" class="text-reset">Branded
                        T-Shirts</a> </h6>
                      <p class="mb-0 fs-12 text-muted"> Quantity: <span>10 x $32</span> </p>
                    </div>
                    <div class="px-2">
                      <h5 class="m-0 fw-normal">$<span class="cart-item-price">320</span></h5>
                    </div>
                    <div class="ps-2">
                      <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                    </div>
                  </div>
                </div>
                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                  <div class="d-flex align-items-center"> <img src="assets/images/products/img-2.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                    <div class="flex-1">
                      <h6 class="mt-0 mb-1 fs-14"> <a href="apps-ecommerce-product-details.html" class="text-reset">Bentwood Chair</a> </h6>
                      <p class="mb-0 fs-12 text-muted"> Quantity: <span>5 x $18</span> </p>
                    </div>
                    <div class="px-2">
                      <h5 class="m-0 fw-normal">$<span class="cart-item-price">89</span></h5>
                    </div>
                    <div class="ps-2">
                      <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                    </div>
                  </div>
                </div>
                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                  <div class="d-flex align-items-center"> <img src="assets/images/products/img-3.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                    <div class="flex-1">
                      <h6 class="mt-0 mb-1 fs-14"> <a href="apps-ecommerce-product-details.html" class="text-reset"> Borosil Paper Cup</a> </h6>
                      <p class="mb-0 fs-12 text-muted"> Quantity: <span>3 x $250</span> </p>
                    </div>
                    <div class="px-2">
                      <h5 class="m-0 fw-normal">$<span class="cart-item-price">750</span></h5>
                    </div>
                    <div class="ps-2">
                      <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                    </div>
                  </div>
                </div>
                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                  <div class="d-flex align-items-center"> <img src="assets/images/products/img-6.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                    <div class="flex-1">
                      <h6 class="mt-0 mb-1 fs-14"> <a href="apps-ecommerce-product-details.html" class="text-reset">Gray
                        Styled T-Shirt</a> </h6>
                      <p class="mb-0 fs-12 text-muted"> Quantity: <span>1 x $1250</span> </p>
                    </div>
                    <div class="px-2">
                      <h5 class="m-0 fw-normal">$ <span class="cart-item-price">1250</span></h5>
                    </div>
                    <div class="ps-2">
                      <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                    </div>
                  </div>
                </div>
                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                  <div class="d-flex align-items-center"> <img src="assets/images/products/img-5.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                    <div class="flex-1">
                      <h6 class="mt-0 mb-1 fs-14"> <a href="apps-ecommerce-product-details.html" class="text-reset">Stillbird Helmet</a> </h6>
                      <p class="mb-0 fs-12 text-muted"> Quantity: <span>2 x $495</span> </p>
                    </div>
                    <div class="px-2">
                      <h5 class="m-0 fw-normal">$<span class="cart-item-price">990</span></h5>
                    </div>
                    <div class="ps-2">
                      <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i class="ri-close-fill fs-16"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border" id="checkout-elem">
              <div class="d-flex justify-content-between align-items-center pb-3">
                <h5 class="m-0 text-muted">Total:</h5>
                <div class="px-2">
                  <h5 class="m-0" id="cart-item-total">$1258.58</h5>
                </div>
              </div>
              <a href="apps-ecommerce-checkout.html" class="btn btn-success text-center w-100"> Checkout </a> </div>
          </div>
        </div><?php */?>
        <div class="ms-1 header-item d-none d-sm-flex">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen"> <i class='bx bx-fullscreen fs-22'></i> </button>
        </div>
        <?php /*?> <div class="ms-1 header-item d-none d-sm-flex">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode"> <i class='bx bx-moon fs-22'></i> </button>
        </div><?php */?>
        <?php /*?><div class="dropdown topbar-head-dropdown ms-1 header-item">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class='bx bx-bell fs-22'></i> <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?=db_scalar("select count(*) from ngo_complain where comp_status='Active' and comp_userid = '$_SESSION[sess_uid]'")+0?><span class="visually-hidden">unread messages</span></span> </button>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
            <div class="dropdown-head bg-primary bg-pattern rounded-top">
              <div class="p-3">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="m-0 fs-16 fw-semibold text-white"> Support  </h6>
                  </div>
                  <div class="col-auto dropdown-tabs"> <span class="badge badge-soft-light fs-13"> Inbox</span> </div>
                </div>
              </div>
              <div class="px-2 pt-2">
                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                  <li class="nav-item waves-effect waves-light"> <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true"> Messages List </a> </li>
                    
                </ul>
              </div>
            </div>
            <div class="tab-content" id="notificationItemsTabContent">
              <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                <div data-simplebar style="max-height: 300px;" class="pe-2">
				
				
				<? 
				$sql_comp = "select * from ngo_complain where comp_status='Active' and comp_userid = '$_SESSION[sess_uid]' order by comp_id desc limit 0,5 ";
$result_comp = db_query($sql_comp);
				?>
			<?
 			if (mysqli_num_rows($result_comp)>0){
			while ($line_comp= mysqli_fetch_array($result_comp)){;
			@extract($line_comp);
 			 ?>	
                  <div class="text-reset notification-item d-block dropdown-item position-relative">
                    <div class="d-flex">
                      <div class="avatar-xs me-3"> <span class="avatar-title bg-soft-info text-info rounded-circle fs-16"> <i class="bx bx-badge-check"></i> </span> </div>
                      <div class="flex-1"> <a href="complain_details.php?comp_id=<?=$comp_id?>"  class="stretched-link">
                        <h6 class="mt-0 mb-2 lh-base"><?=$comp_title?> </h6>
                        </a>
                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted"> <span><i class="mdi mdi-clock-outline"></i> <?=date_format2($comp_datetime)?></span> </p>
                      </div>
                      <div class="px-2 fs-15">
                        <div class="form-check notification-check">
						<i class="ri-message-3-line"></i>
                          <!--<input class="form-check-input" type="checkbox" value="" id="all-notification-check01">-->
                         <!-- <label class="form-check-label" for="all-notification-check01"></label>-->
                        </div>
                      </div>
                    </div>
                  </div>
				  
               <? } } else {?>
			 <!--no notification -->
                 <div class="w-25 w-sm-50 pt-3 mx-auto"> <img src="assets/images/svg/bell.svg" class="img-fluid" alt="user-pic"> </div>
                <div class="text-center pb-5 mt-2">
                  <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>
                </div>
				<!--no notification -->
 			 <? } ?> 
			 <div class="my-3 text-center">
                                        <a href="complain" type="button" class="btn btn-soft-success waves-effect waves-light">View
                                            All <i class="ri-arrow-right-line align-middle"></i></a>
                                    </div>  
                </div>
              </div>
            </div>
          </div>
        </div><?php */?>
        <div class="dropdown ms-sm-3 header-item topbar-user">
          <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-flex align-items-center">
          <?
				$u_photo = db_scalar("select u_photo from ngo_users where u_id = '$_SESSION[sess_uid]'");
									  // print UP_FILES_FS_PATH.'/profile/'.$u_photo ;
								  if (($u_photo!='')&& (file_exists(UP_FILES_FS_PATH.'/profile/'.$u_photo))) { 
								  ?>
          <img src="<?=UP_FILES_WS_PATH.'/profile/'.$u_photo?>"  class="dt-avatar size-10" style="width:50px;height:50px;">
          <!--<img src="<? //=show_thumb(UP_FILES_WS_PATH.'/profile/'.$u_photo,100,150,'resize')?>" align="center" />-->
          <? }  else { ?>
          <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-new.jpg" alt="Header Avatar">
          <? }  ?>
          <span class="text-start ms-xl-2"> <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
          <?=$_SESSION['sess_fname']?>
          </span> <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
          <?=$_SESSION['sess_username']?>
          </span> </span> </span> </button>
          <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">
              <input style="width:65%; float:left;" class="form-control"   id="copyTarget2" value="<?=$_SESSION['sess_username'];?>">
              <a style="cursor:pointer; padding:.6rem .9rem; margin-left:0px; margin-top:2px;margin-right:10px; float:right;" title="Copy Link" onClick="myFunctionCopy2()" class="badge btn-primary"><i class="bx bx-copy text-dark"></i> </a> </h6>
            <hr/>
            <a class="dropdown-item" href="profile_edit"><i class="mdi mdi-message-text-outline text-m uted fs-16 align-middle me-1"></i> <span class="align-middle">Edit Profile</span></a> <a class="dropdown-item" href="psw_edit"><i class="mdi mdi-message-text-outline text-m uted fs-16 align-middle me-1"></i> <span class="align-middle">Edit Password</span></a> <a class="dropdown-item" href="security_code_edit"><i class="mdi mdi-calendar-check-outline text-mu ted fs-16 align-middle me-1"></i> <span class="align-middle">Edit Txn Password</span></a>
            <div class="dropdown-divider"></div>
            <?php /*?><a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a><?php */?>
            <a class="dropdown-item" href="logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Sign Out</span></a> </div>
        </div>
      </div>
    </div>
  </div>
</header>
