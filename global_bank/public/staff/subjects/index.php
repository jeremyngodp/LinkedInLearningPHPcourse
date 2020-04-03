<?php require_once('../../../private/initialize.php');
require_login();
?>

<?php $subject_set = find_all_subjects(); ?>

<?php $page_title = "Subject Menu"; ?>
<?php include(SHARED_PATH .'/staff_header.php'); ?>

    <div id="content">
		<div class="subjects listing">
			<h1>Subjects</h1>
			
			<div class="actions">
				<a class="action" href="<?php echo url_for('/staff/subjects/new.php'); ?>">Create New Subject</a>
			</div>

			<table class="list">
				<tr>
					<th>ID</th>
					<th>Position</th>
					<th>Visible</th>
					<th>Name</th>
					<th>Page</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>

				<?php while($subject = mysqli_fetch_assoc($subject_set)) { ?>
					<?php $count = count_all_pages_by_subject_id($subject['id']); ?>
					<tr>
						<td><?php echo htmlspecialchars($subject['id']); ?></td>
						<td><?php echo htmlspecialchars($subject['position']); ?></td>
						<td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
						<td><?php echo htmlspecialchars($subject['menu_name']); ?></td>
						<td><?php echo htmlspecialchars($count); ?></td>
						<td><a class="action" href="<?php echo url_for('staff/subjects/show.php?id=') . htmlspecialchars(urlencode($subject['id']));?>">View</a></td>
						<td><a class="action" href="<?php echo url_for('staff/subjects/edit.php?id=') . htmlspecialchars(urlencode($subject['id']));?>">Edit</a></td>
						<td><a class="action" href="<?php echo url_for('staff/subjects/delete.php?id=') . htmlspecialchars(urlencode($subject['id'])); ?>">Delete</a></td>
					</tr>
				<?php } ?>
			</table>

			<?php mysqli_free_result($subject_set);?>

		</div>
    </div>

<?php include(SHARED_PATH.'/staff_footer.php'); ?>
