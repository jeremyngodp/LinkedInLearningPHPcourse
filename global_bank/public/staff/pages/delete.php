<?php

require_once('../../../private/initialize.php');
require_login();
if(!isset($_GET['id'])) {
	redirect_to(url_for('/staff/pages/index.php'));
}
$id = $_GET['id'];

$page = find_page_by_id($id);
$current_position = $page['position'];

if(is_post_request()) {
	update_page_position($page['subject_id'], $current_position, 0, $id);
	$result = delete_page($id);
	
	$message = "The page was deleted successfully.";
	$_SESSION['message'] = $message;
	redirect_to(url_for('staff/subjects/show.php?id=' . htmlspecialchars(urlencode($page['subject_id']))));
}

else{

}

?>

<?php $page_title = 'Delete Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

<a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=') . htmlspecialchars(urlencode($page['subject_id'])); ?>">&laquo; Back to Subject Page</a>

	<div class="page delete">
		<h1>Delete Page</h1>
		<p>Are you sure you want to delete this page?</p>
		<p class="item"><b><?php echo htmlspecialchars($page['menu_name']); ?></b></p>

		<form action="<?php echo url_for('/staff/pages/delete.php?id=' . htmlspecialchars(urldecode($page['id']))); ?>" method="post">

			<div id="operations">
				<input type="submit" name="commit" value="Delete Page" />
			</div>
			
		</form>
	</div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
