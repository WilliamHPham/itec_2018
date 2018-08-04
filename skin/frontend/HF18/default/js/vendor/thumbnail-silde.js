   jQuery(document).ready(function(){
    var imageCount = jQuery('.product-image-thumbs').children().length;
    if (imageCount > 4) {
        jQuery('.product-image-thumbs').slick({
            arrows: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            nextArrow: '<i class="arrow-right fa fa-angle-right"></i>',
            prevArrow: '<i class="arrow-left fa fa-angle-left" ></i>'
        });
    };
});