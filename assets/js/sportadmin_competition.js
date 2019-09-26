//require('bootstrap');

var statusNull = '<i class="fas fa-square text-medium h4"></i>';
var statusTrue = '<i class="fas fa-check-square text-success" data-value="true"></i>';
var statusFalse = '<i class="fas fa-minus-square text-warning" data-value="false"></i>';

function loadCompetitionEnrolments(id) {
    $.getJSON( "/api/private/sportadmin/competition/"+id )
    .done(function( data ) {
        if (data.success) {
            $.each(data.data, function(i, item) {
                var td = $('#competition-enrolment-'+item.competitionpart+'-'+item.member);
                if (item.enabled) {
                    if (item.enrolled) {
                        $(td).html( statusTrue );
                    } else {
                        $(td).html( statusFalse );
                    }
                    td.closest('tr').removeClass('competition-disabled');
                    if (!item.enrolledAt) {
                        td.addClass('table-active');
                    }
                } else {
                    $(td).html( statusNull );
                }
            });
        }
    }).fail(function() {
        $('#competition-enrolments-error').removeClass('d-none');
    });
}

// on pageload
loadCompetitionEnrolments($('#competition-enrolments').data('competition'));
