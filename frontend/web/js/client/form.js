$(document).ready(
    $('#dynamic-form').on('beforeSubmit', function(event, jqXHR, settings) {
        var form = $(this);
        if(form.find('.has-error').length) {
            return false;
        }

        $('input[client_id]').each(function () {
            $(this).val($(this).attr('client_id'));
        });

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            beforeSend: function(xhr) {
            },
            success: function(data) {
                form.yiiActiveForm("updateMessages",data);
                if (form.find('.has-error').length == 0) {
                    //form.submit();
                } else {
//                    Pace.stop();
                }
            },
            error: function(data) {
            },
            complete: function() {
            },
        });
        return false;
    })
);