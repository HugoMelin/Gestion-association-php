<?php 
require_once 'src/middleware/db.php';
function login($credentials) {
  $db = Db::getConnexion();

  $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
  $stmt->bindParam(':email', $credentials['email']);
  $stmt->execute();

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($credentials['password'], $user['hashed_password'])) {
    return $user;
  }

  return false;
}