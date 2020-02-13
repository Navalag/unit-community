/*
    Search popup
*/
$(document).ready(function() {
    var ttSearchWrapper = $('#tt-header .tt-search'),
        ttSearchToggle = ttSearchWrapper.find('.tt-search-toggle'),
        ttSearchResults = ttSearchWrapper.find('.search-results'),
        ttSearchInput = ttSearchWrapper.find('.tt-search__input');

    if (ttSearchInput.length && ttSearchResults.length) {
        ttSearchInput.on("input", function(ev){
            if ($(ev.target).val() && $('.tt-search-scroll > ul li').length) {
                ttSearchResults.fadeIn("200");
                ttSearchResults.find('.tt-search-scroll').perfectScrollbar();
            }
            else {
                ttSearchResults.fadeOut("200");
            }
        });
        $('#closeSearchPopUp').on('click', function () {
            ttSearchResults.fadeOut("100");
            ttSearchInput.blur();
        });
        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                ttSearchResults.fadeOut("200");
                ttSearchInput.blur();
            }
        });
    }
});
