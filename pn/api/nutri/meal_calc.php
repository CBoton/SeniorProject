<?php
require_once("../auth/login_check.php"); //Make sure the user is logged in
require_once("../../variables.php"); //Get the database connection patameters




try {
    $user_id = intval($_SESSION['user_id']);

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $con->prepare("
        SELECT blood_type, body_type, target_fat, plan_weight, sex, desired_outcome, current_fat , activity_lvl, timeline
        FROM users
        WHERE user_id = ?;
    ");

    $stmt->execute([$user_id]);
    $data = $stmt->fetchAll();



    //Do calculations here
    $blood_type = $data[0][0];
    $body_type = $data[0][1];
    $target_fat = $data[0][2];
    $plan_weight = $data[0][3];
    $sex = $data[0][4];
    $desired_outcome = $data[0][5];
    $current_fat = $data[0][6];
    $activity_lvl = $data[0][7];
    $timeline = $data[0][8];



    $protein = (int)(($plan_weight - ($plan_weight * ($current_fat / 100))) /2)/ 5;
    $starch1 = 0;
    $starch2 = 0;
    $starch3 = 0;
    $starch4 = 0;
    $starch5 = 0;
    $veg = 3;
    $fruit1 = 10;
    $fruit2 = 0;
    $fruit3 = 0;
    $fruit4 = 0;
    $fruit5 = 0;
    $fat = 0;



    if($desired_outcome = "Burn fat/lose weight"){


        if($activity_lvl == 0){
            $fat = 85/5;
            $fruit2 = 5;
            $fruit5 = 5;}
        elseif($activity_lvl == 1){
            $fat = 95/5;
            $fruit2 = 5;
            $fruit5 = 10;}
        else{$fat = 105/5;
             $fruit2 = 10;
             $fruit4 =5;
             $fruit5 = 5;}

        if($body_type == "Ectomorph" && $sex == "Male" && $plan_weight < 160){
            $veg = 2;
        }
    }

    else if($desired_outcome = "Build muscle/bulk up"){
        if($activity_lvl == 0){
            $fat = 15;
            $fruit2 = 5;
            $fruit5 = 5;
            $starch1 = 20;
            $starch2 = 20;
            $starch3 = 10;
            $starch4 = 10;
            $starch5 = 10;
        }
        elseif($activity_lvl == 1){
            $fat = 15;
            $fruit2 = 5;
            $fruit5 = 10;
            $starch1 = 25;
            $starch2 = 25;
            $starch3 = 15;
            $starch4 = 15;
            $starch5 = 15;
        }
        else{$fat = 15;
            $fruit2 = 10;
            $fruit4 =5;
            $fruit5 = 5;
            $starch1 = 30;
            $starch2 = 30;
            $starch3 = 15;
            $starch4 = 15;
            $starch5 = 15;
        }

        if($body_type == "Ectomorph" && $sex == "Male" && $plan_weight < 160){
            $veg = 2;
        }

    }

    $meals = [
        ["Meal"=>"1", "Protein"=>$protein, "Starch"=>$starch1, "Vegetables"=>$veg, "Fruits"=>$fruit1, "Fats"=>$fat],
        ["Meal"=>"2", "Protein"=>$protein, "Starch"=>$starch2, "Vegetables"=>$veg, "Fruits"=>$fruit2, "Fats"=>$fat],
        ["Meal"=>"3", "Protein"=>$protein, "Starch"=>$starch3, "Vegetables"=>$veg, "Fruits"=>$fruit3, "Fats"=>$fat],
        ["Meal"=>"4", "Protein"=>$protein, "Starch"=>$starch4, "Vegetables"=>$veg, "Fruits"=>$fruit4, "Fats"=>$fat],
        ["Meal"=>"5", "Protein"=>$protein, "Starch"=>$starch5, "Vegetables"=>$veg, "Fruits"=>$fruit5, "Fats"=>$fat]
    ];



die(json_encode($meals));





} catch(PDOException $e) {
    die("Sorry, something went wrong. Try again later.");
    // die( "Failed to add break - " . $e->getMessage());
}

?>