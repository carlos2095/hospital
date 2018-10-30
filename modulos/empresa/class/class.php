<?php
class Proceso_Usuario{
	var $doc;		
	var $nom;								
	var $tel;		
	var $dir;
	var $sexo;		
	var $tipo;		
	var $consultorio;
	var $correo;
	var $estado;
	var $fechar;					
	var $con;			
	
	function __construct($doc,$nom,$tel,$dir,$sexo,$tipo,$consultorio,$correo,$estado,$fechar,$con){
		$this->doc=$doc;	
		$this->nom=$nom;
		$this->tel=$tel;
		$this->dir=$dir;
		$this->sexo=$sexo;
		$this->tipo=$tipo;
		$this->consultorio=$consultorio;
		$this->correo=$correo;
		$this->estado=$estado;
		$this->fechar=$fechar;
		$this->con=$con;	
															
	}
	
	function crear(){
		$doc=$this->doc;	
		$nom=$this->nom;	
		$tel=$this->tel;	
		$dir=$this->dir;	
		$sexo=$this->sexo;		
		$tipo=$this->tipo;
		$consultorio=$this->consultorio;	
		$correo=$this->correo;	
		$estado=$this->estado;	
		$fechar=$this->fechar;	
		$con=$this->con;	
		
		
		mysql_query("INSERT INTO persona (doc, nom, tel, sexo, dir, estado) VALUES 
				('$doc','$nom','$tel','$sexo','$dir','$estado')");
		mysql_query("INSERT INTO username (usu, con, correo, fecha, tipo) VALUES ('$doc','$con','$correo','$fechar','$tipo')");
		mysql_query("INSERT INTO cajero (usu, consultorio) VALUES ('$doc','$consultorio')");
	}
	
	function actualizar(){
		$doc=$this->doc;	
		$nom=$this->nom;	
		$tel=$this->tel;	
		$dir=$this->dir;	
		$sexo=$this->sexo;		
		$tipo=$this->tipo;
		$consultorio=$this->consultorio;	
		$correo=$this->correo;	
		$estado=$this->estado;	
		$fechar=$this->fechar;	
		$con=$this->con;	
				
		mysql_query("UPDATE persona SET nom='$nom', tel='$tel', sexo='$sexo', dir='$dir', estado='$estado' WHERE doc='$doc'");
		mysql_query("UPDATE username SET correo='$correo', tipo='$tipo' WHERE usu='$doc'");
		mysql_query("UPDATE cajero SET cunsultorio='$consultorio' WHERE usu='$doc'");
	}
}

?>