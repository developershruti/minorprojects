<?
$ARR_VALID_IMG_EXTS = array('jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp');

$ARR_WEEK_DAYS = array(
'mon' => 'Monday',
'tue' => 'Tuesday',
'wed' => 'Wednesday',
'thu' => 'Thursday',
'fri' => 'Friday',
'sat' => 'Saturday',
'sun' => 'Sunday'
);

$ARR_WEEK = array(
'Wk1' => 'Week I',
'Wk2' => 'Week II',
'Wk3' => 'Week III',
'Wk4' => 'Week IV',
'Wk5' => 'Week V'
);

$ARR_MONTHS = Array('01'=>'Jan' , '02'=>'Feb' , '03'=>'Mar' , '04'=>'Apr' , '05'=>'May' , '06'=>'Jun' , '07'=>'Jul' , '08'=>'Aug' , '09'=>'Sep' , '10'=>'Oct' , '11'=>'Nov' , '12'=>'Dec');

$ARR_POSSITION = array( ''=>'Please select','A' => 'Left', 'B' => 'Right');

 
$ARR_DEDUCTION_TYPE = array('TDS'=>'TDS','OtherDeduction'=>'OtherDeduction');
$ARR_GENDER = array('0'=>'Please select','Male'=>'Male','Female'=>'Female');
$ARR_PERMISSION = array('public'=>'Public','private'=>'Private');
$ARR_RATE = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10');
//
$ARR_PLAN_TYPE = array(''=>'Please Select','TOPUP'=>'TOPUP');
$ARR_BID_STATUS = array(''=>'Select','New'=>'New','Win'=>'Win','Loss'=>'Loss','Cancel'=>'Cancel','Hold'=>'Hold');
$ARR_GIFT_STATUS = array(''=>'Select','Waiting'=>'Waiting','Accept'=>'Accepted','Reject'=>'Rejected','New'=>'New');
$ARR_PAYMENT_PROCESSOR = array(''=>'Please Select','Bank'=>'Bank','LR'=>'LR' );

$ARR_USER_GROUP = array(''=>'Select','Trader'=>'Trader','Franchise'=>'Franchise','Investor'=>'Investor','FreeAcc'=>'Free Account');

$ARR_SOCIAL_REQUEST_TYPE = array(''=>'Select Post Type','1'=>'Facebook: $2.50', '2'=>'Instagram: $2.50', '3'=>'Twitter: $2.50', '4'=>'Reels: $5.00', '5'=>'YouTube Shorts: $5.00', '6'=>'TikTok: $2.50', '7'=>'YouTube Video: $5.00', '8'=>'Blog Post: $10.00', '9'=>'Web Article: $10.00', '10'=>'YouTube PDF Description: $10.00');  

$ARR_POOL_GROUP = array( '1'=>'Black Pearl','2'=>'Black Gold','3'=>'Benitotite','4'=>'Red Beryl','5'=>'Ruby','6'=>'Emerald','7'=>'Pink Diamond','8'=>'Jadeite', '9'=>'Black Diamond' );

$ARR_RANK = array(''=>'Please Select','35'=>'Storm Bringer','70'=>'Trend Setter','140'=>'Moral Hero','280'=>'Game Changer','560'=>'Hidden Gem','1120'=>'Peak Performers'); 
$ARR_COIN_GROUP = array(''=>'Please Select' ,'DCI'=>'Security Token','DCH'=>'Holding Token' );
 
//$ARR_WALLET_GROUP = array(''=>'Please Select' ,'DW'=>'Purchase Wallet','CW'=>'My Wallet' ); ///,'FW'=>'Flexi Wallet','SW'=>'Shopping Wallet' 

$ARR_WALLET_GROUP = array(''=>'Please Select' ,'CW'=>'Kenzo Wallet'); //,'RW'=>'Refer Wallet'


$ARR_RANK_REWARD_NAME = array('0'=>'N/A', '1'=>'Coral', '2'=>'Pearls', '3'=>'Diamond', '4'=>'Topaz', '5'=>'Sapphire', '6'=>'Emerald');


