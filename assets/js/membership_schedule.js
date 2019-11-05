require('bootstrap');


var statusNull = '<i class="fas fa-square text-medium h4"></i>';
var statusTrue = '<button class="btn btn-success btn-sm"><i class="fas fa-check" data-value="true"></i></button>';
var statusFalse = '<button class="btn btn-warning btn-sm text-light"><i class="fas fa-minus" data-value="false"></i></button>';

function loadSchedule(tab) {
    if (!$(tab).length) {
        var tab = $('#schedule-tab > .active');
    }
    $('#schedule').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    $.getJSON( "/api/trainingsuren", {
        year: $(tab).data('year'),
        week: $(tab).data('week'),
        //teams: $(tab).data('teams'),
    })
    .done(function( data ) {
        if (data.success) {
            $('#schedule').html(data.html)
        }
    });
}

// on pageload
loadSchedule();

$(document).ready(function(){

    $('#schedule-tab').on('show.bs.tab', function (e) {
        loadSchedule(e.target);
    })

})
