require('bootstrap');

var statusNull = '<i class="fas fa-square text-medium h4"></i>';
var statusTrue = '<i class="fas fa-check-square text-success" data-value="true"></i>';
var statusFalse = '<i class="fas fa-minus-square text-warning" data-value="false"></i>';


function loadCompetitionEnrolments(id) {
console.log(id);
    $.getJSON( "/api/private/sportadmin/competition/"+id )
    .done(function( data ) {
        if (data.success) {
            //var newCompetitions = 0;
            $.each(data.data, function(i, item) {
                var td = $('#competition-enrolment-'+item.competitionpart+'-'+item.member);
                if (item.enabled) {
                    if (item.enrolled) {
                        $(td).html( statusTrue );
                    } else {
                        $(td).html( statusFalse );
                    }
                    td.closest('tr').removeClass('competition-disabled');
                } else {
                    $(td).html( statusNull );
                }
                //if (!item.enrolledAt && item.editable) newCompetitions = newCompetitions + 1;
            });
            //if (newCompetitions) $('#competitions-new-tab span').html(newCompetitions);
        }
    });
}

// on pageload
loadCompetitionEnrolments($('#competition-enrolments').data('competition'));
