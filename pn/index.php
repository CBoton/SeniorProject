<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Home"; //Set the browser title
$highlight = "index"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML

?>
<html>
<head>
  <script type="module" src='./api/dashboard/dashboard.js'>
  </script>
  <link rel="stylesheet" href="AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <script src="AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
</head>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <!-- Announcements -->
      <!-- Connecting to twitter may prove difficult, there's a lot more stuff needed than initially thought -->
<!--      <div class="card">-->
<!--        <div class="card-header">-->
<!--          <h3 class="card-title">Announcements</h3>-->
<!--        </div>-->
<!--        <div class="card-body p-0">-->
<!--          <ul class="products-list product-list-in-card">-->
<!--            <li class="item">-->
<!--              <div class="row product-info ml-3 mr-3">-->
<!--                <div class="pl-0 pr-0 col-10">-->
<!--                  <div class="product-description">Hello, this is an annoucement!.</div>-->
<!--                </div>-->
<!--                <div class="text-right pl-0 pr-0 col-2">-->
<!--                  <div class="product-description">Added 100 days ago</div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </li>-->
<!--          </ul>-->
<!--        </div>-->
<!--      </div>-->

      <!-- Goals -->
      <div class="card">
          <div class="card-header">
            <h3 class="card-title">My Goals</h3>
          </div>
          <ul class="todo-list" id="goals">
            <!-- This is populated by get_goals in the header -->
          </ul>
      </div>

      <!-- Body -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">My Body</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-2 col-sm-6">
              <label for="blood_type">Blood Type:</label>
              <select id="blood_type" class="form-control">
                <option>I don't know my blood type</option>
                <option>A-</option>
                <option>A+</option>
                <option>B-</option>
                <option>B+</option>
                <option>AB-</option>
                <option>AB+</option>
                <option>O-</option>
                <option>O+</option>
              </select>
            </div>
            <div class="col-lg-3 col-sm-6">
              <label for="body_type">Body Type:</label>
              <select id="body_type" class="form-control">
                <option>Ectomorph</option>
                <option>Mesomorph</option>
                <option>Endomorph</option>
              </select>
            </div>
            <div class="col-lg-2 col-sm-6">
              <label for="weight">Weight</label>
              <input id="weight" class="form-control" type="number">
            </div>
            <div class="col-lg-3 col-sm-6">
              <label for="activity_level">Activity Level</label>
              <select id="activity_level" class="form-control">
                <option value="0">No exercise</option>
                <option value="1">1-2 days/wk of exercise</option>
                <option value="2">3+ days/wk of exercise</option>
              </select>
            </div>
            <div class="col-lg-2 col-sm-12 mt-auto p-2">
              <button
                class="btn btn-primary float-right"
                id="save_body_btn"
                style="background-color:green;border-color:green;">
                  Save
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Highlighted For You -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Highlighted</h3>
        </div>
        <div class="card-body page-box">
          <div id="highlighted_guides">
            <!-- This is populated by get_guides in the header -->
          </div>
        </div>
      </div>

      <!-- Nutrition Favorites -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Nutrition Favorites</h3>
        </div>
        <div class="card-body page-box">
          <div id="nutrition_favorites">
            <!-- This is populated by get_guides in the header -->
          </div>
        </div>
      </div>

        <!-- Exercise Favorites -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Exercise Favorites</h3>
        </div>
        <div class="card-body page-box">
          <div id="exercise_favorites">
            <!-- This is populated by get_guides in the header -->
          </div>
      </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
</html>
<?php include('structure/bottom.php'); ?>
