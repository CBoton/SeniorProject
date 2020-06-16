<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Home"; //Set the browser title
$highlight = "index"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>
  
  <script type="text/javascript">
    <!-- Put Javascript Here -->
  </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">



            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Card Header Here</h5>
              </div>
              <div class="card-body">
                <!-- Place page content here -->
              </div>
            </div>



      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include('structure/bottom.php'); ?>