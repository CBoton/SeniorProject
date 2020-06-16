<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Owner Panel - Guides"; //Set the browser title
$highlight = "owner_guides"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML


?>
    <html>
    <head>
        <script type="module" src="./dist/js/guides_page.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                //On hover show edit-overlay
                $(document).on('mouseenter', '.guide-card', function(){
                    console.log('hover triggered');
                    $(this).prepend('<div class="overlay dark"> <i class="fas fa-3x fa-pencil-alt"></i> </div>');
                });

                $(document).on('mouseleave', '.guide-card', function(){
                    console.log('leave triggered');
                    $('.overlay').remove();
                });

                $(document).on('click', '.guide-card', function(){
                    console.log($(this).id);
                    var id = $(this).attr('id').split('-');
                    edit_guide(id[id.length-1]);
                });

                //Create guide button
                $('#create_guide').on('click', function () {
                    window.location.href = 'adm_edit_guide.php';
                });
            });

            function create_a_guide() {
                window.location.href = 'adm_edit_guide.php';
            }

            function edit_guide(guide_id){
                window.location.href = 'adm_edit_guide.php?guide_id=' + guide_id;
            }
        </script>
    </head>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">Guides</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Body -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Search</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input id="search-input" type="text" class="form-control" placeholder="Search for...">
                                <div class="input-group-append">
                                    <button id="search-submit" class="form-control btn btn-primary">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container-fluid">

                <!-- Body -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <button id="create_guide" class="form-control btn btn-primary" style="text">
                                    New Guide
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Body -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title" id="results-title">Results</h3>
                    </div>
                    <div class="card-body">
                        <div class="row" id="search-results">

                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>
    <!-- /.content-wrapper -->
    </html>
<?php include('structure/bottom.php'); ?>