<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('subscription_mgmt_api.php');


//FUNCTION: This function trims the PayPal response to essentials, PayPal is returning more personal info than I would like
function trimResponse($response){
    unset($response['subscriber']);
    unset($response['shipping_amount']);
    unset($response['links']);
    return $response;
}

try {
    //Main script
    if (isset($_POST['subscription_id'])) {
        $sub_id = $_POST['subscription_id'];
        $result = get_sub_details_pp($sub_id, $pp_token);
        if ($result == false) { // If we fail to retrieve info we probably have a old access token, we try to update
            gen_new_token();
            $result = get_sub_details_pp($sub_id, $pp_token);
            if ($result == false) {
                die("Error: Failed to get PayPal response with new access token");
            }
        }
        die(json_encode(trimResponse($result)));
    } else {
        die('Error: Request failed - POST value "subscription_id" not set');
    }
} catch(PDOException $e) {
    die("Request failed");
}