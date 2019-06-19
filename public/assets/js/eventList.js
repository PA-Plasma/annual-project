import Search from "./Search";

$(document).ready(function () {
    let le = new Search('#list-event', '/event/list/', '#search', '#display-search', '#rechercher', '.filtre-input', '.skeleton');
    le.getContent();
});