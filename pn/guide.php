<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Guide"; //Set the browser title
$highlight = "guide"; //Select which tab in the navigation to highlight
$guide_id = $_GET['id'];
require("guide_plan_check.php");
require("structure/top.php"); //Include the sidebar HTML
?>

    <script type="text/javascript">
        var guide_id = <?php echo(json_encode($_GET['id'])); ?>;

        $( document ).ready(function() {

            $.ajax({
                type: "POST",
                url: 'api/guides/get_guide.php',
                data: {
                    guide_id: guide_id
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.result === "SUCCESS") {
                        $("#page_title").text(data.guide_data.guide_name);
                        $("#guide_content").html(data.guide_data.content);
                    } else {
                        Swal.fire({
                            title: "Error",
                            html: data.message
                        });
                    }
                }
            });
        });

    </script>
    <!-- SweetAlert -->
    <link rel="stylesheet" href="AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <script src="AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark"><span id="page_title">Loading...</span></h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">



                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div id="guide_content">

                        </div>
                    </div>
                </div>



            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php include('structure/bottom.php'); ?>