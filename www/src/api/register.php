<?php 
require_once 'src/models/register.php';

function registerApi() {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      echo json_encode(['success' => false, 'message' => 'Méthode de requête invalide.']);
      return;
    }

    $data = [
      'username' => $_POST['username'],
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ];

    $result = register($data);

    if (!$result || empty($result['success'])) {
      http_response_code(400);
      echo json_encode([
        'success' => false,
        'message' => $result['message'] ?? 'Erreur lors de l\'inscription.'
      ]);
      return;
    }

    $user = $result['user'];

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($user['hashed_password'])) {
        unset($user['hashed_password']);
    }

    $_SESSION['user'] = $user;

    echo json_encode(['success' => true, 'user' => $user]);
}
