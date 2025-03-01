<?php
include ("../includes/surya.dream.php");
protect_user_page();

$pagesize=2; 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select *  ";
//$sql = " from ngo_users, ngo_classified  ";
$sql = " from ngo_news  ";
$order_by == '' ? $order_by = 'news_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

$arr_error_msgs =array();
$sql_hc="SELECT SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit,SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit, (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]'";
$result_hc=db_query($sql_hc);
$row_hc=mysqli_fetch_array($result_hc); 
  
$sql_details = "select * from ngo_users where  u_id ='$_SESSION[sess_uid]'";
$result_details = db_query($sql_details);
$line_details= mysqli_fetch_array($result_details);
@extract($line_details); 

$_SESSION['arr_error_msgs'] = $arr_error_msgs;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<? include("includes/extra_head.php")?>
</head>
<body class="dt-layout--default dt-sidebar--fixed dt-header--fixed">
<!-- Loader -->
<? include("includes/loader.php")?>
<!-- /loader -->
<!-- Root -->
<div class="dt-root">
  <div class="dt-root__inner">
    <!-- Header -->
    <? include("includes/header.inc.php")?>
    <!-- /header -->
    <!-- Site Main -->
    <main class="dt-main">
      <!-- Sidebar -->
      <? include("includes/sidebar.php")?>
      <!-- /sidebar -->
      <!-- Site Content Wrapper -->
      <div class="dt-content-wrapper">
        <div class="dt-content">
          <router-outlet></router-outlet>
          <app-crypto-dashboard _nghost-ugy-c43="" class="ng-star-inserted">
            <div _ngcontent-ugy-c43="" class="dt-page__header">
              <h1 _ngcontent-ugy-c43="" class="dt-page__title"><button _ngcontent-ugy-c44="" class="btn mr-3 btn-sm btn-secondary ng-star-inserted" style="font-size:18px;">Latest News </button> <marquee scrollamount="5" direction="left" style="width:85%; padding:10px; float:right;">
								 <?=db_scalar("select static_desc from ngo_staticpage where static_page_name='dashboard_news'")?>
			 </marquee> </h1>
            </div>
            <div _ngcontent-ugy-c43="" class="row">
			<div _ngcontent-ugy-c43="" class="col-xl-6">
                <section-balance-history _ngcontent-ugy-c43="" fullheight="" gxcard="" _nghost-ugy-c45="" class="dt-card dt-card__full-height">
                  <img src="images/RIP-CARD.jpg" width="100%" /> 
                   
                </section-balance-history>
              </div>
			 <div _ngcontent-ugy-c43="" class="col-xl-6">
                <section-balance-portfolio _ngcontent-ugy-c43="" fullheight="" gxcard="" _nghost-ugy-c44="" class="dt-card dt-card__full-height">
                  <card-header _ngcontent-ugy-c44="" class="mb-4 dt-card__header">
                    <!---->
                    <card-heading _ngcontent-ugy-c44="" _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 _ngcontent-ugy-c44="" class="dt-card__title">
                        <gx-icon _ngcontent-ugy-c44="" class="mr-3 icon icon-revenue icon-xl" name="revenue" size="xl"></gx-icon>
                        <span _ngcontent-ugy-c44="" class="align-bottom">Your Portfolio Balance</span></h3>
                    </card-heading>
                    <card-tool _ngcontent-ugy-c44="" _nghost-ugy-c32="" class="dt-card__tools"><a _ngcontent-ugy-c44="" class="dt-card__more" href="javascript:void(0)">
                      <gx-icon _ngcontent-ugy-c44="" class="mr-2 icon icon-circle-add-o" name="circle-add-o"></gx-icon>
                      Add New </a></card-tool>
                  </card-header>
                  <card-body _ngcontent-ugy-c44="" class="pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div _ngcontent-ugy-c44="" class="row no-gutters">
                      <div _ngcontent-ugy-c44="" class="col-sm-7 mb-8 mb-sm-0">
                        <div _ngcontent-ugy-c44="" class="d-flex align-items-baseline mb-1"><span _ngcontent-ugy-c44="" class="display-2 font-weight-500 text-dark mr-2">$179,626</span>
                          <div _ngcontent-ugy-c44="" class="trending-section font-weight-500 text-success"><span _ngcontent-ugy-c44="" class="value">64%</span>
                            <gx-icon _ngcontent-ugy-c44="" class="icon icon-pointer-up"></gx-icon>
                          </div>
                        </div>
                        <p _ngcontent-ugy-c44="" class="mb-0">Overall balance</p>
                      </div>
                      <div _ngcontent-ugy-c44="" class="col-sm-5">
                        <div _ngcontent-ugy-c44="" class="mb-3">
                          <!---->
                          <button _ngcontent-ugy-c44="" class="btn mr-3 btn-sm btn-secondary ng-star-inserted">Deposit</button>
                          <button _ngcontent-ugy-c44="" class="btn mr-3 btn-sm btn-light ng-star-inserted">Withdraw</button>
                        </div>
                        <p _ngcontent-ugy-c44="" class="mb-0">A/C: 4578******45</p>
                      </div>
                    </div>
                    <hr _ngcontent-ugy-c44="" class="my-5">
                    <div _ngcontent-ugy-c44="" class="position-relative">
                      <h5 _ngcontent-ugy-c44="">Portfolio Distribution</h5>
                      <div _ngcontent-ugy-c44="" class="row no-gutters">
                        <!---->
                        <div _ngcontent-ugy-c44="" class="col-sm-4 col-12 mb-2 mb-sm-0 ng-star-inserted">
                          <div _ngcontent-ugy-c44="" class="media">
                            <circle-progress _ngcontent-ugy-c44="" class="mr-2 size-50">
                              <!---->
                              <svg preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160" height="160" width="160" class="mr-2 size-50 ng-star-inserted">
                                <defs>
                                  <!---->
                                  <!---->
                                </defs>
                                <!---->
                                <!---->
                                <!---->
                                <circle cx="80" cy="80" r="70" fill="transparent" fill-opacity="1" stroke="transparent" stroke-width="0" class="ng-star-inserted"></circle>
                                <!---->
                                <!---->
                                <!---->
                                <circle cx="80" cy="80" r="55" fill="none" stroke="#e7e8ea" stroke-width="20" class="ng-star-inserted"></circle>
                                <!---->
                                <!---->
                                <!---->
                                <path d="M 80 25
        A 55 55 0 1 1 42.34990917392214 39.90672549182235" stroke="#59c100" stroke-width="20" stroke-linecap="round" fill="none" class="ng-star-inserted"></path>
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                              </svg>
                            </circle-progress>
                            <div _ngcontent-ugy-c44="" class="media-body align-self-center">
                              <h5 _ngcontent-ugy-c44="" class="mb-0">Bitcoin</h5>
                              <div _ngcontent-ugy-c44="" class="d-flex align-items-baseline"><span _ngcontent-ugy-c44="" class="display-5 font-weight-500 text-primary mr-2">8.74</span>
                                <div _ngcontent-ugy-c44="" class="trending-section"><span _ngcontent-ugy-c44="" class="value f-12">78%</span></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div _ngcontent-ugy-c44="" class="col-sm-4 col-12 mb-2 mb-sm-0 ng-star-inserted">
                          <div _ngcontent-ugy-c44="" class="media">
                            <circle-progress _ngcontent-ugy-c44="" class="mr-2 size-50">
                              <!---->
                              <svg preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160" height="160" width="160" class="mr-2 size-50 ng-star-inserted">
                                <defs>
                                  <!---->
                                  <!---->
                                </defs>
                                <!---->
                                <!---->
                                <!---->
                                <circle cx="80" cy="80" r="70" fill="transparent" fill-opacity="1" stroke="transparent" stroke-width="0" class="ng-star-inserted"></circle>
                                <!---->
                                <!---->
                                <!---->
                                <circle cx="80" cy="80" r="55" fill="none" stroke="#e7e8ea" stroke-width="20" class="ng-star-inserted"></circle>
                                <!---->
                                <!---->
                                <!---->
                                <path d="M 80 25
        A 55 55 0 1 1 63.00406530937788 132.30810839623345" stroke="#4f35ac" stroke-width="20" stroke-linecap="round" fill="none" class="ng-star-inserted"></path>
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                              </svg>
                            </circle-progress>
                            <div _ngcontent-ugy-c44="" class="media-body align-self-center">
                              <h5 _ngcontent-ugy-c44="" class="mb-0">Etherium</h5>
                              <div _ngcontent-ugy-c44="" class="d-flex align-items-baseline"><span _ngcontent-ugy-c44="" class="display-5 font-weight-500 text-primary mr-2">3.68</span>
                                <div _ngcontent-ugy-c44="" class="trending-section"><span _ngcontent-ugy-c44="" class="value f-12">38%</span></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div _ngcontent-ugy-c44="" class="col-sm-4 col-12 mb-2 mb-sm-0 ng-star-inserted">
                          <div _ngcontent-ugy-c44="" class="media">
                            <circle-progress _ngcontent-ugy-c44="" class="mr-2 size-50">
                              <!---->
                              <svg preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 160" height="160" width="160" class="mr-2 size-50 ng-star-inserted">
                                <defs>
                                  <!---->
                                  <!---->
                                </defs>
                                <!---->
                                <!---->
                                <!---->
                                <circle cx="80" cy="80" r="70" fill="transparent" fill-opacity="1" stroke="transparent" stroke-width="0" class="ng-star-inserted"></circle>
                                <!---->
                                <!---->
                                <!---->
                                <circle cx="80" cy="80" r="55" fill="none" stroke="#e7e8ea" stroke-width="20" class="ng-star-inserted"></circle>
                                <!---->
                                <!---->
                                <!---->
                                <path d="M 80 25
        A 55 55 0 0 1 134.89147006355495 83.45347857411222" stroke="#ff4081" stroke-width="20" stroke-linecap="round" fill="none" class="ng-star-inserted"></path>
                                <!---->
                                <!---->
                                <!---->
                                <!---->
                              </svg>
                            </circle-progress>
                            <div _ngcontent-ugy-c44="" class="media-body align-self-center">
                              <h5 _ngcontent-ugy-c44="" class="mb-0">Ripple</h5>
                              <div _ngcontent-ugy-c44="" class="d-flex align-items-baseline"><span _ngcontent-ugy-c44="" class="display-5 font-weight-500 text-primary mr-2">1.25</span>
                                <div _ngcontent-ugy-c44="" class="trending-section"><span _ngcontent-ugy-c44="" class="value f-12">15%</span></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </card-body>
                </section-balance-portfolio>
              </div>
              
			
			
              <!--box crypto rate 4 -->
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-bitcoin icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Bitcoin Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-success ng-star-inserted"><span class="f-16 mr-1">84%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-up ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$9,626</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,84.333C11.289,81.667,15.158,68.778,17.737,68.333C20.316,67.889,22.894,82.556,25.473,81.667C28.052,80.778,30.631,69.222,33.21,63C35.789,56.778,38.368,46.111,40.947,44.333C43.526,42.556,46.104,55,48.683,52.333C51.262,49.667,53.841,29.222,56.42,28.333C58.999,27.444,61.578,40.333,64.157,47C66.736,53.667,69.314,66.111,71.893,68.333C74.472,70.556,77.051,59,79.63,60.333C82.209,61.667,86.077,73.667,87.367,76.333" class="ct-line" style="stroke:#512DA8"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-etherium icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Etherium Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-success ng-star-inserted"><span class="f-16 mr-1">07%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-up ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$7,831</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,65.667C11.433,68.037,15.731,78.407,18.596,79.889C21.462,81.37,24.327,84.778,27.193,74.556C30.058,64.333,32.923,20.926,35.789,18.556C38.654,16.185,41.52,58.259,44.385,60.333C47.251,62.407,50.116,30.6,52.981,31C55.847,31.4,58.712,59.844,61.578,62.733C64.443,65.622,67.309,48.333,70.174,48.333C73.04,48.333,75.905,58.956,78.77,62.733C81.636,66.511,85.934,69.622,87.367,71" class="ct-line" style="stroke:#52c41a"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-ripple icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Ripple Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-danger ng-star-inserted"><span class="f-16 mr-1">08%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-down ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$1,239</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,55C11.433,48.333,15.731,15,18.596,15C21.462,15,24.327,50.556,27.193,55C30.058,59.444,32.923,41.667,35.789,41.667C38.654,41.667,41.52,57.222,44.385,55C47.251,52.778,50.116,29.222,52.981,28.333C55.847,27.444,58.712,47.444,61.578,49.667C64.443,51.889,67.309,39.889,70.174,41.667C73.04,43.444,75.905,57.222,78.77,60.333C81.636,63.444,85.934,60.333,87.367,60.333" class="ct-line" style="stroke:#FF4081"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-litcoin icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Litcoin Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-danger ng-star-inserted"><span class="f-16 mr-1">47%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-down ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$849</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,68.333C11.433,59.444,15.731,17.222,18.596,15C21.462,12.778,24.327,50.556,27.193,55C30.058,59.444,32.923,41.667,35.789,41.667C38.654,41.667,41.52,57.222,44.385,55C47.251,52.778,50.116,29.222,52.981,28.333C55.847,27.444,58.712,40.778,61.578,49.667C64.443,58.556,67.309,83,70.174,81.667C73.04,80.333,75.905,46.111,78.77,41.667C81.636,37.222,85.934,52.778,87.367,55" class="ct-line" style="stroke:#fa8c16"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
			  
			   <!--box crypto rate 4 -->
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-bitcoin icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Bitcoin Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-success ng-star-inserted"><span class="f-16 mr-1">84%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-up ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$9,626</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,84.333C11.289,81.667,15.158,68.778,17.737,68.333C20.316,67.889,22.894,82.556,25.473,81.667C28.052,80.778,30.631,69.222,33.21,63C35.789,56.778,38.368,46.111,40.947,44.333C43.526,42.556,46.104,55,48.683,52.333C51.262,49.667,53.841,29.222,56.42,28.333C58.999,27.444,61.578,40.333,64.157,47C66.736,53.667,69.314,66.111,71.893,68.333C74.472,70.556,77.051,59,79.63,60.333C82.209,61.667,86.077,73.667,87.367,76.333" class="ct-line" style="stroke:#512DA8"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-etherium icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Etherium Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-success ng-star-inserted"><span class="f-16 mr-1">07%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-up ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$7,831</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,65.667C11.433,68.037,15.731,78.407,18.596,79.889C21.462,81.37,24.327,84.778,27.193,74.556C30.058,64.333,32.923,20.926,35.789,18.556C38.654,16.185,41.52,58.259,44.385,60.333C47.251,62.407,50.116,30.6,52.981,31C55.847,31.4,58.712,59.844,61.578,62.733C64.443,65.622,67.309,48.333,70.174,48.333C73.04,48.333,75.905,58.956,78.77,62.733C81.636,66.511,85.934,69.622,87.367,71" class="ct-line" style="stroke:#52c41a"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-ripple icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Ripple Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-danger ng-star-inserted"><span class="f-16 mr-1">08%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-down ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$1,239</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,55C11.433,48.333,15.731,15,18.596,15C21.462,15,24.327,50.556,27.193,55C30.058,59.444,32.923,41.667,35.789,41.667C38.654,41.667,41.52,57.222,44.385,55C47.251,52.778,50.116,29.222,52.981,28.333C55.847,27.444,58.712,47.444,61.578,49.667C64.443,51.889,67.309,39.889,70.174,41.667C73.04,43.444,75.905,57.222,78.77,60.333C81.636,63.444,85.934,60.333,87.367,60.333" class="ct-line" style="stroke:#FF4081"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-sm-6 ng-star-inserted">
                <gx-crypto-card _ngcontent-ugy-c43="" gxcard="" class="dt-card">
                  <card-header class="px-5 pt-4 mb-4 dt-card__header">
                    <!---->
                    <card-heading _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 class="dt-card__title f-12 font-weight-400">
                        <gx-icon class="mr-2 icon text-primary icon-litcoin icon-2x" size="2x"></gx-icon>
                        <span class="align-middle">Litcoin Price</span></h3>
                    </card-heading>
                  </card-header>
                  <card-body class="px-5 pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div class="row no-gutters">
                      <div class="col-6">
                        <!---->
                        <div class="d-flex align-items-center text-danger ng-star-inserted"><span class="f-16 mr-1">47%</span>
                          <!---->
                          <gx-icon class="icon icon-pointer-down ng-star-inserted"></gx-icon>
                        </div>
                        <span class="display-4 font-weight-500 text-dark">$849</span></div>
                      <div class="col-6">
                        <gx-chartist-chart _ngcontent-ugy-c43="" class="dt-chart__body" classnames="stroke-w-3 drop-shadow mt-n8 mb-n2">
                          <x-chartist _nghost-ugy-c40="" class="stroke-w-3 drop-shadow mt-n8 mb-n2">
                            <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100" class="ct-chart-line" style="width: 100%;">
                              <g class="ct-grids"></g>
                              <g>
                                <g class="ct-series ct-series-a">
                                  <path d="M10,68.333C11.433,59.444,15.731,17.222,18.596,15C21.462,12.778,24.327,50.556,27.193,55C30.058,59.444,32.923,41.667,35.789,41.667C38.654,41.667,41.52,57.222,44.385,55C47.251,52.778,50.116,29.222,52.981,28.333C55.847,27.444,58.712,40.778,61.578,49.667C64.443,58.556,67.309,83,70.174,81.667C73.04,80.333,75.905,46.111,78.77,41.667C81.636,37.222,85.934,52.778,87.367,55" class="ct-line" style="stroke:#fa8c16"></path>
                                </g>
                              </g>
                              <g class="ct-labels"></g>
                            </svg>
                          </x-chartist>
                        </gx-chartist-chart>
                      </div>
                    </div>
                  </card-body>
                </gx-crypto-card>
              </div>
			  
			  
			  
             
			  
			  
              <div _ngcontent-ugy-c43="" class="col-xl-9 col-md-12">
                <app-section-pricing-updates _ngcontent-ugy-c43="" class="pb-4 dt-card dt-card__full-height" fullheight="" gxcard="" _nghost-ugy-c46="">
                  <card-header _ngcontent-ugy-c46="" card-title="Pricing Updates" class="mb-5 dt-card__header">
                    <!---->
                    <!---->
                    <div class="dt-card__heading ng-star-inserted">
                      <!---->
                      <h3 class="dt-card__title ng-star-inserted" style="text-align:center;">Live Updates</h3>
                      <!---->
                    </div>
                     
                  </card-header>
                   <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <!--<div class="tradingview-widget-copyright"><a href="https://in.tradingview.com/markets/cryptocurrencies/prices-all/" rel="noopener" target="_blank"><span class="blue-text">Cryptocurrency Markets</span></a> by TradingView</div>-->
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
  {
  "width": "768",
  "height": "302",
  "defaultColumn": "overview",
  "screener_type": "crypto_mkt",
  "displayCurrency": "USD",
  "colorTheme": "light",
  "locale": "in",
  "isTransparent": false
}
  </script>
