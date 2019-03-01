import iziToast from './app';

$(document).ready(function () {
    let moduleTournament = new ModuleTournament();
});

class ModuleTournament {
    constructor() {
        this.watchers();
        this.getMatches();
        this.tournament_id = $('#moduleTournament').data('id');
    }

    watchers() {
        this.watchEdit();
        this.watchAdmin();
    }

    watchEdit() {
        let moduleTournament = this;
        $('#edit-tournament').on('click', function () {
            let slugEvent = $(this).data('slugevent');
            moduleTournament.getFormEdit(slugEvent, $(this).closest('.module-content'));
        })
    }

    watchAdmin() {
        let mt = this;
        $('#admin_tournament').on('click', '.add-score', function () {
            mt.addScore($(this));
        });

        $('#admin_tournament').on('click', '#init-matches', function() {
            mt.initMatches();
        })
    }

    getFormEdit(eventSlug, module_content) {
        return $.post('/event/' + eventSlug + '/tounament-parameters', {ajax: true}, function (datas) {
            module_content.html(datas);
        }, 'html');
    }

    initMatches() {
        let mt = this;
        $.post('/tournament/'+mt.tournament_id+'/create-matches', {}, function(data) {
            if (data.etat === 'success') {
                mt.getMatches();
                iziToast.success({
                    message: data.message
                });
            } else {
                iziToast.error({
                    message: data.message
                })
            }
        }, 'json')
    }

    addScore(elem) {
        let mt = this;
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
        return $.post('/tournament/add-score/' + match.data('match-id'), {score: score}, function (datas) {
            if (datas.etat === 'error') {
                iziToast.error({
                    title: 'Erreur',
                    message: datas.message
                });
            }
            mt.getMatches();
        }, 'json');
    }

    getMatches() {
        return $.post('/tournament/' + $('#moduleTournament').data('id') + '/matches', {}, function (data) {
            $('#tournement-content').html(data);
        }, 'html');
    }
}