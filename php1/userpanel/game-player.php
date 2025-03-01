<?php
include ("../includes/surya.dream.php");
protect_user_page();

  $curr_game_id = encryptor('decrypt', $game_id);

$sql = "select * from ngo_games where game_id ='$curr_game_id'";
$result = db_query($sql);
$line_game= ms_form_value(mysqli_fetch_array($result));
@extract($line_game);

 
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
<head>
<? include("includes/extra_head.php")?>
</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
  <? include("includes/header.inc.php")?>
  <!-- ========== App Menu ========== -->
  <? include("includes/sidebar.php")?>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0">Play <?=$line_game['game_name'];?></h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Play Predict</a></li>
                  <li class="breadcrumb-item active">Play <?=$line_game['game_name'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row dash-nft">
          <div class="col-xxl-12">
             
            <!--end row-->
            <div class="row">
              
			   
			  <div class="col-xxl-12">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="row g-0">
                      <div class="col-xxl-12">
                        <div class="">
                          <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1"><?=$line_game['game_name'];?></h4>
                            <div>
                              <button type="button" class="btn btn-soft-secondary btn-sm" onclick="window.location='games.php'"> <i class="bx bx-left-arrow "></i> Back to All Games </button>
                              <!--  <button type="button" class="btn btn-soft-secondary btn-sm"> 1M </button>
                              <button type="button" class="btn btn-soft-secondary btn-sm"> 6M </button>
                              <button type="button" class="btn btn-soft-primary btn-sm"> 1Y </button>-->
                            </div>
                          </div>
                          <!-- end card header -->
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-2">
                    <div class="col-xxl-12 " >
                       
                        
					  
					  <div class="row">
                         
                         
                        <div class="col-xl-12 col-md-12" >
                          <div class="card card-height-100">
                            <div class="card-body" style="background:rgba(0,0,0,0.7);">
                              <div class="d-flex align-items-center">
                                 
                                <div class="flex-grow-1 ps-3">
                                  <h5 class="text-muted text-uppercase fs-13 mb-3"><?=$line_game['game_name'];?> </h5>
                                </div>
                              </div>
                                <?php /*?><iframe src="https://html5.gamemonetize.com/cppc8q98lrebs2ux423g9osd1y26vl10/" id="game-player" width="100%" height="580px" frameborder="0" scrolling="no" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe><?php */?>
							   <iframe src="<?=$line_game['file'];?>" id="game-player" width="100%" height="<?=$line_game['h'];?>px" frameborder="0" scrolling="no" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
                            </div>
							 

                          </div>
                        </div>
						  
                        <!--end col-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--end col-->
            </div>
            <!--end row-->
          </div>
          <!--end col-->
          <!--end col-->
        </div>
        <!--end row-->
        <?php /*?><div class="row">
          <div class="col-xxl-8">
            <div class="swiper marketplace-swiper rounded gallery-light">
              <div class="d-flex pt-2 pb-4">
                <h5 class="card-title fs-18 mb-1">Featured NFTs Artworks</h5>
              </div>
              <div class="swiper-wrapper">
			  
			  
			  
                 
                <div class="swiper-slide">
                  <div class="card explore-box card-animate rounded">
                    <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                      <button type="button" class="btn btn-icon" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                    </div>
                    <div class="explore-place-bid-img"> <img src="assets/images/nft/1_304000307.png" alt="" class="img-fluid card-img-top explore-img" />
                      <div class="bg-overlay"></div>
                      <div class="place-bid-btn"> <a href="#!" class="btn btn-success"><i class="ri-auction-fill align-bottom me-1"></i> Place Bid</a> </div>
                    </div>
                    <div class="card-body">
                      <p class="fw-medium mb-0 float-end"><i class="mdi mdi-heart text-danger align-middle"></i> 9.2k </p>
                      <h5 class="mb-1"><a href="#">Filtered Portrait</a></h5>
                      <p class="text-muted mb-0">Fractional ownership of the world's most sought after NFTs</p>
                    </div>
                    <div class="card-footer border-top border-top-dashed">
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14"> <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> COLLECTABLE: <span class="fw-medium">500</span> </div>
                        <h5 class="flex-shrink-0 fs-14 text-dark mb-0">$125</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card explore-box card-animate rounded">
                    <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                      <button type="button" class="btn btn-icon active" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                    </div>
                    <div class="explore-place-bid-img"> <img src="assets/images/nft/2_0x0.png" alt="" class="img-fluid card-img-top explore-img" />
                      <div class="bg-overlay"></div>
                      <div class="place-bid-btn"> <a href="#!" class="btn btn-success"><i class="ri-auction-fill align-bottom me-1"></i> Place Bid</a> </div>
                    </div>
                    <div class="card-body">
                      <p class="fw-medium mb-0 float-end"><i class="mdi mdi-heart text-danger align-middle"></i> 9.2k </p>
                      <h5 class="mb-1"><a href="#">APE</a></h5>
                      <p class="text-muted mb-0">Fractional ownership of the world's most sought after NFTs</p>
                    </div>
                    <div class="card-footer border-top border-top-dashed">
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14"> <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> COLLECTABLE: <span class="fw-medium">980</span> </div>
                        <h5 class="flex-shrink-0 fs-14 text-dark mb-0">$125</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="card explore-box card-animate rounded">
                    <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                      <button type="button" class="btn btn-icon" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                    </div>
                    <div class="explore-place-bid-img"> <img src="assets/images/nft/3_kav_gma.png" alt="" class="img-fluid card-img-top explore-img" />
                      <div class="bg-overlay"></div>
                      <div class="place-bid-btn"> <a href="#!" class="btn btn-success"><i class="ri-auction-fill align-bottom me-1"></i> Place Bid</a> </div>
                    </div>
                    <div class="card-body">
                      <p class="fw-medium mb-0 float-end"><i class="mdi mdi-heart text-danger align-middle"></i> 9.3k </p>
                      <h5 class="mb-1"><a href="#">kav@gma.com</a></h5>
                      <p class="text-muted mb-0">Fractional ownership of the world's most sought after NFTs</p>
                    </div>
                    <div class="card-footer border-top border-top-dashed">
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14"> <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> COLLECTABLE: <span class="fw-medium">130</span> </div>
                        <h5 class="flex-shrink-0 fs-14 text-dark mb-0">$125</h5>
                      </div>
                    </div>
                  </div>
                </div>
				
				<div class="swiper-slide">
                  <div class="card explore-box card-animate rounded">
                    <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                      <button type="button" class="btn btn-icon" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                    </div>
                    <div class="explore-place-bid-img"> <img src="assets/images/nft/4_nft.png" alt="" class="img-fluid card-img-top explore-img" />
                      <div class="bg-overlay"></div>
                      <div class="place-bid-btn"> <a href="#!" class="btn btn-success"><i class="ri-auction-fill align-bottom me-1"></i> Place Bid</a> </div>
                    </div>
                    <div class="card-body">
                      <p class="fw-medium mb-0 float-end"><i class="mdi mdi-heart text-danger align-middle"></i> 9.3k </p>
                      <h5 class="mb-1"><a href="#">Mind Blown</a></h5>
                      <p class="text-muted mb-0">Fractional ownership of the world's most sought after NFTs</p>
                    </div>
                    <div class="card-footer border-top border-top-dashed">
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14"> <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> COLLECTABLE: <span class="fw-medium">500</span> </div>
                        <h5 class="flex-shrink-0 fs-14 text-dark mb-0">$125</h5>
                      </div>
                    </div>
                  </div>
                </div>
				<div class="swiper-slide">
                  <div class="card explore-box card-animate rounded">
                    <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                      <button type="button" class="btn btn-icon" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                    </div>
                    <div class="explore-place-bid-img"> <img src="assets/images/nft/5_nft.png" alt="" class="img-fluid card-img-top explore-img" />
                      <div class="bg-overlay"></div>
                      <div class="place-bid-btn"> <a href="#!" class="btn btn-success"><i class="ri-auction-fill align-bottom me-1"></i> Place Bid</a> </div>
                    </div>
                    <div class="card-body">
                      <p class="fw-medium mb-0 float-end"><i class="mdi mdi-heart text-danger align-middle"></i> 9.3k </p>
                      <h5 class="mb-1"><a href="#">Mind 2</a></h5>
                      <p class="text-muted mb-0">Fractional ownership of the world's most sought after NFTs</p>
                    </div>
                    <div class="card-footer border-top border-top-dashed">
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14"> <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> COLLECTABLE: <span class="fw-medium">77</span> </div>
                        <h5 class="flex-shrink-0 fs-14 text-dark mb-0">$125</h5>
                      </div>
                    </div>
                  </div>
                </div>
				
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
          <!--end col-->
          <div class="col-xxl-4">
            <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Top NFT's Buyer</h4>
                <div class="flex-shrink-0">
                  <div>
                    <button type="button" class="btn btn-soft-primary btn-sm"> See All </button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive table-card">
                  <div data-simplebar style="max-height: 405px;">
                    <table class="table table-borderless align-middle">
                      <tbody>
					    <?
			$sql_history = "select *  from ngo_users_recharge inner join ngo_users on topup_userid=u_id  order by topup_amount desc  limit 0, 10 " ;
			$result_history = db_query($sql_history);
 		 	$total_count_history = mysqli_num_rows($result_history);
 			if ($total_count_history>0){
 			while ($line_history= mysqli_fetch_array($result_history)){ 
  			 ?>
					  
					 
					   <tr>
                          <td  nowrap="nowrap"><div class="d-flex align-items-center"> <img src="assets/images/nft/img-01.jpg" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1"><?=$line_history['u_fname'];?>-<?=$line_history['u_username'];?></h6>
                                </a>
                                <p class="mb-0 text-muted"><?=$line_history['u_city'];?></p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-1" data-colors='["--vz-danger"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end" nowrap="nowrap"><a href="#!">
                            <h6 class="fs-15 mb-1"><?=price_format($line_history['topup_amount']);?>+</h6>
                            </a>
                            <p class="mb-0 text-muted"> USDT</p></td>
                        </tr>
                     
					  <? } ?>
                <? }  else { ?>
                <tr   >
                  <td colspan="3" class="smalltxt" align="center" >Record not found </td>
                </tr>
                <? } ?>
					  
                       
						
						
                      <!--  <tr>
                          <td><div class="d-flex align-items-center"> <img src="assets/images/nft/img-02.jpg" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1">Coin Journal is dedicated</h6>
                                </a>
                                <p class="mb-0 text-muted">11,752 Sales</p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-2" data-colors='["--vz-danger"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end"><a href="#!">
                            <h6 class="fs-15 mb-1">$632,000+</h6>
                            </a>
                            <p class="mb-0 text-muted">Total USD</p></td>
                        </tr>
                        <tr>
                          <td><div class="d-flex align-items-center"> <img src="assets/images/nft/img-03.jpg" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1">The Bitcoin-holding U.S.</h6>
                                </a>
                                <p class="mb-0 text-muted">7,526 Sales</p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-3" data-colors='["--vz-danger"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end"><a href="#!">
                            <h6 class="fs-15 mb-1">$468,000+</h6>
                            </a>
                            <p class="mb-0 text-muted">Total USD</p></td>
                        </tr>
                        <tr>
                          <td><div class="d-flex align-items-center"> <img src="assets/images/nft/img-04.jpg" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1">Cryptocurrency Price Bitcoin</h6>
                                </a>
                                <p class="mb-0 text-muted">15,521 Sales</p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-4" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end"><a href="#!">
                            <h6 class="fs-15 mb-1">$265,000+</h6>
                            </a>
                            <p class="mb-0 text-muted">Total USD</p></td>
                        </tr>
                        <tr>
                          <td><div class="d-flex align-items-center"> <img src="assets/images/nft/img-05.jpg" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1">Dash, Ripple and Litecoin</h6>
                                </a>
                                <p class="mb-0 text-muted">12,652 Sales</p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-5" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end"><a href="#!">
                            <h6 class="fs-15 mb-1">$456,000+</h6>
                            </a>
                            <p class="mb-0 text-muted">Total USD</p></td>
                        </tr>
                        <tr>
                          <td><div class="d-flex align-items-center"> <img src="assets/images/nft/img-06.jpg" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1">The Cat X Takashi</h6>
                                </a>
                                <p class="mb-0 text-muted">11,745 Sales</p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-6" data-colors='["--vz-danger"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end"><a href="#!">
                            <h6 class="fs-15 mb-1">$256,000+</h6>
                            </a>
                            <p class="mb-0 text-muted">Total USD</p></td>
                        </tr>
                        <tr>
                          <td><div class="d-flex align-items-center"> <img src="assets/images/nft/img-01.jpg" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1">Long-tailed Macaque</h6>
                                </a>
                                <p class="mb-0 text-muted">41,032 Sales</p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-7" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end"><a href="#!">
                            <h6 class="fs-15 mb-1">$745,000+</h6>
                            </a>
                            <p class="mb-0 text-muted">Total USD</p></td>
                        </tr>
                        <tr>
                          <td><div class="d-flex align-items-center"> <img src="../../../../img.themesbrand.com/velzon/images/img-5.gif" alt="" class="avatar-sm rounded-circle">
                              <div class="ms-3"> <a href="#!">
                                <h6 class="fs-15 mb-1">Evolved Reality</h6>
                                </a>
                                <p class="mb-0 text-muted">513,794 Sales</p>
                              </div>
                            </div></td>
                          <td><div id="mini-chart-8" data-colors='["--vz-danger"]' class="apex-charts" dir="ltr"></div></td>
                          <td class="text-end"><a href="#!">
                            <h6 class="fs-15 mb-1">$870,000+</h6>
                            </a>
                            <p class="mb-0 text-muted">Total USD</p></td>
                        </tr>-->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end col-->
        </div><?php */?>
        <? /* ?>
        <!--end row-->
        <div class="row">
          <div class="col-xxl-6">
            <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Recent NFTs</h4>
                <div class="flex-shrink-0">
                  <div class="dropdown card-header-dropdown"> <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="fw-semibold text-uppercase fs-12">Sort by: </span><span class="text-muted">Popular <i class="mdi mdi-chevron-down ms-1"></i></span> </a>
                    <div class="dropdown-menu dropdown-menu-end"> <a class="dropdown-item" href="#">Popular</a> <a class="dropdown-item" href="#">Newest</a> <a class="dropdown-item" href="#">Oldest</a> </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive table-card">
                  <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                    <thead class="text-muted bg-soft-light">
                      <tr>
                        <th>Collection</th>
                        <th>Volume</th>
                        <th>24h %</th>
                        <th>Creators</th>
                        <th>Items</th>
                      </tr>
                    </thead>
                    <!-- end thead -->
                    <tbody>
                      <tr>
                        <td><div class="d-flex align-items-center">
                            <div class="me-2"> <img src="assets/images/nft/img-01.jpg" alt="" class="avatar-xs rounded-circle"> </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1"><a href="apps-nft-item-details.html">Abstract Face Painting</a></h6>
                              <p class="text-muted mb-0"> Artworks</p>
                            </div>
                          </div></td>
                        <td><img src="assets/images/svg/crypto-icons/btc.svg" class="avatar-xxs me-2" alt="">48,568.025</td>
                        <td><span class="text-success mb-0"><i class="mdi mdi-trending-up align-middle me-1"></i>5.26 </span> </td>
                        <td>6.8K</td>
                        <td>18.0K</td>
                      </tr>
                      <!-- end -->
                      <tr>
                        <td><div class="d-flex align-items-center">
                            <div class="me-2"> <img src="../../../../img.themesbrand.com/velzon/images/img-5.gif" alt="" class="avatar-xs rounded-circle"> </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1"><a href="apps-nft-item-details.html">Long-tailed Macaque</a></h6>
                              <p class="text-muted mb-0">Games</p>
                            </div>
                          </div></td>
                        <td><img src="assets/images/svg/crypto-icons/ltc.svg" class="avatar-xxs me-2" alt="">87,142.027</td>
                        <td><span class="text-danger mb-0"><i class="mdi mdi-trending-down align-middle me-1"></i>3.07 </span> </td>
                        <td>2.6K</td>
                        <td>6.3K</td>
                      </tr>
                      <!-- end -->
                      <tr>
                        <td><div class="d-flex align-items-center">
                            <div class="me-2"> <img src="assets/images/nft/img-06.jpg" alt="" class="avatar-xs rounded-circle"> </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1"><a href="apps-nft-item-details.html">Robotic Body Art</a></h6>
                              <p class="text-muted mb-0">Photography</p>
                            </div>
                          </div></td>
                        <td><img src="assets/images/svg/crypto-icons/etc.svg" class="avatar-xxs me-2" alt="">33,847.961</td>
                        <td><span class="text-success mb-0"><i class="mdi mdi-trending-up align-middle me-1"></i>7.13 </span> </td>
                        <td>7.5K</td>
                        <td>14.6K</td>
                      </tr>
                      <!-- end -->
                      <tr>
                        <td><div class="d-flex align-items-center">
                            <div class="me-2"> <img src="assets/images/nft/img-04.jpg" alt="" class="avatar-xs rounded-circle"> </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1"><a href="apps-nft-item-details.html">Smillevers Crypto</a></h6>
                              <p class="text-muted mb-0">Artworks</p>
                            </div>
                          </div></td>
                        <td><img src="assets/images/svg/crypto-icons/dash.svg" class="avatar-xxs me-2" alt="">73,654.421</td>
                        <td><span class="text-success mb-0"><i class="mdi mdi-trending-up align-middle me-1"></i>0.97 </span> </td>
                        <td>5.3K</td>
                        <td>36.4K</td>
                      </tr>
                      <!-- end -->
                      <tr>
                        <td><div class="d-flex align-items-center">
                            <div class="me-2"> <img src="assets/images/nft/img-03.jpg" alt="" class="avatar-xs rounded-circle"> </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1"><a href="apps-nft-item-details.html">Creative Filtered Portrait</a></h6>
                              <p class="text-muted mb-0"> 3d Style</p>
                            </div>
                            <div class="flex-grow-1"></div>
                          </div></td>
                        <td><img src="assets/images/svg/crypto-icons/bnb.svg" class="avatar-xxs me-2" alt="">66,742.077</td>
                        <td><span class="text-danger mb-0"><i class="mdi mdi-trending-down align-middle me-1"></i>1.08 </span> </td>
                        <td>3.1K</td>
                        <td>12.4K</td>
                      </tr>
                      <!-- end -->
                      <tr>
                        <td><div class="d-flex align-items-center">
                            <div class="me-2"> <img src="assets/images/nft/img-02.jpg" alt="" class="avatar-xs rounded-circle"> </div>
                            <div class="flex-grow-1">
                              <h6 class="mb-1"><a href="apps-nft-item-details.html">The Chirstoper</a></h6>
                              <p class="text-muted mb-0"> Crypto Card</p>
                            </div>
                          </div></td>
                        <td><img src="assets/images/svg/crypto-icons/usdt.svg" class="avatar-xxs me-2" alt="">34,736.209</td>
                        <td><span class="text-success mb-0"><i class="mdi mdi-trending-up align-middle me-1"></i>4.52 </span> </td>
                        <td>7.2K</td>
                        <td>25.0K</td>
                      </tr>
                      <!-- end -->
                    </tbody>
                    <!-- end tbody -->
                  </table>
                  <!-- end table -->
                </div>
                <!-- end tbody -->
              </div>
            </div>
          </div>
          <!--end col-->
          <!--end card-->
          <div class="col-xxl-3 col-lg-6">
            <div class="card card-height-100">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Worldwide Top Creators</h4>
                <div class="flex-shrink-0">
                  <button type="button" class="btn btn-soft-primary btn-sm"> Export Report </button>
                </div>
              </div>
              <!-- end card header -->
              <!-- card body -->
              <div class="card-body">
                <div id="creators-by-locations" data-colors='["--vz-gray-200", "--vz-success", "--vz-primary"]' style="height: 265px" dir="ltr"></div>
                <div class="mt-1">
                  <p class="mb-1"><img src="assets/images/flags/us.svg" alt="" height="15" class="rounded me-2"> United States <span class="float-end">34%</span></p>
                  <p class="mb-1"><img src="assets/images/flags/russia.svg" alt="" height="15" class="rounded me-2"> Russia <span class="float-end">27%</span></p>
                  <p class="mb-1"><img src="assets/images/flags/spain.svg" alt="" height="15" class="rounded me-2"> Spain <span class="float-end">21%</span></p>
                  <p class="mb-1"><img src="assets/images/flags/italy.svg" alt="" height="15" class="rounded me-2"> Italy <span class="float-end">13%</span></p>
                  <p class="mb-0"><img src="assets/images/flags/germany.svg" alt="" height="15" class="rounded me-2"> Germany <span class="float-end">5%</span></p>
                </div>
              </div>
              <!-- end card body -->
            </div>
            <!-- end card -->
          </div>
          <!--end col-->
          <div class="col-xxl-3 col-lg-6">
            <div class="card">
              <div class="card-header d-flex align-items-center">
                <h6 class="card-title flex-grow-1 mb-0">Top Collections</h6>
                <a href="apps-nft-collections.html" type="button" class="btn btn-soft-primary btn-sm flex-shrink-0"> See All <i class="ri-arrow-right-line align-bottom"></i> </a> </div>
              <div class="card-body">
                <div class="swiper collection-slider">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <div class="dash-collection overflow-hidden rounded-top position-relative"> <img src="assets/images/nft/img-03.jpg" alt="" height="220" class="object-cover w-100" />
                        <div class="content position-absolute bottom-0 m-2 p-2 start-0 end-0 rounded d-flex align-items-center">
                          <div class="flex-grow-1"> <a href="#!">
                            <h5 class="text-white fs-16 mb-1">Artworks</h5>
                            </a>
                            <p class="text-white-75 mb-0">4700+ Items</p>
                          </div>
                          <div class="avatar-xxs">
                            <div class="avatar-title bg-white rounded-circle"> <a href="#!" class="link-success"><i class="ri-arrow-right-line"></i></a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="dash-collection overflow-hidden rounded-top position-relative"> <img src="assets/images/nft/img-04.jpg" alt="" height="220" class="object-cover w-100" />
                        <div class="content position-absolute bottom-0 m-2 p-2 start-0 end-0 rounded d-flex align-items-center">
                          <div class="flex-grow-1"> <a href="#!">
                            <h5 class="text-white fs-16 mb-1">Crypto Card</h5>
                            </a>
                            <p class="text-white-75 mb-0">743+ Items</p>
                          </div>
                          <div class="avatar-xxs">
                            <div class="avatar-title bg-white rounded-circle"> <a href="#!" class="link-success"><i class="ri-arrow-right-line"></i></a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="dash-collection overflow-hidden rounded-top position-relative"> <img src="../../../../img.themesbrand.com/velzon/images/img-5.gif" alt="" height="220" class="object-cover w-100" />
                        <div class="content position-absolute bottom-0 m-2 p-2 start-0 end-0 rounded d-flex align-items-center">
                          <div class="flex-grow-1"> <a href="#!">
                            <h5 class="text-white fs-16 mb-1">3d Style</h5>
                            </a>
                            <p class="text-white-75 mb-0">4781+ Items</p>
                          </div>
                          <div class="avatar-xxs">
                            <div class="avatar-title bg-white rounded-circle"> <a href="#!" class="link-success"><i class="ri-arrow-right-line"></i></a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="dash-collection overflow-hidden rounded-top position-relative"> <img src="assets/images/nft/img-06.jpg" alt="" height="220" class="object-cover w-100" />
                        <div class="content position-absolute bottom-0 m-2 p-2 start-0 end-0 rounded d-flex align-items-center">
                          <div class="flex-grow-1"> <a href="#!">
                            <h5 class="text-white fs-16 mb-1">Collectibles</h5>
                            </a>
                            <p class="text-white-75 mb-0">3468+ Items</p>
                          </div>
                          <div class="avatar-xxs">
                            <div class="avatar-title bg-white rounded-circle"> <a href="#!" class="link-success"><i class="ri-arrow-right-line"></i></a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--end swiper-->
              </div>
            </div>
            <div class="card">
              <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">Popular Creators</h5>
                <a href="apps-nft-creators.html" type="button" class="btn btn-soft-primary btn-sm flex-shrink-0"> See All <i class="ri-arrow-right-line align-bottom"></i> </a> </div>
              <div class="card-body">
                <div class="swiper collection-slider">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <div class="d-flex">
                        <div class="flex-shink-0"> <img src="assets/images/nft/img-02.jpg" alt="" class="avatar-sm object-cover rounded"> </div>
                        <div class="ms-3 flex-grow-1"> <a href="pages-profile.html">
                          <h5 class="mb-1">Alexis Clarke</h5>
                          </a>
                          <p class="text-muted mb-0"><i class="mdi mdi-ethereum text-dark fs-14"></i> 81,369 ETH</p>
                        </div>
                        <div>
                          <div class="dropdown float-end">
                            <button class="btn btn-ghost-primary btn-icon dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle fs-16"></i> </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a class="dropdown-item" href="javascript:void(0);">View</a></li>
                              <li><a class="dropdown-item" href="javascript:void(0);">Share</a></li>
                              <li><a class="dropdown-item" href="#!">Report</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="d-flex">
                        <div class="flex-shink-0"> <img src="assets/images/nft/img-01.jpg" alt="" class="avatar-sm object-cover rounded"> </div>
                        <div class="ms-3 flex-grow-1"> <a href="pages-profile.html">
                          <h5 class="mb-1">Timothy Smith</h5>
                          </a>
                          <p class="text-muted mb-0"><i class="mdi mdi-ethereum text-dark fs-14"></i> 4,754 ETH</p>
                        </div>
                        <div>
                          <div class="dropdown float-end">
                            <button class="btn btn-ghost-primary btn-icon dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle fs-16"></i> </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a class="dropdown-item" href="javascript:void(0);">View</a></li>
                              <li><a class="dropdown-item" href="javascript:void(0);">Share</a></li>
                              <li><a class="dropdown-item" href="#!">Report</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="d-flex">
                        <div class="flex-shink-0"> <img src="assets/images/nft/img-04.jpg" alt="" class="avatar-sm object-cover rounded"> </div>
                        <div class="ms-3 flex-grow-1"> <a href="pages-profile.html">
                          <h5 class="mb-1">Herbert Stokes</h5>
                          </a>
                          <p class="text-muted mb-0"><i class="mdi mdi-ethereum text-dark fs-14"></i> 68,945 ETH</p>
                        </div>
                        <div>
                          <div class="dropdown float-end">
                            <button class="btn btn-ghost-primary btn-icon dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle fs-16"></i> </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a class="dropdown-item" href="javascript:void(0);">View</a></li>
                              <li><a class="dropdown-item" href="javascript:void(0);">Share</a></li>
                              <li><a class="dropdown-item" href="#!">Report</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="d-flex">
                        <div class="flex-shink-0"> <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-sm object-cover rounded"> </div>
                        <div class="ms-3 flex-grow-1"> <a href="pages-profile.html">
                          <h5 class="mb-1">Glen Matney</h5>
                          </a>
                          <p class="text-muted mb-0"><i class="mdi mdi-ethereum text-dark fs-14"></i> 49,031 ETH</p>
                        </div>
                        <div>
                          <div class="dropdown float-end">
                            <button class="btn btn-ghost-primary btn-icon dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-more-fill align-middle fs-16"></i> </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li><a class="dropdown-item" href="javascript:void(0);">View</a></li>
                              <li><a class="dropdown-item" href="javascript:void(0);">Share</a></li>
                              <li><a class="dropdown-item" href="#!">Report</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--end swiper-->
              </div>
            </div>
          </div>
          <!--end col-->
        </div>
        <!--end row-->
		<? */ ?>
      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <? include("includes/footer.php")?>
  </div>
  <!-- end main content-->
</div>
<!-- END layout-wrapper -->
<? include("includes/extra_footer.php")?>
</body>
</html>
