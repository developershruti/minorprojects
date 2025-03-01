<?php include("includes/surya.dream.php");
$pg = "login";
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

                    <div class="login-wrapper bg-white p-5 rounded-4 shadow" style="background: linear-gradient(to right, darkgreen, darkblue);">
                        <h3 class="text-center mb-4 text-white">Login</h3>
                        <? include("error_msg.inc.php"); ?>

                        <form name="form1" id="contactForm" class="account-form" method="post" action="login_func.php" enctype="multipart/form-data" <?= validate_form() ?>>
                            <div class="form-group mb-4">
                                <span class="form-label fw-medium mb-2 text-white">User ID</span>
                                <div class="input-group">
                                    <span class="input-group-text "><i class="fas fa-user"></i></span>
                                    <input name="username" type="text" id="email" class="form-control py-2 text-dark"
                                        tabindex="1" placeholder="Enter your User ID or Email" style="color:black; font-weight:bold"
                                        value="<?php if (isset($_COOKIE["username"])) {
                                                    echo encryptor('decrypt', $_COOKIE["username"]);
                                                } ?>"
                                        alt="blank" emsg="Please enter your User ID">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <span class="form-label fw-medium mb-2 text-white">Password</span>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control py-2 password-input text-dark"
                                        tabindex="2" placeholder="Enter your password" style="color:black; font-weight:bold"
                                        value="<?php if (isset($_COOKIE["password"])) {
                                                    echo encryptor('decrypt', $_COOKIE["password"]);
                                                } ?>"
                                        id="password" name="password" alt="blank" emsg="Please enter password">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input " style="max-width:25px!important;max-height:25px!important;" tabindex="4" value="1"
                                        <?php if (isset($_COOKIE["remember"])) {
                                            $check_value = encryptor('decrypt', $_COOKIE["remember"]);
                                            if ($check_value == 1) { ?> checked="checked" <? }
                                                                                } ?> name="remember" id="auth-remember-check">
                                    <span class="form-check-label text-white" for="auth-remember-check ">Remember Me</span>
                                </div>
                                <a href="forgot_password.php" class="text-primary text-decoration-none text-white">Forgot Password?</a>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 py-2 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Login Now
                            </button>

                            <p class="text-center mb-0 text-white">
                                Don't have an account? <a href="signup.php" class="text-primary">Sign Up</a>
                            </p>
                        </form>
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
</body>

</html>