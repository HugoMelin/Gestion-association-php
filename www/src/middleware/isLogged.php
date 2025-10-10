<?php
function is_logged() {
  if (!isset($_SESSION)) {
    session_start();
  }

  return isset($_SESSION['user']);
}