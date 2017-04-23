(function ($) {

    var widgetName = 'youtube';
    $.widget("ui." + widgetName, {
        version: "1.00.0",
        defaultElement: "<textarea>",
        widgetEventPrefix: widgetName,
        _videos: [],
        _patterns: [
            /v=([\w_-]+)$/,
            /\/([\w_-]+)$/,
        ],
        _events: {},
        _isValidLink: function (link) {
            for (var i in this._patterns) {
                if (this._patterns[i].test(link)) {
                    return this._patterns[i].exec(link)[1];
                }
            }
            return false;
        },
        _in_array: function (needle, haystack, strict) {

            var found = false, key, strict = !!strict;
            for (key in haystack) {
                if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
                    found = true;
                    break;
                }
            }

            return found;
        },
        _defineEvents: function () {
            this._events["click ." + widgetName + "_button"] = function (event) {
                event.preventDefault();
                var value = this._isValidLink(this._getInput().val());
                if (value !== false && !this._in_array(value, this._videos)) {
                    this._videos.push(value);
                }
                this._updateElementValue();
                this._getInput().val('');
                this._updatePreviews();
            };
            this._events["click ." + widgetName + "_preview button"] = function (event) {
                event.preventDefault();
                var that = $(event.target);
                if (confirm('Вы уверены в удалении?')) {
                    this._deleteVideo(that.attr('videoid'));
                    that.parent().hide();
                }
            };
        },
        _create: function () {
            var uiWidgetName = this.uiWidgetName;
            uiWidgetName = this.uiWidgetName = this.element
                .hide()
                .wrap('<div class="' + widgetName + '"></div>')
                .parent()
                .append('<input class="form-control ' + widgetName + '_input" type="text"/>')
                .append('<button class="btn btn-warning ' + widgetName + '_button">Добавить</button>')
                .append('<div class="' + widgetName + '_previews"></div>');
            this._defineEvents();
            this._on(this._events);
            this._setInitValue();
            this._updateElementValue();
            this._updatePreviews();
        },
        _setInitValue: function () {
            var current = this.element.val().toString().replace(/\s+/, '');
            if (/\,+/.test(current)) {
                var parts = current.split(',');
                for (var i in parts) {
                    if (parts[i].toString().length == 0) {
                        delete parts[i];
                    }
                }
                for (var i in parts) {
                    if (!this._in_array(parts[i].toString(), this._videos)) {
                        this._videos.push(parts[i].toString());
                    }
                }
            } else {
                if (current.length > 0 && !this._in_array(current, this._videos)) {
                    this._videos.push(current);
                }
            }
        },
        _updateElementValue: function () {
            this.element.val([this._videos].join(','));
        },
        _updatePreviews: function () {
            var div = this._getPreviews();
            div.html('');
            for (var i in this._videos) {
                div.append(this._getLink(this._videos[i]));
            }
        },
        _getLink: function (id) {
            return '<div class="' + widgetName + '_preview videoid_' + id.toString() + '">\n\
                        <iframe width="100%" height="200" src = "//www.youtube.com/embed/' + id.toString() + '" frameborder = "0" allowfullscreen></iframe>\n\
                        <button videoid="' + id.toString() + '" type="button"><i class="fa fa-trash-o"></i> Удалить</button>\n\
                    </div>';
        },
        _getInput: function () {
            return this.element.parent().children('.' + widgetName + '_input');
        },
        _getPreviews: function () {
            return this.element.parent().children('.' + widgetName + '_previews');
        },
        _deleteVideo: function (id) {
            for (var i in this._videos) {
                if (this._videos[i] == id) {
                    this._videos.splice(i, 1);
                    break;
                }
            }
            this._updateElementValue();
        },
        _getWidget: function () {
            return this.element
                .parent()
                .parent();
        },
        widget: function () {
            return this.uiWidgetName;
        }
    });
}(jQuery));