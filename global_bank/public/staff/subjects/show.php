<?php
    require_once('../../../private/initialize.php');
    require_login();
    $id = isset($_GET['id']) ? $_GET['id'] : '1';
    $page_title =  'Show Subject ' . htmlspecialchars($id);
    
    include(SHARED_PATH .'/staff_header.php');

    $subject = find_subject_by_id($id);
    $pages_set = find_all_pages_by_subject_id($id);
?>

<div id='content'>
    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject show">
    
        <h1>Subjects: <?php echo htmlspecialchars($subject['menu_name']); ?></h1>

        <div id="attributes">    
            <dl>
                <dt>Subject ID</dt>
                <dd><?php echo htmlspecialchars($subject['id']);?></dd>
            </dl>

            <dl>
                <dt>Menu Name</dt>
                <dd><?php echo htmlspecialchars($subject['menu_name']); ?></dd>
            </dl>

            <dl>
                <dt>Position</dt>
                <dd><?php echo htmlspecialchars($subject['position']); ?></dd>
            </dl>

            <dl>
                <dt>Visible</dt>
                <dd><?php echo $subject['visible'] == '1' ? 'true':'false' ; ?></dd>
            </dl>

        </div>
    </div>

    <hr />

    <div id="page listing">
		<h2>Pages</h2>

		<div class="actions">
		<a class="action" href="<?php echo url_for('/staff/pages/new.php?subject_id=' . htmlspecialchars(urlencode($subject['id']))); ?>">Create new page</a>
		</div>

		<table class = "list">
		
			<tr>
				<th>ID</th>
				<th>Position</th>
				<th>Visible</th>
				<th>Name</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>

			<?php while($page = mysqli_fetch_assoc($pages_set)) { ?>
			<tr>
				<td><?php echo htmlspecialchars($page['id']); ?></td>
				<td><?php echo htmlspecialchars($page['position']); ?></td>
				<td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
				<td><?php echo htmlspecialchars($page['menu_name']); ?></td>
				<td><a class="action" href="<?php echo url_for('staff/pages/show.php?id=' . htmlspecialchars(urlencode($page['id'])));?>">View</a></td>
				<td><a class="action" href="<?php echo url_for('staff/pages/edit.php?id=' . htmlspecialchars(urlencode($page['id'])));?>">Edit</a></td>
				<td><a class="action" href="<?php echo url_for('staff/pages/delete.php?id='. htmlspecialchars(urlencode($page['id'])));?>">Delete</a></td>
			</tr>
			<?php } ?>
		</table>
		<?php mysqli_free_result($pages_set); ?>
	</div>



</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>