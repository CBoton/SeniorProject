<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');

try {
    $user_id = intval($_SESSION['user_id']);
    if(isset($_POST['search_terms'])) {
        $search_terms = $_POST['search_terms']; //Retrieve param, a singular string with search terms (sample: "apple car")
    } else $search_terms = "";
    $search_terms = explode(" ", $search_terms); //Turn the search string into a list by spaces

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //This prepared statement takes the arguments AS IS.
    //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

    //Reference 1: https://stackoverflow.com/questions/16498640/pdo-prepare-with-question-marks-doesnt-work-with-numbers

    //Setup of query
    $sql_query = "
        SELECT g.guide_id, g.guide_name, g.thumbnail, g.subscription_level, g.date_last_modified, p.plan_name, CASE WHEN fav.guide_id IS NOT NULL THEN true ELSE false END AS fav, group_concat(t.tag) as tags
        FROM guides g
        LEFT JOIN favorites AS fav ON (g.guide_id = fav.guide_id AND fav.user_id = ?)
        LEFT JOIN tags AS t ON (g.guide_id = t.guide_id)
        LEFT JOIN plans AS p ON (g.subscription_level = p.premium_state_id)
        WHERE
            t.tag LIKE ? OR g.guide_name LIKE ? 
        ";

    //Adding search ('LIKE') statements for each search term after the first
    for($i = 1; $i < sizeof($search_terms); ++$i)
        $sql_query = $sql_query.
            "OR t.tag LIKE ? OR g.guide_name LIKE ? ";


    //Ending of query
    $sql_query = $sql_query.
            "GROUP BY guide_id 
            ORDER BY date_last_modified DESC";


    //Get tag filtered guides
    $stmt = $con->prepare($sql_query);

    //Bind user_id
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    for($i = 0; $i < sizeof($search_terms); ++$i) {
        $stmt->bindValue($i+2, "%{$search_terms[$i]}%", PDO::PARAM_STR);
        $stmt->bindValue($i+3, "%{$search_terms[$i]}%", PDO::PARAM_STR);
    }
    $stmt->execute();
    $results = $stmt->fetchAll();

    die(json_encode($results));
//    die (json_encode($results));
} catch (PDOException $e) {
    die("Request failed");
}