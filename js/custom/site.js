var $isTitleHide = false;
var isScrollTop = false;
//Job category Selection

//Get job title position in the top.
var $titleOffset = ($('#searchWrapper').offset().top),
    breakpoint = calSize();


var SelectedCategory = (function () {
    var _category = {
        categoryID: {
            main: [],
            sub: []
        }
    };

    $(document).on('click', '.category-list li a', function (evt) {
        evt.preventDefault();

        var $this = $(this),
            $parentUl = $this.parents('.category-list');

        //Main category
        if ($parentUl.hasClass('main')) {

            $('.category-list.main li a').removeClass('active');
            $this.addClass('active');
            _category.categoryID.main = [
                $parentUl.find('li a.active').attr('id'),
                $parentUl.find('li a.active').text()
            ];

            //If select main category All that popup will be hide
            if ($this.hasClass('all')) {
                loadJobsByCategory();
                scrollToDown();
            }
        }

        //Sub category
        if ($parentUl.hasClass('sub')) {
            $('.category-list.sub li a').removeClass('active');
            $this.addClass('active');
            _category.categoryID.sub = [
                $parentUl.find('li a.active').attr('id'),
                $parentUl.find('li a.active').text()
            ];
            //Call after select
            loadJobsByCategory();
            scrollToDown();
        }


    });

    return _category;

})();

//Job Search
var JobSearch = (function () {

    var search = {};

    var $jobInput = $('.job-input input[type="text"]');


    search.changeTitle = function () {
        var $title = $('.main-title');
        var searchSection = $('.search-section');
    };

    //On input focus
    $jobInput.on('focus', function () {
    });

    //On input blur
    $jobInput.on('blur', function () {
    });

    //Show category Popup
    $('.show-category').on('click', function () {
        Popup.beforeShow();
        //Get layout
        //Call to server js and get layout
        CategoryPopup().html(function (html) {
            Popup.addClass('size-60');
            Popup.addClass('no-padding');
            Popup.show(html);
        });
    });

    return search;
})();

function loadJobsByCategory() {
    var category = SelectedCategory.categoryID;

    $('.show-category').find('.selected-item span').text(category.main[1]);
    $('.job-input').find('input[type="text"]').focus();
    $('.subCategory').text(category.sub[1]);

    //Call to server
    loadJobData(category);
    // hide popup
    Popup.hide();
}

function responsivePageHeight() {
    var pageHeight = $(window)[0].innerHeight;
    $('.full-height').css('height', pageHeight + 'px');
}

(function () {

    $('.navbar').removeClass('light-blue').css('backgroundColor', 'transparent');
})();


function calSize() {
    var val = 0;
    var deviceWidth = $(window)[0].innerWidth;
    if (deviceWidth > 425) {
        val = $titleOffset + 90;
    } else {
        val = $titleOffset - 80;
    }
    return val;
}

function scrollToDown() {
    var _titleTopSpace = $titleOffset + 90;
    if (!$(window).scrollTop() > 0) {
        $("html, body").animate({scrollTop: _titleTopSpace}, 500);
    } else {
        $("html, body").scrollTop(_titleTopSpace);
    }

}


// (function () {
//
//     var controller = new ScrollMagic.Controller(
//         {
//             addIndicators: false
//         }
//     );
//     var progress = 1;
//     var jobTitle = 'title';
//
//     var jobScene = new ScrollMagic.Scene({
//         triggerElement: '.search-section',
//         duration: '300%',
//         triggerHook: 0,
//         offset: breakpoint
//     });
//
//     jobScene.addTo(controller);
//     jobScene.setPin('.search-section', {pushFollowers: false});
//     jobScene.on('start', function () {
//         // window.onwheel = preventDefault;
//         // window.ontouch = preventDefault;
//         // setTimeout(function () {
//         //     window.onwheel = null;
//         // }, 1000)
//     });
//
//     //S 2
//     var Scene = new ScrollMagic.Scene({
//         triggerElement: '#title',
//         duration: '30%',
//         triggerHook: 0.3,
//     });
//
//     Scene.addTo(controller);
//
//     Scene.on('progress', function (e) {
//         // var opt = 1 - (e.progress);
//         var opt = Math.max(0, Math.min(1, (1 - (e.progress))));
//
//         if(e.progress === 0) {
//            // $('header').css({'pointer-events': 'auto'});
//             $('header .navbar-nav').css({'pointer-events': 'auto'});
//         }else {
//            // $('header').css({'pointer-events': 'none'});
//             $('header .navbar-nav').css({'opacity': opt,'pointer-events': 'none'});
//         }
//
//         $('#title').css({'opacity': opt});
//
//         $('.filters').animate({'opacity': e.progress}, 0);
//
//         $('.full-height').css('height', '');
//         console.log(e.progress)
//
//     });
//
//     Scene.on('start', function (e) {
//         if (e.scrollDirection == "REVERSE") {
//             $('.filters').css({'opacity': 0});
//             responsivePageHeight();
//         }
//     });
//
//     Scene.on('shift', function (e) {
//         // $('.filters').animate({'opacity': 1}, 0);
//         //$('header').css({'pointer-events': 'none'});
//         $('header .navbar-nav').css({'pointer-events': 'none'});
//     });
//
//     $('#searchText').on('focus click', function () {
//         scrollToDown();
//     });
//
// })($);

