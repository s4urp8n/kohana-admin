function getFirstPart(string) {
    return string.split('-')[0];
}


module.exports = function (pageName, options) {

    if (getFirstPart(pageName) == getFirstPart(options.data.root.page)
        ||
        options.data.root.page.indexOf(getFirstPart(pageName)) == 0
    ) {
        return options.fn(this);
    }

    return '';

};