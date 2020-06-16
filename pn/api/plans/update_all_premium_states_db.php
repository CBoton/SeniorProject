<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('subscription_mgmt_api.php');

function update_premium_states_db(){
    $all_subscriptions = get_all_active_subscriptions_db();
    //Update all the subscriptions
    update_subscription_info_db($all_subscriptions);
    //Once we updated the subscriptions in db, we can now evaluate premium_states for the users
    reevaluate_all_premium_states_db();
}

//Main script
try {
    update_premium_states_db();
} catch(PDOException $e) {
    die("Request failed");
}