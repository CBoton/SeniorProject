<?php
require_once("../auth/login_check.php"); //Make sure the user is logged in
require_once("../../variables.php"); //Get the database connection patameters




try {
    $user_id = intval($_SESSION['user_id']);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $con->prepare("
        SELECT has_meal_plan
        FROM users
        WHERE user_id = ?;
    ");

    $stmt->execute([$user_id]);
    $data = $stmt->fetchAll();
    $has_plan = $data[0][0];
    $site = '';
    if ($has_plan == 1)
    {
        $site = "nutrition_plan.php";
    }
    else $site = "get_nutrition.php";
    var_dump($site);

die($site);

} catch(PDOException $e) {
    die("Sorry, something went wrong. Try again later.");
    // die( "Failed to add break - " . $e->getMessage());
}

?>