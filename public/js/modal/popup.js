$(document).ready(function () {

});

$('body').on('hidden.bs.modal', function () {
    if ($('.modal.in').length > 0) {
        $('body').addClass('modal-open');
    }
});

// function leftMessage(message, type, timeout) {
//     var message_id = makeid();
//     var modal = '<div id="' + message_id + '" style="z-index:9999999;"><div class="message-box ' + type + '">' + message + '' +
//         '<button class="pull-right btn ' + type + ' btn-leftMessage" onclick="RemoveDivID(\'' + message_id + '\')"><i class="glyphicon glyphicon-remove"></i></button>' +
//         '</div></div>';
//     $('#InfoCollection').append(modal);
//
//     if (timeout > 0) {
//         setTimeout(function () {
//             $('#' + message_id).fadeOut("slow", function () {
//                 $(this).remove();
//             });
//         }, timeout * 1000);
//     }
// }

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 20; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function RemovePopUp(popupid) {
    var popup = document.getElementById(popupid);
    if (popup) {
        popup.parentNode.removeChild(popup);
    }
    return false;
}

function RemoveDivID(div_id) {
    var div = document.getElementById(div_id);
    div.parentNode.removeChild(div);
    return false;
}

function refreshPage(popupid) {
    if (popupid) {
        get_page($('#' + popupid + '_popupid').val(), $('#' + popupid + '_page').val(), $('#' + popupid + '_source_page').val(), $('#' + popupid + '_sender_popupid').val());
    } else {
        document.location = document.location.href;
        location.reload();
    }
}

function maximize(popupid) {
    if (popupid) {
        source_page = $('#' + popupid + '_page').val();
        source_page = source_page.replace('&popupid=' + popupid, '');
        source_page = source_page.replace('./', '');
        source_page = source_page.replace('.php?', '&');
        url = source_page;
        var win = window.open(url, '_blank');
        win.focus();
    }
}

function PopUp(popup_id, page, source_page, titlu, width, sender_popupid, refresh_on_close) {
    var refresh = '';
    // page = page + '&popupid=' + popup_id;
    // RemovePopUp(popup_id);
    if (refresh_on_close) {
        if (sender_popupid === '') {
            refresh = 'refreshPage();'
        } else {
            refresh = "refreshPage('" + sender_popupid + "');";
        }
    }

    var modal_popup = '<div id="' + popup_id + '" class="modal fade modal-popup-container" data-backdrop="false" role="dialog" style="z-index:20000; position:absolute !important; top:10px !important;">' +
        '<div class="modal-dialog popup-container" style="width:' + width + '; ">' +
        '<div class="smart-modal-header-buttons">' +
        '<input type="hidden" name="popupid" value="' + popup_id + '"/>' +
        '<input type="hidden" id="' + popup_id + '_popupid" value="' + popup_id + '"/>' +
        '<input type="hidden" id="' + popup_id + '_page" value="' + page + '"/>' +
        '<input type="hidden" id="' + popup_id + '_source_page" value="' + source_page + '"/>' +
        '<input type="hidden" id="' + popup_id + '_sender_popupid" value="' + sender_popupid + '"/>' +
        '<button class="pull-right btn btn-danger btn-modal-header" data-dismiss="modal" onclick="RemovePopUp(\'' + popup_id + '\');' + refresh + '"><i class="glyphicon glyphicon-remove"></i></button>' +
        '<button class="pull-right btn btn-warning btn-modal-header" onClick="maximize(\'' + popup_id + '\');"><i class="glyphicon glyphicon-resize-full"></i></button>' +
        '<button class="pull-right btn btn-success btn-modal-header" onClick="refreshPage(\'' + popup_id + '\');"><i class="glyphicon glyphicon-refresh"></i></button>' +
        '</div>' +
        '<div class="modal-header smart-modal-header modal-header-bk-color">' +
        '<div class="titlu-modal-popup"><h3 class="titlu-modal-popup">' + titlu + '</h3></div>' +
        '</div>' +
        '<div class="modal-content" id="' + popup_id + '_content">' +
        '</div>' +
        '</div>' +
        '</div>';


    $('#popupCollection').append(modal_popup);

    get_page(popup_id, page, source_page, sender_popupid);
    $('.popup-container').draggable({
        handle: ".modal-header"
    });
    $('html, body').animate({
        scrollTop: $("#" + popup_id).offset().top
    }, 400);
}

