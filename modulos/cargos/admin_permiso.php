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
	
	if(!empty($_GET['id'])){
		$id_url=limpiar($_GET['id']);
		
		$sql=mysql_query("SELECT * FROM tipo_usuario WHERE id='$id_url'");
		if($row=mysql_fetch_array($sql)){
			$id=$row['id'];
			$nombre=$row['nombre'];
		}
	}
	
	$b=0;
	$sq=mysql_query("SELECT * FROM tipo_permisos WHERE tipo='$id'");
	if($ro=mysql_fetch_array($sq)){	
		$b++;
	}
	
	if($b==0){
		$sql=mysql_query("SELECT * FROM permisos_tmp");
		while($row=mysql_fetch_array($sql)){
			$id_permiso=$row[0];
			mysql_query("INSERT INTO tipo_permisos (permiso,tipo,estado) VALUES ('$id_permiso','$id','n')");
		}
	}
	
	if(!empty($_GET['id']) and !empty($_GET['es'])){
		$id_es=limpiar($_GET['es']);
		
		$sql=mysql_query("SELECT * FROM tipo_permisos WHERE id='".$id_es."'");
		while($row=mysql_fetch_array($sql)){
			$id=$row['id'];		
			if($row['estado']=='s'){
				mysql_query("UPDATE tipo_permisos SET estado='n' WHERE id='$id'");		
			}elseif($row['estado']=='n'){
				mysql_query("UPDATE tipo_permisos SET estado='s' WHERE id='$id'");		
			}
		}
		header('Location: admin_permiso.php?id='.$id_url);
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
           <?php include_once "../../menu/m_departamento.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
				<div class="alert alert-info" align="center">
                    <h3>ADMINISTRACION DE PERMISOS: <?php echo $nombre; ?><h3>
                </div> 
                 <!-- /. ROW  -->
                 <hr />
 
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
										
                                            <h3 align="center" class="modal-title" id="myModalLabel">Nuevo Departamento</h3>
                                        </div>
										<div class="panel-body">
										<div class="row">
											<div class="col-md-3">																							
												 
											</div>  
											<div class="col-md-6">											
												<label>Nombre:</label>
												<input class="form-control" name="nombre" autocomplete="off" required><br>											
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
								
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">                                   
									<thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                                                                                                                 
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd gradeX">
										<?php 
											$sql=mysql_query("SELECT * FROM tipo_permisos WHERE tipo='$id'");
											while($row=mysql_fetch_array($sql)){
												
												$url2=$row[0];
										?>
                                            <td><?php echo consultar('nombre','permisos_tmp'," id='".$row['permiso']."'"); ?></td>
                                                                                                                               
                                            <td class="center">
											<center>
												<a href="admin_permiso.php?id=<?php echo $id_url.'&es='.$url2; ?>" title="Cambiar Estado">
													<?php echo estado($row['estado']); ?>
												</a>
											</center>
											</td>
                                        </tr> 
										
										<!--  Modals-->
										 <div class="modal fade" id="actualizar<?php echo $row[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">Actualizar Departamento</h3>
															</div>
															<div class="panel-body">
															<div class="row">
																<div class="col-md-3">																							
																												
																</div>    
																<div class="col-md-6">											
																	<label>Nombre:</label>
																	<input type="hidden" name="id" value="<?php echo $row[0]; ?>">
																	<input class="form-control" name="nombre" autocomplete="off" required value="<?php echo $row[1]; ?>"><br>											
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
