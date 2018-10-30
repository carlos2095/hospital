<?php
class Proceso_Paciente{
	var $id;	
	#var $documento;
	var $nombre;
    var $direccion;		
	var $departamento;	
	var $municipio;		
	var $telefono;		
	var $edad;		
	var $sexo;		
	var $email;	
	var $estado;
	var $id_consultorio;
	
	function __construct($id,$nombre,$direccion,$departamento,$municipio,$telefono,$edad,$sexo,$email,$estado,$id_consultorio){
		$this->id=$id;		
		#$this->documento=$documento;		
		$this->nombre=$nombre;		
		$this->direccion=$direccion;	
		$this->departamento=$departamento;
		$this->municipio=$municipio;
		$this->telefono=$telefono;
		$this->edad=$edad;	
		$this->sexo=$sexo;	
		$this->email=$email;			
		$this->estado=$estado;	
		$this->id_consultorio=$id_consultorio;	
	}
	
	function crear(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$departamento=$this->departamento;
		$municipio=$this->municipio;
		$telefono=$this->telefono;	
		$edad=$this->edad;	
		$sexo=$this->sexo;	
		$email=$this->email;	
		$estado=$this->estado;	
		$id_consultorio=$this->id_consultorio;	
							
		mysql_query("INSERT INTO pacientes (nombre, direccion, departamento, municipio, telefono, edad, sexo, email, estado, consultorio) 
					VALUES ('$nombre','$direccion','$departamento','$municipio','$telefono','$edad','$sexo','$email','$estado','$id_consultorio')");
	}
	
	function actualizar(){
		$id=$this->id;		
		#$documento=$this->documento;		
		$nombre=$this->nombre;		
		$direccion=$this->direccion;	
		$departamento=$this->departamento;
		$municipio=$this->municipio;
		$telefono=$this->telefono;	
		$edad=$this->edad;	
		$sexo=$this->sexo;	
		$email=$this->email;	
		$estado=$this->estado;		
		
		mysql_query("UPDATE pacientes SET  
										nombre='$nombre',
										direccion='$direccion',
										departamento='$departamento',
										municipio='$municipio',
										telefono='$telefono',
										edad='$edad',
										sexo='$sexo',										
										email='$email',
										estado='$estado'
									WHERE id='$id'");
	}
}
?>