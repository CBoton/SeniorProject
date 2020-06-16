<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Nutrition"; //Set the browser title
$highlight = "nutrition"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>
<HTML>
  <script type="text/javascript">



      function load_plan(){
          window.location.replace("nutrition_plan.php");
      }
      /*
      if( $('#username').val().length < 5 || $('#username').val().length > 50){
          $('#statusMsg').html("That username is too short or too long.");
          return;
*/
      function validate(){
          let count = 0;
          let weight = parseInt($('#plan_weight').val());
          let target = parseInt($('#target_fat').val());
          let current = parseInt($('#current_fat').val());

          if (weight  < 75 || weight > 1000 || weight === '') {
              $('#weightMsg').html("Please enter a valid weight.");
              count ++;
          }

          if(target > current){
              $('#targetMsg').html("Please enter a target fat lower than your current fat");
              count++;
          }

          if(current >= 40 || current < 4  || isNaN(current)) {
              $('#currentMsg').html("Please enter a number between 4 and 40");
              count++;
          }
          if(target < 4 || target > 40 || isNaN(target)) {
              $('#targetMsg').html("Please enter a number greater than 4");
              count++;
          }


          if (count > 0)return;

          else calculate();
      }

    function calculate(){
//Disable the login button
          $('#calc_btn').prop('disabled', true);
             const blood_type = $('#blood_type').val();
             const body_type = $('#body_type').val();
             const plan_weight = $('#plan_weight').val();
             const target_fat = $('#target_fat').val();
             const sex = $('#sex').val();
             const desired_outcome = $('#desired_outcome').val();
             const current_fat = $('#current_fat').val();
             const activity_lvl = $('#activity_lvl').val();
             const timeline = $('#timeline').val();
             const has_meal_plan = 1;
          //Send the form data
          $.ajax({
            type: "POST",
            url: 'api/nutri/plan_attribs.php',
            data: {
              blood_type: blood_type ,
              body_type: body_type,
              plan_weight: plan_weight,
              target_fat: target_fat,
              sex: sex,
              desired_outcome: desired_outcome,
              current_fat: current_fat,
              activity_lvl: activity_lvl,
              timeline: timeline,
              has_meal_plan: has_meal_plan
                  },
                  success: function() {
                    $('#calc_btn').prop('disabled', false);
                    },
                  error: function() {
                    $('#calc_btn').prop('disabled', false);
                     console.log("ERROR");
                  }
              });
          if (plan_weight >= 300){
              window.location.replace("nutrition_planw.php");
              }
          else {
              window.location.replace("nutrition_plan.php");
              }
            }


  </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Nutrition</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">


             <div class="card-body">
              <form>  <!-- Place page content here -->
                <h3><p>To determine a nutrition plan that will best work for you we need to gather some information about you</p></h3>
              <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                          <label>Select your blood type.</label>
                           <select id="blood_type" class="form-control">
                               <option>I don&apos;t know my blood type</option>
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
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>My weigth(lbs): </label>
                      <input id="plan_weight" type="number" class="form-control" placeholder="Enter your weight here">
                      <p id="weightMsg" style="color:red"></p>
                    </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label>Activity level</label>
                          <select id="activity_lvl" class="form-control">
                              <option value=0>No exercise</option>
                              <option value =1>1-2 days/wk of exercise</option>
                              <option value =2>3+ days/wk of exercise</option></select>
                      </div>
                  </div>
              </div><!-- /row -->
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                         <label>Sex</label>
                           <select id="sex" class="form-control">
                           <option>Male</option>
                           <option>Female</option>
                         </select>
                  </div>
                </div>
                <div class="col-sm-4">
                   <div class="form-group">
                        <label>Desired outcome</label>
                        <select id="desired_outcome" class="form-control">
                         <option>Burn fat/lose weight</option>
                         <option>Build muscle/bulk up</option>
                         <option>Get shredded (below 8% body fat)</option>
                         <option>Increase performance/athleticism</option>
                        </select>
                   </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>I want to accomplish my goal in:</label>
                        <select id="timeline" class="form-control">
                        <option>No time line</option>
                        <option>Less than 2 months</option>
                        <option>2-4 months</option>
                        <option>4-6 months</option>
                        </select>
                    </div>
                </div>

              </div><!-- /.row -->
                <h3><p>Please select the body type that most resembles yours based on the graphic and description</p></h3>

                <div class="row">
                   <div class="col-md-4">
                      <div class="card">
                         <div class="card-header">
                              <h3 class="card-title">Ectomorph</h3>
                         </div>
                              <div class="card-body" style="text-align:center;">
                                <div>
                                   <img style='height: 60%; width: 60%; object-fit: contain' src="dist/img/ectos.jpg">
                                </div>
                                <ul style="display: inline-block; text-align: left;">
                                  <li>Skinny</li>
                                  <li>Small joints/bones</li>
                                  <li>Small shoulders</li>
                                  <li>Lightly muscled</li>
                                  <li>Small chest and buttocks</li>
                                  <li>Low body fat</li>
                                  <li>Can eat anything without gaining weight</li>
                                  <li>Fast metabolism</li>
                                  <li>Difficult to gain weight/muscle</li>
                                  </ul>
                              </div>
                      </div>
                   </div>
                          <div class="col-md-4">
                            <div class="card">
                              <div class="card-header">
                                  <h3 class="card-title">
                                     Mesomorph
                                    </h3>
                              </div>
                              <div class="card-body" style="text-align:center;">
                                 <div>
                                 <img style='height: 60%; width: 60%; object-fit: contain' src="dist/img/mesos.jpg">
                                 </div>
                                  <ul style="display: inline-block; text-align: left;">
                                  <li>Naturally Lean</li>
                                  <li>Naturally muscular</li>
                                  <li>Naturally strong</li>
                                  <li>Medium size joints/bones</li>
                                  <li>Wider at the shoulders than the hips</li>
                                  <li>Broad/ square shoulders</li>
                                  <li>Efficient metabolism</li>
                                  <li>Gain muscle/lose fat with little effort</li>
                                  <li>Responds quickly to exercise</li>
                                  </ul>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">
                                  Endomorph
                                </h3>
                              </div>
                              <div class="card-body" style="text-align:center;">
                                <div>
                                <img style='height: 60%; width: 60%; object-fit: contain' src="dist/img/Endos.jpg">
                                </div>
                                <ul style="display: inline-block; text-align: left;">
                                <li>Soft, round body</li>
                                <li>Short, stocky limbs</li>
                                <li>Big joints/bones</li>
                                <li>Fitted jeans are snug around the hips and glutes</li>
                                <li>Slow metabolism</li>
                                <li>Difficulty losing fat</li>
                                <li>Gain fat and muscle at average rate</li>
                                <li>Lack of muscle definition</li>
                                <li>Large appetite</li>
                                </ul>
                              </div>
                            </div>

                      <!-- /.card -->
                   </div>
                          <!-- ./col -->
                </div>

                         <div class="col-sm-4">
                            <div class="form-group">
                                <label>My body type is:</label>
                                    <select id="body_type"class="form-control">
                                       <option>Ectomorph</option>
                                       <option>Mesomorph</option>
                                       <option>Endomorph</option>
                                    </select>
                                </div>
                            </div>
                         <div>
                            <h3><p>Next we have to know your body fat percentage. It is best to go get this tested for a
                            more precise measure, but you can reference these pictures to get a rough estimate</p></h3>
                            <img style='height: 50%; width: 50%; object-fit: contain' src="dist/img/fatM.jpg">
                            <img style='height: 50%; width: 50%; object-fit: contain' src="dist/img/fatF.jpg">
                          </div>

                         <div class="row">
                           <div class="col-sm-4">
                             <div class="form-group">
                                 <label>My body fat percentage:</label>
                                <input id="current_fat" type="number" class="form-control" placeholder="Enter your body fat % here" required>
                                 <p id="currentMsg" style="color:red"></p>
                             </div>
                           </div>
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label>Target body fat:</label>
                                     <input id="target_fat" type="number" class="form-control" placeholder="Enter your target body fat percentage here" required>
                                     <p id="targetMsg" style="color:red"></p>
                                 </div>
                             </div>
                         </div>
              </form>
                      <div class="col-sm-4">
                            <button class="btn btn-block btn-primary" id="calc_btn" onclick="validate()">Calculate my nutrition plan</button>
                      </div>
             </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</HTML>
<?php include('structure/bottom.php');