//search scroll animation
(function () {

    var $header = $('header'),
        $searchInput = $('#searchText'),
        $searchArea = $('.search-area'),
        $searchSection = $('.search-section'),
        $loadAdvertisements = $('#ajaxLoadAdvertisements'),
        $searchWrapper = $('#searchWrapper'),
        $loadAdvertisementsPosition = 0,
        $_scrollTop = 0,
        isInputFocus = false;

    init();

    function init() {
        $header.addClass('absolute');
        $searchWrapper.addClass('is-animate-bar');

        $(window).on('load resize', function () {
            responsivePageHeight();
        });

        watch();
    }

    function watch() {
        watcher();
        window.requestAnimationFrame(watch);
    }

    function watcher() {
        $loadAdvertisementsPosition = ($loadAdvertisements.offset().top);
    }

    function scrollOnFocusInput() {
        $("html, body").animate({scrollTop: $searchArea.offset().top - 30}, 500);
        $searchArea.siblings('.filters').css('opacity', '1');
    }

    $(window).on('scroll', function () {
        $_scrollTop = $(this).scrollTop();
        console.log($loadAdvertisementsPosition)
        var step1 = $loadAdvertisementsPosition,//300
            step2 = $loadAdvertisementsPosition + 130,//$loadAdvertisementsPosition + 50,//310
            stepUp1 = $loadAdvertisementsPosition + 50,//$loadAdvertisementsPosition + 50,//250
            stepUp2 = 667;//$loadAdvertisementsPosition + 30;//100

        if ($_scrollTop === 0) {

            $searchArea.siblings('.filters').css('opacity', '0');
            responsivePageHeight();

        } else {

            if (isInputFocus) {
                $searchArea.siblings('.filters').css('opacity', '1');
                //$searchSection.css('height', 'auto')
            }
        }

        if ($_scrollTop > step1) {
            $searchWrapper.addClass('is-fixed-search');
        }

        if ($_scrollTop > step2) {
            if ($searchWrapper.hasClass('is-fixed-search')) {
                $searchWrapper.addClass('is-down');
                $searchArea.siblings('.filters').css('opacity', '1');
                //$loadAdvertisements.css('min-height', '900px');
            }
        }

        if ($_scrollTop < step2 && $_scrollTop > stepUp1) {
            if ($searchWrapper.hasClass('is-fixed-search')) {
                $searchWrapper.removeClass('is-down');
                $searchArea.siblings('.filters').css('opacity', '0');
            }
        }

        if ($_scrollTop < stepUp1 - 20) {
            if ($searchWrapper.hasClass('is-fixed-search')) {
                $searchWrapper.removeClass('is-fixed-search');
                //$loadAdvertisements.css('min-height', '');
            }
        }

    });

    $searchInput.on('focus click', function () {
        scrollOnFocusInput();
        isInputFocus = true;
    });

    $searchInput.on('blur', function () {
        isInputFocus = false;
    });

    // var controller = new ScrollMagic.Controller(
    //     {
    //         addIndicators: false
    //     }
    // );
    //
    // var jobScene = new ScrollMagic.Scene({
    //     triggerElement: '.search-section',
    //     duration: '300%',
    //     triggerHook: 0,
    //     offset: breakpoint
    // });

})();