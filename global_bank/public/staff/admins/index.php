<?php require_once('../../../private/initialize.php'); 

require_login();

?>

<?php 
	$page_title = 'Admin Menu';
?> 
<?php include(SHARED_PATH .'/staff_header.php'); ?>

<?php
	$admins_set = find_all_admins();
?>

<div id="content">
	<div id="admin listing">
		<h1>Admins</h1>

		<div class="actions">
		<a class="action" href="<?php echo url_for('/staff/admins/new.php') ?>">Create new admin</a>
		</div>

		<table class = "list">
		
			<tr>
				<th>ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>

			<?php while($admin = mysqli_fetch_assoc($admins_set)) { ?>
			<tr>
				<td><?php echo htmlspecialchars($admin['id']); ?></td>
				<td><?php echo htmlspecialchars($admin['first_name']); ?></td>
				<td><?php echo htmlspecialchars($admin['last_name']); ?></td>
				<td><?php echo htmlspecialchars($admin['username']); ?></td>
				<td><?php echo htmlspecialchars($admin['email']); ?></td>
				<td><a class="action" href="<?php echo url_for('staff/admins/show.php?id=' . htmlspecialchars(urlencode($admin['id'])));?>">View</a></td>
				<td><a class="action" href="<?php echo url_for('staff/admins/edit.php?id=' . htmlspecialchars(urlencode($admin['id'])));?>">Edit</a></td>
				<td><a class="action" href="<?php echo url_for('staff/admins/delete.php?id='. htmlspecialchars(urlencode($admin['id'])));?>">Delete</a></td>
			</tr>
			<?php } ?>
		</table>
		<?php mysqli_free_result($admins_set); ?>
	</div>
</div>

<?php include(SHARED_PATH .'/staff_footer.php'); ?>