<?php
	session_start();
	$_SESSION['user_name']=NULL;
	$_SESSION['tipo_user']=NULL;
	$_SESSION['cod_user']=NULL;
	header('Location:index.php');
?>