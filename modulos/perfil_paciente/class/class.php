<?php
class Proceso_Deparmentos{
	var $id;	
	var $nombre;	
	var $estado;
	
	function __construct($id,$nombre,$estado){
		$this->id=$id;						
		$this->nombre=$nombre;						
		$this->estado=$estado;	
	}
	
	function crear(){
		$id=$this->id;						
		$nombre=$this->nombre;					
		$estado=$this->estado;	
							
		mysql_query("INSERT INTO departamentos (nombre, estado)	VALUES ('$nombre','$estado')");
	}
	
	function actualizar(){
		$id=$this->id;		
		$nombre=$this->nombre;					
		$estado=$this->estado;			
				
		mysql_query("UPDATE departamentos SET nombre='$nombre', estado='$estado' WHERE id='$id'");
	}
}
?>