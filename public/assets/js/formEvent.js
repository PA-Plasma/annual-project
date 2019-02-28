function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    //var $newFormLi = $('<li><input list="pseudo" class="pseudo_input_'+ index +'" type="text"></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}

function hideEntrant(){
    $(document).ready(function () {

        $(document).on('click', '.checkbox_input', function (e) {

                var checkboxId = $(this).attr('id');
                var split = checkboxId.split("_");
                console.log(split[2]);
                var numberCheckbox = parseInt(split[2]);
                var entrantId = "event_entrants_" + numberCheckbox + "_user_related";
                console.log($(entrantId));

            // $('checkbox').is(':checked')
            //$('input').('').hide();
        });
        //#event_entrants_1_user_related
        //#event_entrants_1_show_user_related

    });
}

function entrantType() {
    var $collectionHolder;

// setup an "add a tag" link
    var $addTagButton = $('<button type="button" class="add_entrant_link">Ajouter un inscrit</button>');
    var $newLinkLi = $('<li></li>').append($addTagButton);

    $(document).ready(function () {
        // Get the ul that holds the collection of tags
        $collectionHolder = $('ul.entrants');

        // add the "add a tag" anchor and li to the tags ul
        $collectionHolder.append($newLinkLi);

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addTagButton.on('click', function (e) {
            // add a new tag form (see next code block)
            addTagForm($collectionHolder, $newLinkLi);
        });
    });
}

// function initAutoCompleteOnPseudo(elem) {
//     //https://www.devbridge.com/sourcery/components/jquery-autocomplete/#
//     elem.autocomplete({
//         serviceUrl: '/ajax/user/search',
//         dataType: 'json',
//         onSelect: function (suggestion) {
//             //Récupération de la liste des utilisateurs déjà ajouté
//             let user_already_selected = [];
//             $('.entrants').find('.id_user_related').each(function() {
//                 user_already_selected.push($(this).val());
//             });
//             //si on ne trouve pas l'id dans le tableau
//             if (user_already_selected.includes(suggestion.data.toString()) === false) {
//                 elem.closest('li').find('.id_user_related').val(suggestion.data);
//             } else {
//                 //message d'erreur
//                 elem.val('');
//             }
//         }
//     })
// }

function watch() {
    function addUserWatcher() {
        $('#entrant_add_button').on('click', function (e) {
            e.preventDefault();
            let name = $('#entrant_add').val();
            let id = $('#entrant_add_store_id').val();
            $.post('/ajax/user/infos', {
                name: name,
                id: id
            }, function (datas) {
                console.log(datas);
            }, 'json');
        })
    }

    entrantType();
    hideEntrant();
    addUserWatcher();


    // $('#entrant_add').autocomplete({
    //     serviceUrl: '/ajax/user/search',
    //     dataType: 'json',
    //     onSelect: function (suggestion) {
    //         $('#entrant_add_store_id').val(suggestion.data);
    //     }
    // });
}

$(document).ready(function () {
    watch();
    $(document).on('change', '.pseudo_input', function (e) {
        var pseudo = $(this).val();
        var idUser = $(this).attr('id');
        var split = idUser.split("_");
        var numberCheckbox = parseInt(split[2]);
        var userId = "event_entrants_" + numberCheckbox + "_user_related";
        var mailId = "event_entrants_" + numberCheckbox + "_email";
        var path = '/ajax/user/match';
        $.get(path, {
            pseudo: pseudo,
        }, function (data) {})
            .done(function (data) {
                $('#' + userId).val(data.id);
                $('#' + mailId).hide();
                $('#' + mailId).val(data.mail);
            })
            .fail(function () {
                $('#' + mailId).show();
            });
    });
});