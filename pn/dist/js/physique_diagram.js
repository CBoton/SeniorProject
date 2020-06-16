import Guide from "../../api/guides/Guide.js"

$(document).ready(function () {
    //Mouse moved over a muscle, show tooltip
    $('.muscle').hover(function () {
        $('#info-box').css('display', 'block');

        //Display the correct form of the name
        let displayName =  getDisplayName(this);

        $('#info-box').html(displayName);
    });

    //Mouse click opens popup with guides associated with the
    $('.muscle').click(function(){
        console.log('Clicked')

        $('#modalRow').html(''); //Clearing the modal before showing it
        var tags = [$(this).attr('id')];
        get_guides_tag_filtered(tags, make_cards);

        $('#myModalLabel').html('Exercises for the <span style="font-weight: bold;">' + getDisplayName(this) + '</span>')
        $('#myModal').modal({
            backdrop: true,
            keyboard: true,
            show: true
        })
    })

    //Mouse moved off muscle, hide tooltip
    $('.muscle').mouseleave(function (e) {
        $('#info-box').css('display', 'none');
    });

    //Position tooltip on mouse
    $(document).mousemove(function (e) {
        $('#info-box').css('top', e.pageY - $('#info-box').height() - 30);
        $('#info-box').css('left', e.pageX - ($('#info-box').width()) / 2);
    }).mouseover();
});

//Returns the correct display name (w/o '_' for space), param: group element
function getDisplayName(group_ele) {
    let ret = $(group_ele).attr('data-name') === undefined ? $(group_ele).attr('id') : $(group_ele).attr('data-name');
    return ret;
}

//Make cards in
function make_cards(data) {
    let guide;
    let html_hold = Array();
    for(let key in data) {
        if(data.hasOwnProperty(key)) {
            guide = new Guide(data[key]);
            html_hold.push(guide.card)
        }
    }
    $('#modalRow').html(html_hold);
}

//tags array
function get_guides_tag_filtered(tags_array, make_cards){
    $.ajax({
        type: 'POST',
        url: 'api/guides/get_guides_tag_filtered.php',
        data: {
            number: 4,
            tags: tags_array
        },
        success: function (data) {
            console.log("command sent");
            console.log(data);
            make_cards(JSON.parse(data));
        },
        error: function () {
            console.log("ERROR")
        }
    })
}