function get_page(popup_id, page_to_load, source_page, sender_popupid) {
    var trg_div = popup_id + '_content';
    // tinymce.remove();
    $.ajax({
        type: 'GET',
        data: {source_url: source_page, page_to_load: page_to_load, sender_popupid: sender_popupid, popup_id: popup_id},
        url: page_to_load,
        success: function (page) {
            console.log(page);
            document.getElementById(trg_div).innerHTML = page;
            $('#' + popup_id).modal('show');
            $('#' + popup_id).find("script").each(function (i) {
                eval($(this).text());
            });
        },
        error: function (jqXHR, exception) {
            alert('Erroare incarcare MODAL');
        },
        complete: function () {

        }
    });
}

function submit_form_delete(formid, method, page, popup_id) {
    //document.getElementById(formid).submit();
}

function autosubmit(e, page, popupid, sender_id) {
    var sub_form = $(e).closest("form").attr('id');
    submit_form(sub_form, 'POST', page, popupid, sender_id, false);
    //submit_form(sub_form,'POST',page,popupid,$(e).attr('id'),false);
}

function switch_tabs(e, page, popupid, sender_id, tab_uid) {
    var form_id = $(e).closest("form").attr('id');
    addHidden(form_id, tab_uid + '[active_tab]', sender_id);
    submit_form(form_id, 'POST', page, popupid, sender_id, false);
    //submit_form(form_id,'POST',page,popupid,$(e).attr('id'),false);
}

function addHidden(form_id, key, value) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = value;
    $('#' + form_id).append(input);
}

function submit_form2(formid, method, page, popup_id, sender_id, validate) {
    if (validate != false) {
        var validare = validare_campuri();
    } else {
        var validare = true
    }
    if (validare) {
        if (popup_id != '') {
            var target_div_content = popup_id + '_content';
            addHidden(formid, sender_id, $('#' + sender_id).val());
            addHidden(formid, 'sender_object_id', sender_id);

            // tinyMCE.triggerSave();
            var formData = new FormData($('#' + formid)[0]);

            //$.extend(params,{sender_id: $('#'+sender_id).val()},{sender_object_id: sender_id});
            $.ajax({
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                url: page,
                success: function (page) {
                    // tinymce.remove();
                    document.getElementById(target_div_content).innerHTML = page;
                    $('#' + popup_id).modal('show');
                    $("html, body").scrollTop($('#' + popup_id).offset().top);
                    $('#' + popup_id).scrollTop(0);
                    $('#' + popup_id).focus();
                    $('#' + popup_id).find("script").each(function (i) {
                        eval($(this).text());
                        //console.log($(this).text());
                    });


                },
                error: function (jqXHR, exception) {
                    alert('Erroare incarcare MODAL');
                },
                complete: function () {
                    //refreshPage();
                }

            })
        } else {
            submit_form(formid, method, page, popup_id, sender_id, validate);
        }
    }
}

function DeleteForm(url, popupid) {
    $.ajax({
        type: 'DELETE',
        url: url,
        success: function () {
            if (popupid == '') {
                refreshPage();
            } else {

            }
        },
        error: function (jqXHR, exception) {
            var response = (JSON.parse(jqXHR.responseText));
            leftMessage(response['error'], 'btn-danger', 5);
        }
    });
}


function submit_form(formid, method, page, popup_id, sender_id, validate) {
    if (validate !== false) {
        var validare = validare_campuri();
    } else {
        var validare = true
    }
    if (validare) {

        if (popup_id !== '') {
            var target_div_content = popup_id + '_content';
            // addHidden(formid, sender_id, $('#' + sender_id).val());
            addHidden(formid, 'popup_id', popup_id);
            addHidden(formid, 'sender_object_id', sender_id);
            // tinyMCE.triggerSave();
            var params = (getFormElements(formid));
            var files = $('#upload_files');
            $.ajax({
                type: method,
                data: params,
                url: page,
                success: function (page) {
                    // tinymce.remove();
                    console.log(params);
                    document.getElementById(target_div_content).innerHTML = page;
                    $('#' + popup_id).modal('show');
                    $('#' + popup_id).find("script").each(function (i) {
                        //console.log($(this).text());
                        eval($(this).text());
                    });


                },
                error: function (jqXHR, exception) {
                    alert('Erroare incarcare MODAL');
                }
            })
        } else {
            addHidden(formid, sender_id, sender_id);
            addHidden(formid, 'sender_object_id', sender_id);

            document.getElementById(formid).submit();
        }
    }
}

function explode(s, separator, limit) {
    var arr = s.split(separator);
    if (limit) {
        arr.push(arr.splice(limit - 1, (arr.length - (limit - 1))).join(separator));
    }
    return arr;
}

