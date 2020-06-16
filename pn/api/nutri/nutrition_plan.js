import Guide from '../guides/Guide.js';


$( window ).on( "load", function() {
    Guide.get_guides(
        [$('#nutrition_favorites')],
        [['nutrition']],
        [true],
        4
    );
    get_plan();
    food_by_blood();

});

function buildTable(data){
    let table = document.getElementById('plan_table')
    for(let i = 0; i < data.length; i++){
        let row =` <tr>
                                        <td>${data[i].Meal}</td>
                                        <td>${data[i].Protein + " grams"}</td>
                                        <td>${data[i].Starch + " grams"}</td>
                                        <td>${data[i].Vegetables +" ounces"}</td>
                                        <td>${data[i].Fruits}</td>
                                        <td>${data[i].Fats  +" grams"}</td>
                                    </tr>`
        table.innerHTML += row
    }
}

function get_plan() {
    $.ajax({
        type: 'POST',
        url: '/pn/api/nutri/meal_calc.php',

        success: function (data) {
            let json = JSON.parse(data);
            buildTable(json);
        }
    });
}

function food_by_blood(){
    $.ajax({
        type: 'POST',
        url: '/pn/api/nutri/blood.php',
        success: function(data){
            document.getElementById("blood").innerHTML = data;
        }
    });
}

