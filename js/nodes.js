$(document).ready( function() {
        $('.image').unbind();
        $('.image').live('mouseover', function () {
                if ($(this).parent().next().find('img').size())
                {
                        $(this).parent().hide();
                        $(this).parent().next().find('img').show();
                }
        });

        $('.map-image').unbind();
        $('.map-image').live('mouseout', function () {
            $(this).hide();
            $(this).parent().prev().show();

        });
})