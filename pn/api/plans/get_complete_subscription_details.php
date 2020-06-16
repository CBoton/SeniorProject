<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('subscription_mgmt_api.php');


//FUNCTION: This function trims the PayPal response to essentials, PayPal is returning more personal info than I would like
function trimResponse($response){
    unset($response['subscriber']['shipping_address']);
    unset($response['shipping_amount']);
    unset($response['links']);
    return $response;
}

try {
    //Main script
    if (isset($_POST['subscription_id'])) {
        $result = get_complete_subscription_details($_POST['subscription_id']);
        die(json_encode(trimResponse($result)));
    } else {
        die('Error: Request failed - POST value "subscription_id" not set');
    }
} catch(PDOException $e) {
    die("Request failed");
}