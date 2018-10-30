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
		$id_usu=limpiar($_GET['id']);
		$sql=mysql_query("SELECT nom,estado FROM persona WHERE doc='$id_usu'");
		if($row=mysql_fetch_array($sql)){
			$nombre=$row[0];
			#$salario=$row[1];
			$estado_u=$row[1];
		}
		
		if(!empty($_GET['cambio'])){
			$cambio=limpiar($_GET['cambio']);
			if($estado_u=='s'){
				mysql_query("UPDATE persona SET estado='n' WHERE doc='$cambio'");
			}else{
				mysql_query("UPDATE persona SET estado='s' WHERE doc='$cambio'");
			}
			header('Location: permisos.php?id='.$id_usu);
		}
		
		if(!empty($_GET['pe'])){
			$id_pe=limpiar($_GET['pe']);
					
			$pa=mysql_query("SELECT * FROM permisos WHERE id='$id_pe' and estado='s'");				
			if($row=mysql_fetch_array($pa)){
				mysql_query("UPDATE permisos SET estado='n' WHERE id='$id_pe'");
			}else{
				mysql_query("UPDATE permisos SET estado='s' WHERE id='$id_pe'");
			}
			header('Location: permisos.php?id='.$id_usu);
		}
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
                    <h3>PERMISOS <?php echo $nombre; ?><h3>
                </div> 
                 <!-- /. ROW  -->
                 <hr />                 				 					 
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
										<?php 
											$consulta=mysql_query("SELECT permisos.id,permisos.estado,permisos_tmp.nombre
											FROM permisos_tmp, permisos WHERE permisos.usu='$id_usu' and permisos_tmp.id=permisos.permiso");
											while($row=mysql_fetch_array($consulta)){
												$url='?id='.$id_usu.'&pe='.$row['id'];
												
												if($row['estado']=='s'){
													$estado='<span class="label label-success">PERMITIDO</span>';
												}elseif($row['estado']=='n'){
													$estado=' <span class="label label-danger">NO PERMITIDO</span> ';
												}
										?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['nombre']; ?></td>
                                                                                                                               
                                            <td class="center"><center><a href="permisos.php<?php echo $url; ?>"><?php echo $estado; ?></a></center></td>
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
