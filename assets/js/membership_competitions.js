require('bootstrap');


var statusNull = '<i class="fas fa-square text-medium"></i>';
var statusTrue = '<i class="fas fa-check-square text-success" data-value="true"></i>';
var statusFalse = '<i class="fas fa-minus-square text-warning" data-value="false"></i>';


function loadCompetitions() {
    $.getJSON( "/api/private/membership/competitions", {
        format: "json",
        action: 'load',
    })
    .done(function( data ) {
        if (data.success) {
            var newCompetitions = 0;
            $.each(data.data, function(i, item) {
                var td = $('#competition-enrolment-'+item.competitionpart+'-'+item.member);
                if (item.disabled) {
                    $(td).html( statusNull );
                } else if (item.enrolled) {
                    $(td).html( statusTrue );
                } else {
                    $(td).html( statusFalse );
                }
                if (!item.enrolledAt && item.editable) newCompetitions = newCompetitions + 1;
            });
            if (newCompetitions) $('#competitions-new-tab span').html(newCompetitions);
        }
    });
}

function editCompetition(element) {
    if ($(element).hasClass('editing')) return;
    $(element).addClass('editing');

    var [competition, part, competitionPart, member] = element.id.split('-');
    var enrolled = !$('i',element).data('value');

    $.getJSON( "/api/private/membership/competitions", {
        format: "json",
        action: 'edit',
        competitionpart: competitionPart,
        member: member,
        enrolled: enrolled,
    })
    .done(function( data ) {
        if (enrolled) {
            $(element).html(statusTrue);
        } else {
            $(element).html(statusFalse);
        }
        $(element).removeClass('editing');
    });
}


function editCompetitions(edit=false) {
    $("tr:not(.d-none) td[id^='competition-enrolment-']").each( function() {
        if ($('i',this).attr('data-value')!==undefined) {
            if (edit) {
                $(this).click( function() {
                    editCompetition(this);
                });
            } else {
                $(this).unbind();
            }
        }
    });
}

function showTabCompetitions(tab) {
    $('tr.competition').removeClass('d-none');
    switch(tab.id) {
        case 'competitions-all-tab':
            break;
        case 'competitions-new-tab':
            $('tr:not(.competition-new)').addClass('d-none');
            break;
        case 'competitions-upcoming-tab':
            $('tr.competition-past').addClass('d-none');
            break;
    }
}

// on pageload
loadCompetitions();

var editingCompetitions = false;

$(document).ready(function(){

    $('.competition-past').hide();

    $('#competitions-edit').click( function() {
        if (editingCompetitions) {
            $(this).html('<i class="fas fa-edit"></i> bewerken').removeClass('btn-secondary').addClass('btn-medium'); 
            $('#competitions-tab > a').removeClass( "disabled" );
            $('tr.competition-locked').removeClass('d-none');
            showTabCompetitions($('#competitions-tab').find('.active')[0]);
            editCompetitions(false);
            loadCompetitions();
        } else {
            $(this).html('<i class="fas fa-save"></i> bewaren').removeClass('btn-medium').addClass('btn-secondary');
            $('#competitions-tab > a').addClass( "disabled" );
            $('tr.competition-locked').addClass('d-none');
            editCompetitions(true);
        }
        editingCompetitions = !editingCompetitions;
    });


    $('#competitions-tab').on('show.bs.tab', function (e) {
        //e.target // newly activated tab
        //e.relatedTarget // previous active tab
        showTabCompetitions(e.target);
    })

})
