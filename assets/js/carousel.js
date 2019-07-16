require('bootstrap');
require('bcswipe');

$('.carousel').carousel({ interval: 6500 });
$('.carousel').bcSwipe({ threshold: 60 });
