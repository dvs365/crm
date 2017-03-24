$(function () {
    $('#tell').on('click', function () {
        var text = $("#todo-name");
        text.val(text.val() + ' Звонок ');
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
    $('#missed').on('click', function () {
        $('[current]').hide();
        $('[missed]').show();
        $('#current').removeClass('cur');
        $('#important').removeClass('cur');
        $('#missed').addClass('cur');
    });
    $('#current').on('click', function () {
        $('[missed]').hide();
        $('[current]').show();
        $('#missed').removeClass('cur');
        $('#important').removeClass('cur');
        $('#current').addClass('cur');
    });

    $('#client').on('click', function () {
        $('[missed]').hide();
        $('[current]').hide();
        $('[client]').show();
        $('#missed').removeClass('cur');
        $('#current').removeClass('cur');
        $('#important').addClass('cur');
    })
    $("td").each(function() {
        var span = $(this).children('a').children('span').text();
        if (span) {
            if (span < 6) {
                $(this).attr("level-10","");
            }
            if (span > 5 && span < 11) {
                $(this).attr("level-09","");
            }
            if (span > 10 && span < 16) {
                $(this).attr("level-08","");
            }
            if (span > 15 && span < 21) {
                $(this).attr("level-07","");
            }
            if (span > 20 && span < 26) {
                $(this).attr("level-06","");
            }
            if (span > 25 && span < 31) {
                $(this).attr("level-05","");
            }
            if (span > 30 && span < 36) {
                $(this).attr("level-04","");
            }
            if (span > 35 && span < 41) {
                $(this).attr("level-03","");
            }
            if (span > 40 && span < 46) {
                $(this).attr("level-02","");
            }
            if (span > 45) {
                $(this).attr("level-01","");
            }

        }
    });
});