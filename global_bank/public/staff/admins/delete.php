<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
	redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];



if(is_post_request()) {
	$result = delete_admin($id);
	$message = "The user was deleted successfully.";
	$_SESSION['message'] = $message;
	redirect_to(url_for('staff/admins/index.php'));
}

else{
	$admin = find_admin_by_id($id);
}

?>

<?php $page_title = 'Delete Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  	<a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

	<div class="admin delete">
		<h1>Delete Page</h1>
		<p>Are you sure you want to delete this user?</p>
		<p class="item"><?php echo htmlspecialchars($admin['username']); ?></p>

		<form action="<?php echo url_for('/staff/admins/delete.php?id=' . htmlspecialchars(urldecode($admin['id']))); ?>" method="post">
			<div id="operations">
				<input type="submit" name="commit" value="Delete Admin" />
			</div>
		</form>
	</div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
