//(Re)Populates #exercise_favorites
import Guide from "../../api/guides/Guide.js";
import Pages from "../../api/guides/Pages.js";

$(window).on("load", function () {
    get_exercise_fav();
});

function get_exercise_fav() {
    let paged_guides;
    let exercise = Array();
    $.ajax({
        type:'POST',
        url: './api/guides/get_guides_tag_filtered.php',
        data: {
            tags: ['exercise']
        },
        success: function(data) {
            let guide;
            const json = JSON.parse(data);
            for(let key in json) {
                if(json.hasOwnProperty(key)) {
                    //Creating a new guide object
                    guide = new Guide(json[key],function(){
                        get_exercise_fav()
                    });
                    if(guide.is_favorite === 1) {
                        exercise.push(guide);
                    }
                }
            }
            paged_guides = new Pages(exercise, 4, $('#exercise_favorites'));
        },
        error: function() {
            console.log("get_guides ERROR");
        }
    });
}
