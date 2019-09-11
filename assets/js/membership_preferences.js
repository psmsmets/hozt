require('bootstrap');

$('#preferencesModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var tab = button.data('tab')
  var action = button.data('action')
  var id = button.data('id')
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this).find('.modal-dialog')
  modal.html('<div class="spinner-border mx-auto" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>');
  preferencesAction( tab, action, id, modal );
});

function preferencesAction( tab, action = 'new', id = null, obj ) {
    $.getJSON( "/api/private/membership/preferences", {
        tab: tab,
        action: action,
        id: id,
        format: "json",
    })
    .done(function( data ) {
        if (data.success) {
            if (action !== 'remove') { 
                obj.html( data.html );
                formSubmit();
            }
        }
    });
}

function loadPreferencesContent() {
    var active = $('#preferences-tab').find('.active');
    var tab = active.data('tab');
    var tabpanel = $('#preferences-'+tab);
    $(tabpanel).html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    $.getJSON( "/api/private/membership/preferences", {
        tab: tab,
        action: 'load',
        format: "json",
    })
    .done(function( data ) {
        if (data.success) {
            $(tabpanel).html( data.html );
        }
    });
}

function formSubmit() {
    $('form').submit(function() {
        $.ajax({ // create an AJAX call...
            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: $(this).attr('action'), // the file to call
            success: function(response) { // on success..
                //$('#created').html(response); // update the DIV
                loadPreferencesContent();
                $('#preferencesModal').modal('hide');
            }
        });
        return false; // cancel original event to prevent form submitting
    });
}

$("button[data-action='remove']").each(function(){
    $(this).click(function(){
        if (confirm('Bent u zeker?')) {
            preferencesAction( $(this).data('tab'), $(this).data('action'), $(this).data('id') );
            loadPreferencesContent();
        }
    });
});
