<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OT | Reset Password</title>
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
        function process(){
            if($('#password1').val() != $('#password2').val()){
                //Passwords do not match
                $('#statusMsg').html("Passwords do not match.");
                return;
            }

            //Disable the submit button
            $('#submitBtn').prop('disabled', true);

            //Send the form data
            $.ajax({
                type: "POST",
                dataType: 'text',
                url: 'api/auth/reset_pw_with_token.php',
                data: {
                    email: $('#email').val(),
                    pw_token: $('#pw_token').val(),
                    new_password: $('#password1').val()
                },
                success: function(data, status){
                    if(data == "success"){
                        window.location.replace("index.php");
                    }else{
                        $('#statusMsg').html(data);
                        $('#submitBtn').prop('disabled', false);
                    }
                }
            });
        }

    </script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <b>Organic</b>Transformations
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg" id="statusMsg">Reset Your Password<br>Please enter your new password.</p>

            <div class="input-group mb-3">
                <input id="password1" type="password" class="form-control" placeholder="New Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input id="password2" type="password" class="form-control" placeholder="Confirm New Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <input id="email" type="hidden" class="form-control" value="<?php echo($_GET['email']); ?>">

            <input id="pw_token" type="hidden" class="form-control" value="<?php echo($_GET['pw_token']); ?>">

            <div class="row">
                <div class="col-4">
                    <button id="submitBtn" onclick="process()" class="btn btn-primary btn-block">Submit</button>
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.form-box -->
    </div> <!-- /.card -->
</div> <!-- /.register-box -->

<!-- jQuery -->
<script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
