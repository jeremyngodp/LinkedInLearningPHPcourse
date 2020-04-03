<?php
    function validate_subject($subject) {

        $errors = [];
        
        // menu_name
        if(is_blank($subject['menu_name'])) {
            $errors[] = "Name cannot be blank.";
        }
        else if(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = "Name must be between 2 and 255 characters.";
        }
      
        // position
        // Make sure we are working with an integer
        $postion_int = (int) $subject['position'];
        if($postion_int <= 0) {
            $errors[] = "Position must be greater than zero.";
        }
        if($postion_int > 999) {
            $errors[] = "Position must be less than 999.";
        }
      
        // visible
        // Make sure we are working with a string
        $visible_str = (string) $subject['visible'];
        if(!has_inclusion_of($visible_str, ["0","1"])) {
            $errors[] = "Visible must be true or false.";
        }
      
        return $errors;
    }

    function validate_page($page){
        $errors =[];

        if(is_blank($page['menu_name'])){
            $errors[] = 'Name cannot be blank.';
        }else if (!has_length($page['menu_name'],['min' => 2, 'max' => 255])){
            $errors[] = 'Name must be between 2 and 255 characters.';
        }

        if(has_unique_menu_name($page['menu_name'])){
            $error[] = 'Menu Name is not unique!' ;
        }

        $position_int = (int)$page['position'];
        if($position_int <= 0){
            $errors[] = "Position must be greater than zero." ;
        }
        if($position_int > 999){
            $errors[] ='Position must be less than 999.' ;
        }

        $visible_str= (string)$page['visible'];
        if(!has_inclusion_of($visible_str,['0', '1'])){
            $errors[] = 'Visible must be true or false' ;
        }

        return $errors;
    }

    function validate_admin($admin, $options = []){
        $errors =[];
        $uppercase_set = ['A','B','C','D','E','F','G','H','I','J','K','L',
                        'M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        $lowercase_set = ['a','b','c','d','e','f','g','h','i','j','k','l',
                        'm','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $specialchars_set = ['#','$','%','^','&','*','@','!','?'];

        $number_set = ['1','2','3','4','5','6','7','8','9','0'];

        $password_required = $options['password_required'] ?? false;

        //Name
        if(is_blank($admin['first_name'])){
            $errors[] = 'First Name cannot be blank.';
        }else if (!has_length($admin['first_name'],['min' => 2, 'max' => 255])){
            $errors[] = 'First Name must be between 2 and 255 characters.';
        }

        if(is_blank($admin['last_name'])){
            $errors[] = 'Last Name cannot be blank.';
        }else if (!has_length($admin['last_name'],['min' => 2, 'max' => 255])){
            $errors[] = 'Last Name must be between 2 and 255 characters.';
        }

        //Email
        if(is_blank($admin['email'])){
            $errors[] = 'Please provide an email.';
        }

        if(!has_valid_email_format($admin['email'])){
            $errors[] = 'Invalid email format.';
        }

        //Username
        if(is_blank($admin['username'])){
            $errors[] = 'User Name cannot be blank.';
        }else if (!has_length($admin['username'],['min' => 8, 'max' => 255])){
            $errors[] = 'User Name must be between 8 and 255 characters.';
        }

        if(has_unique_username($admin['username'])){
            $errors[] = 'User Name has already been used' ;
        }
        
        
        //Password
        if($password_required){
            if(is_blank($admin['password'])){
                $errors[] = 'Please provide a password.';
            }else if (!has_length($admin['password'],['min' => 12, 'max' => 255])){
                $errors[] = 'Password must be at least 12 characters.';
            }


            $str_arr = str_split($admin['password']);
            
            $U = $S = $L = $N = '';
            foreach($str_arr as $char){
                if(has_inclusion_of($char, $uppercase_set)){
                    $U = true; 
                    continue;
                } else if(has_inclusion_of($char, $lowercase_set)){
                    $L = true;
                    continue;
                } else if(has_inclusion_of($char, $number_set)){
                    $N = true;
                    continue;
                } else if(has_inclusion_of($char, $specialchars_set)){
                    $S = true;
                }
            }

            if(!$U or !$L or !$S or !$N){
                $errors[] = 'The password must contain at least one special characters, one uppercase, one lowercase and one number';
            }

            if(is_blank($admin['confirm_pass'])){
                $errors[] = 'Please confirm the password.';
            } else if ($admin['password'] !== $admin['confirm_pass']){
                $errors[] = 'Password and Confirm Password did not match';
            }
        }
        
        return $errors;
    }
    
    //Find
    function find_all_subjects($options=[]){
        global $db;
        $visible = $options['visible'] ?? false;

        $sql ="SELECT * FROM subjects "; 
        if($visible){
            $sql .= "WHERE visible = true ";
        } 
        $sql .= "ORDER BY id ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_all_pages(){
        global $db;
        $sql ="SELECT * FROM pages";
        $sql .= " ORDER BY id ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_all_admins(){
        global $db;
        $sql ="SELECT * FROM admins";
        $sql .= " ORDER BY id ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_subject_by_id($id, $options=[]){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM subjects WHERE id='";
        $sql .= $id ."' ";
        if($visible){
            $sql .= "AND visible = true ";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $subject;
    }

    function find_page_by_id($id, $options = []){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM pages WHERE id='";
        $sql .= $id ."' ";
        if($visible){
            $sql .= "AND visible = true ";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page;
    }

    function find_admin_by_id($id, $options = []){
        global $db;
        $sql = "SELECT * FROM admins WHERE id='";
        $sql .= $id ."' ";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admin;
    }

    function find_admin_by_username($username, $options = []){
        global $db;
        $sql = "SELECT * FROM admins WHERE username='";
        $sql .= $username ."' ";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $admin;
    }

    function find_all_pages_by_subject_id($subject_id, $options = []){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM pages WHERE subject_id='";
        $sql .= db_escape($db,$subject_id) ."' ";
        if($visible){
            $sql .= "AND visible = '1' ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
       
        return $result;
    }

    function count_all_pages_by_subject_id($subject_id, $options = []){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT COUNT(id) FROM pages WHERE subject_id='";
        $sql .= db_escape($db,$subject_id) ."' ";
        if($visible){
            $sql .= "AND visible = '1' ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $row = mysqli_fetch_row($result);
        $count = $row[0];
        return $count;
    }

    //Create 
    function insert_subject($subject){
        global $db;
        $errors = validate_subject($subject);
        
        if(!empty($errors)){
            return $errors;
        }


        $sql = "INSERT INTO subjects " ;
        $sql.= "(menu_name, position, visible) ";
        $sql .= "VALUES (" ;
        $sql .= "'" . $subject['menu_name'] . "'," ;
        $sql .= "'" . $subject['position'] . "'," ;
        $sql .= "'" . $subject['visible'] . "')" ;
        $result = mysqli_query($db,$sql); //$result is bool
 
    
        if($result){
            return true;
        }
    
        else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function insert_admin($admin){
        global $db;
        $errors = validate_admin($admin);
        
        if(!empty($errors)){
            return $errors;
        }

        //Encrypt password here
        $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO admins " ;
        $sql.= "(first_name, last_name, username, email, hashed_password) ";
        $sql .= "VALUES (" ;
        $sql .= "'" . $admin['first_name'] . "'," ;
        $sql .= "'" . $admin['last_name'] . "'," ;
        $sql .= "'" . $admin['username'] . "'," ;
        $sql .= "'" . $admin['email'] . "'," ;
        $sql .= "'" . $hashed_password . "')" ;
        $result = mysqli_query($db,$sql); //$result is bool
    
        if($result){
            return true;
        }
    
        else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function insert_page($page){
        global $db;

        $errors = validate_page($page);
        
        if(!empty($errors)){
            return $errors;
        }

        $sql = "INSERT INTO pages" ;
        $sql.= "(menu_name, position, visible, content, subject_id) ";
        $sql .= "VALUES (" ;
        $sql .= "'" . $page['menu_name'] . "'," ;
        $sql .= "'" . $page['position'] . "'," ;
        $sql .= "'" . $page['visible'] . "'," ;
        $sql .= "'" . $page['content'] . "'," ;
        $sql .= "'" . $page['subject_id'] . "')" ;
        $result = mysqli_query($db,$sql); //$result is bool
    
        if($result){
            return true;
        }
    
        else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }
    
    //Update
    function update_subject($subject,$options=[]){
        global $db;
        $errors = validate_subject($subject);
        $visible = $options['visible'] ?? false;
        if($visible){
            $subject['visible'] = 1;
        }
        if(!empty($errors)){
            return $errors;
        }

        $sql = "UPDATE subjects SET ";
        $sql .= "menu_name='" . $subject['menu_name'] . "', ";
        $sql .= "position='" . $subject['position'] . "', ";
        $sql .= "visible='" . $subject['visible'] . "' ";
        $sql .= "WHERE id='" . $subject['id'] . "'" ;
        $sql .= "LIMIT 1";

        $result = mysqli_query($db,$sql);

        if($result){
            return true;
        }
        
        //UPDATE failed
        else{
            echo mqsqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_page($page, $option=[]){
        global $db;
        $errors = validate_subject($page);
        $visible = $option['visible']?? false;
        if($visible){
            $page['visible'] = 1;
        }
        if(!empty($errors)){
            return $errors;
        }

        $sql = "UPDATE pages SET ";
        $sql .= "menu_name='" . $page['menu_name'] . "', ";
        $sql .= "position='" . $page['position'] . "', ";
        $sql .= "subject_id='" . $page['subject_id'] . "', ";
        $sql .= "visible='" . $page['visible'] . "' ";
        $sql .= "WHERE id='" . $page['id'] . "'" ;
        $sql .= "LIMIT 1";

        $result = mysqli_query($db,$sql);

        if($result){
            return true;
        }
        
        //UPDATE failed
        else{
            echo mqsqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_admin($admin,$options=[]){
        global $db;
        $errors = validate_admin($admin, ['password_required' => $password_sent]);

        $password_sent = !is_blank($admin['password']);
        
        if(!empty($errors)){
            return $errors;
        }
        // Encrypt password here. 
        $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);


        $sql = "UPDATE admins SET ";
        $sql .= "first_name='" . $admin['first_name'] . "', ";
        $sql .= "last_name='" . $admin['last_name'] . "', ";
        $sql .= "username='" . $admin['username'] . "', ";
        if($password_sent){
            $sql .= "hashed_password='" . $hashed_password . "' ,";
        }
        $sql .= "email='" . $admin['email'] . "' ";

        $sql .= "WHERE id='" . $admin['id'] . "'" ;
        $sql .= "LIMIT 1";

        $result = mysqli_query($db,$sql);

        if($result){
            return true;
        }
        
        //UPDATE failed
        else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }
    //Delete
    function delete_subject($id){
        global $db;
        $sql = "DELETE FROM subjects ";
	    $sql .= "WHERE id='" . $id . "'";
	    $sql .= "LIMIT 1";

	    $result = mysqli_query($db, $sql);
	
	    if($result){
            $subject_count = mysqli_num_rows(find_all_subjects()) + 1;
            $sql2 = "ALTER TABLE subjects AUTO_INCREMENT = " . $subject_count;
            $result2 = mysqli_query($db, $sql2);
            return true;
	    }

	    else{
		    echo mqsqli_error($db);
            db_disconnect($db);
            exit;
	    }
    }

    function delete_page($id){
        global $db;
        $sql = "DELETE FROM pages ";
	    $sql .= "WHERE id='" . $id . "'";
	    $sql .= "LIMIT 1";

	    $result = mysqli_query($db, $sql);
	
	    if($result){
            $page_count = mysqli_num_rows(find_all_pages($db)) + 1;
            $sql2 = "ALTER TABLE pages AUTO_INCREMENT = " . $page_count;
            $result2 = mysqli_query($db, $sql2);
            return true;
	    }

	    else{
		    echo mqsqli_error($db);
            db_disconnect($db);
            exit;
	    }
    }

    function delete_admin($id){
        global $db;
        $sql = "DELETE FROM admins ";
	    $sql .= "WHERE id='" . $id . "'";
	    $sql .= "LIMIT 1";

	    $result = mysqli_query($db, $sql);
	
	    if($result){
            $admin_count = mysqli_num_rows(find_all_admins()) + 1;
            $sql2 = "ALTER TABLE admins AUTO_INCREMENT = " . $admin_count;
            $result2 = mysqli_query($db, $sql2);
            return true;
	    }

	    else{
		    echo mqsqli_error($db);
            db_disconnect($db);
            exit;
	    }
    }

    // Auto-update position

    function update_subject_position($start_position, $end_position, $current_id=0){
        
        global $db;
        $sql = 'UPDATE subjects SET ';

        if($start_position == 0 ){ // Insert  
            // Add one to position >= endpositon.
            $sql .= 'position = position + 1 ';
            $sql .= 'WHERE position >= ' . $end_position . ' '; 
            $sql .= 'AND id != ' . $current_id ;
        }
        
        elseif($end_position == 0 ){ //Delete
            // Substract 1 from position >= end position.
            $sql .= 'position = position - 1 ';
            $sql .= 'WHERE position >= ' . $start_position ;
        }
        
        
        elseif($start_position > $end_position){ //High to low
            // Add 1 to position in between including endpos.
            $sql .= 'position = position + 1 ';
            $sql .= 'WHERE position >= ' . $end_position . ' ';
            $sql .= 'AND position <' .  $start_position . ' '; 
            $sql .= 'AND id != ' . $current_id ;
        }

        elseif($start_position < $end_position){ ///Low to High
            //Subtract 1 from position in betwenn including endpos.
            $sql .= 'position = position - 1 ';
            $sql .= 'WHERE position <= ' . $end_position . ' ';
            $sql .= 'AND position >' .  $start_position . ' '; 
            $sql .= 'AND id != ' . $curent_id ;
        }

        mysqli_query($db,$sql);
    }

    function update_page_position($subject_id, $start_position, $end_position, $current_id=0){
        
        global $db;
        $sql = 'UPDATE pages SET ';

        if($start_position == 0 ){ // Insert  
            // Add one to position >= endpositon.
            $sql .= 'position = position + 1 ';
            $sql .= 'WHERE position >= ' . $end_position . ' '; 
            $sql .= 'AND id != ' . $current_id ;
        }
        
        elseif($end_position == 0 ){ //Delete
            // Substract 1 from position >= end position.
            $sql .= 'position = position - 1 ';
            $sql .= 'WHERE position >= ' . $start_position ;
        }
        
        
        elseif($start_position > $end_position){ //High to low
            // Add 1 to position in between including endpos.
            $sql .= 'position = position + 1 ';
            $sql .= 'WHERE position >= ' . $end_position . ' ';
            $sql .= 'AND position <' .  $start_position . ' '; 
            $sql .= 'AND id != ' . $current_id ;
        }

        elseif($start_position < $end_position){ ///Low to High
            //Subtract 1 from position in betwenn including endpos.
            $sql .= 'position = position - 1 ';
            $sql .= 'WHERE position <= ' . $end_position . ' ';
            $sql .= 'AND position >' .  $start_position . ' '; 
            $sql .= 'AND id != ' . $curent_id ;
        }
        $sql .= ' AND subject_id = '.$subject_id . ";" ;
        mysqli_query($db,$sql);
    }
    
?>