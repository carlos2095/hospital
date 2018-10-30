<?php 
					if(!empty($_POST['documento']) and !empty($_POST['estado'])){
						                $documento=limpiar($_POST['documento']);		
										$nombre=limpiar($_POST['nombre']);		
										$direccion=limpiar($_POST['direccion']);
										$departamento=limpiar($_POST['departamento']);
										$municipio=limpiar($_POST['municipio']);
										$telefono=limpiar($_POST['telefono']);
										$edad=limpiar($_POST['edad']);			
										$sexo=limpiar($_POST['sexo']);															
										$email=limpiar($_POST['email']);															
										$estado=limpiar($_POST['estado']);
						
						$oGrado=new Consultar_Grado($grado);
						$oSalon=new Consultar_Salon($salon);
						$ngrado=$oGrado->consultar('nombre');
						$nsalon=$oSalon->consultar('nombre');
							
						$oGuardar=new Proceso_Alumno($doc,$nombre,$grado,$salon,$fecha,$direccion,$telefono,$estado,$matricula,$tipo);
						
						if(empty($_POST['id'])){
							$oGuardar->guardar();
							echo mensajes('Alumno "'.$nombre.'" Registrado con Exito en la Base de datos<br>
							Registrado en el Grado "'.$ngrado.'" Salon "'.$nsalon.'"','verde');					
						}else{
							$oGuardar->actualizar();
							echo mensajes('Alumno "'.$nombre.'" Actualizado con Exito en la Base de datos<br>
							Registrado en el Grado "'.$ngrado.'" Salon "'.$nsalon.'"','verde');		
						}
					}
					
					if(!empty($_POST['rh']) and !empty($_POST['emergencia']) and !empty($_POST['id'])){
						$id=limpiar($_POST['id']);
						$rh=limpiar($_POST['rh']);						
						$emergencia=limpiar($_POST['emergencia']);
						$eps=limpiar($_POST['eps']);					
						$padre=limpiar($_POST['padre']);
						$madre=limpiar($_POST['madre']);				
						$p_ocupacion=limpiar($_POST['p_ocupacion']);
						$m_ocupacion=limpiar($_POST['m_ocupacion']);	
						$acudiente=limpiar($_POST['acudiente']);
						mysql_query("UPDATE alumnos SET rh='$rh',
														eps='$eps',
														madre='$madre',
														padre='$padre',
														p_ocupacion='$p_ocupacion',
														m_ocupacion='$m_ocupacion',
														acudiente='$acudiente',
														emergencia='$emergencia'
												WHERE id=$id
						");	
						echo mensajes('Informcion Secundaria Registrada con Exito','verde');
					}
				?>