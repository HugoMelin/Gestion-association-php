<?php
require_once 'src/middleware/db.php';
require_once 'src/models/family.php';
require_once 'src/models/activity.php';

function getAllFamiliesActivities() {
  $db = Db::getConnexion();

  $stmt = $db->query("SELECT fa.id as id, f.name as family_name, a.name as activity_name 
                      FROM family_activity fa 
                      JOIN family f ON fa.id_family = f.id
                      JOIN activity a ON fa.id_activity = a.id");

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFamilyActivityById($id) {
  $db = Db::getConnexion();

  $stmt = $db->prepare("SELECT fa.id as id, f.name as family_name, a.name as activity_name 
                        FROM family_activity fa 
                        JOIN family f ON fa.id_family = f.id
                        JOIN activity a ON fa.id_activity = a.id
                        WHERE fa.id = :id");
  $stmt->execute(['id' => $id]);

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getFamilyActivitiesByFamilyId($familyId) {
  $db = Db::getConnexion();

  $stmt = $db->prepare("SELECT fa.id as id, f.name as family_name, a.name as activity_name 
                        FROM family_activity fa 
                        JOIN family f ON fa.id_family = f.id
                        JOIN activity a ON fa.id_activity = a.id
                        WHERE f.id = :familyId");
  $stmt->execute(['familyId' => $familyId]);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFamiliesActivityByActivityId($activityId) {
  $db = Db::getConnexion();

  $stmt = $db->prepare("SELECT fa.id as id, f.name as family_name, a.name as activity_name 
                        FROM family_activity fa 
                        JOIN family f ON fa.id_family = f.id
                        JOIN activity a ON fa.id_activity = a.id
                        WHERE a.id = :activityId");
  $stmt->execute(['activityId' => $activityId]);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function postFamilyActivity($familyId, $activityId) {
  $db = Db::getConnexion();

  if (!getFamilyById($familyId) || !getActivityById($activityId)) {
    return false;
  }

  $stmt = $db->prepare("INSERT INTO family_activity (id_family, id_activity) VALUES (:familyId, :activityId)");

  return $stmt->execute(['familyId' => $familyId, 'activityId' => $activityId]);
}

function deleteFamilyActivity($id) {
  $db = Db::getConnexion();

  $stmt = $db->prepare("DELETE FROM family_activity WHERE id = :id");

  return $stmt->execute(['id' => $id]);
}
