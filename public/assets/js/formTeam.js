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
    $newLinkLi.before($newFormLi);
}

function teamsType() {
    var $collectionHolder;
    var $addTagButton = $('<button type="button" class="add_team_link">Ajouter une team</button>');
    var $newLinkLi = $('<li></li>').append($addTagButton);

    $(document).ready(function () {
      $collectionHolder = $('ul.teams');
      $collectionHolder.append($newLinkLi);
      $collectionHolder.data('index', $collectionHolder.find(':input').length);

      $addTagButton.on('click', function (e) {
        addTagForm($collectionHolder, $newLinkLi);
      });
    });
}

function watch() {
    teamsType();
}

$(document).ready(function () {
    watch();
});