<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('subscription_mgmt_api.php');

//Main script
try{
    $user_id = $_SESSION['user_id'];
    $user_subscriptions = get_active_subscriptions_of_user_db($user_id);
    die(json_encode($user_subscriptions));
} catch(PDOException $e) {
    die("Request failed");
}