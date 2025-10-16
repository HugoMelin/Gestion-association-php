<?php 
require_once 'src/middleware/db.php';

function register($data) {
  $db = Db::getConnexion();

  $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
  $stmt->bindParam(':email', $data['email']);
  $stmt->execute();

  if ($stmt->fetch(PDO::FETCH_ASSOC)) {
    return ['success' => false, 'message' => 'Cet email est déjà utilisé.'];
  }

  $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

  $stmt = $db->prepare("INSERT INTO user (email, hashed_password, username) VALUES (:email, :hashed_password, :username)");
  $stmt->bindParam(':email', $data['email']);
  $stmt->bindParam(':hashed_password', $hashedPassword);
  $stmt->bindParam(':username', $data['username']);
  $stmt->execute();

  $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
  $stmt->bindParam(':email', $data['email']);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    return ['success' => false, 'message' => 'Erreur lors de la récupération de l\'utilisateur.'];
  }

  if (isset($user['hashed_password'])) {
    unset($user['hashed_password']);
  }

  return ['success' => true, 'user' => $user];
}
