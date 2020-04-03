<?php

require_once('../../../private/initialize.php');

require_login();

if(is_post_request()){
    $admin = [];
    $admin['first_name'] = $_POST['first_name'] ?? '';
    $admin['last_name'] = $_POST['last_name'] ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';
    $admin['email'] = $_POST['email'] ?? '';
    $admin['confirm_pass'] = $_POST['confirm_pass'];
    
    $result = insert_admin($admin);

    if($result === true){
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = "The user was created successfully.";
        redirect_to(url_for('staff/admins/show.php?id=' . $new_id));
    } else {
        $errors = $result;
    }
   
}

else{
    $admin = [];
    $admin['first_name'] = '';
    $admin['last_name'] = '';
    $admin['username'] = '';
    $admin['password'] = '';
    $admin['email'] = '';
    $admin['confirm_pass'] = '';
}

?>

<?php
$page_title = 'Create Admin';
include(SHARED_PATH . '/staff_header.php' ); 
?>

<div id="content">
    
    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>
    
    <div id="admin new">
        <h1>Create New User</h1>
        <?php echo display_errors($errors); ?>
        <form action="<?php echo url_for('/staff/admins/new.php');?>" method="post">
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
                <dt>Password</dt>
                <dd><input type="password" name="password" value="<?php echo htmlspecialchars($admin['password']);?>" /></dd>
            </dl>
           
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type="password" name="confirm_pass" value="<?php echo htmlspecialchars($admin['confirm_pass']);?>" /></dd>
            </dl>	

            <div id="operations">
                <input type="submit" value="Create User" />
            </div>
        </form>
    </div>
<div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>