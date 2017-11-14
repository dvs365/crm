$(function() {
    //принять изменения
    $(".recovery").click(function() {
        href = $(this).attr('input');
        nachem = $(this);

        $.ajax(
            {
                type: "POST",
                async: false,
                url: href,
                beforeSend: function() {
                    $(nachem).hide();
                },
                success: function(result) {
                    if(result) {
                        $(nachem).parent().parent().parent().remove();
                    } else {
                        apprise('<p>Error data!</p>');
                    }
                },
                error: function() {
                    apprise('<p>Error connect!</p>');
                }
            });
    })
    //отменить изменения
})