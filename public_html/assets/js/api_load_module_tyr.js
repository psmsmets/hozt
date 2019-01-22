function toTyr(){
    toClipboard("tyr-clubcode");
    addAnimation("tyr-clubcode","tada");
    var t = setTimeout(function(){window.open('http://www.tyr.nl','_blank');},1000);
}

$(document).ready(function(){
    $('#api_load_module_tyr').html('<div class="row justify-content-around p-3"><div class="col col-8 col-md-10"><div class="tyr" data-toggle="tooltip" data-placement="bottom" title="" data-offset="0" data-original-title="Klik om de clubcode te kopiëren"><img class="mx-auto img-fluid" src="/assets/img/sponsors/tyr.png"><div class="text-center" style="margin-top:.5em; padding-bottom:0;">Clubcode <span id="tyr-clubcode" style="display:inline-block;" class="">HGS15ZM</span></div></div></div></div>');
    $('.tyr').click(function(e){
      toTyr();
    });
});
