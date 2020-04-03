<?php
    $page_id = $page_id ?? '';
    $subject_id = $subject_id ?? '';
    $preview = $preview ?? '';
?>

<navigation>
    <?php 
    if($preview){
        $nav_subjects = find_all_subjects();
    } else{
        $nav_subjects = find_all_subjects(['visible' => true]);
    } 
    ?>
    <ul class="subjects">
        <?php 
        while($nav_subject = mysqli_fetch_assoc($nav_subjects)) { 
           
        ?>
        <li class="<?php if($nav_subject['id'] == $subject_id){echo 'selected';}?> ">
            
            <a href="<?php echo url_for('index.php?subject_id=' . htmlspecialchars(urlencode($nav_subject['id']))); ?>">
                <?php echo htmlspecialchars($nav_subject['menu_name']); ?>
            </a>
            
            <?php if($nav_subject['id'] == $subject_id){ ?>
            <?php 
            if($preview){    
                $nav_pages = find_all_pages_by_subject_id($nav_subject['id']); 
            } else{
                $nav_pages = find_all_pages_by_subject_id($nav_subject['id'], ['visible' => true]); 
            }?>    
                <ul class="pages">                           
                    <?php while($nav_page = mysqli_fetch_assoc($nav_pages)) { ?>
                        
                        <li class="<?php if($nav_page['id']==$page_id){echo 'selected';}?> ">
                            <a href="<?php echo url_for('index.php?id=' . htmlspecialchars(urlencode($nav_page['id']))); ?>">
                                <?php echo htmlspecialchars($nav_page['menu_name']); ?>
                            </a>
                        </li>
                
                    
                    <?php } // while $nav_page ?>
                </ul>
            
            <?php mysqli_free_result($nav_pages); ?>
            <?php } ?>
        </li>
        <?php } // while $nav_subjects ?>
    </ul>
    <?php mysqli_free_result($nav_subjects); ?>
</navigation>

