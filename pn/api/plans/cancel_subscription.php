<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('subscription_mgmt_api.php');

//Main script
try{
    if (isset($_POST['sub_id_to_cancel']) && isset($_POST['reason'])) {
        cancel_subscription($_POST['sub_id_to_cancel'],$_POST['reason']);
        reevaluate_user_premium_state_db($_SESSION['user_id']);
        die ('Success');
    } else {
        die('Error: Request failed - POST value "sub_id_to_cancel" or "reason" are not set');
    }
} catch(PDOException $e) {
    die("Request failed");
}