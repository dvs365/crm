$(function() {
    //вернуть изменения
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
    });
    //принять изменения
    $(".copy").click(function() {
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
    });
    $("#checkbox-all").change(function() {
        var checkboxes = $(this).closest('form[cards]').find(':checkbox');
        checkboxes.prop('checked', $(this).is(':checked'));
    });
});
