<?php include ("includes/surya.dream.php");  
if ($_GET[ref]!='') { $_SESSION[ref]= $_GET[ref]; } 
  $page='faq';
?> 
       
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
 <meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?=$META_TITLE?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	  <?php include("includes/extra_file.inc.php");?>
</head>
<body class="wide">
	<div class="layout">
		<!-- Main Header -->
		<header>
			<!-- Top Bar -->
			 
			 	 <?php include("includes/header.inc.php");?>
			<!-- Search -->
			<div class="search">
				<div class="container">
					<div class="row">
						<div class="span6">
							<!-- Breadcrumb -->
							<ul class="breadcrumb hidden-phone">
								<li class="active"><span class="divider"><a href="index.php" data-toggle="tooltip" title="Go to home"></a></span></li>
								<li><span>Home</span></li>
							</ul>
							<!-- End Breadcrumb -->
						</div>
						<div class="span6">
							<div class="pull-right">
								<!-- Search -->
								<form action="#" method="post" class="form-inline">
									<div class="input-append">
										<input name="searchword" maxlength="20" class="inputbox input-xlarge" type="text" size="20" value="" placeholder="What are you looking for?" />
										<button class="btn">  <span class="hidden-phone">Search</span></button>
									</div>
								</form>
								<!-- End Search -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Search -->
		</header>
		<!-- End Main Header -->
		<div class="main">
			<div class="container">
				<div class="row">
					<div class="span8">
						<!-- Content -->
						<div class="content">
							<!-- Faq -->
								<section class="faq">
									<div class="page-header">
										<h1>FAQ <small>Frequently Asked Questions</small></h1>
									</div>
									<div class="well well-small">
										<p>Frequently asked questions are listed questions and answers, all supposed to be commonly asked in some context, and pertaining to a particular topic. </p>
									</div>
									<hr>
									<div class="accordion" id="accordion2">
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
													 
 <strong style="color:#fd722f;">Q.</strong> HOW WILL MY DONATION BE USED?
												</a>
											</div>
											<div id="collapseOne" class="accordion-body collapse in">
												<div class="accordion-inner">
													<p><strong style="color:#fd722f;">Ans.</strong> The <?=SITE_NAME?> conducts a number of activities in support of the <?=SITE_NAME?>. Unless otherwise specified by you, the <?=SITE_NAME?>'s Board of Directors will choose which of these activities to support with your donation..</p>
													
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
													   <strong style="color:#fd722f;">Q.</strong>  How much of my donation is going directly to people in need?
												</a>
											</div>
											<div id="collapseTwo" class="accordion-body collapse">
												<div class="accordion-inner">
											<strong style="color:#fd722f;">Ans.</strong>	We ensure that 100 % of your donation will go towards our international eye care programs. We work very hard to keep our administrative costs extremely low. In fact .
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
													 <strong style="color:#fd722f;">Q.</strong>  I don't have much money. Can I still help?
												</a>
											</div>
											<div id="collapseThree" class="accordion-body collapse">
												<div class="accordion-inner">
												 <strong style="color:#fd722f;">Ans.</strong> Yes! Our Help plan is designed to fit every people who want to donate us. 
												</div>
											</div>
										</div>
										
										
										
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
													<strong style="color:#fd722f;">Q.</strong>  Can I dedicate my donation to someone??
												</a>
											</div>
											<div id="collapseFour" class="accordion-body collapse">
												<div class="accordion-inner">
												 <strong style="color:#fd722f;">Ans.</strong> Yes. You can make your donation a tribute to someone. You will receive a donation receipt as well as a certificate that you can give to your friend or loved one.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
													<strong style="color:#fd722f;">Q.</strong> What are the causes that <?=$META_TITLE?> works towards?
												</a>
											</div>
											<div id="collapseFive" class="accordion-body collapse">
												<div class="accordion-inner">
													<strong style="color:#fd722f;">Ans.</strong> We mainly address the causes of education & health of underprivileged children through Mission Education, healthcare of people living in urban slums and rural villages through our <?=SITE_NAME?>on Wheels programme, livelihood of the marginalized youth through our <?=SITE_NAME?> Twin e-Learning Programme and girl child & women empowerment through our programme. 
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
													<strong style="color:#fd722f;">Q.</strong> Why do you stress on education, when there are other equally pressing issues in the country?
												</a>
											</div>
											<div id="collapseSix" class="accordion-body collapse">
												<div class="accordion-inner">
													<strong style="color:#fd722f;">Ans.</strong> Education alone is the power that can redeem the poor from their poverty - not only in terms of earning a livelihood but also becoming aware of the rights and freedoms that a citizen is endowed with, thus empowering individuals and becoming self-dependant beyond doubt.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven">
													<strong style="color:#fd722f;">Q.</strong> How many projects do you have in the country? How many people do you reach through these projects?
												</a>
											</div>
											<div id="collapseSeven" class="accordion-body collapse">
												<div class="accordion-inner">
													<strong style="color:#fd722f;">Ans.</strong> There are over 200,000 direct beneficiaries of <?=SITE_NAME?> at present, and this is a modest count considering that our reach keeps growing by every passing day. <?=SITE_NAME?>  has 140 projects of various scales spread across all states in India.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEight">
													<strong style="color:#fd722f;">Q.</strong> Why do you work for these well children?
												</a>
											</div>
											<div id="collapseEight" class="accordion-body collapse">
												<div class="accordion-inner">
													<strong style="color:#fd722f;">Ans.</strong> <?=SITE_NAME?> believes that children are the change makers and it is crucial to "Catch them young" and inculcate in them the compassion and conscience to act responsibly. Our rationale of working for privileged children is driven by the idea that once these children realize the worth of the privileges that they are born with they are humbled and are automatically turned towards positivity. This eventually helps them develop into not only superior but successful personalities in life, who are also individual actors of change.
												</div>
											</div>
										</div>
										<div class="accordion-group">
											<div class="accordion-heading">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseNine">
													<strong style="color:#fd722f;">Q.</strong> How do I ensure that whatever I donate will be used correctly?
												</a>
											</div>
											<div id="collapseNine" class="accordion-body collapse">
												<div class="accordion-inner">
													<strong style="color:#fd722f;">Ans.</strong> The entire management process of  <?=SITE_NAME?> is evaluated by a 4 tier audit system - programme and project audit, internal and process audit, statutory audit and external audit, which ensure the correct utilization of funds. In addition, at <?=SITE_NAME?>, we do not accept any cash donations. In order to maintain transparency we encourage our supporters to make all donations only through cheques, demand drafts, credit cards or online payments.
												</div>
											</div>
										</div>
										 
										 
									</div>
								</section>
								<!-- End Faq -->
						</div>
						<!-- End Content -->
					</div>
						 <?php include("includes/right.inc.php");?>
				</div>
				<a href="#" class="scroll-top"><img src="images/icon_backtotop.png" /></a>
			</div>
		</div>
		<!-- Ticker -->
		 
		 
		<footer>
			<!-- Footer Block -->
			 	<? include("includes/footer.inc.php")?>
			<!-- End Copyright -->
		</footer>
		<!-- End Footer -->
	</div>
	<!-- Style Switcher -->
	 
	<!-- End Style Switcher -->
	<script type="text/javascript" src="js/vendor/jquery.cookie.min.js"></script>
	<!--[if lte IE 9]>
		<script type="text/javascript" src="js/vendor/jquery.placeholder.min.js"></script>
		<script type="text/javascript" src="js/vendor/jquery.menu.min.js"></script>
		<script type="text/javascript">
			/* <![CDATA[ */
			$(function() {
				$('#nav .menu').menu({'effect' : 'fade'});
			});
			/* ]]> */
		</script>
	<![endif]-->
	<script type="text/javascript" src="js/vendor/jquery.switcher.js"></script>
	<script type="text/javascript" src="js/plugins.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-40243398-1', 'atomtech.com.br');
		ga('send', 'pageview');
	</script>
</body>

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
</html>
