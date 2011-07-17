$(document).ready(function() {
    $('#simplemodal').click(function(e) {
	e.preventDefault();
	$('#div-simplemodal').modal();
    });

    $('.modalCloseImg').click(function(e) {
	e.preventDefault();
	$.modal.close();
    });

    $('.jqzoom').jqzoom();
});
