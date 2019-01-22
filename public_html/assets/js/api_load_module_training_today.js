// api_load_module_training_today

$(document).ready(function(){

    $('#api_load_module_training_today').html('<div class="p-3"><h5 class="pb-2 mb-0">Trainingsuren <span class="badge badge-hozt">vandaag</span></h5><ul class="list-unstyled" id="api_load_module_training_today_items"></ul></div>');

    var hoztAPI  = "/api/training/vandaag";
    var itemsId  = "#api_load_module_training_today_items"; 

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
                   t += "<span class=\"badge badge-info ml-1\">" + item.comment + "</span>";
                }
                t += "</div>";
                $( t ).appendTo( itemsId );
            });
        } else {
            $( '<p class="small ml-1">Er is vandaag geen training</p>' ).appendTo( itemsId );
        }
    });

});
