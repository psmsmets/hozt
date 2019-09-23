require('bootstrap');

function showTabCompetitions(tab) {
    $('div.competition').removeClass('d-none');
    switch(tab.id) {
        case 'competitions-all-tab':
            break;
        case 'competitions-upcoming-tab':
            $('div.competition-past').addClass('d-none');
            break;
    }
}

$(document).ready(function(){

    $('#competitions-tab').on('show.bs.tab', function (e) {
        //e.target // newly activated tab
        //e.relatedTarget // previous active tab
        showTabCompetitions(e.target);
    })

})
