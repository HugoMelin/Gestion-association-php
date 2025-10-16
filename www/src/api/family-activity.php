<?php 
require_once 'src/models/family-activity.php';

function familyActivityApi() {
  header ('Content-Type: application/json');

  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {
    case 'GET':
      if (isset($_GET['id'])) {
        $familyActivity = getFamilyActivityById(intval($_GET['id']));
        if ($familyActivity) {
          echo json_encode($familyActivity);
        } else {
          http_response_code(404);
          echo json_encode(['error' => 'Family-Activity association not found']);
        }
      } elseif (isset($_GET['familyId'])) {
        $familyActivities = getFamilyActivitiesByFamilyId(intval($_GET['familyId']));
        echo json_encode($familyActivities);
      } elseif (isset($_GET['activityId'])) {
        $familiesActivities = getFamiliesActivityByActivityId(intval($_GET['activityId']));
        echo json_encode($familiesActivities);
      } else {
        $familiesActivities = getAllFamiliesActivities();
        echo json_encode($familiesActivities);
      }
      break;

    case 'POST':
      if (!isset($_POST['familyId'], $_POST['activityId'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
      }

      $success = postFamilyActivity(
        $_POST['familyId'], 
        $_POST['activityId']
      );

      if ($success) {
        http_response_code(201);
        echo json_encode(['message' => 'Family-Activity association created successfully']);
      } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create Family-Activity association']);
      }
      break;

    case 'DELETE':
      if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing Family-Activity association ID']);
        return;
      }

      $success = deleteFamilyActivity(intval($_GET['id']));

      if ($success) {
        echo json_encode(['message' => 'Family-Activity association deleted successfully']);
      } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete Family-Activity association']);
      }
      break;

    default:
      http_response_code(405);
      echo json_encode(['error' => 'Method not allowed']);
      break;
  }
}