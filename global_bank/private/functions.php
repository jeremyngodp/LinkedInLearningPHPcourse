<?php
function url_for($script_path) {
    // add the leading '/' if not present
    if($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
  }

function redirect_to($location){
    header("Location: " .$location);
    exit();
}

function error_404(){
    header( $_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
    exit();
}

function error_505(){
    header($_SERVER["SERVER_PROTOCOL"] . "505 Internal Server Error");
    exit();
}

function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request(){
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
      $output .= "<div class=\"errors\">";
      $output .= "Please fix the following errors:";
      $output .= "<ul>";
      foreach($errors as $error) {
        $output .= "<li>" . htmlspecialchars($error) . "</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }
?>
