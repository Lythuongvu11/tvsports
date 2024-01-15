(function ($) {
    "use strict";


    $(document).ready(function () {
        function toggleSubcategories() {
            if ($(window).width() > 992) {
                $('.nav-item.dropdown-submenu').on('mouseenter', function () {
                    $(this).find('.sub-categories').show();
                }).on('mouseleave', function () {
                    $(this).find('.sub-categories, .sub-sub-categories').hide();
                });

                $('.sub-categories .dropdown-submenu').on('mouseenter', function () {
                    $(this).find('.sub-sub-categories').show();
                }).on('mouseleave', function () {
                    $(this).find('.sub-sub-categories').hide();
                });

                // Thêm sự kiện click cho danh mục cấp 3
                $('.sub-sub-categories a').on('click', function (e) {
                    e.stopPropagation(); // Ngăn chặn sự kiện click từ lan toả lên các cấp độ cao hơn

                    // Lấy href của thẻ <a> để chuyển hướng trang (nếu cần)
                    var href = $(this).attr('href');
                    if (href) {
                        window.location.href = href;
                    }

                });
            } else {
                // Tắt sự kiện khi kích thước màn hình nhỏ hơn 992px
                $('.nav-item.dropdown-submenu, .sub-categories, .sub-sub-categories').off('mouseenter').off('mouseleave');
            }
        }

        toggleSubcategories();
        $(window).resize(toggleSubcategories);
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


    //Product Quantity

    $(document).ready(function() {
        $('.btn-minus').click(function(e) {
            e.preventDefault();
            var quantity = parseInt($(' input[name="product_quantity"]').val());
            if (quantity > 1) {
                quantity--;
                $('input[name="product_quantity"]').val(quantity);
            }
        });

        $('.btn-plus').click(function(e) {
            e.preventDefault();
            var quantity = parseInt($(' input[name="product_quantity"]').val());
            quantity++;
            $('input[name="product_quantity"]').val(quantity);
        });
    });
    // Cart Quantity
    // delete cart





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





})(jQuery);
//size chart
function toggleImage() {
    var x = document.getElementById("sizeChart");
    if (x.style.display === "none") {
        x.style.display = "block";
    }
}
// swiper
var swiper = new Swiper(".mySwiper", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
});
var swiper2 = new Swiper(".mySwiper2", {
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: swiper,
    },
});

//delete cart
// Thêm sự kiện khi nhấp vào sao
document.getElementById('star-rating').addEventListener('click', function(e) {
    if (e.target.tagName === 'I') {
        var rating = e.target.getAttribute('data-rating');
        document.getElementById('rating-input').value = rating;

        // Update trạng thái sao (hiển thị sao đã chọn)
        var stars = document.querySelectorAll('#star-rating i');
        stars.forEach(function(star, index) {
            star.classList.toggle('fas', index < rating);
            star.classList.toggle('far', index >= rating);
        });
    }
});

