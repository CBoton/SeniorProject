<?php
require("variables.php");

try {
    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    $stmt = $con->prepare("
        SELECT p.plan_name FROM plans p
        LEFT JOIN guides g ON (g.guide_id = ?)
        WHERE p.premium_state_id = g.subscription_level;
    ");
    $stmt->execute([$guide_id]);
    $data = $stmt->fetch();
}
catch(PDOException $e) {
    die("Guide check error");
}
$tier = $data['plan_name'];
if($tier == null) header("Location: index.php?invalid_guide=1");
require("plan_check.php");