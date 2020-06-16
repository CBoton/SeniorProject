export default class Pages {

    constructor(list, width, obj) {
        this.obj = obj; //The page element
        this.width = width; //Number of elements allowed per page
        this.list = list; //Our list of guides
        this.cur_page = 1;
        this.first_page = 1;
        this.last_page = (Math.floor(this.list.length/this.width)) + 1;
        $(obj).on('click', '.page-nav.page-button', this, function(event) {
            event.data.set_current_page(parseInt(event.target.id));
            event.data.update_html();
        });
        this.update_html();
    }

    get_page_set() {
        let pages = [
            this.cur_page - 2,
            this.cur_page - 1,
            this.cur_page,
            this.cur_page + 1,
            this.cur_page + 2
        ];
        if(pages.includes(this.first_page))
            pages = pages.slice(pages.indexOf(this.first_page));
        if(pages.includes(this.last_page))
            pages.splice(pages.indexOf(this.last_page) + 1);
        return pages;
    }

    set_current_page(page) {
        if(page > this.last_page || page < this.first_page) return;
        this.cur_page = page;
    }

    get_numbers(set) {
        let string = Array();
        for(let number in set) {
            if(set.hasOwnProperty(number)) {
                if(set[number] === this.cur_page) string.push('<li class="page-nav page-button text current-page" id="' + set[number] + '">' + set[number] + '</li>');
                else string.push('<li class="page-nav page-button text" id="' + set[number] + '">' + set[number] + '</li>');
            }
        }
        return string.join("");
    }

    update_html() {
        let string = Array();
        const set = this.get_page_set();
        //Get numbers only if we actually have pages
        if(this.list.length > this.width) {
            string.push(
                '<div class="row">' +
                '<div class="col-12">' +
                '<ul class="page-nav float-left">' +
                '<li class="fas fa-angle-double-left page-nav page-button icon" id="' + this.first_page + '"></li>'
            );
            string.push(this.get_numbers(set));
            string.push(
                '<li class="fas fa-angle-double-right page-nav page-button icon" id="' + this.last_page + '"></li>' +
                '</ul>' +
                '</div>' +
                '</div>'
            );
        }

        //New row for guides
        string.push(
            '<div class="row">');

        //Insert guides
        for(let i = this.width * (this.cur_page - 1); i < this.list.length && i < (this.width * this.cur_page); ++i) {
            string.push(this.list[i].card);
        }

        //End row
        string.push(
            '</div>');

        //Get numbers only if we actually have pages
        if(this.list.length > this.width) {
            string.push(
                '<div class="row">' +
                '<div class="col-12">' +
                '<ul class="page-nav float-right">' +
                '<li class="fas fa-angle-double-left page-nav page-button icon" id="' + this.first_page + '"></li>'
            );
            string.push(this.get_numbers(set));
            string.push(
                '<li class="fas fa-angle-double-right page-nav page-button icon" id="' + this.last_page + '"></li>' +
                '</ul>' +
                '</div>' +
                '</div>'
            );
        }
        this.obj.html(string.join(""));
    }
};