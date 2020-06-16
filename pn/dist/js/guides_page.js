import Guide from "./../../api/guides/Guide.js";

$(document).ready(function () {
    //Perform search on search click
    $('#search-submit').on('click', search);
    //Perform search on enter-key
    $('#search-input').keyup(function(event) {
        if ($(this).is(":focus") && event.key === "Enter") {
            search();
        }
    });
    //Get all guides initially (searching "")
    perform_search();
});

function search(){
    var search = $('#search-input').val();  //Gettingsearch  from search input
    perform_search(search); //Performing search
    $('#results-title').html('Results for "' + search + '"') //Renaming title of results card
}

function perform_search(search_terms) {
    $.ajax({
        type: "POST",
        data: {
            search_terms: search_terms
        },
        url: './api/guides/get_guides_term_search.php',
        success: function (data) {
            const searchResults = JSON.parse(data);
            let guide;
            $('#search-results').html('');
            for (let key in searchResults) {
                if (searchResults.hasOwnProperty(key)) {
                    //Creating a new guide object
                    guide = new Guide(searchResults[key]);
                    $('#search-results').append(guide.card);
                }
            }
        },
        error: function () {
            console.log('Error Retrieving search results')
        }

    });
}