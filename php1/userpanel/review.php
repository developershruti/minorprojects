<?
require_once('../includes/surya.dream.php');
protect_user_page();

// Check if user has existing feedback
$sql = "SELECT * FROM ngo_feedback WHERE feedback_name = '$_SESSION[sess_fname]'";
$result = db_query($sql);
$existing_feedback = mysqli_fetch_array($result);

if (is_post_back()) {
    // Get form values
    $feedback_title = ms_form_value($_POST['feedback_title']);      
    $feedback_desc = ms_form_value($_POST['feedback_desc']);
    $feedback_rating = ms_form_value($_POST['rating']);

    if ($existing_feedback) {
        // Update existing feedback
        $sql = "update ngo_feedback set 
            feedback_rating = '$feedback_rating', 
            feedback_title = '" . addslashes($feedback_title) . "', 
            feedback_desc = '" . addslashes($feedback_desc) . "',
            status = 'active'
            where feedback_name = '" . addslashes($_SESSION['sess_fname']) . "'";
        db_query($sql);
        $msg = "Feedback updated successfully.";
    } else {
        // Insert new feedback
        $sql = "insert into ngo_feedback set 
            feedback_name = '" . addslashes($_SESSION['sess_fname']) . "',
            feedback_rating = '$feedback_rating', 
            feedback_title = '" . addslashes($feedback_title) . "', 
            feedback_desc = '" . addslashes($feedback_desc) . "',
            status = 'active'";
        db_query($sql);
        $msg = "Feedback submitted successfully.";
    }

    $message = "
 
Feedback Title: " . $feedback_title . "

From: " . $_SESSION['u_fname'] . "  

Rating: " . $feedback_rating . "

Feedback Description: " . $feedback_desc . "  
 
The " . SITE_NAME . " team";

    $EMAIL_ADDRESS = ADMIN_EMAIL;
    //$EMAIL_ADDRESS = "surya.dream@gmail.com";
    $HEADERS  = "MIME-Version: 1.0 \n";
    $HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
    $HEADERS .= "From:  <" . ADMIN_EMAIL . ">\n";
    $SUBJECT  = "support ticket posted on " . SITE_NAME;
    @mail($EMAIL_ADDRESS, $SUBJECT, $message, $HEADERS);

    $message = "
 

Dear " . $u_username . ",

Thanks for informing us your problem. The support staffs will attend the complain soon.

Please send your feed back always for the continuous monitoring and updation of the process.


Regards

" . SITE_NAME . "  team 

  ";
    $EMAILL_REC = $_SESSION['sess_uemail'];
    if ($EMAILL_REC != '') {
        $HEADERS  = "MIME-Version: 1.0 \n";
        $HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
        $HEADERS .= "From:  <" . ADMIN_EMAIL . ">\n";
        $SUBJECT  = "Thanks for submit a support ticket";
        @mail($EMAILL_REC, $SUBJECT, $message, $HEADERS);
    }

    header("Location: review_list.php?msg=" . urlencode($msg));
    exit;
}

// Pre-fill form if user has existing feedback
if ($existing_feedback) {
    $feedback_title = $existing_feedback['feedback_title'];
    $feedback_desc = $existing_feedback['feedback_desc'];
    $feedback_rating = $existing_feedback['feedback_rating'];
}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">

<head>
    <? include("includes/extra_head.php") ?>

    <style>
        .rating-stars {
            font-size: 18px;
        }

        .rating-stars i {
            margin-right: 2px;
        }

        .card {
            transition: transform 0.2s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card-title {
            color: #fff;
            font-weight: 500;
        }

        .text-muted {
            color: #adb5bd !important;
        }

        .card-text {
            color: #e9ecef;
            line-height: 1.6;
        }

        /* Dark mode specific styles */
        .dark-mode .card {
            background: rgba(255, 255, 255, 0.05);
        }

        .dark-mode .text-muted {
            color: #868e96 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .rating-stars {
                font-size: 16px;
            }
            
            .card-body {
                padding: 1rem;
            }
        }

        .feedback-cards {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .grid-structure {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
        }
        
        .lh-25 {
            line-height: 25px;
        }
        
        .display-flex {
            display: flex;
            align-items: center;
        }
    </style>

</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <? include("includes/header.inc.php") ?>
        <!-- ========== App Menu ========== -->
        <? include("includes/sidebar.php") ?>
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
                                <h4 class="mb-sm-0">Feedback </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Support Ticket </a></li>
                                        <li class="breadcrumb-item active">Feedback </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <? include("error_msg.inc.php"); ?>
                        <div class="col-xxl-6 centered">

                            <div class="card newbordercolor">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        <?= $existing_feedback ? 'Update Your Feedback' : 'Share your Feedback' ?>
                                    </h4>

                                </div>
                                <!-- end card header -->
                                <div class="card-body">
                                    <div class="live-preview">
                                        <p align="center" style="color:#FF0000"> 
                                            <? include("error_msg.inc.php"); ?> 
                                            <?= $msgs ?> 
                                        </p>

                                        <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form() ?> class="forms-sample">
                                            <div class="mb-3">
                                                <label class="form-label">Rating :</label>
                                                <select name="rating" id="rating" class="form-control" required>
                                                    <option value="">Select</option>
                                                    <?php for($i = 1; $i <= 5; $i++) { ?>
                                                        <option value="<?= $i ?>" <?= $feedback_rating == $i ? 'selected' : '' ?>><?= $i ?> rating</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Title :</label>
                                                <input name="feedback_title" type="text" id="feedback_title" value="<?= $feedback_title ?>" alt="blank" emsg="Please enter Title" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Type Your Feedback Here :</label>
                                                <textarea name="feedback_desc" cols="30" rows="4" class="form-control" id="feedback_desc" alt="blank" emsg="Please enter feedback description" required><?= $feedback_desc ?></textarea>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <?= $existing_feedback ? 'Update Feedback' : 'Submit Feedback' ?>
                                                </button>
                                                <a href="review_list.php" class="btn btn-primary ms-2">View All Feedback</a>
                                            </div>
                                        </form>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <? include("includes/footer.php") ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <? include("includes/extra_footer.php") ?>
    <script>
        $(document).ready(function() {
            // Handle page size change
            $('select[name="pagesize"]').change(function() {
                $(this).closest('form').submit();
            });
            
            // Add animation when cards appear
            $('.card').each(function(index) {
                $(this).delay(100 * index).animate({
                    opacity: 1,
                    top: 0
                }, 500);
            });
            
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>