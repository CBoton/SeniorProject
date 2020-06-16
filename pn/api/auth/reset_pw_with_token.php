<?php

require_once('../../variables.php');

$email = strtolower($_POST['email']);
$pw_token = $_POST['pw_token'];
$new_password = $_POST['new_password'];

//check if valid parameters
if(!isset($_POST['email']) || ($_POST['pw_token']) || !isset($_POST['new_password'])){
    die("Invalid Parameters");
}

//Clean email and check if valid
$email = filter_var($email, FILTER_SANITIZE_EMAIL); //Remove illegal characters
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Validate email
    die("Email address is invalid.");
}

//2nd check for email verification
if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
    die("Email address is invalid.");
}

//Make sure the password is the correct length
if( !(strlen($_POST['new_password']) > 9) || strlen($_POST['new_password']) > 50){
    die("That new password is too short or to long.");
}

try {
    //Create connection
    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //Check if that EMAIL/PW_TOKEN pair exists
    $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND pw_token = ? LIMIT 1");
    $stmt->execute([$email, $pw_token]);
    $result = $stmt->fetchColumn();
    if(!$result){
        die("The email or token you specified is invalid.");
    }

    //The pw token matches with the email, great! Lets set their new password.
    $stmt = $con->prepare("UPDATE users SET password = ? WHERE email = ?");
    $updated = $stmt->execute([$new_password, $email]);
    if(!$updated) {
        die("Oops, something went wrong. Try again later.");
    }

    //Clear pw_token field
    $stmt = $con->prepare("UPDATE users SET pw_token = ? WHERE email = ?");
    $updated = $stmt->execute([null, $email]);

    die('success');

} catch(PDOException $e) {
    die("Sorry, something went wrong. Try again later.");
    // die( "Failed to add break - " . $e->getMessage());
}

?>