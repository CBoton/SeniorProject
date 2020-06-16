<?php

require_once('../../variables.php');


if (   !isset($_POST['username'])
	|| !isset($_POST['email'])
	|| !isset($_POST['password'])
	|| !isset($_POST['confirm_password'])
	|| !isset($_POST['phone_number'])
	|| !isset($_POST['birthdate'])
	|| !isset($_POST['first_name'])
	|| !isset($_POST['last_name'])
	|| !isset($_POST['terms_agreed'])
	 ) {
	die("Error: Invalid Parameters");
}

//Sanitize & Validate All Inputs
$username = $_POST['username'];
$email = strtolower($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$phone_number = $_POST['phone_number'];
$birthdate = $_POST['birthdate'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$terms_agreed = $_POST['terms_agreed'];

//Make sure 'username' only includes a-z, A-Z, numbers, and dashes.
if( preg_match("/^[a-zA-Z0-9]*$/u", $username) != 1 ){
	die("Username can only contain letters and numbers.");
}

//Clean email and check if valid
$email = filter_var($email, FILTER_SANITIZE_EMAIL); //Remove illegal characters
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Validate email
	die("Email address is invalid.");
}

//2nd check for email verification
if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
    die("Email address is invalid.");
}

//Make sure the password is the correct length
if( !(strlen($password) > 9 || strlen($password) > 50) ){
	die("That password is not long enough.");
}

//Make sure that the password fields match
if( $password != $confirm_password ){
	die("Passwords do not match.");
}

//Make sure the phone number is 10 digits
$phone_number = preg_replace('/[^0-9]/', '', $phone_number);
if(strlen($phone_number) != 10) {
	die("Phone number is invalid.");
}

//Check that the birthdate is valid
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
if( !validateDate($birthdate) ){
	die("Date of birth is invalid.");
}

//Check their age requirement
if (time() < strtotime('+18 years', strtotime($birthdate))) {
   die('Sorry, you are not old enough to sign up.');
}

//Make sure 'first_name' and 'last_name' only includes a-z, A-Z, and spaces.
if( preg_match("/^[a-zA-Z ]*$/u", $first_name) != 1 ){
	die("First name can only contain letters.");
}
if( preg_match("/^[a-zA-Z ]*$/u", $last_name) != 1 ){
	die("Last name can only contain letters.");
}

//Make sure they agreed to the terms and conditions
if( $terms_agreed != true ){
	die("You must agree to the terms and conditions");
}

try {
	
	//Create connection
	$con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	
	//Check if that USERNAME exists
	$stmt = $con->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
	$stmt->execute([$username, $email]);
    if($stmt->fetchColumn()){
    	die("That username or email already exists.");
    }

    $email_token = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.

    //Create the user
    $stmt = $con->prepare("INSERT INTO users (username, email, password, phone_number, birthdate, first_name, last_name, email_verified, join_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
	$success = $stmt->execute([ $username, strtolower($email), $password, $phone_number, $birthdate, $first_name, $last_name, $email_token ]);

	if(  $success  ){
        $email = strtolower($email);

        $to      = $email; // Send email to our user
        $subject = 'Organic Transformations Registration | Verification'; // Give the email a subject
        $message = '

        Thanks for signing up!
        Your account has been created. You can login with your credentials after you have activated your account by clicking the url below.

        Please click this link to activate your account:
        http://www.organictransformations.com/verify.php?email='.$email.'&email_token='.$email_token.'

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