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
