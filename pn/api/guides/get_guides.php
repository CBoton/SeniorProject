<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');

try {
    $user_id = intval($_SESSION['user_id']);
    $tag = $_POST['tag'];
    $number = intval($_POST['number']);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //This prepared statement takes the arguments AS IS.
    //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

    //Get favorites
    if($_POST['favorite'] == 1) {
        $stmt = $con->prepare("
            SELECT guide_id, guide_name, thumbnail, subscription_level, date_last_modified
            FROM guides
            WHERE 
                guide_id IN (SELECT guide_id FROM tags WHERE tag = ?) AND
                guide_id IN (SELECT guide_id FROM favorites WHERE user_id = ?)
            ORDER BY date_last_modified DESC
            LIMIT ?
        ");
        $stmt->execute([$tag, $user_id, $number]);
        $results_favorites = $stmt->fetchAll();

        die(json_encode($results_favorites));
    }

    //Get all
    $stmt = $con->prepare("
        SELECT guide_id, guide_name, thumbnail, subscription_level, date_last_modified
        FROM guides WHERE guide_id IN (SELECT guide_id FROM tags WHERE tag = ?)
        ORDER BY date_last_modified DESC
        LIMIT ?
    ");
    $stmt->execute([$tag, $number]);
    $results_all = $stmt->fetchAll();

    die(json_encode($results_all));
}

catch(PDOException $e) {
    die("Request failed");
}