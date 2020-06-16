<?php

require_once('../../variables.php');

$apt_id = $_POST['apt_id'];

try {
    //Create connection
    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);


    // Delete counseling request from database
    $stmt = $con->prepare("DELETE FROM appointments WHERE appointment_id = ?");
    $success = $stmt->execute([ $apt_id ]);

    if(  $success  ){
        die("success");
    }else{
        die("Something went wrong. Please try again later.");
    }

} catch(PDOException $e) {
    die("Failed: Something went wrong..");
}

?>


