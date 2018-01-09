module.exports = function (array, prop) {

    function compare(a, b) {
        if (a[prop] < b[prop])
            return -1;
        if (a[prop] > b[prop])
            return 1;
        return 0;
    }

    array.sort(compare);

    return array;

};