function preparePackageManager() {
    $('div.remove-url').css('display', 'none');

    $('button.add').live('click', function(e) {
	id = $('#urls .rowElem').length + 1;
	urlEntry = $('#urls .rowElem').first().clone();
	urlEntry.find('input.url').attr('id', 'url-' + id);
	urlEntry.find('input.url').attr('value', '');
	$('#urls').append(urlEntry);
	$('div.remove-url').css('display', 'block');
	$('div.remove-url').css('opacity', '0.25');
    });

    $('form').ajaxForm(function(response) {
	$('#response').html(response);
	$('.html').chili();
    });

    $('div.remove-url').live('mouseout', function(e) {
	$(this).animate({opacity: 0.25});
    }).live('mouseover', function(e) {
	$(this).animate({opacity: 1.0});
    });

    $('div.remove-url').live('click', function(e) {
	$(this).parent().fadeOut('slow', function() {
	    $(this).remove();
	    if($('div.remove-url').length < 2)
		$('div.remove-url').css('display', 'none');
	});
    });
}

$(document).ready(function() {
    if(($('html.ie6').length != 0 || $('html.ie7').length != 0) && !$.cookie('ie-modal')) {
	$.modal('<p>This site may not be fully functional on IE.</p></p><b>Please, get a better browser!</b></p>');
	$.cookie('ie-modal', 1);
    }
    $('table').tablesorter({widgets: ['zebra']});

    $('.html').chili();

    $('a.fancyzoom').fancyzoom();

    $('.toc').tableOfContents(null, {startLevel: 2});
    $('.toc a').anchorAnimate();

    $('form.jqtransform').jqTransform();

    path = window.location.pathname;
    if(path.indexOf('/quickstart') == 0) 
	id = 'quickstart';
    else if(path.indexOf('/packagemanager') == 0) {
    	id = 'packagemanager';
	preparePackageManager();
    }
    else if(path.indexOf('/docs') == 0) 
	id = 'docs';
    else if(path.indexOf('/examples') == 0) 
	id = 'examples';
    else if(path.indexOf('/interact') == 0) 
	id = 'interact';
    else
	id = 'index';

    $('#menu-' + id).addClass('active');

});
