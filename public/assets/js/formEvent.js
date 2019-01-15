require('./jQuery-Autocomplete/dist/jquery.autocomplete.min');

function watch() {
    function addUserWatcher() {
        $('#entrant_add_button').on('click', function(e) {
            e.preventDefault();
            let name = $('#entrant_add').val();
            let id = $('#entrant_add_store_id').val();
            $.post('/ajax/user/infos', {
                name: name,
                id: id
            }, function(datas){
                console.log(datas);
            }, 'json');
        })
    }

    addUserWatcher();

    $('#entrant_add').autocomplete({
        serviceUrl: '/ajax/user/search',
        dataType: 'json',
        onSelect: function (suggestion) {
            $('#entrant_add_store_id').val(suggestion.data);
        }
    });
}

$(document).ready(function () {
    watch();
});