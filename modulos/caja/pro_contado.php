<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	if($_SESSION['tipo_user']=='a' or $_SESSION['tipo_user']=='c'){
	}else{
		header('Location: ../../php_cerrar.php');
	}
	$usu=$_SESSION['cod_user'];
	
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	
	$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
	
	if(!empty($_GET['valor_recibido']) and !empty($_GET['neto'])){
		$valor_recibido=limpiar($_GET['valor_recibido']);
		$netoO=limpiar($_GET['neto']);
		$neto=$netoO;
		$fecha=date('Y-m-d');
		$hora=date('H:i:s');
		
		$pa=mysql_query("SELECT * FROM caja_tmp WHERE usu='$usu'");				
		if(!$row=mysql_fetch_array($pa)){	
			header('Location: index.php');
		}
		######### TRAEMOS LOS DATOS DE LA EMPRESA #############
		$pa=mysql_query("SELECT * FROM empresa WHERE id=1");				
        if($row=mysql_fetch_array($pa)){
			$nombre_empresa=$row['empresa'];
			$nit_empresa=$row['nit'];
			$dir_empresa=$row['direccion'];
			$tel_empresa=$row['tel'].'-'.$row['fax'];
			$pais_empresa=$row['pais'].' - '.$row['ciudad'];
		}
		
		
		######### SACAMOS EL VALOR MAXIMO DE LA FACTURA Y LE SUMAMOS UNO ##########
		$pa=mysql_query("SELECT MAX(factura)as maximo FROM factura");				
        if($row=mysql_fetch_array($pa)){
			if($row['maximo']==NULL){
				$factura='100000001';
			}else{
				$factura=$row['maximo']+1;
			}
		}	
		
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
	
	<script>
		function imprimir(){
		  var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
		  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
		  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
		  ventana.document.close();  //cerramos el documento
		  ventana.print();  //imprimimos la ventana
		  ventana.close();  //cerramos la ventana
		}
	</script>
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
				<center><button onclick="imprimir();" class="btn btn-default"><i class=" fa fa-print "></i> Imprimir</button></center>
				 <div id="imprimeme">
				<table width="100%">
                                        	<tr>
                                                <td>
                                                    <center>
                                                    	<strong><?php echo $nombre_Consultorio; ?></strong><br>
                                                        <img src="../../img/logo.jpg" width="80" height="80"><br>
                                                        <strong><?php echo $nombre_empresa; ?></strong><br>
                                                    </center>
                                                </td>
                                                <td><br>
                                                    <strong>DOCUMENTO: </strong><?php echo $factura; ?><br>
                                                    <strong>FECHA: </strong><?php echo fecha($fecha); ?> | 
                                                    <strong>HORA: </strong><?php echo date($hora); ?><br>
                                                    <strong>USUARIO/A: </strong><?php echo $cajero_nombre; ?>
                                                </td>
                                            </tr>
                                        </table>
				
                 <!-- /. ROW  -->
                 <hr /><br><br>
                <!-- /. ROW  -->
			<div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             DETALLES DE PRODUCTOS
                        </div><br>
						<div class="table-responsive">
                        <div class="panel-body">                                                                 	                                                                                               
                          <table class="table table-striped table-bordered table-hover" width="100%" rules="all"  border="1">
                                        	<tr>
                                            	
                                                <!--<td><strong>Cod. Articulo</strong></td>-->
												<td><strong>CANTIDAD</strong></td>                                              
                                                <td><strong>PACIENTE</strong></td>
                                                <!--<td><strong>Motivo</strong></td>-->
												<!--<td><strong>Categoria</strong></td>-->
                                                <td><div align="right"><strong>COSTO DE CONSULTA</strong></div></td>
                                                <td><div align="right"><strong>TOTAL</strong></div></td>
                                            </tr>
                                            <?php 
												$item=0;
												$neto=0;
												$neto_full=0;
												$pa=mysql_query("SELECT * FROM caja_tmp, pacientes 
												WHERE caja_tmp.usu='$usu' and caja_tmp.paciente=pacientes.id");				
										        while($row=mysql_fetch_array($pa)){												
													$item=$item+$row['cant'];
													$cantidad=$row['cant'];
													$nit=$row['paciente'];
													$codigo=$row['paciente'];
													$p_nombre=$row['nombre'];													
													#$precio_venta=strtolower($row['precio']);
													#$valor=$row['precio'];
													$precio='15';
													$importe=$precio;
													$neto=$neto+$importe;
																										
													 ########################################
													$new_valor=$row['ref'];
													$importe_dos=$precio;
													$neto_full=$neto_full+$importe_dos;															
																				
													$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, valor, importe, tipo, consultorio)
							                        VALUES ('$factura','$codigo','$p_nombre','$precio','$importe_dos','CONSULTA','$id_consultorio')";
					                                mysql_query($detalle_sql);																																																				
											?>
                                            <tr>
                                            	
                                                <!--<td><?php echo $codigo; ?></td>-->
												<td align="center"><?php echo $cantidad; ?></td>                                                
                                                <td><?php echo $p_nombre; ?></td>
                                                <!--<td><?php echo $referencia; ?></td>-->
												<!--<td><?php echo $row['tipo']; ?></td>-->
                                                <td><div align="right">$<?php echo formato($precio); ?></div></td>
                                                <td><div align="right">$<?php echo formato($importe_dos); ?></div></td>
                                            </tr>
											<?php } ?>
                                            <tr>
                                              <td colspan="3"><div align="right"><strong>Total</strong></div></td>
                                              <td><div align="right"><strong>$ <?php echo formato($neto_full); ?></strong></div></td>
                                            </tr>
                                        </table>                                                                                                                          
                        </div>
                    </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->  
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                     <br>
										<center>
                                        	<?php echo $nombre_empresa; ?><br>
                                            <?php echo $tel_empresa; ?><br>
                                            <?php echo $pais_empresa; ?><br>
                                            <?php echo $dir_empresa; ?><br>
                                        </center>
        </div>               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
			</div>
			<?php 
		######## GUARDAMOS LA INFORMACION DE LA FACTURA EN LA TABLA COMPRA
		$fecha=date('Y-m-d');					
		$hora=date('H:i:s');
		#mysql_query("INSERT INTO fac_operacion (factura,valor,fecha,estado,usu) VALUE ('$factura','$netoO','$fecha','s','$usu')");
		mysql_query("INSERT INTO factura (factura,valor,fecha,estado,consultorio,usu) VALUE ('$factura','$neto_full','$fecha','s','$id_consultorio','$usu')");
		
		$mensaje='Operacion al Contado';
		mysql_query("INSERT INTO resumen (paciente,concepto,factura,clase,valor,tipo,fecha,hora,status,usu,consultorio,estado) VALUE ('$codigo','$mensaje','$factura','CONSULTA','$neto_full','CONSULTA','$fecha','$hora','CANCELADO','$usu','$id_consultorio','s')");
		#mysql_query("INSERT INTO resumen (concepto,clase,valor,tipo,fecha,hora,usu,estado) VALUE ('$mensaje','DESPERDICIO','$neto_full','DESPERDICIO','$fecha','$hora','$usu','s')");
										
		mysql_query("DELETE FROM caja_tmp WHERE usu='$usu'");
		mysql_query("Update citas_medicas Set status='PROCESADO' Where id_paciente='$nit'");	
		
		
		
	?>
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
