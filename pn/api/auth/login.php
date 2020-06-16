<?php
//If already logged in, take them to the home page
session_start();
if(isset($_SESSION['user_id']) || !empty($_SESSION['user_id']) ){
   header("Location: index.php");
   exit();
}

require_once("../../variables.php");

// Make sure both parameters are specified
if(!isset($_POST['username']) || !isset($_POST['password'])	|| $_POST['username'] == "" || $_POST['password'] == "" ){
	die("Please fill in all textboxes");
}

$username = $_POST['username']; //or email
$password = $_POST['password'];

try {
  //Create connection
  $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
   
  //Authenticate user
  $stmt = $con->prepare("SELECT user_id, is_admin, email_verified FROM users WHERE (username = ? OR email = ?) AND password = ?");
  $stmt->execute([ strtolower($_POST['username']), strtolower($_POST['username']), $_POST['password'] ]);
  $data = $stmt->fetch();
  if(!$data){
    die("Invalid username and password combination.");
  }

  //Check that the account is active
  if($data['email_verified'] != 1){
    die("Your account has not been activated. Please check your email for a verification link.");
  }

  //Login is correct, create the session
  $_SESSION['user_id'] = $data['user_id'];
  $_SESSION['is_admin'] = $data['is_admin'];

  die('success');
  
} catch(PDOException $e) {
  die("Sorry, something went wrong. Try again later.");
  // die( "Failed to add break - " . $e->getMessage());
}

?>
