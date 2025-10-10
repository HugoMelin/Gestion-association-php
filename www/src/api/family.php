<?php 
require_once 'src/models/family.php';

function familyApi() {
  header('Content-Type: application/json');

  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method){
    case 'GET':
      if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $family = getFamilyById($id);
        if ($family) {
          echo json_encode($family);
        } else {
          http_response_code(404);
          echo json_encode(['error' => 'Family not found']);
        }
      } else {
        $families = getAllFamilies();
        echo json_encode($families);
      }
      break;
    case 'POST':
      if (!isset($_POST['name'], $_POST['adress'], $_POST['phone'], $_POST['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
      }

      $success = postFamily(
        $_POST['name'], 
        $_POST['adress'], 
        $_POST['phone'], 
        $_POST['email'], 
        $_POST['members'] ?? null
      );

      if ($success) {
        http_response_code(201);
        echo json_encode(['message' => 'Family created successfully']);
      } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create family']);
      }
      break;
    case 'PUT':
      if(!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing family ID']);
        return;
      }

      parse_str(file_get_contents('php://input'), $payload);

      $success = putFamily(intval($_GET['id']), $payload);

      if ($success) {
        echo json_encode(['message' => 'Family updated successfully']);
      } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update family']);
      }
      break;
    case 'DELETE':
      if(!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing family ID']);
        return;
      }

      $success = deleteFamily(intval($_GET['id']));

      if ($success) {
        echo json_encode(['message' => 'Family deleted successfully']);
      } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete family']);
      }
      break;
    }
  return;
}