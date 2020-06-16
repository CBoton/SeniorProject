<?php
require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | Nutrition"; //Set the browser title
$highlight = "nutrition"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>
    <HTML>
    <script type="text/javascript">

        $( window ).on( "load", function() {

            check_plan() ;

        });


        function load_plan(){
            window.location.replace("nutrition_plan.php");
        }

        function check_plan(){
            $.ajax({
                type: "POST",
                url: 'api/nutri/has_plan.php',
                success: function(data) {
                    if (data.length === 50) {
                        let str = data.slice(12, 30);
                        console.log(str);
                        window.location.replace(str);
                    }
                    else window.location.replace("get_nutrition.php");

                }


            });

        }

</script>
    </HTML>
<?php include('structure/bottom.php');