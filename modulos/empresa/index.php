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
                  <div class="panel-body" align="right">                                                                                 
                            <a  href="#myModal" class="btn btn-primary" data-toggle="modal" title="Actualizar">
							<i class="fa fa-refresh" ></i>
							</a>                            				
                  </div>				  					 
            <div class="row">			
                <div class="col-md-12">
				<?php if(permiso($_SESSION['cod_user'],'1')==FALSE){ ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Datos de La Empresa
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
						<?php 	
			
								if(!empty($_POST['empresa']) and !empty($_POST['nit'])){
									$empresa=limpiar($_POST['empresa']);		
									$nit=limpiar($_POST['nit']);
									$pais=limpiar($_POST['pais']);				
									$tel=limpiar($_POST['tel']);
									$ciudad=limpiar($_POST['ciudad']);			
									$fax=limpiar($_POST['fax']);
									$direccion=limpiar($_POST['direccion']);	
									$web=limpiar($_POST['web']);
									$correo=limpiar($_POST['correo']);			
									$fecha=date('Y-m-d');
									$moneda=limpiar($_POST['moneda']);
									mysql_query("UPDATE empresa SET empresa='$empresa',
																	pais='$pais',
																	ciudad='$ciudad',
																	direccion='$direccion',
																	correo='$correo',
																	moneda='$moneda',
																	nit='$nit',
																	tel='$tel',
																	fax='$fax',
																	web='$web',
																	fecha='$fecha'													
																WHERE id=1");
									
									//subir la imagen del articulo
									$nameimagen = $_FILES['imagen']['name'];
									$tmpimagen = $_FILES['imagen']['tmp_name'];
									$extimagen = pathinfo($nameimagen);
									$ext = array("png","jpg");
									$urlnueva = "../../img/logo.jpg";			
									if(is_uploaded_file($tmpimagen)){
										if(array_search($extimagen['extension'],$ext)){
											copy($tmpimagen,$urlnueva);	
										}else{
											echo mensajes("ERROR AL SUBIR EL LOGO, jpg o png","rojo");		
										}
									}else{
										echo mensajes("ERROR AL SUBIR EL LOGO, jpg o png","rojo");	
									}
									
									echo mensajes('Dato de la Empresa Actualizado con Exito, Ctrl+F5 para Actualizar la imagen','verde');	
								}
								
								
								$pa=mysql_query("SELECT * FROM empresa WHERE id=1");									
								$row=mysql_fetch_array($pa);
							?>
					<form name="form2" method="post" enctype="multipart/form-data" action="">
				    <div class="row">                                       
					<div class="col-md-6">											
						<i class="icon-chevron-right"></i> <strong>Nombre: </strong><?php echo $row['empresa']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Pais: </strong><?php echo $row['pais']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Ciudad: </strong><?php echo $row['ciudad']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Direccion: </strong><?php echo $row['direccion']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Correo: </strong><?php echo $row['correo']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Moneda: </strong><?php echo $row['moneda']; ?>																										
					</div>
					<div class="col-md-6">
						<i class="fa fa-chevron-right"></i> <strong>Nit: </strong><?php echo $row['nit']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Telefono: </strong><?php echo $row['tel']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>FAX: </strong><?php echo $row['fax']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Pagina Web: </strong><?php echo $row['web']; ?><br><br>
                            <i class="fa fa-chevron-right"></i> <strong>Ultima Actualizacion: </strong><?php echo fecha($row['fecha']); ?><br><br>
																	
					</div>                                                                        
					</div>
				    </form>
					<!--  Modals-->
										 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form2" method="post" enctype="multipart/form-data" action="">											
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>															
																<h3 align="center" class="modal-title" id="myModalLabel">Actualizar Informacion Empresa</h3>
															</div>
															<div class="panel-body">
															<div class="row">                                       
																<div class="col-md-6">																												
																	<strong>Nombre Empresa</strong><br>
																	<input class="form-control" name="empresa" autocomplete="off" required value="<?php echo $row['empresa']; ?>"><br>
																	<strong>Pais</strong><br>
																	<input class="form-control" name="pais" autocomplete="off" required value="<?php echo $row['pais']; ?>"><br>
																	<strong>Ciudad</strong><br>
																	<input class="form-control" name="ciudad" autocomplete="off" required value="<?php echo $row['ciudad']; ?>"><br>
																	<strong>Direccion</strong><br>
																	<input class="form-control" name="direccion" autocomplete="off" required value="<?php echo $row['direccion']; ?>"><br>
																	<strong>Correo</strong><br>
																	<input class="form-control" type="email" name="correo" autocomplete="off" required value="<?php echo $row['correo']; ?>"><br>
																	<strong>Subir Logo</strong><br>
																	<input type="file" name="imagen" id="imagen">															
																</div>
																<div class="col-md-6">
																	<strong>Nit</strong><br>
																	<input class="form-control" name="nit" data-mask="999999-9999-999" autocomplete="off" required value="<?php echo $row['nit']; ?>"><br>
																	<strong>Telefonos</strong><br>
																	<input class="form-control" name="tel" data-mask="9999-9999" autocomplete="off" required value="<?php echo $row['tel']; ?>"><br>
																	<strong>Fax</strong><br>
																	<input class="form-control" name="fax" data-mask="9999-9999" autocomplete="off" required value="<?php echo $row['fax']; ?>"><br>
																	<strong>Pagina WEB</strong><br>
																	<input class="form-control" name="web" autocomplete="off" required value="<?php echo $row['web']; ?>"><br>
																	 <strong>Moneda</strong><br>
																	<input class="form-control" name="moneda" autocomplete="off" required value="<?php echo $row['moneda']; ?>"><br>
																	
																	
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
                            </div>                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
				<?php }else{ echo mensajes("NO TIENE PERMISO PARA VISUALIZAR  ESTA INFORMACION","rojo"); }?>
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
