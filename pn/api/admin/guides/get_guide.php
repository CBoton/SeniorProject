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
    $stmt = $con->prepare("SELECT * FROM guides WHERE guide_id = ?");
    $stmt->execute([$_POST['guide_id']]);

    $data = $stmt->fetch();

    if(!$data){
        $status->result = "ERROR";
        $status->message = "That guide does not exist.";
        die(json_encode($status));  
    }else{
        $status->result = "SUCCESS";
        $status->guide_data = $data;
        die(json_encode($status));
    }


}catch(PDOException $e) {
    $status->result = "ERROR";
    $status->message = "Something went wrong. Please try again later.";
    die(json_encode($status));
}