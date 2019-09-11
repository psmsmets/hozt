require('bootstrap');


var statusNull = '<i class="fas fa-square text-medium"></i>';
var statusTrue = '<i class="fas fa-check-square text-success" data-value="true"></i>';
var statusFalse = '<i class="fas fa-minus-square text-warning" data-value="false"></i>';


function loadCompetitions() {
    $.getJSON( "/api/private/membership/competitions", {
        action: 'load',
        format: "json",
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

function editCompetitions(edit=false) {
    $("tr:not(.d-none) td[id^='competition-enrolment-']").each( function() {
        if ($('i',this).attr('data-value')!==undefined) {
            if (edit) {
                $(this).click( function() {
                    if ($('i',this).data('value')) {
                        $(this).html(statusFalse);
                    } else {
                        $(this).html(statusTrue);
                    }
                });
            } else {
                $(this).unbind();
            }
        }
/*
        if ($(this).hasClass('competition-editable')) {
            $(this).html(statusTrue);
        } else {
            $(this).html(statusNull);
        }
*/
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
