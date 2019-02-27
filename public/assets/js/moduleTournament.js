import iziToast from './app';

$(document).ready(function () {
    let mt = new ModuleTournament();
});

class ModuleTournament {
    constructor() {
        this.watchers();
    }

    watchers() {
        this.watchEdit();
        this.watchAdmin();
    }

    watchEdit() {
        let mt = this;
        $('#edit-tournament').on('click', function () {
            let slugEvent = $(this).data('slugevent');
            mt.getFormEdit(slugEvent, $(this).closest('.module-content'));
        })
    }

    watchAdmin() {
        let mt = this;
        $('#admin_tournament').on('click', '.add-score', function () {
            mt.addScore($(this));
        });
    }

    getFormEdit(eventSlug, module_content) {
        return $.post('/event/' + eventSlug + '/tounament-parameters', {ajax: true}, function (datas) {
            module_content.html(datas);
        }, 'html');
    }

    addScore(elem) {
        let match = elem.closest('.match');
        let score = [];
        let error = false;
        match.find('.score').each(function () {
            let val = $(this).val();
            if (score === '') {
                error = true;
                iziToast.warning({
                    title: 'Attention',
                    message: 'Veuillez saisir un score'
                });
            } else {
                let player_id = $(this).data('player-id');
                let score_id = $(this).data('score-id');
                score_id = (typeof score_id === 'undefined') ? null : score_id;
                score.push({
                    score: val,
                    player_id: player_id,
                    score_id: score_id
                });
            }
        });
        score = JSON.stringify(score);
        return $.post('/match/' + match.data('match-id') + '/add-score', {score: score}, function(datas) {
            if (datas.etat === 'error') {
                iziToast.error({
                    title: 'Erreur',
                    message: datas.message
                });
            }
        }, 'json');
    }
}