$(document).ready(function () {
    let moduleTeam = new ModuleTeam();
});

class ModuleTeam {
    constructor() {
        this.watchers();
    }

    watchers() {
        this.watchEdit()
    }

    watchEdit() {
        let moduleTeam = this;
        $('#edit-team').on('click', function () {
            let slugEvent = $(this).data('slugevent');
            moduleTeam.getFormEdit(slugEvent, $(this).closest('.module-content'));
        })
    }

    getFormEdit(eventSlug, module_content) {
        return $.post('/event/'+ eventSlug +'/team-parameters', {ajax: true},function(datas) {
            module_content.html(datas);
        }, 'html');
    }
}