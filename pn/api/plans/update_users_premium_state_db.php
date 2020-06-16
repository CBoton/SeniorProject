<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('subscription_mgmt_api.php');

function update_premium_states_db(){
    $users_subscriptions = get_active_subscriptions_of_user_db($_SESSION['user_id']);
    //Update all the subscriptions
    update_subscription_info_db($users_subscriptions);
    //Once we updated the subscriptions in db, we can now evaluate premium_states for the users
    reevaluate_user_premium_state_db($_SESSION['user_id']);
}

//Main script
try {
    update_premium_states_db();
} catch(PDOException $e) {
    die("Request failed");
}