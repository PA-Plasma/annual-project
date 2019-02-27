$(document).ready(function () {
    let moduleTournament = new ModuleTournament();
});

class ModuleTournament {
    constructor() {
        this.watchers();
    }

    watchers() {
        this.watchEdit()
    }

    watchEdit() {
        let moduleTournament = this;
        $('#edit-tournament').on('click', function () {
            let slugEvent = $(this).data('slugevent');
            moduleTournament.getFormEdit(slugEvent, $(this).closest('.module-content'));
        })
    }

    getFormEdit(eventSlug, module_content) {
        return $.post('/event/'+ eventSlug +'/tounament-parameters', {ajax: true},function(datas) {
            module_content.html(datas);
        }, 'html');
    }
}