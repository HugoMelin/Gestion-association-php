<?php
require_once 'src/models/activity.php';

function activityApi() {
    header ('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method){
        case 'GET':
            if (isset($_GET['id'])) {
                $activity = getActivityById(intval($_GET['id']));
                if ($activity) {
                    echo json_encode($activity);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Activity not found']);
                }
            } else {
                $activities = getAllActivities();
                echo json_encode($activities);
            }
            break;

        case 'POST':
            if (!isset($_POST['name'], $_POST['description'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
            }

            $success = postActivity(
                $_POST['name'], 
                $_POST['description'], 
                $_POST['capacity'] ?? 0, 
            );

            if ($success) {
                http_response_code(201);
                echo json_encode(['message' => 'Activity created successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create activity']);
            }
            break;

        case 'PUT':
            if(!isset($_GET['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing activity ID']);
                return;
            }

            parse_str(file_get_contents('php://input'), $payload);

            $success = putActivity(intval($_GET['id']), $payload);

            if ($success) {
                echo json_encode(['message' => 'Activity updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update activity']);
            }
            break;
        case 'DELETE':
            if(!isset($_GET['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing activity ID']);
                return;
            }

            $success = deleteActivity(intval($_GET['id']));

            if ($success) {
                echo json_encode(['message' => 'Activity deleted successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete activity']);
            }
            break;
    }

    return;
}