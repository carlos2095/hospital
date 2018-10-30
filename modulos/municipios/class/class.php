<?php
class Proceso_Municipios{
	var $id;	
	var $nombre;	
	var $departamento;	
	var $estado;
	
	function __construct($id,$nombre,$departamento,$estado){
		$this->id=$id;						
		$this->nombre=$nombre;						
		$this->departamento=$departamento;						
		$this->estado=$estado;	
	}
	
	function crear(){
		$id=$this->id;						
		$nombre=$this->nombre;					
		$departamento=$this->departamento;					
		$estado=$this->estado;	
							
		mysql_query("INSERT INTO municipios (nombre,departamento, estado)	VALUES ('$nombre','$departamento','$estado')");
	}
	
	function actualizar(){
		$id=$this->id;		
		$nombre=$this->nombre;
		$departamento=$this->departamento;	
		$estado=$this->estado;			
				
		mysql_query("UPDATE municipios SET nombre='$nombre', departamento='$departamento', estado='$estado' WHERE id='$id'");
	}
}
?>