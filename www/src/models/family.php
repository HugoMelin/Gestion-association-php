<?php
require_once 'src/middleware/db.php';

function getAllFamilies() {
    $db = Db::getConnexion();
    $stmt = $db->query("SELECT * FROM family");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFamilyById($id) {
    $db = Db::getConnexion();
    $stmt = $db->prepare("SELECT * FROM family WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function postFamily($name, $adress, $phone, $email, int $members=null) {
    $db = Db::getConnexion();
    $stmt = $db->prepare("INSERT INTO family (name, adress, phone, email, members) VALUES (:name, :adress, :phone, :email, :members)");
    return $stmt->execute(['name' => $name, 'adress' => $adress, 'phone' => $phone, 'email' => $email, 'members' => $members]);
}

function putFamily($id, $fields) {
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

    $sql  = 'UPDATE family SET ' . implode(', ', $setParts) . ' WHERE id = :id';
    $stmt = $db->prepare($sql);

    return $stmt->execute($params);
}

function deleteFamily($id) {
    $db = Db::getConnexion();
    $stmt = $db->prepare("DELETE FROM family WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}