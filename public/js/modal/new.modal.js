$(document).ready(function () {
    $(document).on('click', 'a', function (event) {
        if (!$(this).hasClass('open-in-modal')) {
            return;
        }
        event.preventDefault();
        getAjaxPage($(this).attr('href'), null, null, $(this).closest('.modal'));

    });

    $(document).on("click", "div", function (event) {
        if ($(this).hasClass('calendar-day')) {
            document.getElementById('calendar-day-detail-container').innerHTML = '';
            console.log(window.navigator.language);
            let url = $(this).attr('data-info-href');
            $.ajax({
                type: 'GET',
                url: url,
                success: function (page) {
                    document.getElementById('calendar-day-detail-container').innerHTML = page;
                },
                error: function (jqXHR, exception) {
                    alert('Erroare incarcare MODAL');
                }
            });
        }
    });

    $(document).on("click", "button", function (event) {
        if ($(this).hasClass('open-in-modal')) {
            getAjaxPage($(this).attr('data-href'), null, null, $(this).closest('.modal'));
        }
    });
    $(document).on("click", "button", function (event) {
        if ($(this).hasClass('ajax-action')) {
            ajaxAction($(this).attr('data-href'));
        }
    });
    $(document).on("click", "button", function (event) {
        if ($(this).hasClass('btn-modal-refresh')) {
            refreshModal($(event.target.closest('.modal')).attr('data-href'), null, $(event.target.closest('.modal')));
        }
    });
    $(document).on("click", "button", function (event) {
        if ($(this).hasClass('btn-modal-maximize')) {
            var win = window.open($(event.target.closest('.modal')).attr('data-href'), '_blank');
            win.focus();
        }
    });
    $(document).on("click", "button", function (event) {
        if ($(this).hasClass('btn-modal-close')) {
            var sender_modal_id = $(event.target.closest('.modal')).attr('data-sender');
            $(event.target.closest('.modal')).remove();
            if (sender_modal_id) {
                refreshModalId(sender_modal_id);
            } else {
                location.reload();
            }
        }
    });
    $(document).on("click", "button", function (event) {
        if ($(this).hasClass('btn-modal-close-no-refresh')) {
            $(event.target.closest('.modal')).remove();
        }
    });
    $(document).on("click", "button", function (event) {
        if ($(this).hasClass('btn-ask-confirm')) {
            var confirmMessage = $(this).attr('data-confirm')?$(this).attr('data-confirm'):'Confirm ?';
            var sender_modal_id = $(event.target.closest('.modal')).attr('id');
            var conf = confirm(confirmMessage);
            if (conf) {
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('data-href'),
                    success: function () {
                        if (sender_modal_id) {
                            refreshModalId(sender_modal_id);
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        }
    });
    $(document).on("click", "button", function (event) {
        if ($(event.target).hasClass('submit') && $(event.target.closest('.modal')).length > 0) {
            event.preventDefault();
            var form = $(event.target.closest('form'));
            var modal = $(event.target.closest('.modal'));
            var sender_modal_id = $(event.target.closest('.modal')).attr('data-sender');
            $.ajax({
                type: form.attr('method'),
                data: getFormElements(form[0]),
                url: modal.attr('data-href'),
                success: function (page) {
                    var modalObj = $(page);
                    setModalTitle(modal);
                    document.getElementById(modal.attr('id')).innerHTML = $(page).html();
                    $('.popup-container').draggable({
                        handle: ".modal-header"
                    });
                    initSelect2();

                    if ($(page).find('.has-error').length > 0) {
                        setModalTitle(modal);
                    } else if ($(page).find('.has-step').length > 0) {
                        console.log($(page).attr('data-href'));
                        console.log(modal.attr('data-href'));
                        document.getElementById(modal.attr('data-href', $(page).attr('data-href')));
                        setModalTitle(modal);
                    } else {
                        // return;
                        // close modal
                        document.getElementById(modal.attr('id')).remove();
                        // refresh sender
                        if (sender_modal_id) {
                            refreshModalId(sender_modal_id);
                        } else {
                            location.reload();
                        }
                    }

                },
                error: function (jqXHR, exception) {
                    var response = (JSON.parse(jqXHR.responseText));
                }
            })
        }

    });

    $(document).on("submit", "form", function (event) {
        if ($(event.target.closest('.modal')).attr('data-href')) {
            event.preventDefault();
            var searchValue = ($(this).find('input[name="search"]').val());
            var qParams = {'search': searchValue};
            getAjaxPage($(event.target.closest('.modal')).attr('data-href'), qParams, $(event.target.closest('.modal')), $(event.target.closest('.modal')).attr('data-sender'));
        }
    });

    function ajaxAction(url)
    {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (page) {
                console.log(page);
                if (page.success === true){
                    leftMessage(page.message, 'success', 3);
                } else {
                    leftMessage(page.message, 'danger', 3);
                }
            }
        });
    }

    function getAjaxPage(url, qParams, oldModal, senderModal) {
        $.ajax({
            type: 'GET',
            url: url,
            data: qParams,
            success: function (page) {
                var modalObj = $(page);
                modalObj.attr('id', makeid());
                setModalTitle(modalObj);
                if (oldModal) {
                    document.getElementById(oldModal.attr('id')).innerHTML = $(page).html();
                    document.getElementById(oldModal.attr('data-href', $(page).attr('data-href')));
                    setModalTitle(oldModal);
                } else {
                    $('#popupCollection').append(modalObj);
                    $('#' + modalObj.attr('id')).modal('show');
                    if (senderModal) {
                        $(modalObj).attr('data-sender', senderModal.attr('id'));
                    }
                }
                $('.popup-container').draggable({
                    handle: ".modal-header"
                });
                initSelect2();
            },
            error: function (jqXHR, exception) {
                alert('Erroare incarcare MODAL');
            }
        });
    }

    function setModalTitle(modalObj) {
        modalObj.find('.titlu-modal-popup').text(modalObj.find('.panel-title').text());
        modalObj.find('.panel-title').hide();
    }

    function refreshModal(url, qParams, oldModal) {
        $.ajax({
            type: 'GET',
            url: url,
            data: qParams,
            success: function (page) {
                document.getElementById(oldModal.attr('id')).innerHTML = $(page).html();
                setModalTitle(oldModal);
                $('.popup-container').draggable({
                    handle: ".modal-header"
                });
                initSelect2();
            }
        });
    }


    function getFormElements(aform) {
        var form_elements = {};
        for (e = 0; e < aform.elements.length; e++) {
            if (aform.elements[e].name !== '' || aform.elements[e].name !== 'undefined') {
                switch (aform.elements[e].type) {
                    case 'checkbox':
                        // Fix for checkbox sent with ajax
                        if (aform.elements[e].checkbox) {
                            form_elements[aform.elements[e].name] = aform.elements[e].checkbox;
                        }
                        break;
                    case 'select-multiple':
                        var multiselect_array = $("#" + aform.elements[e].id).val();
                        form_elements[aform.elements[e].name] = multiselect_array;
                        break;
                    case 'undefined':
                        break;
                    default:
                        //obj_id='#'+aform.elements[e].id.toString();
                        form_elements[aform.elements[e].name] = aform.elements[e].value;
                        break;

                }
            }
        }
        return form_elements;
    }

    function refreshModalId(modalId) {
        var modal = $('#' + modalId);
        refreshModal(modal.attr('data-href'), null, modal);
    }

    function leftMessage(message, type, timeout) {
        var message_id = makeid();
        var modal = '<div id="' + message_id + '" style="z-index:9999999;"><div class="message-box btn-' + type + '">' + message + '' +
            '<button class="pull-right btn btn-' + type + ' btn-leftMessage" onclick="RemoveDivID(\'' + message_id + '\')"><i class="glyphicon glyphicon-remove"></i></button>' +
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

    function initSelect2() {
        // $('.select2').select2();
    }

    initSelect2();
});