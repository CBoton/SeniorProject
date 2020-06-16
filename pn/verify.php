<?php
require("variables.php");

if (!isset($_GET['email_token']) || !isset($_GET['email'])) {
    $status = 'Invalid token or email address';
}else {
    try {
        //Create connection
        $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

        //Check if that EMAIL/EMAIL_TOKEN pair exists
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND email_token = ? LIMIT 1");
        $stmt->execute([$_GET['email'], $_GET['email_token']]);
        $result = $stmt->fetchColumn();
        if(!$result) {
            $status = 'The email or token you specified is invalid.';
        }else {
            //update email_verified parameter
            $stmt = $con->prepare("UPDATE users SET email_verified=1 WHERE email = ? AND email_token = ?");
            $updated = $stmt->execute([$_GET['email'], $_GET['email_token']]);
            if($updated) {
                $status = 'Your email address has been verified!'.'</br><a href="login.php">Click here</a> to login.';
            }else {
                $status = 'Opps, something went wrong =(';
            }
        }

        //Create the user
        $stmt = $con->prepare("INSERT INTO users (username, email, password, phone_number, birthdate, first_name, last_name, email_verified, join_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $success = $stmt->execute([ $username, strtolower($email), $password, $phone_number, $birthdate, $first_name, $last_name, $email_token ]);

    } catch(PDOException $e) {
        die("Failed: Something went wrong..");
        // die( "Failed to add break - " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OT | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script type="text/javascript">

  </script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <b>Organic</b>Transformations
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg" id="statusMsg"> <?php echo $status; ?> </p>
      </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>