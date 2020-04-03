<?php 
require_once('../../../private/initialize.php');

require_login();

$id = isset($_GET['id']) ? $_GET['id'] : '1';

include(SHARED_PATH . '/staff_header.php');

$admin = find_admin_by_id($id);
?>

<div id='content'>
    
    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

    <div class="admin show">
        <dl>
            <dt>First Name</dt>
            <dd><?php echo htmlspecialchars($admin['first_name']); ?> </dd>
        </dl>

        <dl>
            <dt>Last Name</dt>
            <dd><?php echo htmlspecialchars($admin['last_name']); ?> </dd>
        </dl>

        <dl>
            <dt>User Name</dt>
            <dd><?php echo htmlspecialchars($admin['username']); ?> </dd>
        </dl>

        <dl>
            <dt>Email</dt>
            <dd><?php echo htmlspecialchars($admin['email']); ?> </dd>
        </dl>
    </div>    
</div>

<?php include(SHARED_PATH . '/staff_footer.php');?>
