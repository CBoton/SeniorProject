<?php
require("../../auth/login_check.php"); //Make sure the users is logged in
require_once('../../../variables.php');

if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1){
    $status->result = "ERROR";
    $status->message = "Sorry, you don't have permission to do that.";
    die(json_encode($status));
}

try {
    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $con->prepare("INSERT INTO guides (guide_name, subscription_level, thumbnail, content, date_created, date_last_modified) values (?, ?, ?, ?, now(), now())");
    $stmt->execute([$_POST['guide_name'], $_POST['subscription_level'], $_POST['thumbnail'], $_POST['content']]);

    $guide_id = $con->lastInsertId();

    $status->result = "SUCCESS";
    $status->guide_id = $guide_id;
    die(json_encode($status));

}catch(PDOException $e) {
    $status->result = "ERROR";
    $status->message = "Something went wrong. Please try again later.";
    die(json_encode($status));
}