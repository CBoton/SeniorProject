<?php
// require("api/auth/login_check.php"); //Make sure the users is logged in
$title = "OT | My Plan"; //Set the browser title
$highlight = "my_plan"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML
?>

    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

        <!-- User redirected to my_plan -->
        <script type="text/javascript">
            $(document).ready(function () {
                let required_plan = '<?php echo isset($_GET['required_plan']) ? $_GET['required_plan'] : ""; ?>';
                let current_plan = '<?php echo isset($_GET['user_plan']) ? $_GET['user_plan'] : ""; ?>';
                // console.log(required_plan);
                if (required_plan != "" && current_plan != "") {
                    Swal.fire({
                        title: "You cannot access this content",
                        html: `<p>Your current plan is <b>${current_plan}</b>. <br> <br> Upgrade your plan to <b>${required_plan}</b> to access this content.<p>`
                    });
                }

                $('#show-subscription-btn').on('click', function () {
                    $.ajax({
                        type: 'POST',
                        url: 'api/plans/get_user_subscriptions.php',
                        success: function (data) {
                            console.log("command sent and returned");
                            console.log(data);
                            const subscriptions = JSON.parse(data);
                            display_subscriptions(subscriptions);
                        },
                        error: function () {
                            console.log("ERROR")
                        }
                    });
                });
                //Debug only
                $('#free-banner').on('click', function () {
                    onSubPlanDoesntExist();
                });
            });

            function display_subscriptions(subscriptions) {
                let $html_sub_section = $('#my-subscription');
                $html_sub_section.html("");
                //Display warning if there is more than one subscription
                let num_of_subs = Object.keys(subscriptions).length;
                console.log(num_of_subs);
                //Has multiple subscriptions
                if(num_of_subs > 1){
                    Swal.fire({
                        title: 'Warning!\nMultiple Subscriptions',
                        type: 'warning',
                        html: '<p>You are signed up for <b>'+num_of_subs+'</b> subscriptions.</p>' +
                            '<p>You should only have <b>one</b> premium subscription at a time.</p>' +
                            '<p>Please <b>cancel</b> the subscription(s) you do not wish to keep on this page or through your PayPal dashboard.</p>' +
                            '<p>Unfortunately we are not able to offer refunds. If you have any questions please see the Help page.</p>'
                    });
                }
                //Has no subscription
                if(num_of_subs === 0){
                    Swal.fire({
                        title: 'No Paid Subscription',
                        html: '<p>You are not subscribed to a paid premium subscription</p>',
                    });
                }
                subscriptions.forEach(function (sub) {
                    let $subscriptionRow;
                    $.ajax({
                        type: 'POST',
                        url: 'api/plans/get_complete_subscription_details.php',
                        data: {
                            subscription_id: sub['subscription_id']
                        },
                        success: function (data_sub_details) {
                            console.log(data_sub_details);
                            $subscriptionRow = subscription_row($html_sub_section, JSON.parse(data_sub_details));
                        },
                        error: function () {
                            console.log("ERROR")
                        }
                    });
                });
            }

            function subscription_row(container,sub) {
                //Debug
                console.log(sub);
                let $card = $('<div>').addClass("card card-primary card-outline elevation-2");
                //Header
                let $card_header = $('<div>').addClass("card-header");
                $card_header.append($('<h2>').addClass("card-title").html("Your <b>" + sub['plan_name'] + "</b> Plan:"));

                //Body
                let $card_body = $('<div>').addClass("card-body row margin");
                //Col sub_id
                let $sub_id_col = $('<div>').addClass("col-md-3");
                let $sub_id_header = $('<p>').html('Subscription ID:');
                let $sub_id = $('<p>').html('<b>'+sub['id'] +'</b>');
                $sub_id_col.append($sub_id_header);
                $sub_id_col.append($sub_id);
                //Col 2
                let $name_col = $('<div>').addClass("col-md-3");
                let $name_header = $('<p>').html('Name:');
                let name = sub['subscriber']['name'];
                console.log(name);
                let $name = $('<p>').html('<b>'+ name['given_name'] +' '+ name['surname'] +'</b>');
                $name_col.append($name_header);
                $name_col.append($name);
                //Col 3
                let $created_col = $('<div>').addClass("col-md-3");
                let $created_header = $('<p>').html('Created on:');
                let $created = $('<p>').html('<b>'+sub['create_time'] +'</b>');
                $created_col.append($created_header);
                $created_col.append($created);
                //Col4
                let $next_billing_col = $('<div>').addClass("col-md-3");
                let $next_billing_header = $('<p>').html('Next Billing Time:');
                let $next_billing = $('<p>').html('<b>'+sub['billing_info']['next_billing_time'] +'</b>');
                $next_billing_col.append($next_billing_header);
                $next_billing_col.append($next_billing);
                //Footer
                let $card_footer = $('<div>').addClass("card-footer").append();
                let $cancellation_btn = $('<button>').addClass("btn btn-warning float-right").html("Cancel Subscription");
                $card_footer.append($cancellation_btn);

                //Construct
                $card.append($card_header);
                $card.append($card_body);
                $card_body.append($sub_id_col);
                $card_body.append($name_col);
                $card_body.append($created_col);
                $card_body.append($next_billing_col);
                $card.append($card_footer);

                container.append($card);

                $cancellation_btn.on('click', function () {
                    console.log("clicked");
                    cancellationAlert(sub['id'])
                });

                return $card;
            }

            async function cancellationAlert(id) {
                try{
                    const { value: text } = await Swal.fire({
                        title: 'Cancellation Confirmation',
                        text: "You will not be able to undo this action. Cancellation will take effect immediately and previous payment cannot be refunded. See the Help page if you have any questions. PayPal requires a reason. Needs to be less than 255 characters.",
                        type: 'warning',
                        input: 'textarea',
                        inputPlaceholder: 'Provide a reason for PayPal...',
                        inputAttributes: {
                            'aria-label': 'Provide a reason for PayPal'
                        },
                        showCancelButton: true
                    });
                    if (text) {
                        cancel_subscription(id,text, function () {
                            location.reload();
                        });
                    }
                    //TODO replace this async swal with normal swal where ".then((result) => {" and "result.dismiss" are used
                    // else {
                    //     //No text given
                    //     Swal.fire({
                    //         title: 'No reason given!',
                    //         type: 'warning',
                    //         html: '<p>You must give a reason for the cancellation.</p>'
                    //     })
                    // }
                }catch(e){
                    // Fail!
                    console.error(e);
                }
            }

            function cancel_subscription(sub_id, reason, onCancellationHandler) {
                console.log('Cancelling subscription ' + sub_id + ' with reason "' + reason + '"');
                $.ajax({
                    type: 'POST',
                    url: 'api/plans/cancel_subscription.php',
                    data: {
                        sub_id_to_cancel: sub_id,
                        reason: reason
                    },
                    success: function (data) {
                        console.log("command sent and returned: Cancellation should have been executed");
                        console.log(data);
                        onCancellationHandler();
                    },
                    error: function () {
                        console.log("ERROR");
                    }
                });
            }



        </script>
        <!-- SweetAlert -->
        <link rel="stylesheet" href="AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <script src="AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    </head>


    <body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">My Plan</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div> <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card card-outline">
                    <div class="card-header">
                        <h5 class="m-0">My Plan</h5>
                    </div> <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Place page content here -->
                        <p style="text-align: center; vertical-align:  center">Your current plan is
                            <button class="btn elevation-2 font-weight-bold <?php if(isset($plan_class)) {echo $plan_class;} ?>"><?php if(isset($plan_text)) {echo $plan_text;} ?></button>
                        </p>
                        <hr noshade></hr
                        noshade>
                        <p style="text-align: center;">
                            <button class="btn btn-primary elevation-1 font-weight-bold" id="show-subscription-btn">Show
                                my Subscription details
                            </button>
                        </p>

                        <div class="col-md-12" id="my-subscription">
                            <!--Display subscription(s) here-->
                        </div>

                    </div> <!-- /.card-body -->
                </div> <!-- /.card-primary -->


                <div class="card card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Plans</h5>
                    </div> <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Place page content here -->
                        <p>Note: <b>Upgrades, downgrades, and cancellations will take effect immediately</b>, stopping any future recurring payments under the
                                previous plan. Previous payments cannot be refunded. Payments for new plans will be charged in full.
                                Please see the <a href="help.php">Help page</a> if you have any questions or need support.</p>
                        <p>To cancel a subscription your click the <b>"Show my subscription details"</b> button. Then, click "Cancel" on the subscription you would like to cancel.</p>
                        <hr noshade></hr
                        noshade>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <!-- Place page content here -->
                                        <button id="free-banner" type="button"
                                                class="btn btn-block plan-free-bg elevation-1 font-weight-bold">
                                            Free
                                        </button>
                                        </br>
                                        <center><h5><b>$0/month</b></h5></center>
                                        <hr noshade></hr
                                        noshade>
                                        <ul>
                                            <li>Access to our free content</li>
                                            <li>Free muscle training videos</li>
                                            <li>Free nutritional training videos</li>
                                            <li>Free guides</li>
                                        </ul>
                                        <div id="button-container-free"></div>
                                    </div> <!-- /.card-body -->
                                </div> <!-- /.card-primary -->
                            </div> <!-- /.col -->
                            <div class="col-md-4">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <!-- Place page content here -->
                                        <button type="button"
                                                class="btn btn-block plan-advanced-bg elevation-1 font-weight-bold">
                                            Advanced
                                        </button>
                                        </br>
                                        <center><h5><b>$19.99/month</b></h5></center>
                                        <hr noshade></hr
                                        noshade>
                                        <ul>
                                            <li><b><i>Free</i></b> plan +</li>
                                            <li>Advanced muscle training videos</li>
                                            <li>Advanced nutritional training videos</li>
                                            <li>Advanced level guides</li>
                                        </ul>
                                        <div id="button-container-advanced"></div>
                                    </div> <!-- /.card-body -->
                                </div> <!-- /.card-primary -->
                            </div> <!-- /.col -->
                            <div class="col-md-4">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <!-- Place page content here -->
                                        <button type="button"
                                                class="btn btn-block plan-personal-bg elevation-1 font-weight-bold">
                                            Personal
                                        </button>
                                        </br>
                                        <center><h5><b>$39.99/month</b></h5></center>
                                        <hr noshade></hr
                                        noshade>
                                        <ul>
                                            <li><b><i>Advanced</i></b> plan +</li>
                                            <li>Personal muscle training videos</li>
                                            <li>Personal nutritional training videos</li>
                                            <li>Personal level guides</li>
                                            <li>Monthly <b>Private Coaching</b> with trainers!</li>
                                        </ul>
                                        <div id="button-container-personal"></div>
                                    </div> <!-- /.card-body -->
                                </div> <!-- /.card-primary -->
                            </div> <!-- /.col -->
                        </div> <!-- /.row -->

                    </div> <!-- /.card-body -->
                </div> <!-- /.card-primary -->
            </div> <!-- /.container-fluid -->
        </div> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
    </body>

    <!--PayPal Source-->
    <script src="https://www.paypal.com/sdk/js?client-id=AWeTuCaNHd2YsixQdR9sRiBy9KvtMo-9jrvH_u-JQeT_X-DgiCARacl-J0WE4lSBBRdFX9uNMAu62B55&vault=true&disable-funding=credit"></script>

    <!--PayPal Script-->
    <script>
        //TODO NOTE: Use commit "a93d40a2" to build off upgrade behavior, shortcut has been used for this commit by not giving a upgrade option (Task #335)
        //TODO Final touch, disable PayPal button depending on the plan you arleady have
        let users_prem_state = -1;
        users_prem_state = <?php if(isset($user_data["premium_state"])) {echo $user_data["premium_state"];} ?>;
        console.log("Premium State: " + users_prem_state);

        /** FREE PLAN */
        if(users_prem_state > 0){
            $('#button-container-free').addClass('btn btn-block plan-disabled').html('You already have a higher plan. To downgrade you must first cancel your current subscription.');
        }
        /** ADVANCED PLAN */
        let adv_prem_state = 1;
        if(users_prem_state === 0) {
            paypal.Buttons({
                //On click
                createSubscription: function (data, actions) {
                    return createSubscription('P-5AL450891J419652VL2IEBYQ', actions);
                },

                //On approval
                onApprove: function (data, actions) {
                    onApprove('Advanced', data);
                }
            }).render('#button-container-advanced');
        } else {
            let adv_btn = $('#button-container-advanced').addClass('btn btn-block plan-disabled');
            if(users_prem_state === adv_prem_state){
                adv_btn.html('<b>Your Current Plan</b>')
            } else {
                adv_btn.html('You already have a plan. To downgrade/upgrade you must first cancel your subscription.')
            }
        }

        /** PERSONAL PLAN */
        let prsnl_prem_state = 2;
        if(users_prem_state === 0) {
            paypal.Buttons({
                //On click
                createSubscription: function (data, actions) {
                    return createSubscription('P-90906277YJ992482DL2IEDWA', actions);
                },

                //On approval
                onApprove: function (data, actions) {
                    onApprove('Personal', data);
                }
            }).render('#button-container-personal');
        } else {
            let adv_btn = $('#button-container-personal').addClass('btn btn-block plan-disabled');
            if(users_prem_state === prsnl_prem_state){
                adv_btn.html('<b>Your Current Plan</b>')
            } else {
                adv_btn.html('You already have a plan. To downgrade/upgrade you must first cancel your subscription.')
            }
        }

        //TODO needs to be finished, would check one more time just in case that the plan doesn't exist when PayPal button pressed before opening dialog
        //checkExistingSubscription
        // function onSubPlanDoesntExist(plan_being_checked,when_plan_doesnt_exist_handler){
        //     $.ajax({
        //         type: 'POST',
        //         url: 'api/plans/get_user_subscriptions.php',
        //         success: function (data) {
        //             console.log("command sent and returned");
        //             console.log(data);
        //             const subscriptions = JSON.parse(data);
        //             console.log(subscriptions);
        //             let doesntExist = false;
        //             subscriptions.forEach(function (sub) {
        //                 if(sub['plan_id'] === plan_being_checked && doesntExist === false) {
        //                     doesntExist = true;
        //                 }
        //             };
        //             //If it doesnt exist
        //             if (doesntExist){
        //                 when_plan_doesnt_exist_handler()
        //             }
        //
        //         },
        //         error: function () {
        //             console.log("ERROR");
        //         }
        //     });
        // }

        //On Approval
        function onApprove(plan_name, data) {
            send_subscription(data.subscriptionID);
            //Notify the user
            Swal.fire({
                title: 'Thank You!',
                html: '<p>You have successfully created a <b>' + plan_name + '</b> plan subscription</p>' +
                    '<p>Your subscription-id is <b>' + data.subscriptionID + '</b></p>'
            }).then((result) => {location.reload()});
            //TODO Send an email to client with a thank you, subscription confirmation, upgrade/unsubscribe link, and sub-id
            console.log('You have successfully created a ' + plan_name + ' with Subscription-ID ' + data.subscriptionID);
            console.log(data);
        }

        //On CreateSubscription
        function createSubscription(plan_id, actions) {
            return actions.subscription.create({
                'plan_id': plan_id
            });
        }

        //send subscription to db
        function send_subscription(subscription_id) {
            console.log('Executing send_subscription');
            $.ajax({
                type: 'POST',
                url: 'api/plans/db_send_subscription.php',
                data: {
                    subscription_id: subscription_id,
                },
                success: function (data) {
                    console.log("command sent and returned");
                    console.log(data);
                },
                error: function () {
                    console.log("ERROR")
                }
            })
        }
    </script>

    </html>

<?php include('structure/bottom.php'); ?>