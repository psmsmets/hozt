// api_load_module_training_tomorrow

$(window).bind("load", function() {

    var div = "api_load_tryout_enrolled";
    var hoztAPI  = "/api/ingeschreven/testmomenten";

    $.getJSON( hoztAPI, {})
    .done(function( tryouts ) {
        if ( tryouts.content ){
            $('#'+div).html(tryouts.content);
        }
    });

});

