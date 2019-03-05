$(document).ready(function(){

  let url = location.href.replace(/\/$/, "");
 
  if (location.hash) {
      const hash = url.split("#");
      $('#categoryTab a[href="#'+hash[1]+'"]').tab("show");
      $.scrollTo(0, 500);
  } else if (url.endsWith("wedstrijdzwemmers")) {
      $('#wedstrijden-tab').tab('show');
  }
   
  $('a[data-toggle="tab"]').on("click", function() {
      let newUrl;
      const hash = $(this).attr("href");
      newUrl = url.split("#")[0] + hash;
      history.replaceState(null, null, newUrl);
  });

});
