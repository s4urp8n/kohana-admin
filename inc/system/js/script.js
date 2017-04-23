$(document).ready(function () {

    $('textarea.editor').each(function () {
        var _loading = '<div id="_image_editor_upload" \
                style="position:fixed;top:30%;left:0;display:block;width:100%;background:none;text-align:center;">\
                    <div style="box-shadow:0 0 10px #BBB;background:#FFF;display:inline-block;width:80px;height:80px;padding-top:5px;border-radius:20px;">\
                        <i style="color:#2F8AB9;" class="fa fa-cog fa-spin fa-3x"></i>\
                        <p style="font-weight:bold;color:#2F8AB9;">Загрузка</p>\
                    </div>\
                </div>';
        var that = $(this);
        var data = '';
        var form = that.parents('form');
        that.summernote({
                            height: '400px',
                            onImageUpload: function (files) {
                                data = new FormData();
                                data.append("imageupload", files[0]);
                                $('body').append(_loading);
                                $.ajax({
                                           data: data,
                                           type: "POST",
                                           url: "/admin/ajaxeditor",
                                           cache: false,
                                           contentType: false,
                                           processData: false
                                       }).done(function (output) {
                                    that.summernote('editor.insertImage', output);
                                    $('#_image_editor_upload').remove();
                                });
                            }
                        });
    });

    $('textarea.youtube').youtube();

    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false
    };
    $.datepicker.setDefaults($.datepicker.regional['ru']);

    $("input.date").each(function () {
        if (/\d{4}-\d{2}-\d{2}/.test($(this).val())) {
            var val = $(this).val().toString().split('-');
            switch (val[1]) {
                case '01':
                    val[1] = 'Январь';
                    break;
                case '02':
                    val[1] = 'Февраль';
                    break;
                case '03':
                    val[1] = 'Март';
                    break;
                case '04':
                    val[1] = 'Апрель';
                    break;
                case '05':
                    val[1] = 'Май';
                    break;
                case '06':
                    val[1] = 'Июнь';
                    break;
                case '07':
                    val[1] = 'Июль';
                    break;
                case '08':
                    val[1] = 'Август';
                    break;
                case '09':
                    val[1] = 'Сентябрь';
                    break;
                case '10':
                    val[1] = 'Октябрь';
                    break;
                case '11':
                    val[1] = 'Ноябрь';
                    break;
                case '12':
                    val[1] = 'Декабрь';
            }
            val = val[2] + ' ' + val[1] + ' ' + val[0];
            $(this).val(val);
        }
    });

    $("input.date").datepicker({
                                   changeMonth: true,
                                   dateFormat: "dd MM yy",
                                   changeYear: true
                               });

    $("body").on("click", ".fieldsSave", function (event) {
        event.preventDefault();
        $("input.date").each(function () {
            if (!/\d{4}-\d{2}-\d{2}/.test($(this).val())) {
                var val = $(this).val().toString().split(' ');
                switch (val[1]) {
                    case 'Январь':
                        val[1] = '01';
                        break;
                    case 'Февраль':
                        val[1] = '02';
                        break;
                    case 'Март':
                        val[1] = '03';
                        break;
                    case 'Апрель':
                        val[1] = '04';
                        break;
                    case 'Май':
                        val[1] = '05';
                        break;
                    case 'Июнь':
                        val[1] = '06';
                        break;
                    case 'Июль':
                        val[1] = '07';
                        break;
                    case 'Август':
                        val[1] = '08';
                        break;
                    case 'Сентябрь':
                        val[1] = '09';
                        break;
                    case 'Октябрь':
                        val[1] = '10';
                        break;
                    case 'Ноябрь':
                        val[1] = '11';
                        break;
                    case 'Декабрь':
                        val[1] = '12';
                }
                val = val[2] + '-' + val[1] + '-' + val[0];
                $(this).val(val);
            }
        });
        $('form.fieldForm').submit();
    });

    $('.sortable').sortable();
    $('.sortable').disableSelection();
    $('.sortable').on('sortstop', function () {
        var number = 1;
        $(this).children().each(function () {
            $(this).children('input.sort-number').each(function () {
                $(this).val(number++);
            });
        });
    });

    $("body").on("click", ".confirm", function (event) {
        var confirmText = $(this).attr('confirmText');
        if (!confirmText) {
            confirmText = 'Вы уверены?';
        }
        if (!confirm(confirmText)) {
            event.preventDefault();
        }
    });

    $('.sumoselect').each(function (event) {
        $(this).SumoSelect({
                               okCancelInMulti: true,
                               triggerChangeCombined: true,
                               csvDispCount: 6,
                               outputAsCSV: false,
                               placeholder: $(this).attr('placeholder')
                           });
    });

    $("body").on("click", ".ajaxUploadsDelete", function (event) {
        event.preventDefault();
        var confirmText = $(this).attr('confirmText');
        if (!confirmText) {
            confirmText = 'Вы уверены?';
        }
        if (confirm(confirmText)) {
            $.post($(this).attr('href'));
            $(this).parent().remove();
        }
    });

    $('.image-picker').imagepicker();

    $(".tagsInput").tagit({
                              //availableTags: $.parseJSON(availableTags),
                              //autocomplete: {
                              //    delay: 0,
                              //    minLength: 2
                              //},
                              //allowSpaces: true,
                              //showAutocompleteOnFocus: true
                          });

    $('.ajaxVisibleSwitcher').switcher();

    $('div.ajaxVisibleSwitcherDiv').on('click', function () {
        var model = $(this).children('input').attr('model');
        var primary = $(this).children('input').attr('primary');
        var current = $(this).hasClass('is-active');
        if (current == true) {
            current = 1;
        } else {
            current = 0;
        }

        var url = "/admin/changeVisible/" + model;
        var data = {
            id: primary,
            visible: current,
            model: model
        };

        $.post(url, data, function (data) {
        });

    })

});