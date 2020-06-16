<?php
require_once("login_check.php");

session_start();

require_once("../../variables.php");

if(!isset($_POST['old_password']) || !isset($_POST['new_password'])){
	die("Invalid Parameters");
}

//Make sure the password is the correct length
if( !(strlen($_POST['new_password']) > 9) || strlen($_POST['new_password']) > 50){
  die("That new password is too short or to long.");
}

try {
  //Create connection
  $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
  //Authenticate user
  $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? AND password = ?");
  $stmt->execute([ $_SESSION['user_id'], $_POST['old_password'] ]);
  $data = $stmt->fetch();
  if(!$data){
    die("Incorrect Password! Please try again.");
  }


  //The old password matches, great! Lets set their new password.
  $stmt = $con->prepare("UPDATE users SET password = ? WHERE user_id = ?");
  $updated = $stmt->execute([$_POST['new_password'], $_SESSION['user_id']]);
  if(!$updated) {
    die("Oops, something went wrong. Try again later.");
  }

  die('success');
  
} catch(PDOException $e) {
  die("Sorry, something went wrong. Try again later.");
  // die( "Failed to add break - " . $e->getMessage());
}

?>