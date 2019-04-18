function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function scheduleNoticeAlert(msg) {
    notice = "<div class=\"alert alert-" + msg.type + " alert-dismissible fade fade-in mt-3 show\" role=\"alert\" id=\"" + msg.cookie + "\">";
    notice += "<i class=\"fas fa-exclamation-triangle\"></i> " + msg.title + " voor<span class=\"d-none d-lg-inline\"> de </span>";
    $.each( msg.categories, function( i, item ) {
        notice += "<a class=\"alert-link ml-1 mr-1 d-lg-none\" href=\"" + item.url + "\">" + item.abbr + "</a>";
        notice += "<a class=\"alert-link ml-1 mr-1 d-none d-lg-inline\" href=\"" + item.url + "\">" + item.name + "</a>";
    });
    notice += "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
    notice += "<span aria-hidden=\"true\">&times;</span>";
    notice += "</button></div>";
    return notice;
}
