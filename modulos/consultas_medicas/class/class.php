<?php
class Proceso_Consulta{
	var $id;	
	var $id_paciente;	
	var $id_medico;	
	var $id_consultorio;	
	var $sintomas;	
	var $diagnostico;	
	var $tratamiento;	
	var $reseta;	
	var $observaciones;
	var $fecha;
	var $hora;
	var $status;
	
	function __construct($id,$id_paciente,$id_medico,$id_consultorio,$sintomas,$diagnostico,$tratamiento,$reseta,$observaciones,$fecha,$hora,$status){
		$this->id=$id;						
		$this->id_paciente=$id_paciente;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->sintomas=$sintomas;						
		$this->diagnostico=$diagnostico;						
		$this->tratamiento=$tratamiento;						
		$this->reseta=$reseta;						
		$this->observaciones=$observaciones;	
		$this->fecha=$fecha;	
		$this->hora=$hora;	
		$this->status=$status;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_paciente=$this->id_paciente;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$sintomas=$this->sintomas;					
		$diagnostico=$this->diagnostico;					
		$tratamiento=$this->tratamiento;					
		$reseta=$this->reseta;					
		$observaciones=$this->observaciones;	
		$fecha=$this->fecha;	
		$hora=$this->hora;	
		$status=$this->status;	
							
		mysql_query("INSERT INTO consultas_medicas (id_paciente, id_medico,consultorio,sintomas, diagnostico,tratamiento,reseta,observaciones,fecha,hora,status)	
							VALUES ('$id_paciente','$id_medico','$id_consultorio','$sintomas','$diagnostico','$tratamiento','$reseta','$observaciones','$fecha','$hora','$status')");
	}
	
	function actualizar(){
		$id=$this->id;						
		#$id_paciente=$this->id_paciente;					
		#$id_medico=$this->id_medico;					
		$sintomas=$this->sintomas;					
		$diagnostico=$this->diagnostico;					
		$tratamiento=$this->tratamiento;					
		$reseta=$this->reseta;					
		$observaciones=$this->observaciones;				
				
		mysql_query("UPDATE consultas_medicas SET sintomas='$sintomas',
												  diagnostico='$diagnostico', 
												  tratamiento='$tratamiento', 
												  reseta='$reseta', 
												  observaciones='$observaciones' 
												WHERE id='$id'");
	}
}
?>