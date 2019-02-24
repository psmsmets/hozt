// api_load_module_training_today

$(document).ready(function(){

    var module = "api_load_module_training_today";
    var hoztAPI  = "/api/training/vandaag";

   $('#'+module).html("<div class=\"p-3\"><h5 class=\"pb-2 mb-0\">Trainingsuren <span class=\"badge badge-hozt\">vandaag</span></h5><div id=\""+module+"_items\"></div></div>");


    $.getJSON( hoztAPI, {
        tagmode: "any",
        format: "json"
    })
    .done(function( training ) {
        if ( training.result ){
            $.each( training.data, function( i, item ) {
                var t = "<div class=\"ml-3\"><span class=\"small mr-2\">"+ item.time + "</span>";
                $.each( item.teams, function( i, team ) {
                    t += "<span class=\"badge badge-hozt ml-1\">" + team.abbr + "</span>";
                });
                if ( item.comment ){
                   t += "<span class=\"badge badge-gold ml-1\">" + item.comment + "</span>";
                }
                t += "</div>";
                $( t ).appendTo( "#"+module+"_items" );
            });
        } else {
            $( "<div class=\"small ml-3\">Er is vandaag geen training</div>" ).appendTo( "#"+module+"_items" );
        }
    });

});
