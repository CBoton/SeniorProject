<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');

try {
    $user_id = intval($_SESSION['user_id']);
    $tags = $_POST['tags'];
    $tags = implode(",",$tags); //Turning a js list into a string list

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //This prepared statement takes the arguments AS IS.
    //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);


    //Get tag filtered guides
    $stmt = $con->prepare("
            SELECT g.guide_id, g.guide_name, g.thumbnail, g.subscription_level, p.plan_name, g.date_last_modified, CASE WHEN fav.guide_id IS NOT NULL THEN true ELSE false END AS fav, group_concat(t.tag) as tags
            FROM guides g
            LEFT JOIN favorites AS fav ON (g.guide_id = fav.guide_id AND fav.user_id = ?)
            LEFT JOIN tags AS t ON (g.guide_id = t.guide_id)
            LEFT JOIN plans AS p ON (g.subscription_level = p.premium_state_id)
            WHERE
            	g.guide_id IN (SELECT guide_id FROM tags WHERE FIND_IN_SET(tag, ?) > 0)
            GROUP BY guide_id
            ORDER BY date_last_modified DESC
        ");
    // Reference 1 https://stackoverflow.com/questions/8343458/mysql-select-distinct-rows-into-a-comma-delimited-list-column
    // Reference 2 https://stackoverflow.com/questions/43481869/aggregated-query-without-group-by
    $stmt->execute([$user_id, $tags]);
    $results_favorites = $stmt->fetchAll();

    die(json_encode($results_favorites));
} catch (PDOException $e) {
    die("Request failed");
}