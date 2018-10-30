<?php 
	session_start();
	include_once "modulos/php_conexion.php";
	include_once "modulos/class_buscar.php";
	include_once "modulos/funciones.php";
	
	if($_SESSION['cod_user']){
	}else{
		header('Location: php_cerrar.php');
	}
	
	$oUsuario=new Consultar_Usuario($_SESSION['cod_user']);
	$Nombre=$oUsuario->consultar('nom');
	
	$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
	
	if(!empty($_GET['status'])){
			$nit=limpiar($_GET['status']);
			$cans=mysql_query("SELECT * FROM citas_medicas WHERE status='PROCESADO' and id='$nit'");
			if($dat=mysql_fetch_array($cans)){
				$xSQL="Update citas_medicas Set status='PENDIENTE' Where id='$nit'";
				mysql_query($xSQL);
				header('location:principal.php');
			}else{
				$xSQL="Update citas_medicas Set status='PROCESADO' Where id='$nit'";
				mysql_query($xSQL);
				header('location:principal.php');
			}
		}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Conultorio Clinico</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                <a class="navbar-brand" href="modulos/usuarios/perfil.php"><?php echo $_SESSION['user_name']; ?></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;">Consultorio: <?php echo $nombre_Consultorio; ?> :: Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="php_cerrar.php" class="btn btn-danger square-btn-adjust">salir</a> </div>
        </nav>   
           <?php include_once "menu/m_principal.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">               
                 <div class="row">
               
			  <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-group"></i>
                </span>
                <div class="text-box" >
						<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM pacientes WHERE consultorio='$id_consultorio'";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Pacientes</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-shopping-cart"></i>
                </span>
                <div class="text-box" >
					<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM consultas_medicas WHERE consultorio='$id_consultorio'";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Consultas</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-user"></i>
                </span>
                <div class="text-box" >
							<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM persona";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Usuarios</p>
                </div>
             </div>
		     </div>
			 <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box" >
							<?php
							// primero conectamos siempre a la base de datos mysql
							$sql = "SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio' and status='PENDIENTE'";  // sentencia sql
							$result = mysql_query($sql);
							$numero = mysql_num_rows($result); // obtenemos el número de filas
							
							?>
                    <p class="main-text"> <?php echo "$numero" ?></p>
                    <p class="text-rocket"> Citas</p>
                </div>
             </div>
		     </div>
                    
			</div>
                 <!-- /. ROW  -->                                
                <hr />                
                <div class="col-md-6 col-sm-12 col-xs-12">              
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Ultimos Pacientes Registrados
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NOMBRE</th>
                                            <th>TELEFONO</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
											if(!empty($_POST['buscar'])){
												$buscar=limpiar($_POST['buscar']);
												$pame=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and nombre LIKE '%$buscar%' ORDER BY id");	
											}else{
												$pame=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' ORDER BY id DESC LIMIT 5");		
											}		
											while($row=mysql_fetch_array($pame)){
											$url=$row['id'];
										?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td>
											<i class="fa fa-user fa-2x"></i>
											<a href="modulos/perfil_paciente/index.php?id=<?php echo $url; ?>" title="Valorar Alumno">
												<?php echo $row['nombre']; ?>
											</a>
                                            <td><?php echo $row['telefono']; ?></td>                                            
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                   
                </div>
				<div class="col-md-6 col-sm-12 col-xs-12">              
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Citas para Hoy
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr> 
											<th>#</th>                                          
                                            <th>PACIENTE</th>                                                                                    
                                            <th>STATUS</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
											if(!empty($_POST['buscar'])){
												$buscar=limpiar($_POST['buscar']);
												$pame=mysql_query("SELECT * FROM citas_medicas WHERE consultorio='$id_consultorio' and nombre LIKE '%$buscar%' ORDER BY id");	
											}else{
												$pame=mysql_query("SELECT * FROM citas_medicas WHERE date_format(fechai,'%Y%m%d')=date_format(curdate(),'%Y%m%d') AND consultorio='$id_consultorio' and status='PENDIENTE' ORDER BY id ASC");		
											}		
											while($row=mysql_fetch_array($pame)){
											$url=$row['id'];
											if($row['status']=='PENDIENTE'){
													$status='PENDIENTE';
												}																								
												elseif($row['status']=='PROCESADO'){
													$status='PROCESADO';
												}
												$oPaciente=new Consultar_Paciente($row['id_paciente']);
												$url=$row['id'];
										?>
                                        <tr>                                           
                                            <td><?php echo $row['id']; ?></td>                                                                                     
                                            <td><?php echo $oPaciente->consultar('nombre'); ?></td>                                                                                     
                                            <td>
											<a href="principal.php?statusX=<?php echo $row['id']; ?>" role="button" class="btn btn-danger" data-toggle="modal" title="Procesar Operación">
											<strong><?php echo $status; ?></strong>
                                            </a>  
											</td>                                            
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                   
                </div>
                </div>
                 <!-- /. ROW  -->                                
         
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