function get_tab_page(target_div_content, page, source_page) {

    var ajax_page_loader = 'ajax_call.php';
    $.ajax({
        type: 'GET',
        data: {source_url: source_page, page: page},
        url: ajax_page_loader,
        success: function (page) {
            document.getElementById(target_div_content).innerHTML = page;
            $('#' + target_div_content).find("script").each(function (i) {
                eval($(this).text());
            });
        },
        error: function (jqXHR, exception) {
            alert('Erroare incarcare MODAL');
        },
        complete: function () {
        }
    });
}

function Save(idform, intrebare) {
    dialog('Salvare', intrebare, idform);
}

function confirm_delete(titlu, intrebare, url, popupid) {

    var popup_id = makeid();
    var target_div_content = popup_id + '_content';
    var modal_popup = '<div id="' + popup_id + '" class="modal fade delete-confirm-div" data-backdrop="false" role="dialog" style="z-index:65535;position: fixed !important;">' +
        '<div class="modal-dialog popup-container" style="width:400px;">' +
        '<div class="col-md-2  smart-modal-header-buttons">' +
        '<button class="pull-right btn btn-danger" data-dismiss="modal" onclick="RemovePopUp(\'' + popup_id + '\')"><i class="glyphicon glyphicon-remove"></i></button>' +
        '</div>' +
        '<div class="modal-header smart-modal-header btn-danger">' +
        '<div class="col-md-10"><h3 class="titlu-modal-popup">' + titlu + '</h3></div>' +
        '</div>' +
        '<div class="modal-content" id="' + popup_id + '_content">' +
        '<div class="confirm-dialog-text-area-div" align="center">' + intrebare + '</div>' +
        '<div class="confirm-dialog-btn-div" align="center">' +
        '<div class="confirm-dialog-btn"><button class="pull-right btn btn-success" onClick="RemovePopUp(\'' + popup_id + '\')"><i class="glyphicon glyphicon-remove"></i> NU</button></div>' +
        '<div class="confirm-dialog-btn"><button class="pull-right btn btn-danger mr-15" onClick="DeleteForm(\'' + url + '\',\'' + popupid + '\');RemovePopUp(\'' + popup_id + '\');"><i class="glyphicon glyphicon-ok"></i> DA</button></div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    $('#confirmCollection').append(modal_popup);
    $('#' + popup_id).modal('show');

}

function confirm_popup(titlu, intrebare, idform) {

    var validare = validare_campuri(idform);
    if (validare) {
        var popup_id = makeid();
        var modal_popup = '<div id="' + popup_id + '" class="modal fade" data-backdrop="false" role="dialog" style="z-index:65000;">' +
            '<div class="modal-dialog popup-container" style="width:400px;">' +
            '<div class="smart-modal-header-buttons">' +
            '<button class="pull-right btn btn-danger" data-dismiss="modal" onclick="RemovePopUp(\'' + popup_id + '\')"><i class="glyphicon glyphicon-remove"></i></button>' +
            '</div>' +
            '<div class="confirm-modal-header btn-warning">' +
            '<div class="titlu-modal-confirm-conatiner"><p class="titlu-modal-confirm">' + titlu + '</p></div>' +
            '</div>' +
            '<div class="modal-content" id="' + popup_id + '_content">' +
            '<div class="confirm-dialog-text-area-div" align="center">' + intrebare + '</div>' +
            '<div class="confirm-dialog-btn-div" align="center">' +
            '<div class="confirm-dialog-btn"><button class="pull-right btn btn-warning" onClick="RemovePopUp(\'' + popup_id + '\')"><i class="glyphicon glyphicon-remove"></i> NU</button></div>' +
            '<div class="confirm-dialog-btn"><button class="pull-right btn btn-success mr-15" onClick="submit_form_new(\'' + idform + '\',\'' + popup_id + '\');RemovePopUp(\'' + popup_id + '\');"><i class="glyphicon glyphicon-ok"></i> DA</button></div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        $('#confirmCollection').append(modal_popup);
        $('#' + popup_id).modal('show');
    }

}

function getPopup(e) {
    return e.closest('.modal-popup-container');
}

function getSenderPopupId(e) {
    var popup = getSenderPopup(e);
    var sender_id = $('#' + popup.attr('id') + '_sender_popupid').val();
    if (sender_id === 'undefined') {
        return null;
    }
    return sender_id;
}

function getSenderPopup(e) {
    return $(e).closest('.modal-popup-container');
}

