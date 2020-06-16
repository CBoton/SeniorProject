import Pages from './Pages.js';

export default class Guide {
    //json data and 'on_favorite' function that is triggered when a guide has been favorited (is optional), allows rebuilding of a page if needed
    constructor(json, on_favorite) {
        this.img_directory = '/pn/res/imgs/';
        this.id = json['guide_id'];
        this.thumbnail = json['thumbnail'];
        this.date_last_modified = json['date_last_modified'];
        this.name = json['guide_name'];
        this.subscription_level = json['subscription_level'];
        this.plan_name = json['plan_name'];
        this.is_favorite = json['fav'];
        this.tags = json['tags'];

        $(document).on('click','#guide-fav-' + this.id, this ,function(event){
			event.stopPropagation();
            event.data.favorite($(this),on_favorite);
        });
        if(!window.location.href.includes("owner_guides.php")) {
            $(document).on('click', '#guide-card-' + this.id, this, function (event) {
                window.location.href = "/pn/guide.php?id=" + event.data.id;
            });
        }
    }

    get card() {
        //Resource 1: https://css-tricks.com/perfect-full-page-background-image/
        //Resource 2: https://www.w3schools.com/cssref/pr_background-image.asp
        console.log(this.name + " " + this.thumbnail);
        var html =
            '<div class="col-lg-3 col-md-6 col-sm-12">' + this.get_ribbon() +
                '<div class="guide-card small-box elevation-2" id="guide-card-'+this.id+'" style="background-image: url('+ this.img_directory + this.thumbnail +'), url(/pn/res/imgs/default_thumb.png)">' +
                    '<div class="inner">' +
                        '<svg class="overlay-button ' + (this.is_favorite === 1 ? " favorite" : "") + '" ' +
                        'id="guide-fav-' + this.id + '" viewBox="0 0 940.688 940.688">' +
                            '<path d="M885.344,319.071l-258-3.8l-102.7-264.399c-19.8-48.801-88.899-48.801-108.6,0l-102.7,264.399l-258,3.8\n' +
                            'c-53.4,3.101-75.1,70.2-33.7,103.9l209.2,181.4l-71.3,247.7c-14,50.899,41.1,92.899,86.5,65.899l224.3-122.7l224.3,122.601' +
                            'c45.4,27,100.5-15,86.5-65.9l-71.3-247.7l209.2-181.399C960.443,389.172,938.744,322.071,885.344,319.071z"/>' +
                        '</svg>' +
                        '<div class="img-fluid" style="width:100%; padding-top: 56.25%" alt="Image failed to load"> </div>' +
                        // '<img class="img-fluid guide-thumbnail" src="' + this.img_directory + this.thumbnail + '" onerror="this.onerror=null;this.src=\'/pn/res/imgs/default_thumb.png\';" alt="Image failed to load">' +
                    '</div>' +
                    '<a class="small-box-footer guide-card-footer">' +
                        '<div class="row pl-1 pr-1">' +
                            '<div class="text-left col-7">' + this.name + '</div>' +
                            '<div class="text-right col-5">' + 'Added ' + this.date_str()  + '</div>' +
                        '</div>' +
                    '</a>' +
                '</div>' +
            '</div>';
        return html;
    }

    date_str() {
        if (this.date_last_modified !== undefined && this.date_last_modified !== null) {
            const year_month_day = this.date_last_modified.split('-');
            const date = new Date(year_month_day[0], year_month_day[1] - 1, year_month_day[2]);
            const cur_date = new Date();
            const milli_in_day = 24 * 60 * 60 * 1000;
            const days_since = Math.floor(Math.abs(cur_date - date) / milli_in_day);
            if (days_since >= 365) {
                const years_since = cur_date.getFullYear() - date.getFullYear();
                return years_since.toString() + ((years_since > 1) ? (' years ago') : (' year ago'));
            }
            if (days_since > 30) {
                let months_since = cur_date.getMonth() - date.getMonth();
                if (months_since < 0) months_since = months_since + 12;
                return months_since.toString() + ((months_since > 1) ? (' months ago') : (' month ago'));
            }
            switch (days_since) {
                case 0:
                    return 'today';
                case 1:
                    return 'yesterday';
                default:
                    return days_since.toString() + ' days ago';
            }
        }
    }

