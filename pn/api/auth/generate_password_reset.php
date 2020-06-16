<?php

require_once('../../variables.php');

$email = strtolower($_POST['email']);

//Clean email and check if valid
$email = filter_var($email, FILTER_SANITIZE_EMAIL); //Remove illegal characters
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Validate email
    die("Email address is invalid.<br>Please enter your email address.");
}

//2nd check for email verification
if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
    die("Email address is invalid. Please enter your email address.");
}

try {
    //Create connection
    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    // Generate random 32 character hash and assign it to a local variable
    $pw_token = md5( rand(0,1000) );

    // Insert pw token into db
    $stmt = $con->prepare("UPDATE users SET pw_token = ? WHERE email = ?");
    $success = $stmt->execute([ $pw_token, $email ]);

    if(  $success  ){
        //send password reset email
        $to      = $email; // Send email to our user
        $subject = 'Organic Transformations | Password Reset'; // Give the email a subject
        $message = '
        
                We have received a request to change your password. If you have initiated this request, please follow the instructions below. If not, please disregard this email.
        
                Please click this link to change your password:
                http://www.organictransformations.com/password_reset.php?email='.$email.'&pw_token='.$pw_token.'
        
                '; // Our message above including the link

        $headers = 'From:noreply@organictransformations.com' . "\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email
        die("success");
    }else{
        die("Something went wrong. Please try again later.");
    }

} catch(PDOException $e) {
    die("Failed: Something went wrong..");
    // die( "Failed to add break - " . $e->getMessage());
}



?>


