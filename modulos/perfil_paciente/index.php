<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	if(!empty($_GET['id'])){
		$factura=$_GET['id'];
	}else{
		header('Location:error.php');
	}
	if($_SESSION['tipo_user']=='a' or $_SESSION['tipo_user']=='c'){
		$usu=limpiar($_SESSION['cod_user']);
		
		$usu=$_SESSION['cod_user'];
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
		$oConsultorio=new Consultar_Deposito($id_consultorio);
		$nombre_Consultorio=$oConsultorio->consultar('nombre');
	}
		
		$pa=mysql_query("SELECT * FROM pacientes WHERE consultorio='$id_consultorio' and id='$factura'");				
		if($row=mysql_fetch_array($pa)){
			$nombre=$row['nombre'];
			$direccion=$row['direccion'];
			$telefono=$row['telefono'];
			$departamento=$row['departamento'];
			$municipio=$row['municipio'];
			$edad=$row['edad'];
			$sexo=$row['sexo'];
			$email=$row['email'];
			$sangre=$row['sangre'];
			$vih=$row['vih'];
			$peso=$row['peso'];
			$talla=$row['talla'];
			$alergia=$row['alergia'];
			$medicamento=$row['medicamento'];
			$enfermedad=$row['enfermedad'];			
			$estado=$row['estado'];			
			
		}else{
			header('Location:error.php');
		}
		
	}
	
	$usu=$_SESSION['cod_user'];
	
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');
	
	$pa=mysql_query("SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysql_fetch_array($pa)){
		$id_bodega=$row['consultorio'];
		$oDeposito=new Consultar_Deposito($id_bodega);
		$nombre_deposito=$oDeposito->consultar('nombre');
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
font-size: 16px;">Consultorio: <?php echo $nombre_Consultorio; ?> :: Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_pacientes.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
				<div class="alert alert-info" align="center">
                    <h3>PERFIL DEL PACIENTE<h3>
                </div> 
                 <!-- /. ROW  -->
                			 
				 <center><button onclick="imprimir();" class="btn btn-default"><i class=" fa fa-print "></i> Imprimir</button></center>
				 <div id="imprimeme">
				<table>				
                 <tr>
                    <td>
					<center>
                    <strong><?php echo $nombre_deposito; ?></strong><br><br>
                    <img src="../../img/logo.jpg" width="125px" height="125px"><br><br>
                    <strong><?php echo $nombre_empresa; ?></strong><br>
                    </center>                                                    
                    </td>
                    <td><br>
					<strong>PERFIL DEL PACIENTE: </strong><?php echo $nombre; ?><br>
                    <strong>FECHA: </strong><?php echo fecha($fecha); ?> ||  
                    <strong>HORA: </strong><?php echo date($hora); ?><br>
                    <strong>USUARIO: </strong><?php echo $cajero_nombre; ?><br>                                                    
                    </td>
                 </tr>                       	
                </table><br>
                    <!-- /. TABLA  -->
									
				<div class="col-md-12 col-sm-6">
                    <div class="panel panel-default">                      
                        <div class="panel-body">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#infobasica" data-toggle="tab">INFORMACION BASICA</a>
                                </li>
                                <li class=""><a href="#cuadro" data-toggle="tab">CUADRO CLINICO</a>
                                </li>                                
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="infobasica">
								<h4>Infomación Basica</h4>
								<strong>PACIENTE: </strong><?php echo $nombre; ?><br>
								<strong>DIRECCION: </strong><?php echo $direccion; ?><br>
								<strong>DEPARTAMENTO: </strong><?php echo $departamento; ?><br>                                   
								<strong>MUNICIPIO: </strong><?php echo $municipio; ?><br>                                   
								<strong>EDAD: </strong><?php echo $edad; ?> AÑOS<br>                                   
								<strong>SEXO: </strong><?php echo $sexo; ?><br>                                   
								<strong>EMAIL: </strong><?php echo $email; ?><br>                                   
								<strong>ESTADO: </strong><?php echo $estado; ?><br>                                   
								</div>
                                <div class="tab-pane fade" id="cuadro">
                                <h4>Cuadro Clinico</h4>
                                <strong>TIPO DE SANGRE: </strong><?php echo $sangre; ?><br>
								<strong>VIH: </strong><?php echo $vih; ?><br>
								<strong>PESO: </strong><?php echo $peso; ?><br>                                   
								<strong>TALLA: </strong><?php echo $talla; ?><br>                                   
								<strong>ALERGIAS: </strong><?php echo $alergia; ?><br>                                   
								<strong>MEDICAMENTO: </strong><?php echo $medicamento; ?><br>                                   
								<strong>ENFERMEDAD: </strong><?php echo $enfermedad; ?><br>                                   								 
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div><br><br><br><br><br><br><br>                    				
									<center>
										<strong><?php echo $nombre_empresa; ?></strong><br>
										<strong><?php echo $tel_empresa; ?></strong><br>
										<strong><?php echo $pais_empresa; ?></strong><br>
										<strong><?php echo $dir_empresa; ?></strong><br>
									</center>
			 </div>
			</div>
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
