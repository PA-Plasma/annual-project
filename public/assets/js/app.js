/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

//izitoast
const iziToast = require('../../node_modules/izitoast/dist/js/iziToast.min.js');


let message_succes= $('#success_iz').data('message');
let message_error= $('#error_iz').data('message');
$('#success_iz').show(function () {
    iziToast.success({timeout: 5000, icon: 'fa fa-chrome', message: message_succes});
});

$('#error_iz').show(function () {
    iziToast.error({timeout: 5000, icon: 'fa fa-chrome', message: message_error});
});

export default iziToast;


$(document).on('click', '#register_user', (function () {
    var path = $("#register_user").attr("data-path");
    $.post(path, function (data) {
        iziToast.success({
            title: 'Inscription validé !'
        });
        $("#modalEntrant").html(data);
    });
}));

$(document).on('click', '#cancel_user', (function () {
    var path = $("#cancel_user").attr("data-path");
    $.post(path, function (data) {
        iziToast.success({
            title: 'Inscription annulé !'
        });
        $("#modalEntrant").html(data);
    });
}));


// EVENT TAB LOCAL STORAGE
let openedTab = localStorage.getItem('opened-tab');
let eventInfoLink = $('.event-info-link');
let eventInfoBody = $('.event-info-body');
let infoTabLink = $('.informations-tab');
let infoTabContent = $('.informations-tab-content');

if (openedTab) {
  eventInfoLink.removeClass('active');
  eventInfoBody.removeClass('active show');
  $('#'+openedTab).addClass('active');
  $('#'+openedTab+'-content').addClass('active show');
} else {
  infoTabLink.addClass('active');
  $(infoTabContent).addClass('active show');
}

eventInfoLink.click(function(event) {
    localStorage.setItem('opened-tab', event.target.id);
});