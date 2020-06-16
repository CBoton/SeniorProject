<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');
try {
    $user_id = intval($_SESSION['user_id']);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //This prepared statement takes the arguments AS IS.
    //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $con->prepare("
        SELECT blood_type, body_type, plan_weight, target_fat, sex, desired_outcome, current_fat, activity_lvl, timeline
        FROM users
        WHERE user_id = ?;
    ");
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll();


    die(json_encode($result));
} catch(PDOException $e) {
    die("Request failed");
}