$ARR_WALLET_TYPE_ADM = array(''=>'Please Select','WELCOME'=>'Welcome Bonus','PAID_FUND'=>'Paid Fund','PROMO_FUND'=>'Promotional Fund','USDT_RECEIVE'=>'TRC20 USDT Fund'  ,'BIDING'=>'Bidding','FUND_RECEIVE'=>'User Fund Receive','FUND_TRANSFER'=>'User Fund Transfer');
//,'WELCOME'=>'Welcome Bonus','BIDING'=>'Trade Fees Deduction','TRADE_REWARD'=>'Trade Reward','WITHDRAW_REVERSE'=>'Withdrawal Reverse','WINING_PRIZE'=>'Winning Fund'
$ARR_WALLET_TYPE = array(''=>'Please Select','ADM_FUND'=>'Admin Fund','USDT_RECEIVE'=>'TRC20 USDT Fund'  ,'COIN_CONVERT'=>'Converted in Token','FUND_RECEIVE'=>'User Fund Receive','FUND_TRANSFER'=>'User Fund Transfer' ,'PROMO_FUND'=>'Promo Fund' ,'TOPUP_ACC'=>'Account Topup');
///$ARR_PAYMENT_TYPE = array(''=>'Please Select','GROWTH_INCOME'=>'Growth Income'  ,'SELL_PILOT_REVENUE'=>'Sell Pilot Revenue'  
 
$ARR_PAYMENT_GROUP = array(''=>'Please Select', 'DWP'=>'Daily Wining Profits', 'RWP'=>'Referral Working Profits');
#$ARR_PAYMENT_TYPE = array(''=>'Please Select','TRADE_REWARD'=>'Trade Reward','TRADE_LEVEL'=>'Rider Trade Reward','DAILY_REWARD'=>'Daily Reward','DAILY_LEVEL'=>'Rider Daily Reward','DIRECT_LEVEL'=>'Referral Reward','PLATINUM_REWARD'=>'Platinum Reward','MONTHLY_REWARD'=>'Monthly Reward' ,'BANK_WITHDRAW'=>'Fund Withdrawal','DEDUCTION'=>'Service Deduction','DEDUCTION_BIDING'=>'Biding Deduction');

$ARR_PAYMENT_TYPE = array(''=>'Please Select','DAILY_RETURN'=>'Daily Profit','DIRECT_INCOME'=>'Referral Bonus','LEVEL_INCOME'=>'Level Bonus','REWARDS'=>'Rewards' ,'FUND_WITHDRAW'=>'Fund Withdrawal','DEDUCTION'=>'Service Deduction');
 
 
$ARR_BID_COLUMN = array(''=>'Select','bid_0'=>'0','bid_1'=>'1','bid_2'=>'2','bid_3'=>'3','bid_4'=>'4','bid_5'=>'5','bid_6'=>'6','bid_7'=>'7','bid_8'=>'8','bid_9'=>'9' );
$ARR_BID_GROUP = array(''=>'Select','plan0'=>'No 0','plan1'=>'No 1','plan2'=>'No 2','plan3'=>'No 3','plan4'=>'No 4','plan5'=>'No 5','plan6'=>'No 6','plan7'=>'No 7','plan8'=>'No 8','plan9'=>'No 9' ,'plansilver_num'=>'Silver','planred_num'=>'Brass','planblack_num'=>'Gold');

$ARR_BID_IMG = array(''=>'Select','plan0'=>'0.png','plan1'=>'1.png','plan2'=>'2.png','plan3'=>'3.png','plan4'=>'4.png','plan5'=>'5.png','plan6'=>'6.png','plan7'=>'7.png','plan8'=>'8.png','plan9'=>'9.png' ,'plansilver_num'=>'silver_num.png','planred_num'=>'red_num.png','planblack_num'=>'black_num.png');
$ARR_PREDICTION_COLOR = array(''=>'Please Select','Brass'=>'Brass','Gold'=>'Gold');


$ARR_POOL_GROUP = array(  ''=>'Please Select');
///, 'AUTOPOOL_INCOME'=>'Autopool Income' this income work seperatly from admin 

$ARR_AUTO_POOL_INCOME_GROUP =  array( ''=>'Please Select' );
//,'POOL_7'=>'Diamond Auto Pool' ,'POOL_8'=>'Crown Auto Pool' 
$ARR_DIRECT_CLUB_INCOME_GROUP =  array(''=>'Please Select'  );

$ARR_CLUB_GROUP = array(''=>'Please Select' );


$ARR_POOL_LEVEL = array(''=>'Please Select','1'=>'Level 1','2'=>'Level 2','3'=>'Level 3','4'=>'Level 4','5'=>'Level 5','6'=>'Level 6'); //,'7'=>'Level 7','8'=>'Level 8','9'=>'Level 9','10'=>'Level 10'
$ARR_POOL_LEVEL_NAME = array('1'=>'1st Pool','2'=>'2nd Pool','3'=>'3rd Pool','4'=>'4th Pool','5'=>'5th Pool','6'=>'6th Pool'); //,'7'=>'7th Pool','8'=>'8th Pool'
 
