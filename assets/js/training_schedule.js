require('bootstrap');

function loadSchedule(tab) {
    if (!$(tab).length) {
        var tab = $('#schedule-tab > .active');
    }
    $('#schedule').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    $.getJSON( "/api/trainingsuren", {
        year: $(tab).data('year'),
        week: $(tab).data('week'),
        teams: getTeamSelection().join(","),
        anonymous: true,
    })
    .done(function( data ) {
        if (data.success) {
            $('#schedule').html(data.html)
        }
    });
}

function getTeamSelection() {
    var teams = [];
    $('#team-schedule > input').each(function () {
        if ($(this).prop('checked')) {
            teams.push($(this).val())
        } 
    });
    return teams;
}

function invertTeamSelection() {
    $('#team-schedule > input').each(function () {
        $(this).prop('checked', !$(this).prop('checked')); 
    });
}

// bind functions
$('#invert-team-selection').click(function(e) {
    invertTeamSelection();
    loadSchedule();
});
$('#team-schedule > input').each(function () {
    $(this).change(function() {
        loadSchedule();
    });
});

// on pageload
loadSchedule();

$(document).ready(function(){

    $('#schedule-tab').on('show.bs.tab', function (e) {
        loadSchedule(e.target);
    })

})
