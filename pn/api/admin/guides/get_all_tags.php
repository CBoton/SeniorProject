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
    $stmt = $con->prepare("SELECT tag FROM tags");
    $stmt->execute([]);

    $tags = $stmt->fetchAll();

    $output = [];
    foreach ($tags as &$tag) {
        if( !in_array($tag[0], $output) ){
            array_push($output, $tag[0]);
        }
    }

    $status->result = "SUCCESS";
    $status->data = $output;
    die(json_encode($status));

}catch(PDOException $e) {
    $status->result = "ERROR";
    $status->message = "Something went wrong when getting a list of tags. Please try again later.";
    die(json_encode($status));
}