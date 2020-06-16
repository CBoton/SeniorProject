<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');

try {
    $user_id = intval($_SESSION['user_id']);
    $guide_id = intval($_POST['guide_id']);
    $favorited = $_POST['favorited'];


//    die((($favorited == 1) ? "Removing" : "Adding") . " favorite for " . $user_id . ": " . $guide_id);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //This prepared statement takes the arguments AS IS.
    //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

    if($favorited == 0) {
        //Adding to favorites
        $stmt = $con->prepare("
        INSERT INTO favorites SET 
        guide_id = ?, 
        user_id = ?;
        ");
    }
    else {
        //Removing from favorites
        $stmt = $con->prepare("
        DELETE FROM favorites WHERE 
        guide_id = ? AND 
        user_id = ?;
        ");
    }
    $stmt->execute([$guide_id, $user_id]);
}
catch(PDOException $e) {
    die("Request failed");
}