/**
 * Place any jQuery/helper plugins in here.
 */
$(function () {
    const $body = $('body');

    /**
     * Popovers
     * Note: Disable this if you're not using Bootstrap's Popovers
     */
    $('[data-toggle="popover"]').popover();

    /**
     * Tooltips
     *  Note: Disable this if you're not using Bootstrap's Tooltips
     */
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    /**
     * Find data-confirm-message="" and add confirmation dialog
     */
    $body.on('click', 'a[data-confirm-message]', function (e) {
        e.preventDefault();

        let link = $(this);

        if (confirm(link.attr('data-confirm-message'))) {
            $('#file, #file_type').prop('disabled', true);

            return true;
        } else {
            e.stopPropagation();
            e.stopImmediatePropagation();

            return false;
        }
    });

    /**
     * Find data-method="" and submit links as form
     */
    $body.on('click', 'a[data-method]', function (e) {
        e.preventDefault();

        let target = '_self';
        let link = $(this);
        let token = $('meta[name="csrf-token"]').attr('content');

        if (link.attr('target')) {
            target = link.attr('target');
        }

        $('<form action="' + link.attr('href') + '" method="POST" target="' +
            target + '" style="display:none">\n' +
            '<input type="hidden" name="_method" value="' +
            link.attr('data-method') + '">\n' +
            '<input type="hidden" name="_token" value="' + token + '">\n' +
            '</form>').appendTo('body').submit().remove();
    });

    $('a[data-method]').css('pointer-events', 'auto');

    /**
     * Copy input[name="url"] value to clipboard
     */
    $('.btn-copy').on('click', function (e) {
        e.preventDefault();

        let url = document.querySelector('input[name="url"]');

        url.focus();
        url.select();
        document.execCommand('copy');
        url.blur();
    });

    /**
     * Open tabs by hash
     */
    let hash = window.location.hash;
    hash && $('.nav a[href="' + hash + '"]').tab('show');
    hash && $(hash + '.modal').modal('show');
    hash && $(location.hash + '.collapse').collapse('show').on('shown.bs.collapse', function () {
        let offset = $(this).offset().top - 20;
        if ($(this).data('offset')) {
            offset = $($(this).data('offset')).top - 20;
        }

        if (offset > 0) {
            $([document.documentElement, document.body]).animate({
                scrollTop: offset
            }, 300);
        }
    });

    $('[data-toggle="custom-tooltip"]').tooltip({
        template: '<div class="custom-tooltip tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
        boundary: 'viewport',
    });
});
