<?php 
require_once 'src/middleware/isLogged.php';
function loginView() {
    if (is_logged()) {
        header('Location: /');
        exit();
    }
    
    require 'src/templates/login.php';
}