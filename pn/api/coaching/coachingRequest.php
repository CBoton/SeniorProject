<?php
require("../auth/login_check.php"); //Make sure the users is logged in
require_once('../../variables.php');

try {
  $user_id = intval($_SESSION['user_id']);
  $meeting_topic = $_POST['topic'];
  $preferred_contact = $_POST['contact'];

  $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

  //This prepared statement takes the arguments AS IS.
  //YOU MUST MAKE THEM THE RELEVANT DATA TYPES BEFORE CALLING.
  $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
  $stmt = $con->prepare("
    INSERT INTO appointments 
    SET
    request_date = ?,
    meeting_topic = ?,
    preferred_contact =? ,
    user_id = ?;
  ");
  $stmt->execute([date('Y-m-d'), $meeting_topic, $preferred_contact, $user_id]);
  $result = $stmt->fetchAll();

  die(json_encode($result));
}
catch(PDOException $e)
{
  die("Request failed");
}