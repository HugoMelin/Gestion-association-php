<?php

function logoutController() {
    if (!isset($_SESSION)) {
        session_start();
    }

    session_destroy();
    header('Location: /connexion');
    exit();
}