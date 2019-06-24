import keyDownEnter from "./helper";

export default class Search {
    constructor(id_tableau, ajax_url, id_search, id_display_search, id_search_button, class_filtre_input, skeleton) {
        this.id_tableau = id_tableau;
        this.ajax_url = ajax_url;
        this.id_search = id_search;
        this.id_display_search = id_display_search;
        this.class_filtre_input = class_filtre_input;
        this.id_search_button = id_search_button;
        this.skeleton = skeleton;
        this.watch();
    }

    watch() {
        this.watchSearch();
    }

    watchSearch() {
        const list = this;
        $(list.id_display_search).on('click', function () {
            list.displaySearch();
        });
        $(list.id_search_button).on('click', function () {
            list.getContent();
        });
        $(list.id_search).find(list.class_filtre_input).each(function () {
            keyDownEnter('#' + $(this).attr('id'), list.id_search_button);
        });
    }

    getContent() {
        const list = this;
        let params = [];
        $(list.class_filtre_input).each(function () {
            params.push({
                name: $(this).attr('name'),
                value: $(this).val()
            });
        });
        return $.post(list.ajax_url, params, function (data) {
            $(list.skeleton).removeClass('active-skeleton');
            $(list.id_tableau).html(data);
        }, 'html');
    }

    displaySearch() {
        //--- affichage des champs de recherche
        const list = this;
        let classSearch = $(this.id_search).attr('class');
        if (classSearch === 'd-none') {
            $(list.id_search).attr('class', '');
            $(list.id_display_search).html('<i class="fa fa-times"></i> Cancel research');
        } else {
            $(list.id_search).attr('class', 'd-none');
            $(list.id_display_search).html('<i class="fa fa-search"></i> Search');
            $(list.class_filtre_input).each(function () {
                $(this).val('');
            });
            list.getContent();
        }
    }

}