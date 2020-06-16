<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Nutrition"; //Set the browser title
$highlight = "nutrition"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>
    <html>
    <head>
        <script type="text/javascript">
            function change_plan(){
                $('#change_btn').prop('disabled', true);
                window.location.replace("change_plan.php");
            }
        </script>
        <script type="module" src='./api/nutri/nutrition_plan.js'>

        </script>


    </head>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Nutrition</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Nutrition</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Place page content here -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Nutrition Guides</h3>
                    </div>
                    <div class="card-body">
                        <div id="nutrition_favorites" class="row">
                            <!-- This is populated by get_guides in the header -->
                        </div>
                    </div>
                </div>
                <h3><p style="color:red">**Warning** While we have generated a meal plan for you, we at Organic Transformations care about your health and safety and we recommend that
                        anyone over 300lbs consult a physician before beginning any new fitness or diet plan.</p></h3>
                <h3><p>Below is your daily meal plan. Your goal is to eat every three hours while consuming the suggested nutrient levels for each meal. Every nutrient has a corresponding tab
                with a breakdown of the food to nutrient ratios to help make meal planning easier (except vegetables, just weigh them out on a scale ounce to ounce). Also, you don't have to
                worry about nutrients crossing over. For example, if you have your target grams of protein from a meat, you don't need to worry about the few grams of protein coming from the nuts
                you are eating to get your fats; the crossovers have already been accounted for when calculating your meal plan.</p></h3>
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-two-plan-tab" data-toggle="pill" href="#custom-tabs-two-plan" role="tab" aria-controls="custom-tabs-plan-home" aria-selected="true">My meal plan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-protein-tab" data-toggle="pill" href="#custom-tabs-two-protein" role="tab" aria-controls="custom-tabs-two-protein" aria-selected="false">Protein</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-starch-tab" data-toggle="pill" href="#custom-tabs-two-starch" role="tab" aria-controls="custom-tabs-two-starch" aria-selected="false">Starches</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-fruit-tab" data-toggle="pill" href="#custom-tabs-two-fruit" role="tab" aria-controls="custom-tabs-two-fruit" aria-selected="false">Fruits</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-fats-tab" data-toggle="pill" href="#custom-tabs-two-fats" role="tab" aria-controls="custom-tabs-two-fats" aria-selected="false">Fats</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-two-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-two-plan" role="tabpanel" aria-labelledby="custom-tabs-two-plan-tab">
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Meal#</th>
                                            <th>Protein</th>
                                            <th>Starch</th>
                                            <th>Vegetables</th>
                                            <th>Fruits</th>
                                            <th>Fats</th>
                                        </tr>
                                        </thead>
                                        <tbody id="plan_table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-two-protein" role="tabpanel" aria-labelledby="custom-tabs-two-protein-tab">
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Protein</th>
                                            <th>30g</th>
                                            <th>25g</th>
                                            <th>20g</th>
                                            <th>15g</th>
                                            <th>1g</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Ground Beef</td>
                                            <td>125g</td>
                                            <td>104g</td>
                                            <td>83g</td>
                                            <td>63g</td>
                                            <td>4.2g</td>
                                        </tr>
                                        <tr>
                                            <td>Steak</td>
                                            <td>114g</td>
                                            <td>95g</td>
                                            <td>76g</td>
                                            <td>57g</td>
                                            <td>3.8g</td>
                                        </tr>
                                        <tr>
                                            <td>Eggs(whole)</td>
                                            <td>5ct</td>
                                            <td>4ct</td>
                                            <td>3ct</td>
                                            <td>3ct</td>
                                            <td>1egg/6g</td>
                                        </tr>
                                        <tr>
                                            <td>Egg whites</td>
                                            <td>270g</td>
                                            <td>225g</td>
                                            <td>180g</td>
                                            <td>135g</td>
                                            <td>9g</td>
                                        </tr>
                                        <tr>
                                            <td>Chicken Breast</td>
                                            <td>100g</td>
                                            <td>83g</td>
                                            <td>67g</td>
                                            <td>50g</td>
                                            <td>3.3</td>
                                        </tr>
                                        <tr>
                                            <td>Chicken Thighs</td>
                                            <td>116g</td>
                                            <td>95g</td>
                                            <td>78g</td>
                                            <td>59g</td>
                                            <td>3.9g</td>
                                        </tr>
                                        <tr>
                                            <td>Cod</td>
                                            <td>132g</td>
                                            <td>110g</td>
                                            <td>88g</td>
                                            <td>66g</td>
                                            <td>4.4g</td>
                                        </tr>
                                        <tr>
                                            <td>Turkey</td>
                                            <td>102g</td>
                                            <td>95g</td>
                                            <td>68g</td>
                                            <td>51g</td>
                                            <td>3.4g</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-two-starch" role="tabpanel" aria-labelledby="custom-tabs-two-starch-tab">
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Starch</th>
                                            <th>30g</th>
                                            <th>25g</th>
                                            <th>20g</th>
                                            <th>15g</th>
                                            <th>1g</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Rice</td>
                                            <td>107g</td>
                                            <td>90g</td>
                                            <td>72g</td>
                                            <td>54g</td>
                                            <td>3.6g</td>
                                        </tr>
                                        <tr>
                                            <td>Potatoes</td>
                                            <td>145g</td>
                                            <td>120g</td>
                                            <td>96g</td>
                                            <td>72g</td>
                                            <td>4.8g</td>
                                        </tr>
                                        <tr>
                                            <td>Quinoa</td>
                                            <td>141g</td>
                                            <td>118g</td>
                                            <td>3ct</td>
                                            <td>3ct</td>
                                            <td>4.7g</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-two-fruit" role="tabpanel" aria-labelledby="custom-tabs-two-fruit-tab">
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Fruit</th>
                                            <th>15</th>
                                            <th>10</th>
                                            <th>5</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Watermelon</td>
                                            <td>199g</td>
                                            <td>132g</td>
                                            <td>66g</td>
                                        </tr>
                                        <tr>
                                            <td>Strawberries</td>
                                            <td>195g</td>
                                            <td>130g</td>
                                            <td>65g</td>
                                        </tr>
                                        <tr>
                                            <td>Apples</td>
                                            <td>100g</td>
                                            <td>73g</td>
                                            <td>37g</td>
                                        </tr>
                                        <tr>
                                            <td>Bananas</td>
                                            <td>66g</td>
                                            <td>45g</td>
                                            <td>33g</td>
                                        </tr>
                                        <tr>
                                            <td>Berries</td>
                                            <td>125g</td>
                                            <td>83g</td>
                                            <td>42g</td>
                                        </tr>
                                        <tr>
                                            <td>Cantaloupe</td>
                                            <td>171g</td>
                                            <td>114g</td>
                                            <td>57g</td>
                                        </tr>
                                        <tr>
                                            <td>Mango</td>
                                            <td>66g</td>
                                            <td>44g</td>
                                            <td>22g</td>
                                        </tr>
                                        <tr>
                                            <td>Pineapple</td>
                                            <td>114g</td>
                                            <td>76g</td>
                                            <td>38g</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-two-fats" role="tabpanel" aria-labelledby="custom-tabs-two-fats-tab">
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <th>Fats</th>
                                        <th>15</th>
                                        <th>5</th>
                                        <th>1</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Almonds</td>
                                            <td>28ct</td>
                                            <td>9ct</td>
                                            <td>2ct</td>
                                        </tr>
                                        <tr>
                                            <td>Walnuts</td>
                                            <td>28ct</td>
                                            <td>9ct</td>
                                            <td>2ct</td>
                                        </tr>
                                        <tr>
                                            <td>Cashews</td>
                                            <td>28ct</td>
                                            <td>9ct</td>
                                            <td>2ct</td>
                                        </tr>
                                        <tr>
                                            <td>Pecans</td>
                                            <td>28ct</td>
                                            <td>9ct</td>
                                            <td>2ct</td>
                                        </tr>
                                        <tr>
                                            <td>Pistachios</td>
                                            <td>50ct</td>
                                            <td>17ct</td>
                                            <td>3ct</td>
                                        </tr>
                                        <tr>
                                            <td>MCT Oil</td>
                                            <td>1tbsp</td>
                                            <td>1tsp</td>
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <td>Avocados</td>
                                            <td>1.5</td>
                                            <td>0.5</td>
                                            <td>0.1</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <p id="blood"></p>
                    </div>
                    <!-- /.card -->

                </div>
                <div class="col-sm-4">
                    <button class="btn btn-block btn-primary" id="change_btn" onclick="change_plan()">Change my nutrition plan</button>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </html>
<?php include('structure/bottom.php'); ?>
