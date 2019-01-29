// api_load_module_competition_programs

$(document).ready(function(){

    var module  = "api_load_module_competition_programs";
    var hoztAPI = "/api/wedstrijden/programmas";

    $('#'+module).html("<div class=\"p-3\"><h5 class=\"pb-2 mb-0\">Programma's</h5><div id=\""+module+"_items\"></div></div>"); 

    $.getJSON( hoztAPI, {
        tagmode: "any",
        format: "json"
    })
    .done(function( files ) {
        if ( files.result ){
            $.each( files.data, function( i, item ) {
                var t = "<div class=\"ml-3 small\"><a class=\"text-dark\" href=\"" + item.program + "\">"+ item.title + " (" + item.date + ")</a></div>";
                $( t ).appendTo( "#"+module+"_items" );
            });
        } else {
            $( "<div class=\"small ml-3\">Geen programma's gevonden</div>" ).appendTo( "#"+module+"_items" );
        }
    });

});
