<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');

try {
    $goal_id = intval($_POST['goal_id']);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //This prepared statement takes the arguments AS IS.
    //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $con->prepare("
        DELETE FROM goals
        WHERE 
            goal_id = ?
        LIMIT 1;
    ");
    $stmt->execute([$goal_id]);
}
catch(PDOException $e) {
    die("Request failed");
}