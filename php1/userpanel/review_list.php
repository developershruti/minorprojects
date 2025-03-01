<?php
require_once('../includes/surya.dream.php');

// if (is_post_back()) {
//     if (isset($_POST['arr_feedback_ids']) && is_array($_POST['arr_feedback_ids'])) {
//         $arr_feedback_ids = implode(',', $_POST['arr_feedback_ids']);
//         if (isset($_POST['Activate'])) {
//             $sql = "update ngo_feedback set status = 'active' where feedback_id in ($arr_feedback_ids)";
//             db_query($sql);
//             $msg = "Selected feedback(s) activated successfully.";
//         } else if (isset($_POST['Deactivate'])) {
//             $sql = "update ngo_feedback set status = 'inactive' where feedback_id in ($arr_feedback_ids)";
//             db_query($sql);
//             $msg = "Selected feedback(s) deactivated successfully.";
//         }
//         header("Location: review_list.php?msg=" . urlencode($msg));
//         exit;
//     } 
// }

protect_user_page();

$start = intval($start);
$pagesize = intval($pagesize) == 0 ? $pagesize = DEF_PAGE_SIZE : $pagesize;
$sql = "SELECT COUNT(*) as total FROM ngo_feedback";
$result = db_query($sql);
$row = mysqli_fetch_array($result);
$reccnt = $row['total'];

$sql = "SELECT * FROM ngo_feedback ORDER BY feedback_id DESC LIMIT $start, $pagesize";
$result = db_query($sql);
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">

<head>
    <? include("includes/extra_head.php") ?>
</head>

<body>
    <div id="layout-wrapper">
        <? include("includes/header.inc.php") ?>
        <? include("includes/sidebar.php") ?>
        
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Feedback List</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Feedback</a></li>
                                        <li class="breadcrumb-item active">List</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            Records Per Page: <?= pagesize_dropdown('pagesize', $pagesize); ?>
                                        </div>
                                        <a href="review.php" class="btn btn-primary">Add Feedback</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if($reccnt > 0) { ?>
                                        <div class="text-muted mb-3">
                                            Showing Records: <?= $start + 1 ?> to <?= ($reccnt < $start + $pagesize) ? $reccnt : ($start + $pagesize) ?> of <?= $reccnt ?>
                                        </div>
                                    <?php } ?>

                                    <div class="table-responsive">
                                        <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
                                            <table class="table table-bordered table-striped align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>SL No.</th>
                                                        <th>Title</th>
                                                        <th>Rating</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (mysqli_num_rows($result) > 0) {
                                                        $counter = $start + 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tr>
                                                            <td><?= $counter++ ?></td>
                                                            <td><?= htmlspecialchars($row['feedback_title']) ?></td>
                                                            <td>
                                                                <div class="text-warning">
                                                                    <?php
                                                                    for($i = 1; $i <= 5; $i++) {
                                                                        if($i <= $row['feedback_rating']) {
                                                                            echo '<i class="ri-star-fill"></i>';
                                                                        } else {
                                                                            echo '<i class="ri-star-line"></i>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                $desc = htmlspecialchars($row['feedback_desc']);
                                                                echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if($row['feedback_name'] == $_SESSION['sess_fname']) { ?>
                                                                    <a href="review.php" class="btn btn-sm btn-primary">
                                                                        <i class="ri-edit-2-line"></i> Edit
                                                                    </a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php 
                                                        }
                                                    } else { 
                                                    ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">
                                                                <div class="py-4">
                                                                    <i class="ri-feedback-line" style="font-size: 48px; color: #ccc;"></i>
                                                                    <h5 class="mt-2">No Feedback Yet</h5>
                                                                    <p class="text-muted">Be the first one to share your feedback!</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                         
                                        </form>
                                    </div>

                                    <?php if($reccnt > 0) { ?>
                                        <div class="d-flex justify-content-center mt-4">
                                            <?php include("paging.inc.php"); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <? include("includes/footer.php") ?>
        </div>
    </div>
    <? include("includes/extra_footer.php") ?>
    
    <script>
        $(document).ready(function() {
            // Handle page size change
            $('select[name="pagesize"]').change(function() {
                $(this).closest('form').submit();
            });
        });

        // function checkall(form) {
        //     var checkboxes = form.getElementsByTagName('input');
        //     for (var i = 0; i < checkboxes.length; i++) {
        //         if (checkboxes[i].type == 'checkbox') {
        //             checkboxes[i].checked = form.check_all.checked;
        //         }
        //     }
        // }

        // function validateForm() {
        //     var checkboxes = document.getElementsByName('arr_feedback_ids[]');
        //     var checked = false;
        //     for (var i = 0; i < checkboxes.length; i++) {
        //         if (checkboxes[i].checked) {
        //             checked = true;
        //             break;
        //         }
        //     }
            
        //     if (!checked) {
        //         alert('Please select at least one feedback.');
        //         return false;
        //     }
            
        //     return confirm('Are you sure you want to perform this action?');
        // }
    </script>
</body>
</html>