    get_ribbon() {
        if(this.subscription_level === 0) return "";
        let color_levels = {
            // "BEGINNER" : '<div class="ribbon plan-beginner-bg">',
            // "INTERMEDIATE" : '<div class="ribbon plan-intermediate-bg">',
            1 : '<div class="ribbon plan-advanced-bg">', //"ADVANCED"
            2 : '<div class="ribbon plan-personal-bg">' //"PERSONAL"
        };
        return (
            '<div class="ribbon-wrapper ribbon-lg" style="right:5px">' +
            color_levels[this.subscription_level] +
            this.plan_name +
            '</div>' +
            '</div>'
        );
    }

    //Sends favorite message to db AND executes'on_favorite' function that can perform a rebuild of some sort on your page
    favorite(wrapper, on_favorite_handler) {
        let classes = $(wrapper).attr('class').toString();
        const guide_id = $(wrapper).attr('id').slice('guide-fav-'.length);
        const favorited = classes.includes('favorite') ? 1 : 0;
        $.ajax({
            type:'POST',
            url: '/pn/api/dashboard/favorite_guide.php',
            data: {
                guide_id: guide_id,
                favorited: favorited
            },
            success: function() {
                if(favorited){
                    $(wrapper).removeClass('favorite')
                } else {
                    $(wrapper).addClass('favorite')
                }
                //Fire toast alert?

                //Perform callback function
                if (isFunction(on_favorite_handler)) {
                    on_favorite_handler();
                }
            },
            error: function() {
                console.log("ERROR");
            }
        });

        //Checks if the passed param is a function
        function isFunction(functionToCheck) {
            return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
        }
    }

    //Parameter prototypes
    //containers: [ $(container1), $(container2), ...]
    //tag_bucket: [ [tag_for_1_a, tag_for_1_b, ...], [tag_for_2_a, tag_for_2_b, ...], ...]
    //favorite_only [ TRUE, FALSE, ...]
    //These will use corresponding indices, like containers[0] uses tag_bucket[0] and favorite_only[0]
    //Width specifies how many guides are allowed per page.
    static get_guides(containers, tag_bucket, favorite_only, width) {
        let tags = Array();
        for(let i = 0; i < tag_bucket.length; ++i)
            for(let j = 0; j < tag_bucket[i].length; ++j)
                tags.push(tag_bucket[i][j]);
        $.ajax({
            type:'POST',
            url: '/pn/api/guides/get_guides_tag_filtered.php',
            data: {
                tags: tags
            },
            success: function(data) {
                let guide;
                let guide_tags;
                const json = JSON.parse(data);
                let guides_bucket = Array();
                for(let i = 0; i < containers.length; ++i) guides_bucket[i] = Array();
                for(let key in json) {
                    if(json.hasOwnProperty(key)) {
                        //Create a Guide object using the JSON value, making sure to add the favorite listener.
                        //Favorites just calls for a get_guides again to get an updated set.
                        guide = new Guide(json[key], function() {
                            Guide.get_guides(containers, tag_bucket, favorite_only, width);
                        });
                        //Go through each cluster of tags, these clusters each correspond to a container.
                        for(let index = 0; index < tag_bucket.length; ++index) {
                            //Turn the list of tags from a string to an array
                            guide_tags = guide.tags.split(',');
                            //Check if any of the tags from the guide exist in the current cluster of tags
                            if(guide_tags.some(tag => tag_bucket[index].indexOf(tag) !== -1)) {
                                //If the container we're working with only wants favorites, make sure the guide is a favorite.
                                if(favorite_only[index]) {
                                    if (guide.is_favorite)
                                        guides_bucket[index].push(guide);
                                }
                                //Otherwise just put it in the appropriate spot in the collection of guides.
                                else guides_bucket[index].push(guide);
                            }
                        }
                    }
                }
                //Go through all the guide clusters and make new pages with them. Pages takes care of the html population.
                for(let index = 0; index < guides_bucket.length; ++index)
                    new Pages(guides_bucket[index], width, containers[index]);
            },
            error: function() {
                console.log("get_guides ERROR");
            }
        });
    }
};