$ARR_CODE_STATE = array(''=>'Please Select','UP'=>'UP','Punjab'=>'Punjab','Hariyana'=>'Hariyana','Rajsthan'=>'Rajsthan','Maharashtra'=>'Maharashtra');
$ARR_CLUB_LEVEL = array(''=>'Please Select','1'=>'Level 1','2'=>'Level 2','3'=>'Level 3','4'=>'Level 4','5'=>'Level 5','6'=>'Level 6'); //,'7'=>'Level 7','8'=>'Level 8'

$ARR_PLAN_TOPUP_RATE = array('20'=>'Incentive:20% Period: 10 Month','3'=>'Incentive:3% Period: 100 Days');
$ARR_PLAN_RECHARGE_RATE = array('15'=>'Double in 15 Days','30'=>'Double in  30 Days');

$ARR_ADMIN_LINK_PERMISSION= array('1'=>'Manage User' ,'4'=>'Manage Topup','5'=>'Manage user payment','6'=>'Manage News' ,'8'=>'Manage Static Pages','9'=>'Manage admin','10'=>'Send SMS on User','11'=>'Sent SMS to Other','12'=>'Contact Us List' );
  
 $ARR_ADMIN_PAGES=array('1'=>'users_list.php' ,'4'=>'recharge_topup_list.php','5'=>'users_acc_drcr_list.php','6'=>'news_list.php' ,'8'=>'staticpage_list.php','9'=>'admin_list.php','10'=>'send_sms.php','11'=>'send_sms_other.php','12'=>'complain_list.php');

 
$ARR_BEP20_ADDRESS = array(''=>'Please Select','1'=>'0x5103698Af694bb9A72029241EAc2faaaaaaaaaaa','2'=>'0x909e085086b8aB9138c0EdE0703c805bbbbbbbbb','3'=>'0x0E56450263fb620A6aD8591f082556C6cccccccccc','4'=>'0xE56414897b45bbAd19909a0808B6f8E6dddddddddd','5'=>'0xFeEc800Da0A3f9bFd493f771d9dC33eeeeeeeee','6'=>'0xfdcd1AAae16791d12181eF4E3bF2af9fffffffffff');

$ARR_BEP20_KEY = array(''=>'Please Select','1'=>'721e4d4080ccbc867404c81bdf9477f91960a6d22f28626b6f6e41e111111111111','2'=>'0xc620c3f5ca226f72dc8a2b34a88f3cb78d4b73ac7ba6ee06b760d47df111111111111','3'=>'d147be86499f066326372f0a3fcddef3ae83e19e1ca760b76225111111111111','4'=>'0x4323a47b9eb4a0c65f5ce954a490b878b5bed7ca0490499230e8ef111111111111','5'=>'184a130eb9498b676ffe777d04263284c851dcb7e01a0847825086111111111111','6'=>'7b7a2a597dbc5e9705fcb4ab759916fdbe78ee716abd47df79b14563c111111111111');

/*

, '4'=>'Manage Cheque'
,'4'=>'cheque_list.php'

 $ARR_ADMIN_LINK_PERMISSION=	array('0'=>'Manage User','1'=>'Manage Closing' , '2'=>'Manage Payout','3'=>'Manage Setting','4'=>'Send SMS','5'=>'Send SMS Other Number', '6'=>'Manage Bill', '7'=>'Manage Ledger', '8'=>'Manage Cheque', '9'=>'Manage Pin','10'=>'Manage Static Pages','11'=>'Manage admin','12'=>'Manage User','13'=>'Manage Product Distribution','14'=>'Manage Pin Request' ,'15'=>'Feedback', '15'=>'Manage Payout Deduction ', '16'=>'Manage 21 Days Offer ');
 
 $ARR_ADMIN_PAGES=array('0'=>'users_list.php','1'=>'closing_list.php' , '2'=>'payout_cheque_list.php','3'=>'setting_list.php','4'=>'send_sms.php','5'=>'send_sms_other.php', '6'=>'bill_list.php', '7'=>'ledger_list.php', '8'=>'cheque_list.php','9'=>'code_list.php','10'=>'staticpage_list.php','11'=>'admin_list.php' ,'12'=>'users_list.php','13'=>'product_dist_list.php','14'=>'code_req_list.php','15'=>'feedback_list.php', '15'=>'deduction_list.php','16'=>'generate_payout_all.php');
*/
 
$META_TITLE=SITE_NAME;
$META_KEYWORD='';
$META_DESC='';

?>