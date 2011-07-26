function preparePackageManager() {
    $('div.remove-url').css('display', 'none');

    $('button.add').live('click', function(e) {
	id = $('#urls .rowElem').length + 1;
	urlEntry = $('#urls .rowElem').first().clone();
	urlEntry.find('input.url').attr('id', 'url-' + id);
	urlEntry.find('input.url').attr('placeholder', 'http://...');
	$('#urls').append(urlEntry);
	$('div.remove-url').css('display', 'block');
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
    $('table').tablesorter({widgets: ['zebra']});

    $('.html').chili();

    $('a.fancyzoom').fancyzoom();

    $('.toc').tableOfContents(null, {startLevel: 2});

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
    else
	id = 'index';

    $('#menu-' + id).addClass('active');

});
