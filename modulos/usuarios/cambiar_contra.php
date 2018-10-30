<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	$documento=limpiar($_SESSION['cod_user']);
	$paaw=mysql_query("SELECT * FROM persona WHERE doc='$documento'");				
	if($rwow=mysql_fetch_array($paaw)){
		$nombre=$rwow['nom'];
		$tel=$rwow['tel'];		
		$dir=$rwow['dir'];
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
                <a class="navbar-brand" href="index.html"><?php echo $_SESSION['user_name']; ?></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_deposito.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                
				<div class="alert alert-info" align="center">
                    <h3>MY PERFIL [ <?php echo $nombre; ?> ]<h3>
                </div> 
                 <!-- /. ROW  -->
                 <hr />
				  <div class="col-md-6 col-sm-12 col-xs-12">           
			<div class="panel panel-back noti-box">               
                <div class="text-box" align="center">
                    <?php
                            if (file_exists("usuarios/".$_SESSION['cod_user'].".jpg")){
                                echo '<img src="../../img/usuario/'.$_SESSION['cod_user'].'.jpg" width="200" height="200" class="img-polaroid img-polaroid">';
                            }else{
                                echo '<img src="../../img/usuario/default.png" width="200" height="200">';
                            }
                        ?>
                    <hr />
                    <p class="text-muted">                          
						<a href="Principal.php" class="btn btn-default"> Regresar al Menu Principal</a>
						<a href="cambiar_contra.php" class="btn btn-default"> Cambiar Contraseña</a>										
                    </p>
                </div>
             </div>
		     </div>
			 <div class="col-md-6 col-sm-12 col-xs-12">           
			<div class="panel panel-back noti-box">               
                <div class="text-box" >
                    <p class="main-text" align="center"> Información Personal </p>                    
                    <hr />
                    <p class="">                   
                    <i class="fa fa-edit"></i><strong> Documento: </strong> <?php echo $documento; ?><br><br>
                    <i class="fa fa-edit"></i><strong> Telefono: </strong> <?php echo $tel; ?><br><br>					
                    <i class="fa fa-edit"></i><strong> Direccion: </strong> <?php echo $dir; ?><br><br>
                    </p>
                </div>
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