function submit_form_new(form_id, popup_id, sender_id, validate) {
    var form = document.getElementById(form_id);
    var trg_div = popup_id + '_content';
    if (popup_id !== '') {
        var params = (getFormElements(form_id));
        $.ajax({
            type: form.method,
            data: params,
            url: form.action,
            success: function (page) {
                var popup = getPopup(form);
                document.getElementById(popup.id + '_content').innerHTML = page;
                if ($(page).find('.form_errors').val() === '1') {
                    leftMessage('Form Errors', 'btn-danger', 3);
                } else {
                    leftMessage('Salavat cu success', 'btn-success', 3);
                    // refresh sender
                    refreshPage(document.getElementById(popup.id + '_sender_popupid').value);
                    //remove modal
                    RemovePopUp(popup.id);

                }

            },
            error: function (jqXHR, exception) {
                var response = (JSON.parse(jqXHR.responseText));
                leftMessage(response['error'], 'btn-danger', 5);
            }
        })
    }
}

function alert_popup(titlu, intrebare) {
    var popup_id = makeid();
    var target_div_content = popup_id + '_content';
    var modal_popup = '<div id="' + popup_id + '" class="modal fade message-confirm-div" data-backdrop="false" role="dialog" style="z-index:20000;">' +
        '<div class="modal-dialog popup-container" style="width:400px;">' +
        '<div class="col-md-2  smart-modal-header-buttons">' +
        '<button class="pull-right btn btn-danger" data-dismiss="modal" onclick="RemovePopUp(\'' + popup_id + '\')"><i class="glyphicon glyphicon-remove"></i></button>' +
        '</div>' +
        '<div class="modal-header smart-modal-header btn-warning"><div class="col-md-10"><h3 class="titlu-modal-popup">' + titlu + '</h3></div>' +
        '</div>' +
        '<div class="modal-content" id="' + popup_id + '_content">' +
        '<div class="confirm-dialog-text-area-div" align="center">' + intrebare + '</div>' +
        '<div class="confirm-dialog-btn-div" align="center">' +
        '<div class="confirm-dialog-btn"><button class="center btn btn-warning" onClick="RemovePopUp(\'' + popup_id + '\')"><i class="glyphicon glyphicon-remove"></i> OK</button></div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    $('#confirmCollection').append(modal_popup);
    $('#' + popup_id).modal('show');
}


function dialog(title, intrebare, idform) {
    validare_campuri();

    $('#ModalConfirm-title').html(title);
    $('#confirm_question_text').html(intrebare);
    $('#confirm_ok_btn').click(function () {
        $('#' + idform).submit();
    });
}

function validare_campuri(idform) {
    var ix = 0;
    $('.required').each(function (i, obj) {
        switch (obj.tagName) {
            case 'SELECT':
                if (obj.value == '0' || obj.value == '-1') {
                    ix++;
                    leftMessage("Campul " + $('label[for=' + obj.id + ']').text() + " nu poate fi gol", 'btn-danger', 5);
                    if (ix < 2) {
                        $('#' + obj.id).focus();
                    }
                }
                break;
            case 'INPUT':
                if (obj.value == '') {
                    ix++;
                    leftMessage("Campul " + $('label[for=' + obj.id + ']').text() + " nu poate fi gol", 'btn-danger', 5);
                    if (ix < 2) {
                        $('#' + obj.id).focus();
                    }
                }
                break;
        }


    });
    if (ix === 0) {

        return true;
    } else {
        return false;
    }
}

function getFormElements(formid) {
    var aform = document.getElementById(formid);
    var form_elements = {};
    for (e = 0; e < aform.elements.length; e++) {
        if (aform.elements[e].name !== '' || aform.elements[e].name !== 'undefined') {
            switch (aform.elements[e].type) {
                case 'checkbox':
                    // Fix for checkbox sent with ajax
                    if (aform.elements[e].checked) {
                        form_elements[aform.elements[e].name] = aform.elements[e].checked;
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
    // console.log(form_elements);
    return form_elements;
//	return (unserialize(($('#'+formid+'').serialize())));
}

function unserialize(serializedString) {
    var str = decodeURI(serializedString);
    var pairs = str.split('&');
    var obj = {}, p, idx, val;
    for (var i = 0, n = pairs.length; i < n; i++) {
        p = pairs[i].split('=');
        idx = p[0];
        if (idx.indexOf("[]") == (idx.length - 2)) {
            var ind = idx.substring(0, idx.length - 2);
            if (obj[ind] === undefined) {
                obj[ind] = [];
            }
            obj[ind].push(p[1]);
        }
        else {
            obj[idx] = p[1];
        }
    }
    return obj;
}
