function grado(valor){
	var url = 'DibujaSalon.php';
	var pars = ("filtro=" + valor);
	var myAjax = new Ajax.Updater('divSalon', url, { method: 'get', parameters: pars});
}
