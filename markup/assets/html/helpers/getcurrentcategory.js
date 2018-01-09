var getCategories = require("./getcategories");

module.exports = function (options) {

    var currentPage = options.data.root.page;

    var categories = getCategories(options);

    for (var i in categories) {
        if (categories[i].url == currentPage) {
            return categories[i].name;
        }
    }

    return false;
};