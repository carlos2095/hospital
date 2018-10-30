<?php
class Proceso_Cita{
	var $id;	
	var $id_paciente;	
	var $id_medico;	
	var $id_consultorio;	
	var $fechai;		
	var $observaciones;
	var $fecha;	
	var $hora;
	var $horario;
	var $status;
	
	function __construct($id,$id_paciente,$id_medico,$id_consultorio,$fechai,$observaciones,$fecha,$hora,$horario,$status){
		$this->id=$id;						
		$this->id_paciente=$id_paciente;						
		$this->id_medico=$id_medico;						
		$this->id_consultorio=$id_consultorio;						
		$this->fechai=$fechai;																												
		$this->observaciones=$observaciones;	
		$this->fecha=$fecha;	
		$this->hora=$hora;
		$this->horario=$horario;
		$this->status=$status;	
	}
	
	function crear(){
		$id=$this->id;						
		$id_paciente=$this->id_paciente;					
		$id_medico=$this->id_medico;					
		$id_consultorio=$this->id_consultorio;					
		$fechai=$this->fechai;																						
		$observaciones=$this->observaciones;	
		$fecha=$this->fecha;	
		$hora=$this->hora;
		$horario=$this->horario;
		$status=$this->status;	
							
		mysql_query("INSERT INTO citas_medicas (id_paciente, id_medico, consultorio, fechai, observaciones, fecha, hora, horario, status)	
							VALUES ('$id_paciente','$id_medico','$id_consultorio','$fechai','$observaciones','$fecha','$hora','$horario','$status')");
	}
	
	function actualizar(){
		$id=$this->id;						
		#$id_paciente=$this->id_paciente;					
		#$id_medico=$this->id_medico;					
		$fechai=$this->fechai;								
		$horario=$this->horario;								
		$observaciones=$this->observaciones;				
				
		mysql_query("UPDATE cita_medicas SET fechai='$fechai',												  
												  observaciones='$observaciones'
												  horario='$horario' 
												WHERE id='$id'");
	}
}
?>