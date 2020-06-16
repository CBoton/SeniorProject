import Guide from '../guides/Guide.js';
import Pages from '../guides/Pages.js';

// TODO for Joel:  Goals ID should use goal id from database instead of goal text
// TODO why is the Add a goal button added via script and not apart of the html

$( window ).on( "load", function() {
    if(window.location.href.includes("invalid")) {
        Swal.fire({
            title: "Guide not available",
            html: "Unfortunately, the guide you requested is not available, please contact site administrators if you believe this is an error."
        });
    }
    $(document).on('click','#add_goal_btn', function (){
        add_goal();
    });
    $(document).on('click','.delete-goal', function (){
        delete_goal($(this));
    });
    $(document).on('click','#submit_goal_btn', function (){
        submit_goal();
    });
    $(document).on('click','#save_body_btn', function () {
	save_body();
    });
    Guide.get_guides(
        [$('#highlighted_guides'), $('#nutrition_favorites'), $('#exercise_favorites')],
        [['highlighted'], ['nutrition'], ['exercise']],
        [false, true, true],
        4
    );
    get_body();
    get_goals();
});

function get_body() {
    $.ajax({
        type: 'POST',
        url: '/pn/api/nutri/get_nutrition.php',
        success: function(data) {
            let json = JSON.parse(data);
            for(let key in json) {
                if(json.hasOwnProperty(key)) {
                    $('#blood_type').val(json[key]['blood_type']);
                    $('#body_type').val(json[key]['body_type']);
                    $('#weight').val(json[key]['current_weight']);
                    $('#activity_level').val(json[key]['activity_lvl']);
                    break;
                }
            }
        },
        error: function() {
            console.log("Get_Body ERROR");
        }
    });
}

function save_body() {
    $('#save_body_btn').prop('disabled', true);
    const blood_type = $('#blood_type').val();
    const body_type = $('#body_type').val();
    const weight = $('#weight').val();
    const activity_level = $('#activity_level').val();
    if(weight < 10 || weight > 1000) {
        Swal.fire({
            title: "Invalid weight",
            html: "Please enter a weight between 10 and 1000."
        });
    }
    $.ajax({
        type: 'POST',
        url: '/pn/api/nutri/save_nutrition.php',
        data: {
            blood_type: blood_type,
            body_type: body_type,
            weight: weight,
            activity_level: activity_level
        },
        success: function() {
            $('#save_body_btn').prop('disabled', false);
        },
        error: function() {
            $('#add_goal_btn').prop('disabled', false);
            console.log("Get_Body ERROR");
        }
    });
}

function get_goals() {
    $.ajax({
        type:'POST',
        url: '/pn/api/dashboard/get_goals.php',
        success: function(data) {
            let goal_str = Array();
            const json = JSON.parse(data);
            for(let key in json) {
                if (json.hasOwnProperty(key))
                    goal_str.push(
                        '<li>' +
                        json[key]['goal'] +
                        '<button type="button" ' +
                        'class="delete-goal close text-right" ' +
                        'id="' + json[key]['goal_id'] + '"">' +
                        '×' +
                        '</button>' +
                        '</li>');
            }
            goal_str.push(
                '<li class="text-right" id="last_goal_line">' +
                '<button class="btn btn-primary" id="add_goal_btn" ' +
                'style="background-color:green;border-color:green;height:100%">' +
                'Add Goal' +
                '</button>' +
                '</li>'
            );
            $('#goals').html(goal_str);
        },
        error: function() {
            console.log("Get_Goals ERROR");
        }
    });
}

function add_goal() {
    $('#last_goal_line').before(
        '<li id="add_goal_line">' +
        '<div class="row">' +
        '<input id="goal_input" class="form-control col-11" type="text" placeholder="New Goal">' +
        '<button class="btn btn-primary col-1" id="submit_goal_btn"> ' +
        '<i class="fas fa-plus"> </i>' +
        '</button>' +
        '</div>' +
        '</li>'
    );
    $('#add_goal_btn').prop('disabled', true);
}

function submit_goal() {
    const goal = $('#goal_input').val();
    if(goal === "") {
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/pn/api/dashboard/submit_goal.php',
        data: {
            goal: goal
        },
        success: function(data) {
            get_goals();
            // const parent = document.getElementById('goals');
            // parent.removeChild(document.getElementById('add_goal_line'));
            // $('#last_goal_line').before(
            //     '<li>' + data +
            //     '<button type="button" ' +
            //     'class="delete-goal close text-right" ' +
            //     'id="' + data + '">' +
            //     '×' +
            //     '</button>' +
            //     '</li>'
            // );
            // $(document).on('click','.delete-goal', function (){
            //     delete_goal($(this));
            // });
            // ++goal_len;
            // $('#add_goal_btn').prop('disabled', false);
        },
        error: function() {
            console.log("Submit_Goal ERROR");
        }
    });
}

function delete_goal(button) {
    let goal_id = $(button).attr('id');
    $.ajax({
        type: 'POST',
        url: '/pn/api/dashboard/remove_goal.php',
        data: {
            goal_id: goal_id
        },
        success: function() {
            get_goals();
            // for(let key in list) {
            //     if(list.hasOwnProperty(key)) {
            //         if(list[key].childNodes[0].textContent === goal) {
            //             list[key].remove();
            //             break;
            //         }
            //     }
            // }
            // --goal_len;
        },
        error: function() {
            console.log("ERROR");
        }
    });
}
