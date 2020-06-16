<?php
require_once("../auth/login_check.php"); //Make sure the user is logged in
require_once("../../variables.php"); //Get the database connection patameters




try {
    $user_id = intval($_SESSION['user_id']);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $con->prepare("
        SELECT blood_type
        FROM users
        WHERE user_id = ?;
    ");

    $stmt->execute([$user_id]);
    $data = $stmt->fetchAll();


    $blood = $data[0][0];
    $out = '';

    switch ($blood){


        case "A+":
        case "A-":
            $out = "Type A's should choose fruit, vegetables, tofu, seafood, turkey, and whole grains but avoid meat. 
            For weight loss, seafood, vegetables, 
            pineapple, olive oil, and soy are best; dairy, wheat, corn, and kidney beans should be avoided.";
            break;


        case "B+":
        case "B-":
            $out = "Type B's should pick a diverse diet including meat, fruit, dairy, 
            seafood, and grains. To lose weight, type B individuals should choose green vegetables, eggs, liver, 
            and licorice tea but avoid chicken, corn, peanuts, and wheat.";
            break;


        case "AB+":
        case "AB-":
            $out = "Type AB's should eat dairy, tofu, lamb, fish, grains, fruit, and vegetables. 
            For weight loss, tofu, seafood, green vegetables, and kelp are best but chicken, corn, 
            buckwheat, and kidney beans should be avoided.";
            break;


        case "O-":
        case "O+":
            $out = "Type O's should choose high-protein foods and eat lots of meat, vegetables, fish, and fruit but limit grains, beans, 
                    and legumes. To lose weight, seafood, kelp, red meat, 
                   broccoli, spinach, and olive oil are best; wheat, corn, and dairy are to be avoided.";
            break;

        default:
            $out = "Did you know that certain blood types react differently to different foods?
                  We highly recommend you go get blood work done to determine your blood type
                  so our program can help you achieve the best possible results through optimal nutrition";

    }

    die($out);

} catch(PDOException $e) {
    die("Sorry, something went wrong. Try again later.");
    // die( "Failed to add break - " . $e->getMessage());
}

?>