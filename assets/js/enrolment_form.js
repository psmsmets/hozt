$('input.form-control[data-category-title]').each(function(){
    var formGroup = $(this).parent();
    $( '<h4 class="pt-4">' + $(this).data('category-title') + '</h4>' ).insertBefore(formGroup);
});

$('input.form-control[data-category-description]').each(function(){
    var formGroup = $(this).parent();
    $( '<p>' + $(this).data('category-description') + '<p>' ).insertBefore(formGroup);
});

$(".form-control[data-parent-class]").each(function(){
    var formGroup = $(this).parent();
    $(formGroup).addClass($(this).data('parent-class'));
});

$(".form-control[data-parent-parent-class]").each(function(){
    var formGroup = $(this).parent().parent();
    $(formGroup).addClass($(this).data('parent-parent-class'));
});


function getTotals() {

    var totalDefault = 0;
    var totalIncluded = 0;
    var totalSupplement = 0;

    var totalPrice = 0.;

    $('input.form-control[data-category-type]').each(function(){
        if ($(this).val() == ''){
            return true;
        }
        value = parseInt($(this).val());
        if ($(this).data('category-type') === 'default') {
            totalDefault += value;
            if (typeof $(this).data('value') !== 'undefined') {
                totalPrice += value * parseFloat($(this).data('value'));
            }
        }
        else if ($(this).data('category-type') === 'included') {
            totalIncluded += value;
        }
        else if ($(this).data('category-type') === 'supplement') {
            totalSupplement += value;
            if (typeof $(this).data('value') !== 'undefined') {
                totalPrice += value * parseFloat($(this).data('value'));
            }
        }
    });

    $('input#enrolment_form_totalPrice').val(totalPrice.toFixed(2).replace(".", ","));
    $('input#enrolment_form_numberOfPersons').val(totalDefault);

    return {
        "default" : totalDefault,
        "included" : totalIncluded,
        "supplement" : totalSupplement,
        "totalPrice" : totalPrice,
    };
}

function setMaxIncluded(totals) {
    $('input.form-control[data-category-type="included"]').each(function(){
        maxVal = totals.default - totals.included;
        if ($(this).val() != '') {
            maxVal += parseInt($(this).val());
        }
        $(this).attr({
            "max" : maxVal,
        });
    });
}

function setDefaultRequired(totals) {
    if (totals.default == 0) {
      $('input.form-control[data-category-type="default"]').attr("min",1);
    } else {
      $('input.form-control[data-category-type="default"]').attr("min",0);
    }
}

$('input.form-control[data-category-type]').each(function(){
    $(this).focusout(function(){
        var totals = getTotals();
        if ($(this).data('category-type') !== 'supplement' ) {
            setMaxIncluded(totals);
        }
        setDefaultRequired(totals);
    });
});
