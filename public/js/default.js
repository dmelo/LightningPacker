$(document).ready(function() {
    $('table').tablesorter({widgets: ['zebra']});

    $('.html').chili();

    $('a.fancyzoom').fancyzoom();

    $('.toc').tableOfContents(null, {startLevel: 2});
});
