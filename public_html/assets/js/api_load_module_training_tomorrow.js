// api_load_module_training_tomorrow

$(document).ready(function(){

    $('#api_load_module_training_tomorrow').html('<div class="p-3"><h5 class="pb-2 mb-0">Trainingsuren <span class="badge badge-secondary">morgen</span></h5><div id="api_load_module_training_tomorrow_items"></div></div>');

    var hoztAPI  = "/api/training/morgen";
    var itemsId  = "#api_load_module_training_tomorrow_items"; 

    $.getJSON( hoztAPI, {
        tagmode: "any",
        format: "json"
    })
    .done(function( training ) {
        if ( training.result ){
            $.each( training.data, function( i, item ) {
                var t = "<div class=\"ml-3\"><span class=\"small mr-2 w-50\">"+ item.time + "</span>";
                $.each( item.teams, function( i, team ) {
                    t += "<span class=\"badge badge-secondary ml-1\">" + team.abbr + "</span>";
                });
                if ( item.comment ){
                   t += "<span class=\"badge badge-info ml-1\">" + item.comment + "</span>";
                }
                t += "</div>";
                $( t ).appendTo( itemsId );
            });
        } else {
            $( '<div class="small ml-3">Er is morgen geen training</div>' ).appendTo( itemsId );
        }
    });

});
