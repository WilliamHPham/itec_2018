(function ($) {
    $(document).ready(function () {
        $icon.on( "click", function() {
            API.open();
        });
        API.bind("open:start", function() {
            $icon.addClass( "is-active" );
        });
        API.bind("close:start", function() {
            $icon.removeClass( "is-active" );
        });
})(jQuery);