<?
require_once('../includes/surya.dream.php');
// protect_page();

if (is_post_back()) {
    // Get form values
    $feedback_title = ms_form_value($_POST['feedback_title']);
    $feedback_desc = ms_form_value($_POST['feedback_desc']);
    $feedback_rating = ms_form_value($_POST['rating']);
    $status = ms_form_value($_POST['status']);
    $feedback_name = ms_form_value($_POST['feedback_name']);

    if ($feedback_id != '') {
        // Update existing feedback
        $sql = "update ngo_feedback set 
            feedback_rating = '" . addslashes($feedback_rating) . "', 
            feedback_title = '" . addslashes($feedback_title) . "', 
            feedback_desc = '" . addslashes($feedback_desc) . "',
            status = '" . addslashes($status) . "'
            where feedback_id = '$feedback_id'";
        db_query($sql);
        $msg = "Feedback updated successfully.";
    } else {
        // Insert new feedback
        $sql = "insert into ngo_feedback set 
            feedback_name = '" . addslashes($feedback_name) . "',
            feedback_rating = '" . addslashes($feedback_rating) . "', 
            feedback_title = '" . addslashes($feedback_title) . "', 
            feedback_desc = '" . addslashes($feedback_desc) . "',
            status = '" . addslashes($status) . "'";
        db_query($sql);
        $msg = "Feedback added successfully.";
    }
    
    header("Location: feedback_list.php?msg=" . urlencode($msg));
    exit;
}

$feedback_id = $_REQUEST['feedback_id'];
if ($feedback_id != '') {
    $sql = "select * from ngo_feedback where feedback_id = '$feedback_id'";
    $result = db_query($sql);
    if ($line_raw = mysqli_fetch_array($result)) {
        @extract($line_raw);
    }
}
?>

<? include("top.inc.php"); ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td id="pageHead">
            <div id="txtPageHead"><?= $feedback_id ? 'Edit' : 'Add New' ?> Feedback</div>
        </td>
    </tr>
</table>

<div align="right" style="padding:10px;">
    <a href="feedback_list.php">Back to Feedback List</a>
</div>

<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form() ?>>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
                    <?php if (!$feedback_id) { ?>
                    <tr>
                        <td width="25%" class="tdLabel">User Name:</td>
                        <td width="75%" class="tdField">
                            <input name="feedback_name" type="text" class="textfield" value="<?= $feedback_name ?>" size="40" required>
                        </td>
                    </tr>
                    <?php } ?>
                    
                    <tr>
                        <td class="tdLabel">Rating:</td>
                        <td class="tdField">
                            <select name="rating" id="rating" class="textfield" required>
                                <option value="">Select Rating</option>
                                <?php for($i = 1; $i <= 5; $i++) { ?>
                                    <option value="<?= $i ?>" <?= $feedback_rating == $i ? 'selected' : '' ?>><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Title:</td>
                        <td class="tdField">
                            <input name="feedback_title" type="text" class="textfield" id="feedback_title" value="<?= $feedback_title ?>" size="40" alt="blank" emsg="Please enter feedback title" required>
                        </td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Description:</td>
                        <td class="tdField">
                            <textarea name="feedback_desc" class="textfield" id="feedback_desc" rows="4" cols="50" alt="blank" emsg="Please enter feedback description" required><?= $feedback_desc ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Status:</td>
                        <td class="tdField">
                            <select name="status" class="textfield" required>
                                <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="tdLabel">&nbsp;</td>
                        <td class="tdField">
                            <input type="submit" name="Submit" value="<?= $feedback_id ? 'Update' : 'Add' ?>" class="button">
                            <input type="button" name="Cancel" value="Cancel" class="button" onClick="window.location='feedback_list.php'">
                            <?php if($feedback_id) { ?>
                                <input type="hidden" name="feedback_id" value="<?= $feedback_id ?>">
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>

<? include("bottom.inc.php"); ?>