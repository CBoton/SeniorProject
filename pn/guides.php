<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Guides"; //Set the browser title
$highlight = "guides"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML


?>
    <html>
    <head>
        <script type="module" src="./dist/js/guides_page.js"></script>
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