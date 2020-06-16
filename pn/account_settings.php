<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Account Settings"; //Set the browser title
$highlight = "none"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>

<head>

  <!-- SweetAlert -->
  <link rel="stylesheet" href="AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <script src="AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>


  <script type="text/javascript">
    $( document ).ready(function() {
      refresh();
    });


    function refresh(){
      $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: 'api/account_settings/get_settings.php',
        success: function(data, status){
          if(data != "ERROR"){
            $('#first_name').val(data['first_name']);
            $('#last_name').val(data['last_name']);
            $('#email').val(data['email']);
            //TODO : Format phone_number
            $('#phone_number').val(data['phone_number']);
            if(data['sex'] == "male" || data['sex'] == "female"){
              $('#sex').val(data['sex']);
            }
            $('#birthdate').val(data['birthdate']);
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'This page failed to load properly.. Please try again later.'
            });
          }
        }
      });
    }


    function changePassword(){
      var old_password = $('#password').val();
      if($('#new_password1').val() != $('#new_password2').val()){
        //Passwords do not match
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Those passwords do not match!'
        });
        return;
      }
      var new_password = $('#new_password1').val();
      $('#changePasswordBtn').attr("disabled", true);
      $.ajax({
        type: "POST",
        data: {
          old_password: old_password,
          new_password: new_password
        },
        url: 'api/auth/change_password.php',
        success: function(data, status){
          $('#changePasswordBtn').attr("disabled", false);
          if(data == "success"){
            $('#old_password').val("");
            $('#new_password1').val("");
            $('#new_password2').val("");
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Your password has been updated.'
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data
            });
          }
        }
      });      
    }


    function saveSettings(){
      $('#saveSettingsBtn').attr("disabled", true);
      $.ajax({
        type: "POST",
        data: {
          first_name: $("#first_name").val(),
          last_name: $("#last_name").val(),
          email: $("#email").val(),
          phone_number: $("#phone_number").val(),
          sex: $("#sex").val(),
          birthdate: $("#birthdate").val()
        },
        url: 'api/account_settings/set_settings.php',
        success: function(data, status){
          $('#saveSettingsBtn').attr("disabled", false);
          if(data == "success"){
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Your account settings have been updated.'
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data
            });
          }
        }
      });      
    }

  </script>
</head>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Account Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Account Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div> <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">


          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary card-outline"> <!--card-secondary for grey format-->
                  <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>
                  </div> <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group">
                      <label for="first_name last_name">Name</label>
                      <input type="text" class="form-control" id="first_name" placeholder="First Name">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="last_name" placeholder="Last Name">
                    </div>

                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input type="email" class="form-control" id="email" placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                      <label for="phone_number">Phone Number</label>
                      <input type="text" class="form-control" id="phone_number" data-inputmask='mask": "(999) 999-9999"' data-mask="" im-insert="true" placeholder="(___) ___-____">
                    </div>

                    <div class="form-group">
                      <label>Gender</label>
                      <select class="custom-select" id="sex">
                        <option value="unknown">----</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Birthdate</label>
                      <div class="input-group mb-3">
                        <input id="birthdate" type="date" class="form-control" placeholder="Date of Birth" />
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-calendar"></span>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div> <!-- /.card-body -->
                  <div class="card-footer">
                    <button class="btn btn-primary" id="saveSettingsBtn" onclick="saveSettings()">Save Settings</button>
                  </div> <!-- /.card-footer -->
              </div> <!-- /.card-primary -->
            </div> <!-- /.col-md-6 -->

            <div class="col-md-6">
              <div class="card card-primary card-outline"> <!--card-secondary for grey format-->
                  <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                  </div> <!-- /.card-header -->
                  <div class="card-body">
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" placeholder="Old Password">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="new_password1" placeholder="New Password">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="new_password2" placeholder="Confirm New Password">
                    </div>
                  </div> <!-- /.card-body -->

                  <div class="card-footer">
                    <button onclick="changePassword()" id="changePasswordBtn" class="btn btn-primary">Submit</button>
                  </div> <!-- /.card-footer -->
              </div> <!-- /.card-primary -->

            </div> <!-- /.col-md-6 -->
          </div> <!-- /.row -->


      </div> <!-- /.container-fluid -->
    </div> <!-- /.content -->
  </div> <!-- /.content-wrapper -->


  <script src="AdminLTE/plugins/moment/moment.min.js"></script>
  <script src="AdminLTE/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script>
  $(function () {

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()


  });
</script>

<!-- ChartJS -->
<script src="AdminLTE/plugins/chart.js/Chart.min.js"></script>


<?php include('structure/bottom.php'); ?>