<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('subscription_mgmt_api.php');

//Sends and records a users newly created subscription ID from PayPal to db
try {
    if(!isset($_POST['subscription_id'])){
        die('Error: No Subscription is set');
    }

    $user_id = intval($_SESSION['user_id']);
    $subscription_id = $_POST['subscription_id'];

    send_subscription_to_db($user_id,$subscription_id);
    //Now that it has been sent, update
    $users_subscriptions = get_active_subscriptions_of_user_db($_SESSION['user_id']);
    //Update all the subscriptions
    update_subscription_info_db($users_subscriptions);
    //Once we updated the subscriptions in db, we can now evaluate premium_states for the users
    reevaluate_user_premium_state_db($_SESSION['user_id']);

    die();
} catch(PDOException $e) {
    die("Request failed");
}