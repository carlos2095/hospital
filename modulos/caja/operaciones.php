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
				 <?php 
				if(!empty($_GET['fechai']) and !empty($_GET['fechaf'])){
					$fechai=limpiar($_GET['fechai']);
					$fechaf=limpiar($_GET['fechaf']);
				}else{
					$fechai=date('Y-m-d');	
					$fechaf=date('Y-m-d');	
				}
				$usu='';	$trans='';		$where='';
				$act_trans='active';$act_usu='';
				if(!empty($_GET['trans'])){
					$trans=limpiar($_GET['trans']);
					$act_trans='active';
					$act_usu='';
					if($trans<>'TODOS'){
						$where="WHERE tipo='".$trans."' and fecha between '$fechai' AND '$fechaf'";
					}else{
						$where='';	
					}
				}elseif(!empty($_GET['usu'])){
					$usu=limpiar($_GET['usu']);
					$act_usu='active';
					$act_trans='';	
					$where="WHERE usu='".$usu."' and fecha between '$fechai' AND '$fechaf'";
				}
							$venta_total=0;$entrada=0;$cxp=0;$cxc=0;
							$sqlx=mysql_query("SELECT * FROM resumen WHERE consultorio='$id_consultorio' and fecha between '$fechai' AND '$fechaf' and estado='s'");
							while($row=mysql_fetch_array($sqlx)){
								if($row['tipo']=='COMPRA'){
									$entrada=$entrada+$row['valor'];
								}
								elseif($row['tipo']=='CONSULTA'){
									$venta_total=$venta_total+$row['valor'];
									
								}
								elseif($row['tipo']=='CXP'){
									
								}
							}
			?>
				<div class="col-md-12 col-sm-6">
                    <div class="panel panel-default">                      
                        <div class="panel-body">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#transaccion" data-toggle="tab">Consultar por Tipo de Transaccion</a>
                                </li>
								 <li class=""><a href="#usuario" data-toggle="tab">Consultar por Usuario</a>
                                </li>  
                            </ul>

                            <div class="tab-content">
                               <div class="tab-pane fade active in" id="transaccion">
								<form name="form1" action="" method="get" class="form-inline">
                           <div class="panel-body">
						   <div class="row"> 
                                <div class="col-md-4">
                                    <strong>Fecha Inicial</strong><br>
                                    <input class="form-control" value="<?php echo $fechai; ?>" name="fechai" type="date" autocomplete="off" required>
                                </div>
                                <div class="col-md-4">
                                    <strong>Fecha Finalizacion</strong><br>
                                    <input class="form-control" value="<?php echo $fechaf; ?>" name="fechaf" type="date" autocomplete="off" required>
                                </div>
                                <div class="col-md-4">
                                	<strong>Tipo de Transaccion</strong><br>
                                    <select class="form-control" name="trans">
                                    	<option value="TODOS" <?php if($trans=='TODOS'){ echo 'selected'; } ?>>TODOS</option>                                       
                                        <!--<option value="CONSULTA" <?php if($trans=='CONSULTA'){ echo 'selected'; } ?>>CONSULTA</option> -->                                      
                                    </select>
                                    <button type="submit" class="btn btn-primary"><i class="icon-search"></i> <strong>Consultar</strong></button>
                                </div>
                            </div>
                           </div>
			            </form>
								                                 
								</div>
                                <!--<div class="tab-pane fade fade" id="usuario">
                                <form name="form2" action="" method="get" class="form-inline">
							<div class="panel-body">
							<div class="row"> 
                                <div class="col-md-4">	
                                    <strong>Fecha Inicial</strong><br>
                                    <input class="form-control" value="<?php echo $fechai; ?>" name="fechai" type="date" autocomplete="off" required>
                                </div>
                                <div class="col-md-4">	
                                    <strong>Fecha Finalizacion</strong><br>
                                    <input class="form-control" value="<?php echo $fechaf; ?>" name="fechaf" type="date" autocomplete="off" required>
                                </div>
                                <div class="col-md-4">	
                                	<strong>Usuario</strong><br>
                                    <select class="form-control" name="usu">
                                    	<?php 
											$sql=mysql_query("SELECT * FROM persona ORDER BY nom");
											while($row=mysql_fetch_array($sql)){
												if($row['doc']==$usu){
													echo '<option value="'.$row['doc'].'" selected>'.$row['nom'].'</option>';
												}else{
													echo '<option value="'.$row['doc'].'">'.$row['nom'].'</option>';
												}
											}
										?>
                                    </select>
                                    <button type="submit"  class="btn btn-primary"><i class="icon-search"></i> <strong>Consultar</strong></button>
                                </div>
                            </div>
                            </div>
                        </form>
                                                               								 
                                </div> -->        
                                                        
                            </div>
                        </div>
                    </div>
                </div><br>								
					<center>
					<a href="#venta" class="btn btn-danger" title="Listado" data-toggle="modal">
					<i class="fa fa-shopping-cart" ></i><strong> Ver Caja</strong>
				</a></center><br> 
				
				<!-- Modal -->           			
			 <div class="modal fade" id="venta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
											
												<h4><pre><h1 class="text-success" align="center"><?php echo $s.' '.formato($venta_total); ?></h1></pre>	</h4>
																					
											
																					                                                                    
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
			
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             OPERACIONES
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
								
                              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    
									<thead>
                                        <tr>
                                            <th>DOCUMENTO</th>
                                            <th>PACIENTE</th>                                                                                      
                                            <th>TIPO</th>                                                                                     
                                            <th>FECHA REGISTRO</th>
                                            <th>VALOR</th>
                                            <th>STATUS</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										  <?php 
											$sql=mysql_query("SELECT * FROM resumen WHERE consultorio='$id_consultorio'".$where);
											while($row=mysql_fetch_array($sql)){
											
												if($row['tipo']=='COMPRA'){
													$tipo='<span class="label label-success">COMPRA</span>';
												}
												elseif($row['tipo']=='CONSULTA'){
													$tipo='<span class="label label-info">CONSULTA</span>';
												}
												
			
												#################################################################
												if($row['status']=='PENDIENTE'){
													$status='<span class="label label-danger">PENDIENTE</span>';
												}																								
												elseif($row['status']=='PROCESADO'){
													$status='<span class="label label-success">PROCESADO</span>';
												}
												
												$url=$row['factura'];
												
												############# CONSULTAS ######################
												$oPaciente=new Consultar_Paciente($row['paciente']);
												
												
										?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['factura']; ?></td>
                                            <td><?php echo $oPaciente->consultar('nombre'); ?></td>
                                            <td><?php echo $tipo; ?></td>
                                            <td><?php echo fecha($row['fecha']).' '.$row['hora']; ?></td>
                                            <td><?php echo $s.' '.formato($row['valor']); ?></td>
                                            <!--<td><?php echo $status; ?></td>-->
                                            <td><center>
												<a href="index.php?estado=<?php echo $row['id']; ?>" title="Cambiar Satatus"><?php echo status($row['status']); ?></a>
												</center>
											</td>
                                                                                                                               
                                            <td class="center">
											<a href="../detalle/index.php?detalle=<?php echo $url; ?>"  class="btn btn-info" title="Detalle">
											<i class="fa fa-list-alt" ></i>
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
