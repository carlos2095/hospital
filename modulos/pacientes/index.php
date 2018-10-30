<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	if($_SESSION['cod_user']){
	}else{
		header('Location: ../../php_cerrar.php');
	}
	
	$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM pacientes WHERE id='$id'");
		header('index.php');
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Consultorio Medico</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../usuarios/perfil.php"><?php echo $_SESSION['user_name']; ?></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;">Consultorio: <?php echo $nombre_Consultorio; ?> :: Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_pacientes.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">
				<div class="panel-body">                            
                    <div class="alert alert-info" align="center">
                    <h3>PACIENTES<h3>
                    </div>                
                 <!-- /. ROW  -->                 
                 <div class="panel-body" align="right">                                                                                 
                            <button type="button" class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal" title="Agregar Paciente"><i class="fa fa-plus fa-2x"></i>
                            </button>
                            <button type="button" class="btn btn-info btn-circle"><i class="fa fa-question fa-2x"></i>
                            </button>                                                                                 
                  </div>
				  <!--  Modals-->
								 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h3 align="center" class="modal-title" id="myModalLabel">Nuevo Paciente</h3>
													</div>
										<div class="panel-body">
										<div class="row">											
											<div class="col-md-12">
											<br>
											<input class="form-control" name="nombre" placeholder="Nombre Completo" autocomplete="off" required><br>
											
											</div>
											<div class="col-md-6">											
												<!--<label>Documento:</label>
												<input class="form-control" name="documento" data-mask="99999999-9" autocomplete="off" required autofocus><br>-->																																															
												<input class="form-control" name="direccion" placeholder="Dirección" autocomplete="off" required><br>	
												<select class="form-control" name="departamento" autocomplete="off" required>									
												<option value="x">---ESTADO---</option>
													<?php
															$p=mysql_query("SELECT * FROM departamentos WHERE estado='s'");				
															while($r=mysql_fetch_array($p)){
																echo '<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
															}
														?>												
												</select><br>												
												<select class="form-control" name="municipio" autocomplete="off" required>
													<option>---CIUDAD---</option>
													<?php
															$p=mysql_query("SELECT * FROM municipios WHERE estado='s' ORDER BY nombre");				
															while($r=mysql_fetch_array($p)){
																echo '<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
															}
														?>	
												<!--<div id="divEstado">
                                    				<select class="form-control" name="municipio" autocomplete="off" required>
                                                    </select>
                                                </div>-->
												</select><br>												
												<input class="form-control" name="telefono" data-mask="(999)999-9999" placeholder="Telefono" autocomplete="off" required><br>
												
											</div>
											<div class="col-md-6">
												<input class="form-control" name="edad" placeholder="Edad" autocomplete="off" required><br>
												<select class="form-control" name="sexo" autocomplete="off" required>
													<option value="m">Masculino</option>
													<option value="f">Femenino</option>													
												</select><br>												
												<input class="form-control" name="email" placeholder="Email" autocomplete="off"><br>																							 
												<select class="form-control" name="estado" placeholder="Estado" autocomplete="off" required>						
													<option value="s">Activo</option>
													<option value="n">No Activo</option>													
												</select>
											</div> 																																												                                                            
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
					  
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             LISTADO
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
								<?php 
									if(!empty($_POST['nombre'])){ 
										#$documento=limpiar($_POST['documento']);		
										$nombre=limpiar($_POST['nombre']);		
										$direccion=limpiar($_POST['direccion']);
										$departamento=limpiar($_POST['departamento']);
										$municipio=limpiar($_POST['municipio']);
										$telefono=limpiar($_POST['telefono']);
										$edad=limpiar($_POST['edad']);			
										$sexo=limpiar($_POST['sexo']);															
										$email=limpiar($_POST['email']);															
										$estado=limpiar($_POST['estado']);
										
										if(empty($_POST['id'])){
											$oPaciente=new Proceso_Paciente('',$nombre,$direccion,$departamento,$municipio,$telefono,$edad,$sexo,$email,$estado,$id_consultorio);
											$oPaciente->crear();
											echo mensajes('Paciente "'.$nombre.'" Creado con Exito','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oPaciente=new Proceso_Paciente($id,$nombre,$direccion,$departamento,$municipio,$telefono,$edad,$sexo,$email,$estado,$id_consultorio);
											$oPaciente->actualizar();
											echo mensajes('Paciente "'.$nombre.'" Actualizado con Exito','verde');
										}
									}
									if(!empty($_POST['sangre']) and !empty($_POST['vih']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);
											$sangre=limpiar($_POST['sangre']);						
											$vih=limpiar($_POST['vih']);
											$peso=limpiar($_POST['peso']);					
											$talla=limpiar($_POST['talla']);
											$alergia=limpiar($_POST['alergia']);				
											$medicamento=limpiar($_POST['medicamento']);
											$enfermedad=limpiar($_POST['enfermedad']);												
											mysql_query("UPDATE pacientes SET sangre='$sangre',
																			vih='$vih',
																			peso='$peso',
																			talla='$talla',
																			alergia='$alergia',
																			medicamento='$medicamento',
																			enfermedad='$enfermedad'																			
																	WHERE id=$id
											");	
											echo mensajes('Expedinte Registrado con Exito','verde');
									}
								?>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    
									<thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>DIRECCION</th>
                                            <th>TELEFONO</th>                                           
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
											if(!empty($_POST['buscar'])){
												$buscar=limpiar($_POST['buscar']);
												$pame=mysql_query("SELECT * FROM pacientes WHERE and consultorio='$id_consultorio' nombre LIKE '%$buscar%' ORDER BY nombre");	
											}else{
												$pame=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' ORDER BY nombre");		
											}		
											while($row=mysql_fetch_array($pame)){
											$url=$row['id'];
										?>
                                        <tr class="odd gradeX">
                                            <td><i class="fa fa-user fa-2x"></i> <?php echo $row['nombre']; ?></td>
                                            <td><?php echo $row['direccion']; ?></td>
                                            <td><?php echo $row['telefono']; ?></td>                                           
                                            <td class="center">
											<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu">
												<li><a  href="../perfil_paciente/index.php?id=<?php echo $url; ?>"><i class="fa fa-user"></i> Perfil</a></li>
												<li class="divider"></li>
												<li><a  href="#" data-toggle="modal" data-target="#actualizar<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Editar</a></li>
												<!--<li class="divider"></li>
												<li><a href="index.php?del=<?php echo $row['id']; ?>" ><i class="fa fa-pencil"></i> Eliminar</a></li>-->																																				
											  </ul>
											</div>
											<a href="#cuadro<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-primary" title="Expediente Clinico">
											<i class="fa fa-edit" ></i>
										    </a>																			
											<a href="../historial_medico/index.php?id=<?php echo $url; ?>"  class="btn btn-info" title="Historial Clinico">
											<i class="fa fa-list-alt" ></i>
										    </a>											
											</td>
											
									    <!--  Modals-->
										 <div class="modal fade" id="actualizar<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">Actualizar Información</h3>
															</div>
										<div class="panel-body">
										<div class="row">                                       
											<div class="col-md-6">											
												<!--<label>Documento:</label>
												<input class="form-control" name="documento" data-mask="99999999-9" autocomplete="off" required value="<?php echo $row['documento']; ?>"><br>-->
												<label>Nombre:</label>
												<input class="form-control" name="nombre" autocomplete="off" required value="<?php echo $row['nombre']; ?>"><br>
												<label>Dirección:</label>
												<input class="form-control" name="direccion" autocomplete="off" required value="<?php echo $row['direccion']; ?>"><br>
												<label>Estado:</label>
												<select class="form-control" name="departamento" onchange="pais(this.value);" autocomplete="off" required>			
													<?php
														$p=mysql_query("SELECT * FROM departamentos WHERE estado='s'");				
														while($r=mysql_fetch_array($p)){
															if($r['id']==$row['departamento']){
																echo '<option value="'.$r['id'].'" selected>'.$r['nombre'].'</option>';
															}else{
																echo '<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
															}
														}
													?>										
												</select><br>
												<label>Ciudad:</label>
												<select class="form-control" name="municipio" autocomplete="off" required>											
													<?php
														$p=mysql_query("SELECT * FROM municipios WHERE estado='s'");				
														while($r=mysql_fetch_array($p)){
															if($r['id']==$row['municipio']){
																echo '<option value="'.$r['id'].'" selected>'.$r['nombre'].'</option>';
															}else{
																echo '<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
															}
														}
													?>		
												<!--<div id="divEstado">
                                    				<select class="form-control" name="municipio" autocomplete="off" required>
                                                    </select>
                                                </div>-->
												</select>
											</div>
											<div class="col-md-6">											
												<label>Telefono:</label>
												<input class="form-control" name="telefono" data-mask="9999-9999" autocomplete="off" required value="<?php echo $row['telefono']; ?>"><br>
												<label>Edad:</label>
												<input type="number" class="form-control" name="edad" autocomplete="off" required min="1" value="<?php echo $row['edad']; ?>"><br>
												<label>Sexo:</label>
												<select class="form-control" name="sexo" autocomplete="off" required>
													<option value="m" <?php if($row['sexo']=='m'){ echo 'selected'; } ?>>Masculino</option>
													<option value="f" <?php if($row['sexo']=='f'){ echo 'selected'; } ?>>Femenino</option>												
												</select><br>
												<label>Email:</label>
												<input class="form-control" name="email" autocomplete="off" required value="<?php echo $row['email']; ?>"><br>
												 <label>Estado</label>
												<select class="form-control" name="estado" autocomplete="off" required>
													<option value="s" <?php if($row['estado']=='s'){ echo 'selected'; } ?>>Activo</option>
													<option value="n" <?php if($row['estado']=='n'){ echo 'selected'; } ?>>No Activo</option>													
												</select>
											</div>                                 
                                       
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
					 <!--  Modals-->
								 <div class="modal fade" id="cuadro<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
										<input type="hidden" value="<?php echo $row['id']; ?>" name="id">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h3 align="center" class="modal-title" id="myModalLabel">Cuadro Clinico</h3>
													</div>
										<div class="panel-body">
										<div class="row">                                       
											<div class="col-md-6">											
												<label>Nombre:</label>
												<input class="form-control" name="nombre" value="<?php echo $row['nombre']; ?>" disabled autocomplete="off" required autofocus ><br>
												<label>Grupo Sanguineo:</label>
												<select class="form-control" name="sangre" value="<?php echo $row['sangre']; ?>" autocomplete="off" required>
													<option>---SELECCIONE---</option>
													<option value="AME" <?php if ($row['sangre']=="AME") echo 'selected'; ?>>A RH-</option>
													<option value="AMA" <?php if ($row['sangre']=="AMA") echo 'selected';?>>A RH+</option>
													<option value="ABME" <?php if ($row['sangre']=="ABME") echo 'selected'; ?>>AB RH-</option>
													<option value="ABMA" <?php if ($row['sangre']=="ABMA") echo 'selected'; ?>>AB RH+</option>
													<option value="BME" <?php if ($row['sangre']=="BME") echo 'selected'; ?>>B RH-</option>
													<option value="BMA" <?php if ($row['sangre']=="BMA") echo 'selected'; ?>>B RH+</option>
													<option value="OME" <?php if ($row['sangre']=="OME") echo 'selected'; ?>>O RH-</option>
													<option value="OMA" <?php if ($row['sangre']=="OMA") echo 'selected'; ?>>O RH+</option>		
												</select><br>
												<label>VIH:</label>
												<select class="form-control" name="vih" autocomplete="off" required>
													<option>---SELECCIONE---</option>
													<option value="p" <?php if($row['vih']=='p'){ echo 'selected'; } ?>>Positivo</option>
													<option value="n" <?php if($row['vih']=='n'){ echo 'selected'; } ?>>Negativo</option>																									
												</select><br>
												<label>Peso:</label>
												<input class="form-control" name="peso" value="<?php echo $row['peso']; ?>" autocomplete="off" required><br>
												<label>Talla:</label>
												<input class="form-control" name="talla" value="<?php echo $row['talla']; ?>" autocomplete="off" required><br>
												
											</div>
											<div class="col-md-6">											
												<label>Alergico</label>
                                                <textarea class="form-control" name="alergia"  value="<?php echo $row['alergia']; ?>" rows="3"><?php echo $row['alergia']; ?></textarea><br>
												<label>Medicamento que Toma Actualmente</label>
                                                <textarea class="form-control" name="medicamento" value="<?php echo $row['medicamento']; ?>"  rows="3"><?php echo $row['medicamento']; ?></textarea><br>
												<label>Enfermedad que tiene</label>
                                                <textarea class="form-control" name="enfermedad" value="<?php echo $row['enfermedad']; ?>"  rows="3"><?php echo $row['enfermedad']; ?></textarea><br>
											</div>                                 
                                       
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
                                        </tr> 
											<?php } ?>
                                    </tbody>									
                                </table>							
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->                                     
        </div>               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../../assets/js/dataTables/dataTables.bootstrap.js"></script>
	<!-- VALIDACIONES -->
	<script src="../../assets/js/jasny-bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
		
       
</body>
</html>

