<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');
try {
    $user_id = intval($_SESSION['user_id']);
    $blood_type = $_POST['blood_type'];
    $body_type = $_POST['body_type'];
    $current_weight = intval($_POST['weight']);
    $activity_level = intval($_POST['activity_level']);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //This prepared statement takes the arguments AS IS.
    //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $con->prepare("
        UPDATE users
        SET 
            blood_type = ?,
            body_type = ?,
            current_weight = ?,
            activity_lvl = ?
        WHERE user_id = ?;
    ");
    $stmt->execute([$blood_type, $body_type, $current_weight, $activity_level, $user_id]);
} catch(PDOException $e) {
    die("Request failed");
}