// $('#calendar').datepicker({});

$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});


String.prototype.replaceAll = function(search, replacement) {
	var target = this;
	return target.split(search).join(replacement);
};

function iraUrlInput(url, inputId = false) {

	if (inputId) {
		var input = $("#"+inputId).val();
    // var input = $("input[name='"+inputName+"']").val();
		if (input) {
			input = input.replaceAll(' ', '+');
			url = url+'/search/'+input; // '/place/' considera que lo ha encontrado
		}
	}

	if (win = window.open(url, '_blank')) { win.focus(); }
	else { alert('Please allow popups for this website'); }
}


// Cargamos los tooltips on ready
$(function() {
	$('[data-toggle="tooltip"]').tooltip();
});
