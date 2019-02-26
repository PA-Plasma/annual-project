export default function keyDownEnter(input, button) {
    $(input).keypress(function (e) {
        if (e.which === 13) {
            $(button).click();
        }
    });
}