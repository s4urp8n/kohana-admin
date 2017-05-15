$(document).ready(
    function () {


        if ($('html').hasClass('index_page')) {

            /**
             * Index page radial containers clicks
             */
            $('.radialContainers-left, .radialContainers-right').on('click', function () {

                var mainLink = $(this).find('.radialContainer-link-main').first();

                document.location.href = mainLink.attr('href');

            });


            /**
             * Wrapper height fix on INDEX PAGE
             */
            var footerHeight = $('.footer').height();
            var headerHeight = $('.header').height();
            var pageHeight = $(document).height();

            $('.wrapper-bottom').height(footerHeight);
            $('.wrapper-top > .page-container').height(pageHeight - footerHeight - headerHeight);

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

    }
);