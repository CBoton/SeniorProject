<?php

require("../auth/login_check.php");
session_start();
require_once('../../variables.php');

//Make sure all elements were sent to the API
if (   !isset($_POST['first_name'])
	|| !isset($_POST['last_name'])
	|| !isset($_POST['email'])
	|| !isset($_POST['phone_number'])
	|| !isset($_POST['sex'])
	|| !isset($_POST['birthdate'])
	 ) {
	die("Error: Invalid Parameters");
}

//Save the inputs
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = strtolower($_POST['email']);
$phone_number = $_POST['phone_number'];
$sex = $_POST['sex'];
$birthdate = $_POST['birthdate'];




//Clean email and check if valid
$email = filter_var($email, FILTER_SANITIZE_EMAIL); //Remove illegal characters
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Validate email
	die("Email address is invalid.");
}

//2nd check for email verification
// if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) ) {
//     die("Email address is invalid.");
// }

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
   die('Sorry, the specified age is not old enough.');
}

//Make sure 'first_name' and 'last_name' only includes a-z, A-Z, and spaces.
if( preg_match("/^[a-zA-Z ]*$/u", $first_name) != 1 ){
	die("First name can only contain letters.");
}
if( preg_match("/^[a-zA-Z ]*$/u", $last_name) != 1 ){
	die("Last name can only contain letters.");
}

//Make sure the sex is valid
if($sex != "male" && $sex != "female"){
	die("The gender you specified is invalid.");
}




try {

    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

	$stmt = $con->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, sex = ?, birthdate = ? WHERE user_id = ?");
	$updated = $stmt->execute([$first_name, $last_name, $email, $phone_number, $sex, $birthdate, $_SESSION['user_id']]);
	if(!$updated) {
		die("Oops, something went wrong. Try again later.");
	}

	die('success');

} catch(PDOException $e) {
    // die("ERROR");
  die("Sorry, something went wrong. Try again later.");
  // die( "Failed to add break - " . $e->getMessage());
}
?>