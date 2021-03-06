require('bootstrap');

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
