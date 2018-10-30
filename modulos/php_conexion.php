<?php
	
	$conexion = mysql_connect("localhost","root","");
	mysql_select_db("consultorio",$conexion);
	date_default_timezone_set("America/El_Salvador");
    mysql_query("SET NAMES utf8");
	mysql_query("SET CHARACTER_SET utf");
	$s='$';
	
	function limpiar($tags){
		$tags = strip_tags($tags);
		return $tags;
	}

	
?>