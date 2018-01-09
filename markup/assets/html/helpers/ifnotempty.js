module.exports = function (object, options) {

    if (object == null
        ||
        object == undefined) {
        return '';
    }

    return options.fn(this);

};