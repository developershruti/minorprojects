<div class="app-menu navbar-menu  border-end">
  <div class="navbar-menu2">
    <!-- LOGO -->
    <div class="navbar-brand-box">
      <!-- Dark Logo-->
      <a href="index" class="logo logo-dark"> <span class="logo-sm"> <img src="../images/logo-light.png" alt="" height=" 30"> </span> <span class="logo-lg"> <img src="../images/logo-light.png" alt="" height="30"> </span> </a>
      <!-- Light Logo-->
      <a href="index" class="logo logo-light"> <span class="logo-sm"> <img src="../images/logo-light.png" alt="" height=" 30"> </span> <span class="logo-lg"> <img src="../images/logo-light.png" alt="" height="30"> </span> </a>
      <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover"> <i class="ri-record-circle-line"></i> </button>
    </div>
    <div id="scrollbar" class="bg-menu-img">
      <div class="container-fluid">
        <div id="two-column-menu"> </div>
        <ul class="navbar-nav" id="navbar-nav">
          <li class="menu-title">
            <h6 style="text-align:left;"><span class="text-gradient" data-key="t-menu"> Main Menu </span></h6>
          </li>
          <li class="nav-item"> <a class="nav-link menu-link " href="myaccount"> <i class="ri-dashboard-3-line"></i> <span data-key="t-widgets">Kenzoboard</span> </a> </li>
          <?php /*?><li class="nav-item"> <a class="nav-link menu-link" href="games.php"> <i class="ri-gamepad-line"></i> <span data-key="t-widgets">Play Free Games</span> </a> </li><?php */?>
          <!--<li class="nav-item"> <a class="nav-link menu-link" href="#social_promo" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts"> <i class="ri-bank-fill"></i> <span data-key="t-layouts">Social Bounty</span> </a>
          <div class="collapse menu-dropdown" id="social_promo">
            <ul class="nav nav-sm flex-column">
              <li class="nav-item"> <a href="bounty_request"  class="nav-link" data-key="t-horizontal">Bounty Request</a> </li>
              <li class="nav-item"> <a href="bounty_details"  class="nav-link" data-key="t-detached">Bounty Request Details</a> </li>
            </ul>
          </div>
        </li>-->
          <!-- end Dashboard Menu -->
          <li class="nav-item"> <a class="nav-link menu-link " href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps"> <i class="ri-team-line"></i> <span data-key="t-apps">Kenzo Network</span> </a>
            <div class="collapse menu-dropdown" id="sidebarApps">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"><a href="direct_list" class="nav-link " data-key="t-calendar">Referral Team</a></li>
                <?php /*?><!--<li class="nav-item"> <a href="direct_level_tree" class="nav-link" data-key="t-calendar">Referral Tree</a></li>--><?php */ ?>
                <li class="nav-item"><a href="direct_downline_list" class="nav-link " data-key="t-chat"> Level Team </a></li>
              </ul>
            </div>
          </li>
          <!--  <li class="nav-item"> <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts"> <i class="ri-bank-fill"></i> <span data-key="t-layouts">Deposit</span> </a>
          <div class="collapse menu-dropdown" id="sidebarLayouts">
            <ul class="nav nav-sm flex-column">
              <li class="nav-item"> <a href="deposit_process"  class="nav-link" data-key="t-horizontal">Deposit Request</a> </li>
              <li class="nav-item"> <a href="deposit_process_history"  class="nav-link" data-key="t-detached">Deposit Request List</a> </li>
            </ul>
          </div>
        </li>-->
          <?php /*?><li class="nav-item"> <a class="nav-link menu-link" href="#walletLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="walletLayouts"> <i class="ri-wallet-line"></i> <span data-key="t-layouts">My Staking</span> </a>
          <div class="collapse menu-dropdown" id="walletLayouts">
            <ul class="nav nav-sm flex-column">
			<li class="nav-item"> <a href="my_ewallet_staking"  class="nav-link" data-key="t-horizontal">Staking</a> </li>
			 <li class="nav-item"> <a href="my_ewallet_staking_history"  class="nav-link" data-key="t-detached">Staking History</a> </li>
               <!-- <li class="nav-item"> <a href="my_ewallet_investment"  class="nav-link" data-key="t-horizontal">NFTs Purchase</a> </li>
              <li class="nav-item"> <a href="my_ewallet_investment_history"  class="nav-link" data-key="t-detached">NFTs History</a> </li>
            <li class="nav-item"> <a href="my_ewallet_fund_transfer?pay_group=CW"  class="nav-link" data-key="t-detached">Wallet Transfer</a> </li> 
              <li class="nav-item"> <a href="my_ewallet_statement?pay_group=CW"  class="nav-link" data-key="t-detached">Wallet Statement</a> </li>-->
            </ul>
          </div>
        </li><?php */ ?>
          <?php /* */ ?>
          <!--package section temp comment-->
          <?php /*?><li class="nav-item"> <a class="nav-link menu-link" href="#rw_walletLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="walletLayouts"> <i class="ri-wallet-line"></i> <span data-key="t-layouts">Promotional Bonus</span> </a>
            <div class="collapse menu-dropdown" id="rw_walletLayouts">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="bounty_request" class="nav-link" data-key="t-horizontal">Bounty Request</a> </li>
                <li class="nav-item"> <a href="bounty_details" class="nav-link" data-key="t-detached">Bounty Request Details</a> </li>
                <li class="nav-item"> <a href="promotional_bonus_statement?pay_plan=BOUNTY_BONUS&pay_group=RW" class="nav-link" data-key="t-detached"> Self Bounty Bonus</a> </li>
                <li class="nav-item"> <a href="promotional_bonus_statement?pay_plan=TEAM_BOUNTY_BONUS&pay_group=RW" class="nav-link" data-key="t-detached2">Referral Bounty Bonus</a> </li>
                <li class="nav-item"> <a href="promotional_bonus_statement?pay_plan=SIGNUP_BONUS&pay_group=RW" class="nav-link" data-key="t-detached"> Sign Up Bonus</a> </li>
                <li class="nav-item"> <a href="promotional_bonus_statement?pay_plan=SIGNUP_REFERRAL_BONUS&pay_group=RW" class="nav-link" data-key="t-detached2">Sign Up Referral Bonus</a> </li>
                <li class="nav-item"> <a href="promotional_bonus_statement?pay_group=RW" class="nav-link" data-key="t-detached2">Sign Up Bonus Statement</a> </li>
              </ul>
            </div>
          </li><?php */?>
          <li class="nav-item"> <a class="nav-link menu-link" href="#walletLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="walletLayouts"> <i class="ri-wallet-fill"></i> <span data-key="t-layouts">Kenzo Wallet</span> </a>
            <div class="collapse menu-dropdown" id="walletLayouts">
              <ul class="nav nav-sm flex-column">
                <!--<li class="nav-item"> <a href="my_ewallet_purchase_package"  class="nav-link" data-key="t-horizontal">Purchase Package</a> </li>
			 <li class="nav-item"> <a href="my_ewallet_purchase_history"  class="nav-link" data-key="t-detached">Purchased History</a> </li>-->
                <?php /*?><li><a class="nav-link" id="connect" onclick="onClickConnect()" style="cursor:pointer;">Connect Wallet</a> </li>
			   <li class="nav-item"> <a href="deposit_token"  class="nav-link" data-key="t-horizontal"> Deposit COIN</a> </li><?php */ ?>
                <li class="nav-item"> <a href="deposit_process_bep20" class="nav-link" data-key="t-horizontal2">USDT Deposit</a> </li>
                <li class="nav-item"> <a href="my_ewallet_fund_transfer?pay_group=CW" class="nav-link" data-key="t-detached">Transfer Fund Wallet</a> </li>
                <li class="nav-item"> <a href="my_ewallet_statement?pay_group=CW" class="nav-link" data-key="t-detached2">Fund Wallet Statement</a> </li>
                <?php /*?><li class="nav-item"> <a href="my_ewallet_statement?pay_group=RW"  class="nav-link" data-key="t-detached2">Refer Wallet Statement</a> </li><?php */ ?>
              </ul>
            </div>
          </li>
          <li class="nav-item"> <a class="nav-link menu-link" href="#aiPackages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="walletLayouts"> <i class="ri-shopping-cart-line"></i> <span data-key="t-layouts">Trade Packages</span> </a>
            <div class="collapse menu-dropdown" id="aiPackages">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="my_ewallet_investment" class="nav-link" data-key="t-horizontal">Package Purchase</a> </li>
                <li class="nav-item"> <a href="my_ewallet_purchase_history" class="nav-link" data-key="t-detached">Packages Details</a> </li>
              </ul>
            </div>
          </li>
          <?php /*?><li class="nav-item"> <a class="nav-link menu-link" href="#bidLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="bidLayouts"> <i class="ri-play-circle-line"></i> <span data-key="t-layouts">Game Play Station</span> </a>
          <div class="collapse menu-dropdown" id="bidLayouts">
            <ul class="nav nav-sm flex-column">
              <li class="nav-item"> <a href="bid_options.php" class="nav-link" data-key="t-horizontal">Play Game</a> </li>
 			  <li class="nav-item"> <a href="bid_statement.php" class="nav-link" data-key="t-horizontal">Played History</a> </li>
 			  <li class="nav-item"> <a href="games.php" class="nav-link" data-key="t-horizontal">Free Games</a> </li>
             </ul>
          </div>
        </li><?php */ ?>
          <li class="nav-item"> <a class="nav-link menu-link" href="#earningsLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="earningsLayouts"> <i class="ri-money-dollar-circle-line"></i> <span data-key="t-layouts">Earnings</span> </a>
            <div class="collapse menu-dropdown" id="earningsLayouts">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="my_payout_details?pay_plan=DAILY_RETURN" class="nav-link" data-key="t-horizontal">Daily Profit</a> </li>
                <li class="nav-item"> <a href="my_payout_details?pay_plan=DIRECT_INCOME" class="nav-link" data-key="t-horizontal">Referral Bonus</a> </li>
                <li class="nav-item"> <a href="my_payout_details?pay_plan=LEVEL_INCOME" class="nav-link" data-key="t-horizontal">Level Bonus</a> </li> 
                <!--<li class="nav-item"> <a href="my_payout_details?pay_plan=REWARDS" class="nav-link" data-key="t-horizontal">Reward Bonus</a> </li>-->
              </ul>
            </div>
          </li>
          <li class="nav-item"> <a class="nav-link menu-link" href="#withdrawLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="withdrawLayouts"> <i class="ri-currency-line"></i> <span data-key="t-layouts">Withdraw</span> </a>
            <div class="collapse menu-dropdown" id="withdrawLayouts">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="my_ebank_fund_withdraw" class="nav-link" data-key="t-horizontal">Withdraw Request</a> </li>
                <li class="nav-item"> <a href="my_payout_details?pay_plan=FUND_WITHDRAW" class="nav-link" data-key="t-detached">Withdrawal Details</a> </li>
                <!--  <li class="nav-item"> <a href="my_fund_transfer_ewallet"  class="nav-link" data-key="t-detached">Transfer in My Wallet</a> </li>
              <li class="nav-item"> <a href="my_payout_details?pay_plan=FUND_TRANSFER"  class="nav-link" data-key="t-detached">Transfer History</a> </li>-->
              </ul>
            </div>
          </li>
          <!-- <li class="nav-item"> <a class="nav-link menu-link" href="my_reward"> <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Rewards</span> </a> </li>-->
          <li class="nav-item"> <a class="nav-link menu-link" href="#supportLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="supportLayouts"> <i class="ri-message-3-line"></i> <span data-key="t-layouts">Kenzo Support</span> </a>
            <div class="collapse menu-dropdown" id="supportLayouts">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="complain_add" class="nav-link" data-key="t-detached">Create Ticket</a> </li>
                <li class="nav-item"> <a href="complain" class="nav-link" data-key="t-detached">Ticket History</a> </li>
              </ul>
            </div>
          </li>


          <li class="nav-item"> <a class="nav-link menu-link" href="#profileLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="profileLayouts"> <i class="ri-settings-5-line"></i> <span data-key="t-layouts">Kenzo Account </span> </a>
            <div class="collapse menu-dropdown" id="profileLayouts">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="profile_edit" class="nav-link" data-key="t-detached">Edit Profile</a> </li>
                <li class="nav-item"> <a href="psw_edit" class="nav-link" data-key="t-detached">Edit Password</a> </li>
                <li class="nav-item"> <a href="security_code_edit" class="nav-link" data-key="t-detached">Edit Security Password</a> </li>
              </ul>
            </div>
          </li>



          <li class="nav-item"> <a class="nav-link menu-link" href="#reviewLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="profileLayouts"> <i class="ri-feedback-line"></i></i> <span data-key="t-layouts">Share Your Feedback </span> </a>
            <div class="collapse menu-dropdown" id="reviewLayouts">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="review.php" class="nav-link" data-key="t-detached">review Profile</a> </li>
                <li class="nav-item"> <a href="review_list.php" class="nav-link" data-key="t-detached">review List</a> </li>

              </ul>
            </div>
          </li>



		  <!-- <li class="nav-item"> <a class="nav-link menu-link" href="#"> <i class="ri-feedback-line"></i> <span data-key="t-widgets">Share Your Feedback</span> </a>
    
      <div class="collapse menu-dropdown" id="profileLayouts">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item"> <a href="review.php" class="nav-link" data-key="t-detached">review</a> </li>
            </ul>
            </div>
  
    </li> -->






          <li class="nav-item"> <a class="nav-link menu-link" href="logout"> <i class="ri-login-circle-line"></i> <span data-key="t-widgets">Sign Out</span> </a> </li>
        </ul>
      </div>
      <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
  </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
