<?php

require("../auth/login_check.php");
require_once('../../variables.php');

try {

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

    $stmt = $con->prepare("SELECT first_name, last_name, email, phone_number, sex, birthdate FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $result = $stmt->fetch();

    die(json_encode($result));

} catch(PDOException $e) {
    die("ERROR");
  // die("Sorry, something went wrong. Try again later.");
  // die( "Failed to add break - " . $e->getMessage());
}
?>