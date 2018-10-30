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
		mysql_query("DELETE FROM departamentos WHERE id='$id'");
		header('index.php');
	}
	$cargo='';
	
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
           <?php include_once "../../menu/m_departamento.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
				<div class="alert alert-info" align="center">
                    <h3>USUARIOS<h3>
                </div> 
                 <!-- /. ROW  -->
                 <hr />
				 <?php if(permiso($_SESSION['cod_user'],'1')==FALSE){ ?>
 
                 <div class="panel-body" align="right">                                                                                 
                            <button type="button" class="btn btn-success btn-circle" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus fa-2x"></i>
                            </button>
                            <button type="button" class="btn btn-info btn-circle"><i class="fa fa-question fa-2x"></i>
                            </button>                                                                                 
                  </div>
				  
					 
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
							#echo cadenas().encrypt('121212','URLCODIGO');
							if(!empty($_POST['doc']) and !empty($_POST['nom'])){
									$doc=limpiar($_POST['doc']);		
									$nom=limpiar($_POST['nom']);
									$tel=limpiar($_POST['tel']);
									$dir=limpiar($_POST['dir']);
									$sexo=limpiar($_POST['sexo']);									
									$tipo=limpiar($_POST['tipo']);
									$consultorio=limpiar($_POST['consultorio']);
									$correo=limpiar($_POST['correo']);									
									$estado=limpiar($_POST['estado']);									
									$fechar=date('Y-m-d');																																	
									$con=$doc;							
									$url=cadenas().encrypt($doc,'URLCODIGO');
									#$cargo=limpiar($_POST['cargo']);
									/*if($cargo=='admin'){
										$tipo='Admin';
										$ncargo='Administrador';
									}else{
										$tipo=$cargo;
										$ncargo=consultar('nombre','tipo_usuario'," id='".$tipo."'");
									}*/
														
									$oConsultar=new Consultar_Usuario($doc);
									$oUsuario=new Proceso_Usuario($doc,$nom,$tel,$dir,$sexo,$tipo,$consultorio,$correo,$estado,$fechar,$con);
																
									if(!empty($_GET['doc'])){
										$oUsuario->actualizar();
										
										//subir la imagen del articulo
										$nameimagen = $_FILES['imagen']['name'];
										$tmpimagen = $_FILES['imagen']['tmp_name'];
										$extimagen = pathinfo($nameimagen);
										$ext = array("png","jpg");
										$urlnueva = "../../img/usuario/".$doc.".jpg";			
										if(is_uploaded_file($tmpimagen)){
											if(array_search($extimagen['extension'],$ext)){
												copy($tmpimagen,$urlnueva);	
											}else{
												echo mensajes("Error al Cargar la Imagen","rojo");	
											}
										}else{
											echo mensajes("Error al Cargar la Imagen","rojo");	
										}
										echo mensajes('El Usuario "'.$nom.' '.'" Ha sido Actualizado/a con Exito<br>
										Tipo de Usuario "'.usuario($tipo).'"','verde');
									}else{
										if($oConsultar->consultar('nom')==NULL){
											$oUsuario->crear();
											echo mensajes('El Usuario "'.$nom.' '.'" Ha sido Registrado/a con Exito<br> Como "'.usuario($tipo).'"','verde');
											
											//subir la imagen del articulo
											$nameimagen = $_FILES['imagen']['name'];
											$tmpimagen = $_FILES['imagen']['tmp_name'];
											$extimagen = pathinfo($nameimagen);
											$ext = array("png","jpg");
											$urlnueva = "../../img/usuario/".$doc.".jpg";			
											if(is_uploaded_file($tmpimagen)){
												if(array_search($extimagen['extension'],$ext)){
													copy($tmpimagen,$urlnueva);	
												}else{
													echo mensajes("Error al Cargar la Imagen","rojo");	
												}
											}else{
												echo mensajes("Error al Cargar la Imagen","rojo");	
											}
											
										}else{
											echo mensajes('El Usuario "'.$nom.'" Ya se Encuentra Registrado con el Documento "'.$doc.'"','rojo');
										}
									}
							}
						?>
						
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    
									<thead>
                                        <tr>
                                            <th>DOCUMENTO</th>
                                            <th>NOMBRE</th>
                                            <th>ESTADO</th>                                                                                      
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											if(!empty($_POST['buscar'])){
												$buscar=limpiar($_POST['buscar']);
												$pame=mysql_query("SELECT * FROM persona, username WHERE 
																	username.usu=persona.doc and (persona.doc='$buscar' or persona.nom LIKE '%$buscar%'  or persona.ape LIKE '%$buscar%')");	
											}
											else{
												$pame=mysql_query("SELECT * FROM persona  ORDER BY nom");		
											}		
											while($row=mysql_fetch_array($pame)){
												$url=cadenas().encrypt($row['doc'],'URLCODIGO');
												
										  ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['doc']; ?></td>
                                            <td><?php echo $row['nom']; ?></td>
                                            <td><?php echo estado($row['estado']); ?></td>                                                                                   
                                            <td class="center">
											<div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu">
												<li><a href="agregar.php?doc=<?php echo $url; ?>"><i class="fa fa-edit"></i> Editar</a></li>												
												<li class="divider"></li>
												<li><a href="index.php?del=<?php echo $row['id']; ?>" ><i class="fa fa-pencil"></i> Eliminar</a></li>																																				
											  </ul>
											</div>											
											</td>
                                        </tr> 
										
										
										<!--  Modals-->
										 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form2" method="post" enctype="multipart/form-data" action="">											
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>															
																<h3 align="center" class="modal-title" id="myModalLabel">Nuevo Usuario</h3>
															</div>
															<div class="panel-body">
															<div class="row">                                       
																<div class="col-md-6">											
																	<label>Documento:</label>
																	<input class="form-control" name="doc" data-mask="999999999" autocomplete="off" required><br>
																	<label>Nombre:</label>
																	<input class="form-control" name="nom" autocomplete="off" required><br>	
																	<label>Telefono:</label>
																	<input class="form-control" name="tel" data-mask="9999-9999" autocomplete="off" required><br>
																	<label>Dirección:</label>
																	<input class="form-control" name="dir" autocomplete="off" required><br><br><br>
																	<strong>Fotografia</strong><br>
																	<input type="file" name="imagen" id="imagen">																	
																</div>
																<div class="col-md-6">
																	<label>Sexo</label>
																	<select class="form-control" name="sexo" autocomplete="off" required>
																		<option value="m">Masculino</option>
																		<option value="f">Femenino</option>													
																	</select><br>
																	<label>Tipo de Usuario</label>
																	<!--<select name="tipo" class="form-control">
																		<option value="admin" <?php if($cargo=='admin'){ echo 'selected'; } ?>>Administrador Principal</option>
																		<?php 
																			$sql=mysql_query("SELECT id,nombre FROM tipo_usuario ORDER BY nombre");
																			while($row=mysql_fetch_array($sql)){
																				if($row[0]==$cargo){
																					echo '<option value="'.$row[0].'" selected>'.$row[1].'</option>';
																				}else{
																					echo '<option value="'.$row[0].'">'.$row[1].'</option>';
																				}
																			}
																		?>
																	</select><br>-->
																	<select class="form-control" name="tipo" autocomplete="off" required>
																		<option value="Admin">Medico</option>
																		<option value="1">Asistente</option>													
																	</select><br>
																	<label>Consultorio;</label>
																	<select class="form-control" name="consultorio" autocomplete="off" required>
																		<?php
																			$sal=mysql_query("SELECT * FROM consultorios WHERE estado='s'");				
																			while($col=mysql_fetch_array($sal)){
																				echo '<option value="'.$col['id'].'">'.$col['nombre'].'</option>';
																			}
																		?>													
																	</select><br>
																	<label>Email:</label>
																	<input class="form-control" name="correo" autocomplete="off" required><br>
																	<label>Estado</label>
																	<select class="form-control" name="estado" autocomplete="off" required>
																		<option value="s">ACTIVO</option>
																		<option value="n">NO ACTIVO</option>													
																	</select><br><br>
																	
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																	<button type="submit" class="btn btn-primary">Guardar</button>
																	
																</div>                                                                        
															</div> 
															</div> 
															<div class="modal-footer">
																
															</div>										 
														</div>
													</div>
													</form>
												</div>
										 <!-- End Modals-->
										 <!--  Modals-->
										 <div class="modal fade" id="actualizar<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>															
																<h3 align="center" class="modal-title" id="myModalLabel">Actualizar Usuario</h3>
															</div>
															<div class="panel-body">
															<div class="row">                                       
																<div class="col-md-6">																												
																	<label>Documento:</label>
																	<input class="form-control" name="doc" value="<?php echo $row['doc']; ?>" data-mask="99999999-9" autocomplete="off" required><br>
																	<label>Nombre:</label>
																	<input class="form-control" name="nom" value="<?php echo $row['nom']; ?>" autocomplete="off" required><br>	
																	<label>Telefono:</label>
																	<input class="form-control" name="tel" value="<?php echo $row['tel']; ?>" data-mask="9999-9999" autocomplete="off" required><br>
																	<label>Dirección:</label>
																	<input class="form-control" name="dir" value="<?php echo $row['dir']; ?>" autocomplete="off" required><br><br><br>
																	<strong>Fotografia</strong><br>
																	<input type="file" name="imagen" id="imagen">
																</div>
																<div class="col-md-6">
																	<label>Sexo</label>
																	<select class="form-control" name="sexo" autocomplete="off" required>																		
																		<option value="m" <?php if($row['sexo']=='m'){ echo 'selected'; } ?>>MASCULINO</option>
																		<option value="f" <?php if($row['sexo']=='f'){ echo 'selected'; } ?>>FEMENINO</option>
																	</select><br>
																	<label>Tipo de Usuario</label>
																	<select class="form-control" name="tipo" autocomplete="off" required>																		
																		<option value="a">ADMINISTRADOR</option>
																		<option value="c">ASISTENTE</option>
																	</select><br>
																	<label>Consultorio;</label>
																	<select class="form-control" name="consultorio" autocomplete="off" required>
																		<?php
																			$pa=mysql_query("SELECT * FROM consultorios");				
																			while($row=mysql_fetch_array($pa)){
																				if($row['id']){
																					echo '<option value="'.$row['id'].'" selected>'.$row['nombre'].'</option>';	
																				}else{
																					echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';	
																				}
																			}
																		?>												
																	</select><br>
																	<label>Email:</label>
																	<input class="form-control" name="correo" value="<?php echo $row['correo']; ?>" autocomplete="off" required><br>
																	 <label>Estado</label>
																	 <select class="form-control" name="estado">
																			<option value="s" <?php if($row['estado']=='s'){ echo 'selected'; } ?>>ACTIVO</option>
																			<option value="n" <?php if($row['estado']=='n'){ echo 'selected'; } ?>>NO ACTIVO</option>
																	</select><br><br>
																	<div align="right">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																    <button type="submit" class="btn btn-primary">Guardar</button>
																</div>                                                                        
																</div>                                                                        
															</div> 
															</div> 
															<div class="modal-footer">
																
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
			<?php }else{ echo mensajes("NO TIENES PERMISO PARA ENTRAR A ESTE FORMULARIO","rojo"); }?>
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
