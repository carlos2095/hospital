function pais(valor){
	var url = 'DibujaEstado.php';
	var pars = ("filtro=" + valor);
	var myAjax = new Ajax.Updater('divEstado', url, { method: 'get', parameters: pars});
}
function estado(valor){
	var url = 'DibujaMunicipio.php';
	var pars = ("filtro=" + valor);
	var myAjax = new Ajax.Updater('divMunicipio', url, { method: 'get', parameters: pars});
}
function municipio(valor){
	var url = 'DibujaLocalidad.php';
	var pars = ("filtro=" + valor);
	var myAjax = new Ajax.Updater('divLocalidades', url, { method: 'get', parameters: pars});
}

function grado(valor){
	var url = 'DibujaSalon.php';
	var pars = ("filtro=" + valor);
	var myAjax = new Ajax.Updater('divSalon', url, { method: 'get', parameters: pars});
}