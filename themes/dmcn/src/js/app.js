jQuery(function ($) {

});

(function ($, Drupal) {
    $(function() {
        if ($(".load_downloads").length > 0) {
            var ProjectVars = drupalSettings.dm_project;
            if (ProjectVars.is_core_module) {
                $(".load_downloads").parents("#block-module-download").remove();
            } else {
                $.get("/api/get_download/" + ProjectVars.project_id, function (data) {
                    $(".load_downloads").html(data);
                });
            }
        }

        var fixed = false;
        var div = $("#block-rightmenu");
        if(div.length > 0) {
            var tops = div.offset().top;
            if (div.length > 0) {
                $(window).scroll(function() {
                    if ($(this).scrollTop() > tops) {
                        if( !fixed ) {
                            fixed = true;
                            div.addClass('directoryfixed');
                        }
                    } else {
                        if( fixed ) {
                            fixed = false;
                            div.removeClass('directoryfixed');
                        }
                    }
                });
            }}
    });


})(jQuery, Drupal);