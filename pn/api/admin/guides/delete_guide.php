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
    //Find and delete the thumbnail
    $stmt = $con->prepare("SELECT thumbnail FROM guides WHERE guide_id = ?");
    $stmt->execute([$_POST['guide_id']]);
    $thumbnail = $stmt->fetch();
    if($thumbnail['thumbnail'] != "default_thumb.png")
        unlink("../../../res/imgs/" . $thumbnail['thumbnail']);
    //Delete the guide
    $stmt = $con->prepare("DELETE FROM guides WHERE guide_id = ?");
    $stmt->execute([$_POST['guide_id']]);
    //Delete the tags assocaited with that guide
    $stmt = $con->prepare("DELETE FROM tags WHERE guide_id = ?");
    $stmt->execute([$_POST['guide_id']]);

    $status->result = "SUCCESS";
    $status->message = "The guide has been deleted.";
    die(json_encode($status));

}catch(PDOException $e) {
    $status->result = "ERROR";
    $status->message = "Something went wrong. Please try again later.";
    die(json_encode($status));
}