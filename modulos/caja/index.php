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
	
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');
	
	$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
		
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM caja_tmp WHERE paciente='$id'");
		header('location:index.php');
	}
	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Las Perlitas</title>
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
           <?php include_once "../../menu/m_caja.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">
			<br>
				<a href="operaciones.php" class="btn btn-success btn-lg btn-block" title="Listado">
					<i class="fa fa-plus" ></i><strong> Ver Pagos</strong>
				</a>
			<hr />													
<!--###################################################################################################################################### -->				
				
				<div class="alert alert-success" align="center">				
				<form name="form2" action="" method="post">
                                    <strong>CODIGO/NOMBRE PACIENTE</strong><br>
                                    <input type="text" autofocus list="browsers" name="buscar" autocomplete="off" class="form-control" required>
                                    <datalist id="browsers">
                                        <?php
                                            $pa=mysql_query("SELECT * FROM consultas_medicas 
                                            WHERE date_format(fecha,'%Y%m%d')=date_format(curdate(),'%Y%m%d') AND consultas_medicas.id_paciente AND consultas_medicas.consultorio='$id_consultorio' ORDER BY consultas_medicas.id DESC");				
                                            while($row=mysql_fetch_array($pa)){
											$oPaciente=new Consultar_Paciente($row['id_paciente']);
                                                echo '<option value="'.$oPaciente->consultar('nombre').'">';
                                            }
                                        ?> 
                                    </datalist>
                                </form>
                </div> 
				 <?php
					if(!empty($_POST['new_cant'])){
						$new_cant=limpiar($_POST['new_cant']);
						$ncodigo=limpiar($_POST['ncodigo']);
						mysql_query("UPDATE caja_tmp SET cant='$new_cant' WHERE producto='$ncodigo' and usu='$usu'");
					}
					
					if(!empty($_POST['ncodigo_ref'])){
						$referencia=limpiar($_POST['referencia']);
						$ref_ant=limpiar($_POST['ref_ant']);
						$ncodigo=limpiar($_POST['ncodigo_ref']);
						
						if($referencia==''){
							mysql_query("UPDATE caja_tmp SET ref='' WHERE producto='$ncodigo' and usu='$usu' and ref='$ref_ant'");
						}else{
							$pa=mysql_query("SELECT * FROM caja_tmp WHERE caja_tmp.ref='$referencia'");				
							if($row=mysql_fetch_array($pa)){
								echo mensajes('El Numero de Referencia "'.$referencia.'" Esta siendo usada','rojo');
							}else{
								mysql_query("UPDATE caja_tmp SET ref='$referencia' WHERE producto='$ncodigo' and usu='$usu' and ref='$ref_ant'");
							}
						}
						
					}	
				
                	if(!empty($_POST['buscar'])){
						$buscar=limpiar($_POST['buscar']);
						$poa=mysql_query("SELECT pacientes.id FROM pacientes 
						WHERE (pacientes.id='$buscar' or pacientes.nombre='$buscar') GROUP BY pacientes.nombre");	
						if($roow=mysql_fetch_array($poa)){
							$codigo=$roow['id'];
							$pa=mysql_query("SELECT * FROM caja_tmp WHERE paciente='$codigo' and usu='$usu' and ref=''");	
							if($row=mysql_fetch_array($pa)){
								$cant=$row['cant']+1;
								mysql_query("UPDATE caja_tmp SET cant='$cant' WHERE paciente='$codigo' and usu='$usu'");
							}else{
								mysql_query("INSERT INTO caja_tmp (paciente, cant, usu) VALUES ('$codigo','1','$usu')");	
							}
						}else{
							echo mensajes('El Paciente que Busca no se encuentra Registrado en la Base de Datos','rojo');	
						}
					}															
                ?>
                 <!-- /. ROW  -->										 
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->                 
                        <div class="panel-body">
                            <div class="table-responsive">
								
                        <table class="table table-striped">
                            <tr class="well-dos">
                            	<td><strong>CODIGO</strong></td>
                                <!--<td><strong>Referencia</strong></td>-->
                                <td><strong>PACIENTE</strong></td>
                                <!--<td><strong><center>CANT.</center></strong></td>-->
                                <td><strong><div align="right">COSTO CONSULTA</div></strong></td>
                                <td><strong><div align="right">IMPORTE</div></strong></td>
                                <td></td>
                            </tr>
                            <?php 
								$neto=0;$item=0;
                                $pa=mysql_query("SELECT * FROM caja_tmp, pacientes WHERE caja_tmp.usu='$usu' and caja_tmp.paciente=pacientes.id");				
                                while($row=mysql_fetch_array($pa)){
									$item=$item+$row['cant'];									
                                    #$defecto=strtolower($row['precio']);
									$precio='15';
                                    #$valor=$row['precio'];
                                    #$importe=$row['cant']*$precio;
									$neto=$neto+$precio;
									
                                    
                            ?>
                            <tr>
							 <td align="center"><span class="label label-info"> <?php echo $row['paciente']; ?></span></td>                           	                                
                                <td><?php echo $row['nombre']; ?></td>
                               <!-- <td>
                                	<center>
                                    	<a href="#m<?php echo $row['id']; ?>" role="button" class="btn btn-success btn-mini" data-toggle="modal" title="Cambiar Cantidad">
											<strong><?php echo $row['cant']; ?></strong>
                                        </a>
                                    </center>
                                </td>-->
                                <td><div align="right">$ <?php echo $precio; ?></div></td>
                                <td><div align="right">$ <?php echo formato($precio); ?></div></td>								
                                <td>
                                    <center>                           
										<a href="index.php?del=<?php echo $row['id']; ?>"  class="btn btn-danger" title="Eliminar">
											<i class="fa fa-times" ></i>
										</a>
                                    </center>
                                </td>
                            </tr>														
                            </div>                             					 					                                                                        
                            <?php } ?>
                        </table>
								
                            </div>
                            
                        
                    </div>
                    <!--End Advanced Tables -->
					<div class="span4">
                    	<table class="table table-bordered">
                            <tr>
                                <td>
                                	<center><strong>TOTAL</strong>
                                	<pre><h2 class="text-success" align="center">$ <?php echo formato($neto); ?></h2></pre>
                                    
                                </td>
                            </tr>
                    	</table>
                        <?php if($neto<>0){ ?>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                	<div align="center">
                                        <a href="#contado" role="button" class="btn btn-primary btn-lg" data-toggle="modal">
                                            <i class="icon-shopping-cart icon-white"></i> <strong>Realizar Pago</strong>
                                        </a>
                                	</div>
                                </td>
                            </tr>
                    	</table>
                        <?php } ?>
                    </div>
                </div>
            </div>
                <!-- /. ROW  -->
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
