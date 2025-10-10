<?php
require_once 'src/models/login.php';

function loginApi() {
  header('Content-Type: application/json');

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode de requête invalide.']);
    return;
  }

  $credentials = [
    'email' => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? ''
  ];

  $user = login($credentials);

  if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect.']);
    return;
  }

  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

  if (isset($user['hashed_password'])) {
    unset($user['hashed_password']);
  }

  $_SESSION['user'] = $user;

  echo json_encode(['success' => true, 'user' => $user]);
  return;
}
