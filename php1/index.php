<?php include ("includes/surya.dream.php"); 
  if ($_GET['ref']!='') { 
	$_SESSION['ref']= $_GET['ref']; 
	$_SESSION['ref_side']= $_GET['ref_side']; 
	header("Location: signup.php");
	exit;
 }
$pg = "index";

/// Dynamic popup
/*$sql_popup = "select * from ngo_image where image_title ='INDEX'";
$result_popup = db_query($sql_popup);
$line_popup= mysqli_fetch_array($result_popup);
@extract($line_popup);  */

?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
	<?php include("includes/extra_head.inc.php") ?>
    </head>
<body data-mobile-nav-style="classic" class="custom-cursor">
		<?php include("includes/header.inc.php") ?>
        
        <!-- start section -->
        <section id="home" class="bg-light-gray cover-background" style="background-image: url('images/demo-cryptocurrency-hero-bg.jpg')">
            <div class="position-absolute left-minus-70px mt-2 d-none d-xl-inline-block" data-parallax-liquid="true" data-parallax-transition="2" data-parallax-position="top">
                <img src="images/demo-cryptocurrency-elements-01.png" alt="" data-bottom-top="transform: rotate(-30deg)" data-top-bottom="transform:rotate(10deg)">            </div>
            <div class="position-absolute mt-10 right-80px xxl-right-0px d-none d-xl-inline-block" data-parallax-liquid="true" data-parallax-transition="2" data-parallax-position="bottom">
                <img src="images/demo-cryptocurrency-elements-02.png" alt="" data-bottom-top="transform: rotate(-60deg)" data-top-bottom="transform:rotate(60deg)">            </div>
            <div class="position-absolute bottom-0 xl-bottom-120px left-0 ms-12 xxl-ms-5 mb-25 xxl-mb-30 d-none d-xl-inline-block" data-parallax-liquid="true" data-parallax-transition="2" data-parallax-position="bottom">
                <img src="images/demo-cryptocurrency-elements-03.png" alt="" data-bottom-top="transform: rotate(-30deg)" data-top-bottom="transform:rotate(60deg)">            </div>
            <div class="container position-relative">
                <div class="row pt-12 mb-14 xxl-pt-10 xl-pt-6 xxl-mb-10 sm-pt-70px xs-mb-35px">
				<style>
				@keyframes blink {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

.blinking-text {
  animation: blink 1s infinite;
}

				</style>
					<h4 class="text-green blinking-text" style="text-align:center;">THE OFFICIAL LAUNCH DATE OF <span class="text-white"><strong>KENZO TRADE</strong></span> IS <span class="text-white"><strong>01 FEBRUARY</strong></span></h4>
                    <div class="col text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div class="fs-80 lg-fs-70 md-fs-60 fw-600 ls-minus-2px mb-25px text-white">Best place to invest and make <div class="highlight-separator z-index-1" data-shadow-animation="true" data-animation-delay="500">cryptocurrency <span><img src="images/demo-cryptocurrency-highlight-separator.svg" alt="" class="h-25px"></span></div> assets</div>
                        <p class="fs-20 fw-300 w-55 lg-w-70 md-w-100 mx-auto mb-0">The platform is where you can invest your money and  make assets securely and quickly. The best investment platform..</p>
                        <div class="d-flex align-items-center justify-content-center flex-wrap mt-40px xs-mt-30px">
                            <a href="signup.php" class="btn btn-extra-large btn-base-color btn-rounded d-inline-block me-30px xs-me-10px btn-box-shadow btn-switch-text sm-mt-10px sm-mb-10px section-link"><span><span class="btn-double-text" data-text="Get started now">Get started now</span></span></a>
							
							<a href="login.php" class="btn btn-extra-large btn-base-color btn-rounded d-inline-block me-30px xs-me-10px btn-box-shadow btn-switch-text sm-mt-10px sm-mb-10px section-link"><span><span class="btn-double-text" data-text="Login Now">Login Now</span></span></a>
                            <!--<a href="https://www.youtube.com/watch?v=cfXHhfNy7tU" class="text-center d-inline-flex sm-mt-10px sm-mb-10px rounded-circle video-icon-box video-icon-medium popup-vimeo position-relative text-uppercase">
                                <span class="video-icon bg-extra-medium-gray me-15px">
                                    <i class="fa-solid fa-play text-base-color"></i>
                                    <span class="video-icon-sonar">
                                        <span class="video-icon-sonar-afr bg-white"></span>                                    </span>                                </span>
                                <span class="text-white fs-16">Explore features</span>                            </a>-->                        </div>
                    </div> 
                </div>
                <div class="row mb-14 xxl-mb-10 justify-content-center g-0">
                    <div class="col-md-auto col-sm-10 border-radius-100px pt-15px pb-15px ps-45px pe-45px md-ps-20px md-pe-20px border border-color-transparent-white-very-light fs-22 text-white text-md-start text-center" data-anime='{"opacity": [0,1], "duration": 4000, "staggervalue": 300, "easing": "easeOutQuad" }'>
                         
                        <span class="d-inline-block text-green"><span class="fw-700 ">A unique trading platform </span> where there is no room for losing.</span>                    </div>
                </div>
            </div>
            <div class="container-fluid ps-9 pe-9 xxl-ps-2 xxl-pe-2 sm-ps-15px sm-pe-15px">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-4 justify-content-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-02 transition-inner-all xl-mb-30px">
                        <div class="feature-box feature-box-left-icon-middle bg-medium-gray-transparent border-radius-10px p-9 overflow-hidden last-paragraph-no-margin box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                            <div class="feature-box-icon">
                                <img src="images/demo-cryptocurrency-icon-01.svg" alt="">                            </div>
                            <div class="feature-box-content">
                                <span class="d-inline-block fs-18 text-white fw-600 text-uppercase">Bitcoin</span>
                                <p class="fs-15 lh-22">Price: $2,708.90</p>
                            </div>
                            <span class="d-inline-block bg-green text-black fw-600 border-radius-100px ps-10px pe-10px fs-12">+0.50%</span>
                            <div class="feature-box-overlay bg-gradient-black-bottom-transparent"></div>
                        </div>  
                    </div>
                    <!-- end features box item -->                    
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-02 transition-inner-all xl-mb-30px">
                        <div class="feature-box feature-box-left-icon-middle bg-medium-gray-transparent border-radius-10px p-9 overflow-hidden last-paragraph-no-margin box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                            <div class="feature-box-icon">
                                <img src="images/demo-cryptocurrency-icon-02.svg" alt="">                            </div>
                            <div class="feature-box-content">
                                <span class="d-inline-block fs-18 text-white fw-600 text-uppercase">Ethereum</span>
                                <p class="fs-15 lh-22">Price: $1,890.24</p>
                            </div>
                            <span class="d-inline-block bg-green text-black fw-600 border-radius-100px ps-10px pe-10px fs-12">+0.35%</span>
                            <div class="feature-box-overlay bg-gradient-black-bottom-transparent"></div>
                        </div>  
                    </div>
                    <!-- end features box item -->                    
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-02 transition-inner-all sm-mb-30px">
                        <div class="feature-box feature-box-left-icon-middle bg-medium-gray-transparent border-radius-10px p-9 overflow-hidden last-paragraph-no-margin box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                            <div class="feature-box-icon">
                                <img src="images/demo-cryptocurrency-icon-03.svg" alt="">                            </div>
                            <div class="feature-box-content">
                                <span class="d-inline-block fs-18 text-white fw-600 text-uppercase">Cardano</span>
                                <p class="fs-15 lh-22">Price: $948.90</p>
                            </div>
                            <span class="d-inline-block bg-red text-black fw-600 border-radius-100px ps-10px pe-10px fs-12">-0.25%</span>
                            <div class="feature-box-overlay bg-gradient-black-bottom-transparent"></div>
                        </div>  
                    </div>
                    <!-- end features box item -->                    
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-02 transition-inner-all">
                        <div class="feature-box feature-box-left-icon-middle bg-medium-gray-transparent border-radius-10px p-9 overflow-hidden last-paragraph-no-margin box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                            <div class="feature-box-icon">
                                <img src="images/demo-cryptocurrency-icon-04.svg" alt="">                            </div>
                            <div class="feature-box-content">
                                <span class="d-inline-block fs-18 text-white fw-600 text-uppercase">Binance</span>
                                <p class="fs-15 lh-22">Price: $948.90</p>
                            </div>
                            <span class="d-inline-block bg-green text-black fw-600 border-radius-100px ps-10px pe-10px fs-12">+0.20%</span>
                            <div class="feature-box-overlay bg-gradient-black-bottom-transparent"></div>
                        </div>  
                    </div>
                    <!-- end features box item -->                    
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section id="about" class="cover-background pb-0" style="background-image: url('images/demo-cryptocurrency-bg-01.jpg');">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-12 last-paragraph-no-margin order-lg-1 order-2" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <span class="text-white fw-600 mb-15px text-uppercase d-inline-block fs-14 ls-1px border-bottom border-color-transparent-white-very-light">About Kenzo Trade</span>
                        <h3 class="fw-600 text-white w-90 xl-w-100 text-dark-gray fw-700 ls-minus-1px">Kenzo Trade</h3>
                        <p class="w-95 xl-w-100">This platform offers an opportunity for those who want to turn a small investment into a large amount of money, where they can convert their money into a much larger sum without any knowledge or experience, and that too without any loss.</p>
                        <ul class="p-0 mb-20px mt-15px list-style-01">
                            <li class="border-color-transparent-white-light text-white d-flex align-items-center pt-20px pb-20px">
                                <div class="feature-box-icon feature-box-icon-rounded w-40px h-40px rounded-circle bg-light-gray me-20px text-center d-flex align-items-center justify-content-center flex-shrink-0"><i class="fa-solid fa-check fs-14 text-base-color"></i></div>A unique trading system that generates profit whether the market is falling or rising.                           </li>
                            <li class="text-white d-flex align-items-center pt-20px pb-20px">
                                <div class="feature-box-icon feature-box-icon-rounded w-40px h-40px rounded-circle bg-light-gray me-20px text-center d-flex align-items-center justify-content-center flex-shrink-0"><i class="fa-solid fa-check fs-14 text-base-color"></i></div>Global Opportunity and Instant Transactions.                            </li>
                        </ul>
                        <a href="#live-market" class="btn btn-large btn-base-color btn-box-shadow btn-rounded btn-switch-text inner-link">
                            <span>
                                <span class="btn-double-text" data-text="Start now">Start now</span>                            </span>                        </a>                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-12 order-lg-2 order-1 md-mb-15px md-ps-70px sm-ps-40px" data-anime='{ "el": "childs", "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'> 
                        <img src="images/demo-cryptocurrency-img-01.png" data-bottom-top="transform: translateY(-50px)" data-top-bottom="transform: translateY(50px)" alt="">                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section id="live-market" class="cover-background overflow-visible" style="background-image: url('images/demo-cryptocurrency-bg-02.jpg');">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <h3 class="fw-600 mb-10px text-white">Top cryptocurrencies</h3>
                        <p>More then 91 crypto coins available in the market.</p>
                    </div>
                </div>
                <div class="crypto-data-scroll mb-50px sm-mb-35px">
                    <div class="row justify-content-center border-color-very-light-gray border border-radius-10px lg-no-border-radius crypto-data-min-width g-0 overflow-hidden" data-anime='{ "el": "childs", "translateY": [15, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue":100, "easing": "easeOutQuad" }'>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-ps-15px lg-pe-15px fs-15 bg-gradient-dark-transparent text-uppercase text-white">
                            <div class="row align-items-center fw-600">
                                <div class="col-2">Crypto</div>
                                <div class="col-1 w-100px">Symbol</div>
                                <div class="col-2">Market value</div>
                                <div class="col-2">Price</div>
                                <div class="col-2">Volume</div>
                                <div class="col-auto w-120px">Change</div>
                                <div class="col-auto">Trade</div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-01.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">Bitcoin</span>                                </div>
                                <div class="col-1">BTC</div>
                                <div class="col-2 text-white">$513,347,849,710</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$15,534,672,501</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-down text-red fs-20 me-5px align-middle"></i>-0.76%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15 bg-light-gray">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-02.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">Ethereum</span>                                </div>
                                <div class="col-1">ETH</div>
                                <div class="col-2 text-white">$221,778,352,150</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$6,477,454,144</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-down text-red fs-20 me-5px align-middle"></i>-0.80%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-03.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">Tether</span>                                </div>
                                <div class="col-1">USDT</div>
                                <div class="col-2 text-white">$83,311,196,592</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$23,309,821,463</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-down text-red fs-20 me-5px align-middle"></i>-0.03%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15 bg-light-gray">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-04.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">Litecoin</span>                                </div>
                                <div class="col-1">LTC</div>
                                <div class="col-2 text-white">$6,435,318,786</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$465,055,044</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-down text-red fs-20 me-5px align-middle"></i>-3.79%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-05.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">USD Coin</span>                                </div>
                                <div class="col-1">USDC</div>
                                <div class="col-2 text-white">$28,501,411,171</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$3,607,661,067</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-up text-green fs-20 me-5px align-middle"></i>0.16%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15 bg-light-gray">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-06.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">Monero</span>                                </div>
                                <div class="col-1">XMR</div>
                                <div class="col-2 text-white">$2,645,855,936</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$49,944,795</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-down text-red fs-20 me-5px align-middle"></i>-3.38%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-07.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">Cardano</span>                                </div>
                                <div class="col-1">ADA</div>
                                <div class="col-2 text-white">$11,410,276,829</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$370,632,725</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-down text-red fs-20 me-5px align-middle"></i>-5.72%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-20px pb-20px ps-35px pe-35px lg-p-15px fs-15 bg-light-gray">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="images/demo-cryptocurrency-icon-08.svg" alt="" class="h-30px w-30px me-10px">
                                    <span class="fw-600 text-white align-middle d-inline-block">Solana</span>                                </div>
                                <div class="col-1">SOL</div>
                                <div class="col-2 text-white">$7,462,156,337</div>
                                <div class="col-2 text-white">$26,456.53</div>
                                <div class="col-2 text-white">$392,785,339</div>
                                <div class="col-auto w-120px text-white">
                                    <span><i class="bi bi-arrow-down text-red fs-20 me-5px align-middle"></i>-3.79%</span>                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-very-small border-1 btn-transparent-base-color btn-transparent-base-color-hover btn-rounded btn-switch-text">
                                        <span>
                                            <span class="btn-double-text" data-text="Trade now">Trade now</span>                                        </span>                                    </a>                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="col-12 text-white fs-20 text-green">You can start making money on this platform with <div class="highlight-separator z-index-1 fw-600 pb-10px" data-shadow-animation="true" data-animation-delay="500"> $50 or any multiple of this amount.<span><img src="images/demo-cryptocurrency-highlight-separator-small.svg" alt="" class="h-25px"></span></div></div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section id="features" class="cover-background" style="background-image:url('images/demo-cryptocurrency-bg-03.jpg');">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <h3 class="fw-600 mb-10px text-white">Kenzo Trade</h3>
                        <p class="text-white">Kenzotrade is a unique and amazing method of trading , you can start from the $50 and multiple</p>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center" data-anime='{ "el": "childs", "translateY": [0, 0], "perspective": [1200,1200], "scale": [1.1, 1], "rotateX": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                        <div class="feature-box bg-gradient-gray-light-dark-transparent border-radius-10px h-100 p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover overflow-hidden">
                            <div class="feature-box-icon feature-box-icon-rounded bg-light-gray w-110px h-110px rounded-circle mb-25px box-shadow-medium">
                                <img src="images/demo-cryptocurrency-icon-10.png" alt="">                            </div>
                            <div class="feature-box-content last-paragraph-no-margin">
                                <span class="d-inline-block text-white fw-600 fs-18 mb-5px">Daily Profit</span>
                                <p class="text-green">Daily Profit 4% per day for 30 days.<br>
<br>
<br>
 </p>
                            </div>
                            <div class="feature-box-overlay bg-very-light-gray"></div>
                        </div>  
                    </div>
                    <!-- end features box item -->
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                        <div class="feature-box bg-gradient-gray-light-dark-transparent border-radius-10px h-100 p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover overflow-hidden">
                            <div class="feature-box-icon feature-box-icon-rounded bg-light-gray w-110px h-110px rounded-circle mb-25px box-shadow-medium">
                                <img src="images/demo-cryptocurrency-icon-11.png" alt="">                            </div>
                            <div class="feature-box-content last-paragraph-no-margin">
                                <span class="d-inline-block text-white fw-600 fs-18 mb-5px">Referral Bonus</span>
                                <p class="text-green">You will receive 30% from the person you sponsor, and this will be according to your package.</p>
                            </div>
                            <div class="feature-box-overlay bg-very-light-gray"></div>
                        </div>  
                    </div>
                    <!-- end features box item -->
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-04 transition-inner-all">
                        <div class="feature-box bg-gradient-gray-light-dark-transparent border-radius-10px h-100 p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover overflow-hidden">
                            <div class="feature-box-icon feature-box-icon-rounded bg-light-gray w-110px h-110px rounded-circle mb-25px box-shadow-medium"> 
                                <img src="images/demo-cryptocurrency-icon-12.png" alt="">                            </div>
                            <div class="feature-box-content last-paragraph-no-margin">
                                <span class="d-inline-block text-white fw-600 fs-18 mb-5px">Level Bonus</span>
                                <p class="text-green">This will come to you up to 10 levels in your team, and it will be calculated from your team's profit bonus.</p>
                            </div>
                            <div class="feature-box-overlay bg-very-light-gray"></div>
                        </div>  
                    </div>
                    <!-- end features box item -->
				
					
                </div>
					 
					<p  style="text-align:center; margin-top:50px; "><h5 class="text-green-bordered" >Level 1 : <span class="text-white">3%</span>, Level 2 : <span class="text-white">2%</span>, Level 3 : <span class="text-white">1%</span>, Level 4 To 9 : <span class="text-white">0.50%</span>, Level 10 : <span class="text-white">1%</span></h5></p>
					 
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="pt-25px pb-25px bg-base-color">
            <div class="container-fluid">
                <div class="row">
                    <div class="col swiper" data-slider-options='{ "slidesPerView": "auto", "spaceBetween":0, "centeredSlides": true, "speed": 12000, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": false, "autoplay": { "delay":1, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                        <div class="swiper-wrapper swiper-width-auto marquee-slide">
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-60px me-60px md-ms-30px md-me-30px opacity-2"></span>A smart and secure way to invest in crypto</div>
                            </div>
                            <!-- end client item --> 
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-60px me-60px md-ms-30px md-me-30px opacity-2"></span>Buy, sell, and spend crypto anywhere</div>
                            </div>

                            <!-- end client item -->
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-60px me-60px md-ms-30px md-me-30px opacity-2"></span>Trusted cryptocurrency platform</div>
                            </div>
                            <!-- end client item -->
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-60px me-60px md-ms-30px md-me-30px opacity-2"></span>Making the future of crypto beautiful</div>
                            </div>
                            <!-- end client item --> 
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-60px me-60px md-ms-30px md-me-30px opacity-2"></span>A smart and secure way to invest in crypto</div>
                            </div>
                            <!-- end client item --> 
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-60px me-60px md-ms-30px md-me-30px opacity-2"></span>Buy, sell, and spend crypto anywhere</div>
                            </div>
                            <!-- end client item -->
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-60px me-60px md-ms-30px md-me-30px opacity-2"></span>Trusted cryptocurrency platform</div>
                            </div>
                            <!-- end client item -->
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="fs-22 sm-fs-20 fw-500 text-dark-gray"><span class="w-30px border border-1 border-color-dark-gray d-inline-block align-middle ms-45px me-45px md-ms-30px md-me-30px opacity-2"></span>Making the future of crypto beautiful</div>
                            </div>
                            <!-- end client item --> 
                        </div> 
                    </div>  
                </div> 
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
   		<section  class="position-relative pb-12 overflow-hidden background-repeat" style="background-image:url('images/demo-cryptocurrency-bg-04.jpg');">
        <div class="container">
            <div class="row justify-content-center align-items-xl-start align-items-center lg-mb-5 sm-mb-0">
                <div class="col-lg-6 col-md-12 md-mb-50px position-relative"> 
                    <div class="w-85" data-animation-delay="200" data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)">
                        <img src="images/demo-cryptocurrency-img-03.png" alt="" class="border-radius-6px w-100">                    </div>
                    <div class="overflow-hidden position-absolute right-minus-40px bottom-0px lg-w-60 lg-right-minus-10px" data-animation-delay="100" data-bottom-top="transform: translateY(-20px)" data-top-bottom="transform: translateY(20px)">
                       <!-- <img src="images/demo-cryptocurrency-img-02.png" alt="" class="border-radius-6px w-100"/>  -->                  </div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-12 offset-xl-1" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <span class="text-white fw-600 mb-15px text-uppercase d-inline-block fs-14 ls-1px border-bottom border-color-transparent-white-very-light">Use Interface</span>
                    <h3 class="text-white fw-600 mb-15px lg-w-80 md-w-100">Invest your currencies with a few clicks.</h3>
                    <p>Platform is designed to provide you with the best experience, wide features that cater to every investor.</p>
                    <div class="mb-40px sm-mb-30px">
                        <!-- start features box item -->
                        <div class="icon-with-text-style-08 mb-10px">
                            <div class="feature-box feature-box-left-icon-middle">
                                <div class="feature-box-icon feature-box-icon-rounded w-35px h-35px bg-light-gray rounded-circle me-15px">
                                    <i class="fa-solid fa-check fs-15 text-base-color"></i>                                </div>
                                <div class="feature-box-content"> 
                                    <span>Easy-to-use interface.</span>                                </div>
                            </div>
                        </div>
                        <!-- end features box item -->
                        <!-- start features box item -->
                        <div class="icon-with-text-style-08 mb-10px">
                            <div class="feature-box feature-box-left-icon-middle">
                                <div class="feature-box-icon feature-box-icon-rounded w-35px h-35px bg-light-gray rounded-circle me-15px">
                                    <i class="fa-solid fa-check fs-15 text-base-color"></i>                                </div>
                                <div class="feature-box-content"> 
                                    <span>Kenzo trading strategies.</span>                                </div>
                            </div>
                        </div>
                        <!-- end features box item -->
                        <!-- start features box item -->
                        <div class="icon-with-text-style-08">
                            <div class="feature-box feature-box-left-icon-middle">
                                <div class="feature-box-icon feature-box-icon-rounded w-35px h-35px bg-light-gray rounded-circle me-15px">
                                    <i class="fa-solid fa-check fs-15 text-base-color"></i>                                </div>
                                <div class="feature-box-content"> 
                                    <span>Advanced trading tools.</span>                                </div>
                            </div>
                        </div>
                        <!-- end features box item -->
                    </div>
                    <a href="#live-market" class="btn btn-large btn-base-color btn-rounded btn-switch-text btn-box-shadow inner-link">
                        <span>
                            <span class="btn-double-text" data-text="Start trading now">Start trading now</span>                        </span>                    </a>                </div>
            </div>
        </div>
        <div class="position-absolute bottom-minus-70px xxl-bottom-minus-40px md-bottom-minus-20px left-0px right-0px text-center fs-300 xxl-fs-200 xl-fs-180 md-fs-140 d-none d-md-block text-very-light-gray ls-minus-8px fw-600 opacity-4">investment</div>
    </section>
        <!-- end section -->
        <!-- start section -->


        
        <section id="reviews" class="cover-background" style="background-image:url('images/demo-cryptocurrency-bg-05.jpg');">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <h3 class="fw-600 mb-10px text-white">Users share experiences</h3>
                        <p>Our support team is available to help you with any questions.</p>
                    </div>
                </div>
                <div class="row align-items-center mb-40px md-mb-25px">
                    <div class="col-12 position-relative" data-anime='{ "translateX": [100, 0], "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                        <div class="swiper slider-three-slide swiper-initialized swiper-horizontal magic-cursor base-color" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loopedSlides": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": true, "dynamicBullets": false }, "autoplay": { "delay": 300000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 3 }, "992": { "slidesPerView": 2 }, "768": { "slidesPerView": 2 } }, "effect": "slide" }'>
                            <div class="swiper-wrapper pb-20px">
                                <?php
                                // Fetch active feedback from database
                                $sql = "SELECT * FROM ngo_feedback WHERE status = 'active' ORDER BY feedback_id DESC LIMIT 6";
                                $result = db_query($sql);
                                
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                ?>
                                <!-- start review item -->
                                <div class="swiper-slide review-style-04"> 
                                    <div class="d-flex justify-content-center h-100 flex-column bg-dark-gray border-radius-10px p-10 xl-p-12 box-shadow-extra-large">
                                        <div class="review-star-icon fs-16">
                                            <?php
                                            // Display rating stars
                                            for($i = 1; $i <= 5; $i++) {
                                                if($i <= $row['feedback_rating']) {
                                                    echo '<i class="bi bi-star-fill"></i>';
                                                } else {
                                                    echo '<i class="bi bi-star-line"></i>';
                                                }
                                            }
                                            ?>
                                        </div> 
                                        <span class="text-white mb-15px fs-18">
                                            <?= htmlspecialchars($row['feedback_title']) ?>
                                        </span>
                                        <p class="mb-20px">
                                            <?= htmlspecialchars($row['feedback_desc']) ?>
                                        </p>
                                        <div class="mt-5px d-flex align-items-center">
                                            <div class="d-inline-block align-middle"> 
                                                <div class="text-white fw-500 fs-18">
                                                    <?= htmlspecialchars($row['feedback_name']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <!-- end review item -->
                                <?php
                                    }
                                } else {
                                ?>
                                <!-- If no feedback found -->
                                <div class="swiper-slide review-style-04"> 
                                    <div class="d-flex justify-content-center h-100 flex-column bg-dark-gray border-radius-10px p-10 xl-p-12 box-shadow-extra-large">
                                        <div class="text-center">
                                            <i class="ri-feedback-line" style="font-size: 48px; color: #ccc;"></i>
                                            <h5 class="mt-2 text-white">No Feedback Yet</h5>
                                            <p style="color: white">Be the first one to share your feedback!</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- start slider pagination -->
                            <div class="swiper-pagination slider-four-slide-pagination-2 swiper-pagination-style-2 swiper-pagination-clickable swiper-pagination-bullets"></div>
                            <!-- end slider pagination --> 
                        </div> 
                    </div>  
                </div>
                <div class="row">
                    <div class="col-12 text-center" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                        <div class="d-inline-block align-middle bg-base-color fw-700 text-dark-gray text-uppercase border-radius-30px ps-20px pe-20px fs-12 me-10px lh-30 sm-m-5px">Trust</div>
                        <div class="fs-22 d-inline-block align-middle">A unique <div class="highlight-separator z-index-1 fw-600 pb-5px text-white" data-shadow-animation="true" data-animation-delay="500">trading platform <span class="z-index-1"><img src="images/demo-cryptocurrency-highlight-separator-very-small.svg" alt="" class="h-25px" data-no-retina=""></span>
                            </div> where there is no place for loss</div>
                    </div>
                </div>
            </div>
        </section>


        <!-- end section -->
        <!-- start section -->
        <section id="application" class="cover-background overflow-visible md-pb-30px" style="background-image:url('images/demo-cryptocurrency-bg-06.jpg');">
            <div class="position-absolute left-minus-35px top-minus-100px d-none d-xl-inline-block" data-parallax-liquid="true" data-parallax-transition="2" data-parallax-position="top">
                <img src="images/demo-cryptocurrency-elements-04.png" alt="" data-bottom-top="transform: rotate(-30deg)" data-top-bottom="transform:rotate(10deg)">            </div>
            <div class="position-absolute mt-5 right-120px xl-right-30px d-none d-xl-inline-block" data-parallax-liquid="true" data-parallax-transition="2" data-parallax-position="bottom">
                <img src="images/demo-cryptocurrency-elements-05.png" alt="" data-bottom-top="transform: rotate(-60deg)" data-top-bottom="transform:rotate(60deg)">            </div>
            <div class="position-absolute bottom-minus-10px right-150px me-30 d-none d-xl-inline-block" data-parallax-liquid="true" data-parallax-transition="2" data-parallax-position="bottom">
                <img src="images/demo-cryptocurrency-elements-06.png" alt="" data-bottom-top="transform: rotate(-30deg)" data-top-bottom="transform:rotate(60deg)">            </div>
            <div class="container">
                <div class="row align-items-center justify-content-center text-lg-start text-center">
                    <div class="col-xl-5 col-lg-6 col-md-12 last-paragraph-no-margin mb-5 lg-mb-30px" data-anime='{ "el": "childs", "opacity": [0, 1], "rotateY": [-90, 0], "rotateZ": [-10, 0], "translateY": [80, 0], "translateZ": [50, 0], "staggervalue": 200, "duration": 900, "delay": 300, "easing": "easeOutCirc" }'>
                        <span class="text-white fw-600 mb-15px text-uppercase d-inline-block fs-14 ls-1px border-bottom border-color-transparent-white-very-light">Kenzo Trade application</span>
                        <h3 class="fw-600 ls-minus-2px text-white w-90 xl-w-100 mb-15px">Get ready to explore the <span class="highlight-separator z-index-1 fw-600 pb-10px text-white" data-shadow-animation="true" data-animation-delay="500">crypto journey.<span><img src="images/demo-cryptocurrency-highlight-separator-02.svg" alt="" class="h-25px" data-no-retina=""></span></span></h3>
                        <p class="w-95 sm-w-100">Download & install Kenzo Trade now to learn the safest, easiest and smartest way to invest your crypto currencies.</p>
                        <div class="mt-30px">
                            <a href="#" target="_blank" class="me-25px">
                                <img src="images/demo-cryptocurrency-google-play-icon.svg" alt="">                            </a>
                            <a href="#" target="_blank">
                                <img src="images/demo-cryptocurrency-app-store.svg" alt="">                            </a>                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-12 md-ps-10" data-anime='{ "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'> 
                        <img src="images/demo-cryptocurrency-img-04.png" data-bottom-top="transform: translateY(-50px)" data-top-bottom="transform: translateY(50px)" alt="">                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="pt-30px pb-30px bg-light-gray position-relative z-index-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col swiper" data-slider-options='{ "slidesPerView": "auto", "spaceBetween":0, "centeredSlides": true, "speed": 12000, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": false, "autoplay": { "delay":1, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                        <div class="swiper-wrapper swiper-width-auto marquee-slide">
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="d-flex align-items-center ps-70px">
                                    <img src="images/demo-cryptocurrency-icon-01.svg" alt="" class="w-35px h-35px me-10px">
                                    <span class="d-inline-block fs-20 text-white fw-600 me-10px">Bitcoin (BTC)</span>
                                    <p class="mb-0 me-10px text-white">$25,578.03</p>
                                    <span class="d-inline-block text-green"><i class="bi bi-arrow-up text-green"></i>0.13%</span>                                </div>
                            </div>
                            <!-- end client item --> 
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="d-flex align-items-center ps-70px">
                                    <img src="images/demo-cryptocurrency-icon-02.svg" alt="" class="w-35px h-35px me-10px">
                                    <span class="d-inline-block fs-20 text-white fw-600 me-10px">Ethereum (ETH)</span>
                                    <p class="mb-0 me-10px text-white">$1,670.23</p>
                                    <span class="d-inline-block text-green"><i class="bi bi-arrow-up text-green"></i>9.35%</span>                                </div>
                            </div>
                            <!-- end client item -->
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="d-flex align-items-center ps-70px">
                                    <img src="images/demo-cryptocurrency-icon-03.svg" alt="" class="w-35px h-35px me-10px">
                                    <span class="d-inline-block fs-20 text-white fw-600 me-10px">Tether (USDT)</span>
                                    <p class="mb-0 me-10px text-white">$0.9992</p>
                                    <span class="d-inline-block text-green"><i class="bi bi-arrow-up text-green"></i>0.31%</span>                                </div>
                            </div>
                            <!-- end client item -->
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="d-flex align-items-center ps-70px">
                                    <img src="images/demo-cryptocurrency-icon-05.svg" alt="" class="w-35px h-35px me-10px">
                                    <span class="d-inline-block fs-20 text-white fw-600 me-10px">USD Coin (USDC)</span>
                                    <p class="mb-0 me-10px text-white">$1.00</p>
                                    <span class="d-inline-block text-green"><i class="bi bi-arrow-up text-green"></i>0.01%</span>                                </div>
                            </div>
                            <!-- end client item --> 
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="d-flex align-items-center ps-70px">
                                    <img src="images/demo-cryptocurrency-icon-07.svg" alt="" class="w-35px h-35px me-10px">
                                    <span class="d-inline-block fs-20 text-white fw-600 me-10px">Cardano (ADA)</span>
                                    <p class="mb-0 me-10px text-white">$0.262</p>
                                    <span class="d-inline-block text-green"><i class="bi bi-arrow-up text-green"></i>16.79%</span>                                </div>
                            </div>
                            <!-- end client item -->
                            <!-- start client item -->
                            <div class="swiper-slide">
                                <div class="d-flex align-items-center ps-70px">
                                    <img src="images/demo-cryptocurrency-icon-08.svg" alt="" class="w-35px h-35px me-10px">
                                    <span class="d-inline-block fs-20 text-white fw-600 me-10px">Monero (XMR)</span>
                                    <p class="mb-0 me-10px text-white">$144.53</p>
                                    <span class="d-inline-block text-green"><i class="bi bi-arrow-up text-green"></i>3.38%</span>                                </div>
                            </div>
                            <!-- end client item --> 
                        </div> 
                    </div>  
                </div> 
            </div>
        </section>
        <!-- end section -->
        <!-- start footer -->
		<?php include("includes/footer.inc.php") ?>
        
       
		<?php include("includes/extra_footer.inc.php") ?>
       
</body>
</html>