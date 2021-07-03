$(document).on('click', '.color-theme li', function () {

    $('.color-theme li').each(function () {
        $('.gsi-step-indicator').removeClass($(this).data('skin'));
    });



    $('.gsi-step-indicator').addClass($(this).data('skin'));

});
