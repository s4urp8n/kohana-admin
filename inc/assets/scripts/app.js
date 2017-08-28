var blockA = 0;

var getAbsoluteUrl = (function () {
    var a;

    return function (url) {
        if (!a) a = document.createElement('a');
        a.href = url;

        return a.href;
    };
})();

$(document).ready(function () {


    if ($('.mobile-navigation--secondary').length > 0) {

        var currentHref = window.location.href;

        $('.mobile-navigation--secondary option').each(function () {

            $(this).attr('href', getAbsoluteUrl($(this).attr('href')));

            if ($(this).attr('href') == currentHref) {

                $(this).prop('selected', true);

            }
        });

    }

    $('.mobile-navigation--secondary').on('change', function () {

        var href = $(this).find('option:selected').attr('href');

        window.location.href = href;

    });


    /**
     * Cart remove button
     */
    $('.btn-remove').on('click', function (event) {

        event.preventDefault();

        var confirmMessage = 'Are you sure to delete?';

        var lang = $('html').attr('lang');

        if (lang == 'ru') {
            confirmMessage = 'Вы уверены в удалении товара из корзины?';
        }

        if (lang == 'am') {
            confirmMessage = 'Համոզված եք, որ հեռացնել ապրանքը զամբյուղի.';
        }

        if (confirm(confirmMessage)) {

            var href = $(this).attr('href');
            var count = $('.cartTable > table tr').length - 1;

            $(this).parent().parent().remove();

            $.ajax(href, {});

            if (count == 2) {
                $('.cartTable').html('<div class="alert alert-warning"> Корзина пуста, воспользуйтесь каталогом для поиска товаров. </div>');
                $('.cart-badge').remove();
            } else {
                $('.cart-badge').text(count - 2);
            }

            updateSummary();
        }
    });

    /**
     * Update cart summary
     */
    var updateSummary = function () {

        var count = 0;
        $('.cartTable .numberChanger li.active span').each(function () {
            count = count + parseInt($(this).html(), 10);
        });

        var sum = 0;
        $('.cartTable .cartPrice').each(function () {
            sum = sum + parseInt($(this).html(), 10);
        });

        var curHtml = $('.cartTable .cartPrice .currencies')[0].outerHTML + '';

        var defaultCur = $(curHtml).attr('default');

        var newHtml = '';

        $(curHtml).find('.currency').each(function (index, item) {

            var currencyString = $(item).html().replace(/\s+/g, '');

            var matches = /^([\d\.]+)(\D+)$/.exec(currencyString);

            var value = matches[1];
            var label = matches[2];
            var ratio = $(item).attr('ratio');

            var html = parseFloat(sum * ratio).toFixed(2) + '' + label;

            $(item).html(html);

            newHtml += $(item)[0].outerHTML;

        });

        curHtml = $(curHtml).html('')[0].outerHTML;

        curHtml = $(curHtml).html(newHtml)[0].outerHTML;

        $('.cartTotalSum').html(sum + ' ' + defaultCur + curHtml);
        $('.cartTotalCount').html(count);
    };

    /**
     * Background slider on index page
     */
    if ($('html').hasClass('index_page')) {

        /**
         * Index page radial containers clicks
         */
        $('.radialContainers-left, .radialContainers-right').on('click', function () {

            var mainLink = $(this).find('.radialContainer-link-main').first();

            document.location.href = mainLink.attr('href');

        });


        /**
         * Background image slider
         */
        $('.index_page body').vegas({
            timer: false,
            shuffle: true,
            // overlay: true,
            delay: 7000,
            slides: [
                {src: '/inc/images/index/1.jpg'},
                {src: '/inc/images/index/2.jpg'},
                {src: '/inc/images/index/3.jpg'},
                {src: '/inc/images/index/4.jpg'},
                {src: '/inc/images/index/5.jpg'},
            ]
        });
    }

    /**
     * Show photobox gallery
     */
    var isOperaMini = (navigator.userAgent.indexOf("Opera Mini") > -1);
    if (!isOperaMini) {

        var photoboxParams = {
            time: 1000,
            autoplay: false,
            history: true,
            loop: true,
            thumbs: true,
            hideFlash: true,
            counter: true,
        };

        $(".photobox_container").photobox("a", photoboxParams);
        $(".articlePhotobox").photobox("a", photoboxParams);
        setTimeout(window._photobox.history.load, 10);
    }

    /**
     * Update total on product page
     */
    $('.shop-item-content--count input[name=count]').on('change', function () {

        var count = $(this).val();
        var price = parseFloat($(this).parents('form').find('.shop-item-content-price-price').html(), 10);

        var defaultCur = $('.shop-item-content-total-total .currencies').attr('default');

        $('.shop-item-content-total-total .currency').each(function (index, item) {

            var currencyString = $(item).html().replace(/\s+/g, '');

            var matches = /^([\d\.]+)(\D+)$/.exec(currencyString);

            var value = matches[1];
            var label = matches[2];
            var ratio = $(item).attr('ratio');

            $(item).html(parseFloat(price * ratio * count).toFixed(2) + '' + label);

        });

        var currenciesHtml = $('.shop-item-content-total-total.input .currencies')[0].outerHTML;

        var total = price * count;

        $('.shop-item-content-total-total.input').html(total + ' ' + defaultCur + currenciesHtml);

    });

    /**
     * Update cart inc/dec using ajax
     */
    $('.numberChanger .pagination a').on('click', function (event) {

        event.preventDefault();

        if (blockA == 0) {

            blockA = 1;

            var href = $(this).attr('href');
            var action = String($(this).text()).replace(/\s+/g, '');
            var value = parseFloat($(this).parent().parent().find('li span').html(), 10);
            var unit = $(this).parent().parent().find('li span').html().split(' ');

            unit[0] = '';

            unit = unit.join(' ');

            var price = 0.0;

            $(this).parents('ul').find('li span').html('<i class="fa fa-cog fa-spin"></i>');

            if (isNaN(value) || value < 1) {
                value = 1;
            }

            if (action == '-' && value >= 2) {
                value = value - 1;
            }

            if (action == '+' && value >= 1) {
                value = value + 1;
            }

            price = parseFloat($(this).parents('tr').find('.cartPrice').attr('price'), 10) * value;
            var defaultCur = $(this).parents('tr').find('.cartPrice .currencies').attr('default');


            $(this).parents('tr').find('.cartPrice .currency').each(function (index, item) {

                var currencyString = $(item).html().replace(/\s+/g, '');

                var matches = /^([\d\.]+)(\D+)$/.exec(currencyString);

                var value = matches[1];
                var label = matches[2];
                var ratio = $(item).attr('ratio');


                $(item).html(parseFloat(price * ratio).toFixed(2) + '' + label);

            });

            var curHtml = $(this).parents('tr').find('.cartPrice .currencies')[0].outerHTML;


            var that = $(this);

            $.ajax(href, {}).done(function () {
                that.parents('ul').find('li span').html(value + unit);
                that.parents('tr').find('td:eq(4)').html(price + ' ' + defaultCur + curHtml);
                updateSummary();
                blockA = 0;
            });


        }

        $(this).blur();
    });
});