require('./jQuery-Autocomplete/dist/jquery.autocomplete.min');

function watch() {
    // function addUserWatcher() {
    //     $('#entrant_add_button').on('click', function(e) {
    //         e.preventDefault();
    //         let name = $('#entrant_add').val();
    //         $.post('/ajax/user/search/', {
    //             slug: name
    //         }, function(datas){
    //             console.log(datas);
    //         }, 'json');
    //     })
    // }

    // addUserWatcher();

    $('#entrant_add').autocomplete({
        serviceUrl: '/ajax/user/search',
        dataType: 'json',
        onSelect: function (suggestion) {

        }
    });
}

$(document).ready(function () {
    watch();
});