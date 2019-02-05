// api_load_module_training_tomorrow

$(document).ready(function(){

    $('#api_load_module_calendar_upcoming').html('<div class="p-3"><h5 class="pb-2 mb-0">Kalender</h5><div id="api_load_module_calendar_upcoming_items"></div></div>');

    var hoztAPI  = "/api/kalender/aanstaande";
    var itemsId  = "#api_load_module_calendar_upcoming_items"; 

    $.getJSON( hoztAPI, {
        tagmode: "any",
        format: "json"
    })
    .done(function( calendar ) {
        if ( calendar.result ){
            $.each( calendar.data, function( i, item ) {
                var t = '';
                t += "<div class=\"media pt-2 text-muted\" style=\"cursor: pointer;\" onclick=\"window.location='" + item.url + "';\">";
                t += '  <span class="badge badge-dark mr-2 cal cal-sm '+ item.class +'">'+ item.day +'<br>'+ item.month +'</span>';
                t += '  <div class="media-body pb-2 mb-0 small lh-125 border-bottom border-gray">';
                t += '    <div class="d-flex justify-content-between align-items-center w-100">';
                t += '      <strong class="text-gray-dark">'+item.title+'</strong>';
                t += '      <a href="#" class="d-none">Bekijk</a>';
                t += '    </div>';
                t += '    <span class="d-block">'+item.formattedPeriod+'</span>';
                t += '  </div>';
                t += '</div>';
                $( t ).appendTo( itemsId );
            });
            $('<p class="small mt-2 text-right"><a href="/kalender"><i class="fas fa-calendar-plus"></i> Alle events</a></p>').appendTo( itemsId );
        } else {
            $( "<p>Er zijn geen events</p>" ).appendTo( itemsId );
        }
    });

});
