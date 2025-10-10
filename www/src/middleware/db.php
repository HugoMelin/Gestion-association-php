<?php 
class Db extends PDO {
  private $host = 'mysql';
  private $db_name = 'db';
  private $username = 'user';
  private $password = 'password';

  function __construct() {
    $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=utf8mb4";
    parent::__construct($dsn, $this->username, $this->password);
    $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
}