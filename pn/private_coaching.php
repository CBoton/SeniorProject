<?php
require("api/auth/login_check.php"); //Make sure the users is logged in

//tier and plan_check.php are used for potentially redirecting the user to my_plan
$tier = "PERSONAL";
require("plan_check.php");

$title = "OT | Private Coaching"; //Set the browser title
$highlight = "private_coaching"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>
<html>
<head>
  <script type="text/javascript">
    let date_range = null;
    $(window).on('load', function() {
      let f_date = new Date();
      let l_date;
      let yyyy = f_date.getFullYear();
      let mm = String(f_date.getMonth() + 1).padStart(2, '0'); //Gets month and pads with 0 if needed
      let fd = String(1).padStart(2, '0'); //Creates string 01 which is first day of month
      let ld = String(new Date(yyyy, mm, 0).getDate()); // Creates string of last day of month
      f_date = mm + '/' + fd + '/' + yyyy; //First date
      l_date = mm + '/' + ld + '/' + yyyy; //Last date
      date_range = f_date + " - " + l_date;
      init_box();
    });

    function init_box(){
      document.getElementById("coaching_box").innerHTML =
        '<!-- Thank You-->' +
        '<p class = "coach_white"><b><i>Thank You</i></b> for being a <i>Personal tier</i> member! </p>' +
        '<p class = "coach_white">Every month you can request counseling with either one of us, <b>Doug</b> or <b>Dan</b>.</p>' +
        '<!-- Plan Cycle -->' +
        '<p class = "coach_black"><b> Session for plan cycle</b></p>' +
        '<p class = "coach_black"><b id = "date"></b></p>' +
        '<!-- Instructions-->' +
        '<p class = "coach_white"><b>Simply</b> let us know your <b>goals</b> and/or <b>concerns</b> in the field below</p>' +
        '<p class = "coach_white">and we will contact you for private coaching if possible.*</p>' +
        '<!-- Text Box -->' +
        '<textarea id="meeting_topic" class="form-control" rows="3" maxlength = "918" placeholder="Enter your goals/concerns..." onchange="allow()"> </textarea>' +
        "<!-- Contact text -->" +
        '<p class = coach_black><br><b>"I would like to be contacted via..."</b></p>' +
        '<!-- Email/Phone number Buttons -->' +
        '<div class="btn-group" style = "display: flex; align-items: center; justify-content: center">' +
        '<div class = "col-4" style = "display: flex; align-items: center; justify-content: center">' +
        '<button id = "email_btn" ' +
        'class="btn btn-primary" ' +
        'style="text-align: center; color: black; background-color:GhostWhite; border-color:LightGrey; width: 800px;" ' +
        'onclick="disable_button(this)">' +
        '</button>' +
        '</div>' +
        '<div class = "col-4" style = "display: flex; align-items: center; justify-content: center">' +
        '<button id = "phone_number_btn" ' +
        'class="btn btn-primary" ' +
        'style="text-align: center; color: black; background-color:GhostWhite; border-color:LightGrey; width: 800px;" ' +
        'onclick="disable_button(this)">' +
        '</button>' +
        '</div>' +
        '</div>' +
        '<br>' +
        '<div class = "fc-row" style="display: flex; align-items: center; justify-content:center;">' +
        '<button id = "submit_btn" ' +
        'class = btn-lg ' +
        'style="text-align: center; color: white; background-color:Black" ' +
        'onclick="check_request_duplicate()">' +
        'Done! Request my session with Doug/Dan!' +
        '</button>' +
        '</div>' +
        '<p class = "coach_white" style ="font-size: medium"><b><br><br>*Meetings every month are not guaranteed and depend on our demand as private trainers</b>';
        get_contact_info();
        $('#submit_btn').prop('disabled', true);
        document.getElementById("date").innerHTML = date_range;
    }

    function duplicate_found(){
      document.getElementById("coaching_box").innerHTML =
        '<!-- Thank You-->' +
        '<p class = "coach_white"><b><i>Thank You</i></b> for being a <i>Personal tier</i> member! </p>' +
        '<p class = "coach_white">But, you have already requested a session this month</b>.</p>' +
        '<!-- Plan Cycle -->' +
        '<p class = "coach_black"><b> Session for plan cycle</b></p>' +
        '<p class = "coach_black"><b id = "date"></b></p>' +
        '<br><br>' +
        '<p class = "coach_white">Please wait at least <b>1-7 business days</b> for us to get in touch with you*.</p>' +
        '<p class = "coach_white">If we are not able to reach you this month, we apologize profusely.</p>' +
        '<p class = "coach_white">We are private trainers with busy schedule and <b>do our best to set aside some time</b></p>' +
        '<p class = "coach_white">to meet one-on-one with <b>dedicated individuals</b> such as <b>yourself</b>.</p>' +
        '<p class = "coach_white" style ="font-size: medium"><b><br><br>*Meetings every month are not guaranteed and depend on our demand as private trainers</b>';
      document.getElementById("date").innerHTML = date_range;
    }

    function request_success(){
      document.getElementById("coaching_box").innerHTML =
      '<!-- Thank You-->' +
      '<p class = "coach_white"><b><i>Thank You</i></b> for being a <i>Personal tier</i> member! </p>' +
      '<p class = "coach_white">You have <b id = "request_status">successfully requested a session this month</b>.</p>' +
      '<!-- Plan Cycle -->' +
      '<p class = "coach_black"><b> Session for plan cycle</b></p>' +
      '<p class = "coach_black"><b id = "date"></b></p>' +
      '<br><br>' +
      '<p class = "coach_white">Please wait at least <b>1-7 business days</b> for us to get in touch with you*.</p>' +
      '<p class = "coach_white">If we are not able to reach you this month, we apologize profusely.</p>' +
      '<p class = "coach_white">We are private trainers with busy schedule and <b>do our best to set aside some time</b></p>' +
      '<p class = "coach_white">to meet one-on-one with <b>dedicated individuals</b> such as <b>yourself</b>.</p>' +
      '<p class = "coach_white" style ="font-size: medium"><b><br><br>*Meetings every month are not guaranteed and depend on our demand as private trainers</b>';
      document.getElementById("date").innerHTML = date_range;
    }

    function formatPhoneNumber(phoneNumberString) {
      let cleaned = ('' + phoneNumberString).replace(/\D/g, '');
      let match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
      if (match) {
          return '(' + match[1] + ') ' + match[2] + '-' + match[3]
      }
      return null
    }

    function disable_button(button){
      if (button.id === "email_btn"){
        $('#email_btn').prop('disabled', true);
        $('#phone_number_btn').prop('disabled', false);
      }
      else {
        $('#phone_number_btn').prop('disabled', true);
        $('#email_btn').prop('disabled', false);
      }
    }

    function get_contact_info(){
      document.getElementById("email_btn").innerHTML = "<?php echo $user_data['email'] ?>";
      document.getElementById("phone_number_btn").innerHTML = formatPhoneNumber("<?php echo $user_data['phone_number'] ?>");
    }

    function check_request_duplicate(){
      $.ajax({
        type: 'POST',
        url: 'api/coaching/duplicateRequestCheck.php',
        data: {},
        success: function(data) {
          let json = JSON.parse(data);
          if (json.length > 0){
              console.log("Duplicate found");
              duplicate_found();
          }
          else {
              console.log("No duplicate");
              coach_request();
          }
        },
        error: function() {
          console.log("Something went wrong in duplicate check");
        }
      });
  }

    function coach_request() {
        let topic_text = document.getElementById("meeting_topic").value;
        let preferred_contact = document.getElementById("email_btn").disabled ? "EMAIL" : "PHONE";
        $.ajax({
            type: 'POST',
            url: 'api/coaching/coachingRequest.php',
            data:{ topic: topic_text, contact: preferred_contact },
            success: function() {
                request_success();
            },
            error: function() {
                console.log("Coach_request ERROR");
            }
        });
    }

    function allow(){
        $('#submit_btn').prop('disabled', false);
    }

  </script>

 <style>
   p.coach_white{
     font-size: x-large;
     text-align: center;
     color: white;
     line-height: 70%;
     font-family: Arial, Helvetica, sans-serif;
   }

   p.coach_black{
     font-size: x-large;
     text-align: center;
     color: black;
     line-height: 70%;
     font-family: Arial, Helvetica, sans-serif;
   }
 </style>
</head>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0 text-dark">Private Coaching</h1>
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
        <div id = "coaching_box" class="card-body" style = "background-color:#17a2b8">
        </div>
      </div>
    </div>
  </div>
</div>
</html>

<?php include('structure/bottom.php'); ?>