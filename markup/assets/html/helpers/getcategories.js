var slugify = require('slugify');

module.exports = function (options) {

    var categories = [];

    var category = '';

    var products = options.data.root.products;
    var found = [];

    for (var i in products) {

        category = products[i].category;

        if (found.indexOf(category) == -1) {

            found.push(category);

            categories.push({
                name: category,
                url: slugify('catalog ' + category.toLowerCase())
            });
        }

    }

    function compare(a, b) {
        if (a.name < b.name)
            return -1;
        if (a.name > b.name)
            return 1;
        return 0;
    }

    categories.sort(compare);

    return categories;

};