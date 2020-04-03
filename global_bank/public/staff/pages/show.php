<?php 
require_once('../../../private/initialize.php');

require_login();

$id = isset($_GET['id']) ? $_GET['id'] : '1';

include(SHARED_PATH . '/staff_header.php');

$page = find_page_by_id($id);
$subject = find_subject_by_id($page['subject_id']);
?>

<div id='content'>
    
    <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=') . htmlspecialchars(urlencode($subject['id'])); ?>">&laquo; Back to Subject Page</a>

    <div class="page show">
        <h1>Page: <?php echo htmlspecialchars($page['menu_name']); ?> </h1>
        <p><?php echo $_SESSION['sql'] ?></p>
        <div id='attributes'>
            <dl>
                <dt>Page ID: </dt>
                <dd><?php echo htmlspecialchars($page['id']); ?></dd>
            </dl>

            <dl>
                <dt>Postion : </dt>
                <dd><?php echo htmlspecialchars($page['position']); ?></dd>
            </dl>

            <dl>
                <dt>Subject Name: </dt>
                <dd><?php echo htmlspecialchars($subject['menu_name']); ?></dd>
            </dl>

            <dl>
                <dt>Visible: </dt>
                <dd><?php echo $page['visible'] == 1?'true': 'false'; ?></dd>
            </dl>

            <dl>
                <dt>Content</dt>
                <dd><?php echo htmlspecialchars($page['content']); ?></dd>
            </dl>
        
        </div>
            
    </div>

    <a class="action" target="_blank" href="<?php echo url_for('/index.php?preview=true&id=' . htmlspecialchars(urlencode($page['id'])));?>">Preview</a>
    <br>

</div>

<?php include(SHARED_PATH . '/staff_footer.php');?>
