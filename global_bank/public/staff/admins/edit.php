<?php

require_once('../../../private/initialize.php');

require_login();

$page_title = 'Edit User';
if(!isset($_GET['id'])) {
    redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id']?? "";


if(is_post_request()){
    $admin = [];
    $admin['id'] = $id;
    $admin['first_name'] = $_POST['first_name'] ?? '';
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';
    $admin['confirm_pass'] = $_POST['confirm_pass'] ?? '';
    $admin['email'] = $_POST['email'] ?? '  ';

    
    $result = update_admin($admin);
    if($result === true){
        $message ="The user was edited successfully.";
        $_SESSION['message'] = $message;
        redirect_to(url_for('/staff/admins/show.php?id=' . $id));
    } else {
        $errors = $result;
        // var_dump($error);
    }
}

else{
    $admin = find_admin_by_id($id);
}
?>

<?php include(SHARED_PATH . '/staff_header.php' ); ?>


<div id="content">
    
    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>
    
    <div id="admin edit">
        <h1>Edit User</h1>

        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/staff/admins/edit.php?id=' . htmlspecialchars(urlencode($id)));?>" method="post">
            <dl>
                <dt>First Name</dt>
                <dd><input type="text" name="first_name" value="<?php echo htmlspecialchars($admin['first_name']);?>" /></dd>
            </dl>

            <dl>
                <dt>Last Name</dt>
                <dd><input type="text" name="last_name" value="<?php echo htmlspecialchars($admin['last_name']);?>" /></dd>
            </dl>

            <dl>
                <dt>User Name</dt>
                <dd><input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']);?>" /></dd>
            </dl>

            <dl>
                <dt>Email</dt>
                <dd><input type="text" name="email" value="<?php echo htmlspecialchars($admin['email']);?>" /></dd>
            </dl>

            <dl>
                <dt>Edit Password</dt>
                <dd><input type="password" name="password" value="" /></dd>
            </dl>
           
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type="password" name="confirm_pass" value="" /></dd>
            </dl>

            <div id="operations">
                <input type="submit" value="Edit Admin" />
            </div>
        </form>
    </div>
<div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>