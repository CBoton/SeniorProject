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

    $stmt = $con->prepare("UPDATE guides SET date_last_modified = now(), guide_name = ?, subscription_level = ?, content = ?, thumbnail = ? WHERE guide_id = ?");
    $stmt->execute([ $_POST['guide_name'], $_POST['subscription_level'], $_POST['content'], $_POST['thumbnail'], $_POST['guide_id'] ]);
    $updated = $stmt->rowCount();

    if(!$updated){
        $status->result = "ERROR";
        $status->message = 'Guide was not updated. Maybe nothing was changed?';
        die(json_encode($status));
    }else{
        $status->result = "SUCCESS";
        $status->message = 'Guide was updated.';
        die(json_encode($status));
    }

}catch(PDOException $e) {
    $status->result = "ERROR";
    $status->message = "Something went wrong. Please try again later.";
    die(json_encode($status));
}