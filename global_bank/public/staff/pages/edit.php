<?php

require_once('../../../private/initialize.php');
require_login();
$page_title = 'Edit Page';
if(!isset($_GET['id'])) {
    redirect_to(url_for('/staff/pages/index.php'));
}
$id = $_GET['id']?? "";

$page = find_page_by_id($id);
$current_position = $page['position'];

if(is_post_request()){
    $page = [];
    $page['id'] = $id;
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['content'] = $_POST['content'] ?? '';

    $result = update_page($page);
    if($result === true){
        $message ="The page was edited successfully.";
        $_SESSION['message'] = $message;
        update_page_position($page['subject_id'],$current_position, $page['position'], $id);
        redirect_to(url_for('/staff/pages/show.php?id=' . $id));
    } else {
        $errors = $result;
        // var_dump($error);
    }
}

else{
    $count = count_all_pages_by_subject_id($page['subject_id']);
}

?>

<?php include(SHARED_PATH . '/staff_header.php' ); ?>


<div id="content">
    
<a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=') . htmlspecialchars(urlencode($page['subject_id'])); ?>">&laquo; Back to Subject Page</a>
    
    <div id="page edit">
        <h1>Edit Page</h1>

        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/staff/pages/edit.php?id=' . htmlspecialchars(urlencode($id)));?>" method="post">
            <dl>
                <dt>Page Name</dt>
                <dd><input type="text" name="menu_name" value="<?php echo htmlspecialchars($page['menu_name']);?>" /></dd>
            </dl>

            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php
                            for($i=1; $i <= $count; $i++) {
                                echo "<option value=\"{$i}\"";
                                if($page["position"] == $i) {
                                    echo " selected";
                                }
                                echo ">{$i}</option>";
                            }
                        ?>
                    </select>
                </dd>
            </dl>

            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="0" />
                    <input type="checkbox" name="visible" value="1" <?php if($page['visible'] == "1"){echo "checked";}?> />
                </dd>
            </dl>
            
            <dl>
                <dt>Subject Name</dt>
                <dd>
                    <select name="subject_id">
                        <?php
                            $subject_set = find_all_subjects();
                            while($subject = mysqli_fetch_assoc($subject_set)){
                        ?>

                        <option value='<?php echo htmlspecialchars($subject['id']);?>'
                            <?php if($page['subject_id']==$subject['id']){echo 'selected';}?> >
                            <?php echo htmlspecialchars($subject['menu_name']);?>
                        </option>
                        <?php } ?>
                    </select>
                </dd>
            </dl>

            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="content" cols="60" rows="10"><?php echo htmlspecialchars($page['content']); ?></textarea>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Edit Page" />
            </div>
        </form>
    </div>
<div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>