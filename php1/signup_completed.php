<?php
include ("includes/surya.dream.php");  
$page='registration' ;
//protect_user_page();

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php include("includes/extra_head.inc.php") ?>
</head>

<body data-mobile-nav-style="classic" class="custom-cursor">
    <!-- preloader start -->

    <!-- preloader end -->
    <!-- ==========Header Section Starts Here========== -->
    <?php include("includes/header.inc.php") ?>
    <!-- ==========Header Section Ends Here========== -->
    <!-- ===========Banner Section start Here========== -->
    <section id="home" class="bg-light-gray cover-background" style="background-image: url('images/demo-cryptocurrency-hero-bg.jpg')">
        <div class="container position-relative">
            <div class="row pt-12 mb-14 xxl-pt-10 xl-pt-6 xxl-mb-10 sm-pt-70px xs-mb-35px">
                <div class="col-md-6 mx-auto">

                    <div class="login-wrapper bg-white p-5 rounded-4 shadow" style="background: linear-gradient(to right, green, darkblue);">
                        <h3 class="text-center mb-4 text-white">Registration Successful</h3>
                <?php include("error_msg.inc.php"); ?>
                
                <div class="registration-details">
                    <?php 
                    if ($u_id=='') {
                        if ($_SESSION['sess_recid']!='') {
                            $u_id=$_SESSION['sess_recid'];
                        } else {
                            $u_id = $_SESSION['sess_uid'];
                        } 
                    }
                    
                    $sql = "select * from ngo_users where u_id ='$u_id'";
                    $result = db_query($sql);
                    $line = mysqli_fetch_array($result);
                    @extract($line);
                    ?>

                    <div class="details-row">
                        <div class="detail-label text-white">Name</div>
                        <div class="detail-value text-white"><?=$u_fname." ".$u_lname?></div>
                    </div>
                    <div class="details-row">
                        <div class="detail-label text-white">User ID</div>
                        <div class="detail-value text-white"><?=$u_username?></div>
                    </div>
                    <div class="details-row">
                        <div class="detail-label text-white">Password</div>
                        <div class="detail-value text-white"><?=$u_password?></div>
                    </div>
                    <div class="details-row">
                        <div class="detail-label text-white">Security Key</div>
                        <div class="detail-value text-white"><?=$u_password2?></div>
                    </div>
                    <div class="details-row">
                        <div class="detail-label text-white">Sign Up Date</div>
                        <div class="detail-value text-white"><?=date_format2($u_date)?></div>
                    </div>
                    <div class="details-row">
                        <div class="detail-label text-white">Email</div>
                        <div class="detail-value text-white"><?=$u_email?></div>
                    </div>
                </div>

                <div class="account-bottom text-center">
                    <span class="d-block cate pt-10 text-white" >
                        Back To login <a href="login.php" class="text-primary">Click Here</a>
                    </span>
                </div>


                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ===========Banner Section Ends Here========== -->
    <!-- Login Section Section Starts Here -->


    <!-- <div class="login-section padding-top padding-bottom">
        <div class=" container">
            <div class="account-wrapper">
                <h3 class="title">Login</h3>

                <? include("error_msg.inc.php"); ?>
                <form name="form1" id="contactForm" class="account-form text-start" method="post" action="login_func.php" enctype="multipart/form-data" <?= validate_form() ?>>
                    <div class="form-group">
                        <span>User ID / Email :</span>
                        <input name="username" type="text" id="email" class="form-control" tabindex="1" placeholder="User ID / Email" value="<?php if (isset($_COOKIE["username"])) {
                                                                                                                                                    echo encryptor('decrypt', $_COOKIE["username"]);
                                                                                                                                                } ?>" alt="blank" emsg="Please enter your User ID / Email">
                    </div>
                    <div class="form-group">
                        <span>Password :</span>
                        <input type="password" class="form-control pe-5 password-input" tabindex="2" placeholder="Enter password" value="<?php if (isset($_COOKIE["password"])) {
                                                                                                                                                echo encryptor('decrypt', $_COOKIE["password"]);
                                                                                                                                            } ?>" id="password" name="password" alt="blank" emsg="Please enter password">
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between flex-wrap pt-sm-2">
                            <div class="checkgroup">
                                <input type="checkbox" tabindex="4" value="1" <?php if (isset($_COOKIE["remember"])) {
                                                                                    $check_value = encryptor('decrypt', $_COOKIE["remember"]);
                                                                                    if ($check_value == 1) { ?> checked="checked" <? }
                                                                                                        } ?> name="remember" id="auth-remember-check">
                                <span for="remember">Remember Me</span>
                            </div>
                            <a href="forgot-password">Forget Password?</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="d-block default-button"><span>Login Now</span></button>
                    </div>
                </form>
                <div class="account-bottom"> <span class="d-block cate pt-10">Don’t Have any Account? <a href="signup.php"> Sign Up</a></span>

                    <?php /*?> <span class="or"><span>or</span></span>
        <h5 class="subtitle">Login With Social Media</h5>
        <ul class="match-social-list d-flex flex-wrap align-items-center justify-content-center mt-4">
          <li><a href="#"><img src="assets/images/match/social-1.png" alt="vimeo"></a></li>
          <li><a href="#"><img src="assets/images/match/social-2.png" alt="youtube"></a></li>
          <li><a href="#"><img src="assets/images/match/social-3.png" alt="twitch"></a></li>
        </ul><?php */ ?>
                </div>
            </div>
        </div>
    </div> -->



    
    <!-- Login Section Section Ends Here -->
    <!-- ================ footer Section start Here =============== -->
    <?php include("includes/footer.inc.php") ?>
    <!-- ================ footer Section end Here =============== -->
    <?php include("includes/extra_footer.inc.php") ?>


    <style>
    .registration-details {
        background: linear-gradient(to right, rgb(66, 173, 52), rgb(59, 37, 182));
        padding: 30px;
        border-radius: 10px;
        margin: 20px 0;
    }
    .details-row {  
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    .details-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: 600;
        color: #666;
    }
    .detail-value {
        color: #333;
    }
    .account-wrapper {
        max-width: 600px;
        margin: 0 auto;
    }
    </style>


</body>

</html>