<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	if($_SESSION['tipo_user']=='a'){
	}else{
		header('Location: ../../php_cerrar.php');
	}
	$id_medico=$_SESSION['cod_user'];
	$usu=$_SESSION['cod_user'];
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	
	$fecha=date('Y-m-d');
	$hora=date('H:m:s');
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM citas_medicas WHERE id='$id'");
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
font-size: 16px;"> Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_caja.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
				<div class="alert alert-info" align="center">
                    <h3>CAJA<h3>
                    </div> 
                 <!-- /. ROW  --> 
			<hr />
				 <a href="operaciones.php" class="btn btn-success btn-lg btn-block" title="Listado">
					<i class="fa fa-plus" ></i><strong> Ver Operaciones</strong>
				</a><br>
					 
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             PACIENTES PENDIENTES DE PAGO
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
								
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">                                    
									<thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PACIENTE</th>                                                                                                                              
                                            <th>FECHA CONSULTA</th>                                                                                      
                                            <th>MEDICO</th>                                                                                                                                                                                                             
                                            <th>PAGO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
											if(!empty($_POST['buscar'])){
												$buscar=limpiar($_POST['buscar']);
												$pame=mysql_query("SELECT * FROM citas_medicas WHERE id_paciente LIKE '%$buscar%' ORDER BY id");	
											}else{
												$pame=mysql_query("SELECT * FROM citas_medicas WHERE status='PENDIENTE' ORDER BY id DESC LIMIT 10");		 
											}		
											while($row=mysql_fetch_array($pame)){
											$oPaciente=new Consultar_Paciente($row['id_paciente']);
							                #$oMedico=new Consultar_Medico($row['id_medico']);
											$url=$row['id'];
										?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><i class="fa fa-user fa-2x"></i> <?php echo $oPaciente->consultar('nombre'); ?></td>                                                                                   
                                            <td><?php echo fecha($row['fechai']).' '.$row['hora']; ?></td>
											<td><?php echo consultar('nom','persona',' doc='.$row['id_medico']); ?></td>                                             
											<td>
											<a  href="#" data-toggle="modal" data-target="#contado<?php echo $row['id']; ?>" role="button" class="btn btn-danger" data-toggle="modal" title="Cambiar Status">
												<?php echo $row['status']; ?>
											</a>
																							
											</td>											
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
			<!--  Modals-->
								 <div class="modal fade" id="contado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="contado" action="pro_contado.php" method="get">
								<div class="modal-dialog">
									<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
														<h3 align="center" class="modal-title" id="myModalLabel">Seguridad</h3>
													</div>
										<div class="panel-body">
										<div class="row" align="center">                                       
																					
											<strong>Hola! <?php echo $cajero_nombre; ?></strong><br>
											 <div class="alert alert-danger">
												<h4>¿Esta Seguro de Procesar esta operación?<br> 
												una vez completada no podra ser editada.</h4>
											</div>											
											<input type="hidden" value="<?php echo $neto; ?>" name="valor_recibido">
											<input type="hidden" value="<?php echo $neto; ?>" name="neto">	
																					                                                                    
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Procesar</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->       	
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