</div>
<!-- TradingView Widget END -->
                </app-section-pricing-updates>
              </div>
              <?php /*?><div _ngcontent-ugy-c43="" class="col-xl-4 col-md-6">
                <gx-currency-calculator _ngcontent-ugy-c43="" cardtitle="Currency Calculator" fullheight="" gxcard="" _nghost-ugy-c47="" class="dt-card dt-card__full-height">
                  <card-header _ngcontent-ugy-c47="" class="mb-6 dt-card__header">
                    <!---->
                    <!---->
                    <div class="dt-card__heading ng-star-inserted">
                      <!---->
                      <h3 class="dt-card__title ng-star-inserted">Currency Calculator</h3>
                      <!---->
                    </div>
                  </card-header>
                  <card-body _ngcontent-ugy-c47="" _nghost-ugy-c31="" class="dt-card__body">
                    <form _ngcontent-ugy-c47="" novalidate="" class="ng-untouched ng-pristine ng-valid">
                      <div _ngcontent-ugy-c47="" class="form-row mb-7">
                        <div _ngcontent-ugy-c47="" class="col-sm-4 col-6">
                          <label _ngcontent-ugy-c47="" for="currency-type-1">From</label>
                          <select _ngcontent-ugy-c47="" class="custom-select custom-select-sm" id="currency-type-1">
                            <option _ngcontent-ugy-c47="" selected="">BTC</option>
                            <option _ngcontent-ugy-c47="" value="1">RPL</option>
                            <option _ngcontent-ugy-c47="" value="2">LTE</option>
                          </select>
                        </div>
                        <div _ngcontent-ugy-c47="" class="col-sm-4 col-6">
                          <label _ngcontent-ugy-c47="" for="currency-type">From</label>
                          <select _ngcontent-ugy-c47="" class="custom-select custom-select-sm" id="currency-type">
                            <option _ngcontent-ugy-c47="" selected="">USD</option>
                            <option _ngcontent-ugy-c47="" value="1">Yen</option>
                            <option _ngcontent-ugy-c47="" value="2">Dinar</option>
                          </select>
                        </div>
                        <div _ngcontent-ugy-c47="" class="col-sm-4 col-12 mt-5 mt-sm-0">
                          <label _ngcontent-ugy-c47="" for="amount">Amount(BTC)</label>
                          <input _ngcontent-ugy-c47="" class="form-control form-control-sm" id="amount" placeholder="Amount" type="text">
                        </div>
                      </div>
                      <div _ngcontent-ugy-c47="" class="mb-6"><span _ngcontent-ugy-c47="" class="d-block f-12 mb-1">1 Euro = 1.23 USD</span>
                        <h2 _ngcontent-ugy-c47="" class="mb-1 display-4 font-weight-500 text-primary">11466.78 USD</h2>
                        <span _ngcontent-ugy-c47="" class="d-block">@ 1 BTC = 6718.72 USD</span></div>
                      <div _ngcontent-ugy-c47="">
                        <button _ngcontent-ugy-c47="" class="btn btn-primary btn-sm f-14 mr-2" type="submit">Buy Now</button>
                        <button _ngcontent-ugy-c47="" class="btn btn-light btn-sm f-14" type="reset">Reset</button>
                      </div>
                    </form>
                  </card-body>
                </gx-currency-calculator>
              </div><?php */?>
              <div _ngcontent-ugy-c43="" class="col-xl-3 col-md-6">
                <gx-invite-friends-card _ngcontent-ugy-c43="" class="bg-image-v6 bg-overlay overlay-opacity-0_8 bg-gradient-blue--after text-white dt-card dt-card__full-height" fullheight="" gxcard="" _nghost-ugy-c48="">
                  <div _ngcontent-ugy-c48="" class="bg-overlay__inner mt-auto">
                    <div _ngcontent-ugy-c48="" class="dt-card__body text-center">
                      <h3 _ngcontent-ugy-c48="" class="text-white mb-2">Refer &amp; Earn $15</h3>
                      <p _ngcontent-ugy-c48="">Refer us to your friends and earn Income when they join.</p>
                      <input _ngcontent-ugy-c48="" class="form-control form-control-transparent text-center mb-2" placeholder="Enter Mobile No." type="email">
                      <a _ngcontent-ugy-c48="" class="btn btn-light btn-block" href="javascript:void(0)">Invite Friends</a></div>
                  </div>
                </gx-invite-friends-card>
              </div>
            </div>
             
          </app-crypto-dashboard>
        </div>
		 <? include("includes/footer.php")?>
       </div>
      <!-- /site content wrapper -->
      <!-- Theme Chooser -->
      <!-- /theme chooser -->
      <!-- Customizer Sidebar -->
      <!-- /customizer sidebar -->
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
<!-- /contact user information -->
<!-- masonry script -->
<? include("includes/extra_footer.php")?>
</body>
</html>
