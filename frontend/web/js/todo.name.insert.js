$(function () {
    $('#tell').on('click', function () {
        var text = $("#todo-name");
        text.val(text.val() + ' Позвонить ');
    });
    $('#mail').on('click', function () {
        var text = $("#todo-name");
        text.val(text.val() + ' Написать ');
    });
    $('#bill').on('click', function () {
        var text = $("#todo-name");
        text.val(text.val() + ' Счет ');
    });
    $('#check').on('click', function () {
        var text = $("#todo-name");
        text.val(text.val() + ' Контроль оплаты ');
    });
});