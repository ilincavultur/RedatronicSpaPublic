$(document).on("click", "button", function (event) {
    if ($(this).hasClass('reload-month')) {
        console.log(event);

        $.ajax({
            type: 'GET',
            url: $(this).attr('data-href'),
            success: function (page) {
                document.getElementById('month6').innerHTML = $(page).html();

            }
        });
    }
});
$(document).on("click", "button", function (event) {
    if ($(this).hasClass('btn-close')) {
        $(event.target.closest('div')).remove();
    }
});
// $(document).on("click", "button", function (event) {
//     if ($(this).hasClass('btn-modal-close')) {
//         // $(event.target.closest('modal')).remove();
//     }
// });
$(document).on("click", "button", function (event) {
    if ($(this).hasClass('btn-delete')) {
        console.log($(this).attr('data-href'));
        $.ajax({
            type: 'GET',
            url: $(this).attr('data-href'),
            success: function (page) {
                var confirmModalId = $(page).closest('div').attr('id');
                $('#popupCollection').append(page);
                $('#' + confirmModalId).modal('show');
            }
        });
    }
});
$(document).on("click", "button", function (event) {
    if ($(this).hasClass('btn-confirm')) {
        console.log($(this).attr('data-href'));
        $.ajax({
            type: 'GET',
            url: $(this).attr('data-href'),
            success: function (page) {
                var confirmModalId = $(page).closest('div').attr('id');
                $('#confirmCollection').append(page);
                $('#' + confirmModalId).modal('show');
            }
        });
    }
});
$(document).on("click", "button", function (event) {
    if ($(this).hasClass('ajax-call')) {
        console.log($(this).attr('data-href'));
        $.ajax({
            type: 'GET',
            url: $(this).attr('data-href'),
            success: function (page) {
                if (page.success){
                    $(event.target.closest('button')).remove();
                    leftMessage('Success','succes', 3);
                }
            }
        });
    }
});

function leftMessage(message, type, timeout) {
    var message_id = makeid();
    var modal = '<div id="' + message_id + '" style="z-index:9999999;"><div class="message-box ' + type + '">' + message + '' +
        '<button class="pull-right btn ' + type + ' btn-leftMessage" onclick="RemoveDivID(\'' + message_id + '\')"><i class="glyphicon glyphicon-remove"></i></button>' +
        '</div></div>';
    $('#InfoCollection').append(modal);

    if (timeout > 0) {
        setTimeout(function () {
            $('#' + message_id).fadeOut("slow", function () {
                $(this).remove();
            });
        }, timeout * 1000);
    }
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 20; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
