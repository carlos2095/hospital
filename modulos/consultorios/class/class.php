<?php
class Proceso_Consultorios{
	var $id;	
	var $nombre;	
	var $direccion;	
	var $telefono;	
	var $encargado;	
	var $estado;
	
	function __construct($id,$nombre,$direccion,$telefono,$encargado,$estado){
		$this->id=$id;						
		$this->nombre=$nombre;						
		$this->direccion=$direccion;						
		$this->telefono=$telefono;						
		$this->encargado=$encargado;						
		$this->estado=$estado;	
	}
	
	function crear(){
		$id=$this->id;						
		$nombre=$this->nombre;					
		$direccion=$this->direccion;					
		$telefono=$this->telefono;					
		$encargado=$this->encargado;					
		$estado=$this->estado;	
							
		mysql_query("INSERT INTO consultorios (nombre,direccion,telefono,encargado,estado)	VALUES ('$nombre','$direccion','$telefono','$encargado','$estado')");
	}
	
	function actualizar(){
		$id=$this->id;						
		$nombre=$this->nombre;					
		$direccion=$this->direccion;					
		$telefono=$this->telefono;					
		$encargado=$this->encargado;					
		$estado=$this->estado;			
				
		mysql_query("UPDATE consultorios SET nombre='$nombre',direccion='$direccion',telefono='$telefono',encargado='$encargado', estado='$estado' WHERE id='$id'");
	}
}
?>