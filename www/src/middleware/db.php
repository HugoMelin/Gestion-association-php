<?php 
class Db extends PDO {
  private static ?PDO $instance = null;
  
  public static function getConnexion(): ?PDO {
    if (self::$instance === null) {
      $host = 'mysql';
      $dbname = 'db';
      $username = 'user';
      $password = 'password';
      $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

      try {
        self::$instance = new PDO($dsn, $username, $password);
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
      }
    }
    return self::$instance;
  }
}