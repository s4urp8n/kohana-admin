$(document).ready(
    function () {


        // /**
        //  * Wrapper height fix
        //  */
        // var footerHeight = $('.footer').height();
        // var headerHeight = $('.header').height();
        // var pageHeight = $(document).height();
        //
        // $('.wrapper-bottom').height(footerHeight);
        // $('.wrapper-top > .page-container').height(pageHeight - footerHeight - headerHeight);

        /**
         * Background image slider
         */
        $('.index_page body').vegas({
            timer: false,
            shuffle: true,
            delay: 7000,
            slides: [
                {src: '/inc/images/index/1.jpg'},
                {src: '/inc/images/index/2.jpg'},
                {src: '/inc/images/index/3.jpg'},
                {src: '/inc/images/index/4.jpg'},
                {src: '/inc/images/index/5.jpg'},
                {src: '/inc/images/index/6.jpg'}
            ]
        });

    }
);