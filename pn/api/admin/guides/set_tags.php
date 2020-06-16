<?php
require("../../auth/login_check.php"); //Make sure the users is logged in
require_once('../../../variables.php');

if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1){
    $status->result = "ERROR";
    $status->message = "Sorry, you don't have permission to do that.";
    die(json_encode($status));
}

if(!isset($_POST['guide_id']) || !isset($_POST['tags']) || !is_array($_POST['tags']) ){
    $status->result = "ERROR";
    $status->message = "Invalid parameters.";
    die(json_encode($status));
}

try {
    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    //First, lets remove existing tags
    $stmt = $con->prepare("DELETE FROM tags WHERE guide_id = ?");
    $stmt->execute([$_POST['guide_id']]);

    //Now, add all the tags the user provided
    $tags = $_POST['tags'];
    foreach ($tags as &$tag) {
        $stmt = $con->prepare("INSERT INTO tags (guide_id, tag) values (?, ?)");
        $stmt->execute([$_POST['guide_id'], $tag]);
    }

    $status->result = "SUCCESS";
    $status->message = "The tags were successfully saved.";
    die(json_encode($status));

}catch(PDOException $e) {
    $status->result = "ERROR";
    $status->message = "Something went wrong. Please try again later.";
    die(json_encode($status));
}