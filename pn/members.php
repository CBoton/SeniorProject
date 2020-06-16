<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Members"; //Set the browser title
$highlight = "members"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>

<html style="height: auto;"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">Members Panel</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div> <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="members" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sex</th>
                                    <th>Member Since</th>
                                    <th>Goal</th>
                                    <th>Plan</th>
                                    <th>Email Address</th>
                                    <th>Phone Number</th>
                                    <th>Billing Cycle Ends</th>
                                </tr>
                                </thead>
                                <?php
                                $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                                $stmt = $con->prepare("SELECT * FROM users");
                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                $stmt->execute();

                                ?>
                                <tbody>
                                <?php while($row = $stmt->fetch()) {
                                    switch ($row["premium_state"]){
                                        case 0:
                                            $plan_text = "Welcome";
                                            break;
                                        case 1:
                                            $plan_text = "Advanced";
                                            break;
                                        case 2:
                                            $plan_text = "Personal";
                                            break;
                                    }

                                    echo "<tr>
                                            <td>" . $row["first_name"] . " " . $row["last_name"]. "</td>
                                            <td>" . $row["sex"] . "</td>
                                            <td>" . (new DateTime($row["join_date"]))->format('M j, Y') . "</td>
                                            <td>" . $row["desired_outcome"] . "</td>
                                            <td>" . $plan_text . "</td>
                                            <td>" . $row["email"] . "</td>
                                            <td>" . preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $row["phone_number"]) . "</td>    
                                            <td>" . (new DateTime($row["premium_expiration"]))->format('M j, Y') . "</td>                                                                                    
                                          </tr>";
                                };
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="AdminLTE/plugins/datatables/jquery.dataTables.js"></script>
<script src="AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- page script -->
<script>
    $(function () {
        $("#members").DataTable({
            "lengthChange": true,
            "paging": false,
        });
    });
</script>
</body>
</html>


<?php include('structure/bottom.php'); ?>
