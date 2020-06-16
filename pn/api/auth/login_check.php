<?php

//Include this file in your page in order to make sure that the users is logged in.
	// If they don't have a valid session, it will forward them to the login page.
session_start();
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){ // If not logged in
   header("Location: login.php");
   exit();
}

//Else, do nothing...
?>