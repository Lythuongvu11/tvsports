(function ($) {
    "use strict";

    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Vendor carousel
    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:2
            },
            576:{
                items:3
            },
            768:{
                items:4
            },
            992:{
                items:5
            },
            1200:{
                items:6
            }
        }
    });


    // Related carousel
    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });


    // Product Quantity
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });
    // active
    $(document).ready(function () {
        // Lấy URL hiện tại
        var currentUrl = window.location.href;

        // Tìm tất cả các liên kết trong thanh điều hướng
        $('.navbar-nav .nav-link').each(function () {
            // So sánh URL của liên kết với URL hiện tại
            if ($(this).attr('href') === currentUrl) {
                // Loại bỏ lớp 'active' từ tất cả các liên kết
                $('.navbar-nav .nav-link').removeClass('active');
                // Thêm lớp 'active' vào liên kết hiện tại
                $(this).addClass('active');
            }
        });
    });
    //star
    function rateStar(rating) {
        $('#star-rating i').each(function (index, star) {
            const starRating = parseInt($(star).data('rating'));
            if (starRating <= rating) {
                $(star).removeClass('far').addClass('fas');
            } else {
                $(star).removeClass('fas').addClass('far');
            }
        });
    }

// Gọi hàm rateStar khi người dùng click vào một sao
    $('#star-rating i').on('click', function () {
        const rating = parseInt($(this).data('rating'));
        rateStar(rating);
    });

})(jQuery);

