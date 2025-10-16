<?php
require_once 'src/middleware/db.php';

function getAllActivities() {
    $db = Db::getConnexion();
    $stmt = $db->query("SELECT * FROM activity");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getActivityById($id) {
    $db = Db::getConnexion();
    $stmt = $db->prepare("SELECT * FROM activity WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function postActivity($name, $description, int $capacity = 0) {
    $db = Db::getConnexion();
    $stmt = $db->prepare("INSERT INTO activity (name, description, capacity) VALUES (:name, :description, :capacity)");
    return $stmt->execute([
        'name' => $name, 
        'description' => $description, 
        'capacity' => $capacity, 
    ]);
}

function putActivity($id, $fields) {
    $db = Db::getConnexion();

    $setParts = [];
    $params   = ['id' => $id];

    foreach ($fields as $column => $value) {
        if ($value !== null) {
            $setParts[]       = "$column = :$column";
            $params[$column]  = $value;
        }
    }

    if (!$setParts) {
        return false;
    }

    $sql  = 'UPDATE activity SET ' . implode(', ', $setParts) . ' WHERE id = :id';
    $stmt = $db->prepare($sql);

    return $stmt->execute($params);
}

function deleteActivity($id) {
    $db = Db::getConnexion();
    $stmt = $db->prepare("DELETE FROM activity WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}