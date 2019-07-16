// calendar
$(document).ready(function(){

  $('#toggle-past').click(function(e) {
    if (pasthidden){
      $('.past').show(400);
      $('#toggle-past i').removeClass("fa-eye-slash");
      $('#toggle-past i').addClass("fa-eye");
      $.each( $('a[id^="cal-"]'), function() {
        if ($(this).hasClass('hidden')) {
          $('.media.'+$(this).attr('id')).hide();
        }
      });
      pasthidden = false;
    } else {
      $('.past').hide(400);
      $('#toggle-past i').removeClass("fa-eye");
      $('#toggle-past i').addClass("fa-eye-slash");
      pasthidden = true;
    }
  });

  $.each( $('a[id^="cal-"]'), function() {
    $(this).click(function(e) {
      if ($(this).hasClass('hidden')) {
        $('.media.'+$(this).attr('id')).show(400);
        if (pasthidden){ $('.past').hide(); }
        $(this).removeClass("hidden");
        $('#'+$(this).attr('id')+ ' i').removeClass("fa-eye-slash");
        $('#'+$(this).attr('id')+ ' i').addClass("fa-eye");
      } else {
        $('.media.'+$(this).attr('id')).hide(400);
        $(this).addClass("hidden");
        $('#'+$(this).attr('id')+ ' i').removeClass("fa-eye");
        $('#'+$(this).attr('id')+ ' i').addClass("fa-eye-slash");
      }
    });
  });

  var pasthidden = $('.js-calendar-past').data('pastHidden');
  if (pasthidden) {
    $('.past').hide();
  }

});
