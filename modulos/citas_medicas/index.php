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
	$id_medico=$_SESSION['cod_user'];
	$usu=$_SESSION['cod_user'];
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	
	$fecha=date('Y-m-d');
	$hora=date('H:m:s');
	
	$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM consultas_medicas WHERE id='$id'");
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
           <?php include_once "../../menu/m_citas_medica.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
				<div class="alert alert-info" align="center">
                    <h3>CITAS MEDICAS<h3>
                    </div> 
                 <!-- /. ROW  -->                
                 <div class="panel-body" align="right">                                                                                 
                            <button type="button" class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus fa-2x"></i>
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
										
                                            <h3 align="center" class="modal-title" id="myModalLabel">Nueva Cita Medica</h3>
                                        </div>
										<div class="panel-body">
										<div class="row">                                       
											<div class="col-md-6">											
												<label>Paciente:</label>
												<select class="form-control" name="id_paciente">
                                                	<?php
														$sal=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and estado='s'");				
														while($col=mysql_fetch_array($sal)){
															echo '<option value="'.$col['id'].'">'.$col['nombre'].'</option>';
														}
													?>
                                                </select><br>
												<label>Horario:</label>
												<select class="form-control" name="horario">
                                                	<option value="m">Mañana</option>
													<option value="t">Tarde</option>
                                                </select><br>	
											</div>
											<div class="col-md-6">
												<label>Fecha Proxima Cita:</label>
												<input type="date" class="form-control" name="fechai" min="1" value="<?php echo $fecha ?>" autocomplete="off" required><br>																			
												<label>Observaciones:</label>
												<textarea class="form-control" name="observaciones" rows="3"></textarea><br>
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
                            CONTROL DE CITAS MEDICAS
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
								<?php 
									if(!empty($_POST['id_paciente'])){ 												
										$id_paciente=limpiar($_POST['id_paciente']);																											
										$fechai=limpiar($_POST['fechai']);																																																						
										$horario=limpiar($_POST['horario']);																																																						
										$observaciones=limpiar($_POST['observaciones']);
										$fecha=date('Y-m-d');
										$hora=date('H:m:s');
										$status='PENDIENTE';
										
																						
										if(empty($_POST['id'])){
											$oConsulta=new Proceso_Cita('',$id_paciente,$id_medico,$id_consultorio,$fechai,$observaciones,$fecha,$hora,$horario,$status);
											$oConsulta->crear();
											echo mensajes('Cita Medica Guardada con Exito','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oConsulta=new Proceso_Cita($id,$fechai,$observaciones,$horario);
											$oConsulta->actualizar();
											echo mensajes('Cita Medica Actualizada con Exito','verde');
										}
									}
								?>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    
									<thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PACIENTE</th>                                                                                                                              
                                            <th>FECHA DE PROXIMA CITA</th>                                                                                      
                                            <th>MEDICO</th>                                                                                      
                                            <th>STATUS</th>                                                                                      
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
											if(!empty($_POST['buscar'])){
												$buscar=limpiar($_POST['buscar']);
												$pame=mysql_query("SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio'");	
											}else{
												$pame=mysql_query("SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio'");		 
											}		
											while($row=mysql_fetch_array($pame)){
											$oPaciente=new Consultar_Paciente($row['id_paciente']);
							                #$oMedico=new Consultar_Medico($row['id_medico']);
											$url=$row['id'];
											
											############# STATUS FULL ######################
											if($row['status']=='PENDIENTE'){
												
												 $status='<a href="#" role="button" class="btn btn-warning" data-toggle="modal" title="Cambiar Status">
																	<strong>PENDIENTE</strong>
															</a> ';
											}else{
												$status='<a href="#" role="button" class="btn btn-success" data-toggle="modal" title="Cambiar Status">
																	<strong>PROCESADO</strong>
															</a> ';
												
											}
											$pamela=strftime( "%Y-%m-%d-%H-%M-%S", time() );										
											if($row['fechai']==$pamela){
													$status='si';
												}																								
												elseif($row['fechai']>$pamela){
													$status='<a href="#" role="button" class="btn btn-danger" data-toggle="modal" title="Cambiar Status">
																<strong>PENDIENTE</strong>
														</a> ';
												}
												$horario=$row['horario'];
										?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><i class="fa fa-user fa-2x"></i> <?php echo $oPaciente->consultar('nombre'); ?></td>                                                                                   
                                            <td><?php echo fecha($row['fechai']); ?></td>
											<td><?php echo consultar('nom','persona',' doc='.$row['id_medico']); ?></td>  
											<td><?php echo $status; ?></td>  
                                            <td class="center">
											<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu">
												<li><a href="#" data-toggle="modal" data-target="#actualizar<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Editar</a></li>
												<!--<li class="divider"></li>
												<li><a href="index.php?del=<?php echo $row['id']; ?>" ><i class="fa fa-pencil"></i> Eliminar</a></li>-->																																				
											  </ul>
											</div>
											<a href="../imprimir/index.php?id=<?php echo $url; ?>" class="btn btn-primary" title="Imprimir">
											<i class="fa fa-print" ></i>
										    </a>
											</td>
								
                                        </tr> 
										
										<!--  Modals-->
										 <div class="modal fade" id="actualizar<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">Modificar Cita Medica</h3>
															</div>
															<div class="panel-body">
															<div class="row">                                       
																<div class="col-md-6">
																	<label>Paciente:</label>
																		<select class="form-control" name="id_paciente" disabled >
																			<option value="x">---SELECCIONE---</option>
																			<?php
																				$p=mysql_query("SELECT * FROM pacientes WHERE estado='s'");				
																				while($r=mysql_fetch_array($p)){
																					if($r['id']==$row['id_paciente']){
																						echo '<option value="'.$r['id'].'" selected>'.$r['nombre'].'</option>';
																					}else{
																						echo '<option value="'.$r['id'].'">'.$r['nombre'].'</option>';
																					}
																				}
																			?>
																		</select><br>
																		<label>Horario:</label>
																		<select class="form-control" name="horario">
																			<option value="m" <?php if($horario=='m'){ echo 'selected'; } ?>>Mañana</option>
																			<option value="m" <?php if($horario=='t'){ echo 'selected'; } ?>>Tarde</option>
																		</select><br>	
																																				
																		</div>
																<div class="col-md-6">
																		<label>Fecha:</label>
																		<input type="date" class="form-control" name="fecha" min="1" value="<?php echo $row['fechai'] ?>" autocomplete="off" required><br>																		
																		<label>Observaciones:</label>
																		<textarea class="form-control" name="observaciones" value="<?php echo $row['observaciones']; ?>" rows="3"><?php echo $row['observaciones']; ?></textarea><br>											
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
