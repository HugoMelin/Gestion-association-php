<?php
require_once 'src/middleware/isLogged.php';

function registerView() {
    //if (is_logged()) {
    //    header('Location: /');
    //    exit();
    //}

    require 'src/templates/register.php';
}