<?php
session_start();

require 'src/controllers/login.php';
require 'src/api/login.php';
require 'src/controllers/register.php';
require 'src/api/register.php';
require 'src/controllers/logout.php';
require 'src/api/family.php';
require 'src/api/activity.php';
require 'src/api/family-activity.php';

$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

switch ($path) {
  case '':
  case '/':
    echo "Welcome to the homepage!";
    echo $_SESSION['user']['username'] ?? 'Guest';
    break;
  case '/connexion':
    loginView();
    break;
  case '/api/login':
    loginApi();
    break;
  case '/inscription':
    registerView();
    break;
  case '/api/register':
    registerApi();
    break;
  case '/deconnexion':
    logoutController();
    break;
  case '/api/family':
    familyApi();
    break;
  case '/api/activity':
    activityApi();
    break;
  case '/api/family-activity':
    familyActivityApi();
    break;
  default:
    echo "404 Not Found";
    break;
}