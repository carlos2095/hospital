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
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM departamentos WHERE id='$id'");
		header('index.php');
	}
	
	$titulo='Registrar Usuario';			
	$existe=FALSE;	
	$boton='Registrar';		
	$consultorio='';
	$doc='';				
	$nom='';		
	$dir='';		
	$tel='';		
	$sexo='';				
	$tipo='c';		
	$correo='';
	$estado='';				
			
	if(!empty($_GET['doc'])){
		$id_doc=limpiar($_GET['doc']);
		$id_doc=substr($id_doc,10);
		$id_doc=decrypt($id_doc,'URLCODIGO');
		
		$pa=mysql_query("SELECT * FROM persona, username, cajero WHERE username.usu='$id_doc' and persona.doc='$id_doc'");				
		if($row=mysql_fetch_array($pa)){
			$existe=TRUE;			
			$boton='Actualizar';	
			$consultorio=$row['consultorio'];		
			$doc=$id_doc;			
			$nom=$row['nom'];		
			$dir=$row['dir'];
			$tel=$row['tel'];
			$sexo=$row['sexo'];	
			$tipo=$row['tipo'];		
			$correo=$row['correo'];
			$estado=$row['estado'];					
			$fechar=date('Y-m-d');				
			$titulo="Actualizar Usuario [ ".$nom." ]";
		}else{
			header('Location: agregar.php');
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
                <a class="navbar-brand" href="index.html">Clinica</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Fecha de Acceso : <?php echo fecha(date('Y-m-d')); ?> &nbsp; <a href="../../php_cerrar.php" class="btn btn-danger square-btn-adjust">Salir</a> </div>
        </nav>   
           <?php include_once "../../menu/m_departamento.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">						                				
                  <div class="panel-body" align="right">                                                                                 
                            <a href="index.php" class="btn btn-primary" title="Listado">
							<i class="fa fa-list" ></i>
							</a>
                            				

                  </div>
				  
					 
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             <?php echo $titulo ?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
						<?php
							#echo cadenas().encrypt('121212','URLCODIGO');
							if(!empty($_POST['doc']) and !empty($_POST['nom'])){
									$doc=limpiar($_POST['doc']);		
									$nom=limpiar($_POST['nom']);
									$tel=limpiar($_POST['tel']);
									$dir=limpiar($_POST['dir']);
									$sexo=limpiar($_POST['sexo']);
									$tipo=limpiar($_POST['tipo']);
									$consultorio=limpiar($_POST['consultorio']);
									$correo=limpiar($_POST['correo']);									
									$estado=limpiar($_POST['estado']);									
									$fechar=date('Y-m-d');																																	
									$con=$doc;							
									$url=cadenas().encrypt($doc,'URLCODIGO');
									
														
									$oConsultar=new Consultar_Usuario($doc);
									$oUsuario=new Proceso_Usuario($doc,$nom,$tel,$dir,$sexo,$tipo,$consultorio,$correo,$estado,$fechar,$con);
																
									if(!empty($_GET['doc'])){
										$oUsuario->actualizar();
										
										//subir la imagen del articulo
										$nameimagen = $_FILES['imagen']['name'];
										$tmpimagen = $_FILES['imagen']['tmp_name'];
										$extimagen = pathinfo($nameimagen);
										$ext = array("png","jpg");
										$urlnueva = "../../img/usuario/".$doc.".jpg";			
										if(is_uploaded_file($tmpimagen)){
											if(array_search($extimagen['extension'],$ext)){
												copy($tmpimagen,$urlnueva);	
											}else{
												echo mensajes("Error al Cargar la Imagen","rojo");	
											}
										}else{
											echo mensajes("Error al Cargar la Imagen","rojo");	
										}
										echo mensajes('El Usuario "'.$nom.' '.'" Ha sido Actualizado/a con Exito<br>
										Tipo de Usuario "'.usuario($tipo).'"','verde');
									}else{
										if($oConsultar->consultar('nom')==NULL){
											$oUsuario->crear();
											echo mensajes('El Usuario "'.$nom.' '.'" Ha sido Registrado/a con Exito<br> Como "'.usuario($tipo).'"','verde');
											
											//subir la imagen del articulo
											$nameimagen = $_FILES['imagen']['name'];
											$tmpimagen = $_FILES['imagen']['tmp_name'];
											$extimagen = pathinfo($nameimagen);
											$ext = array("png","jpg");
											$urlnueva = "../../img/usuario/".$doc.".jpg";			
											if(is_uploaded_file($tmpimagen)){
												if(array_search($extimagen['extension'],$ext)){
													copy($tmpimagen,$urlnueva);	
												}else{
													echo mensajes("Error al Cargar la Imagen","rojo");	
												}
											}else{
												echo mensajes("Error al Cargar la Imagen","rojo");	
											}
											
										}else{
											echo mensajes('El Usuario "'.$nom.'" Ya se Encuentra Registrado con el Documento "'.$doc.'"','rojo');
										}
									}
							}
						?>
					<form name="form2" method="post" enctype="multipart/form-data" action="">
				    <div class="row">                                       
					<div class="col-md-6">											
								<label>Documento:</label>
								<input class="form-control" name="doc" <?php if($existe==TRUE){ echo 'readonly'; }else{ echo 'required'; } ?>   value="<?php echo $doc; ?>" data-mask="99999999-9" autocomplete="off" required><br>
								<label>Nombre:</label>
								<input class="form-control" name="nom" value="<?php echo $nom; ?>" autocomplete="off" required><br>	
								<label>Telefono:</label>
								<input class="form-control" name="tel" value="<?php echo $tel; ?>" data-mask="9999-9999" autocomplete="off" required><br>
								<label>Dirección:</label>
								<input class="form-control" name="dir" value="<?php echo $dir; ?>" autocomplete="off" required><br>
								<strong>Fotografia</strong><br>
								<?php
											if (file_exists("../../img/usuario/".$doc.".jpg")){
												echo '<img src="../../img/usuario/'.$doc.'.jpg" width="150px" height="150px" class="img-polaroid">';
											}else{ 
												echo '<img src="../../img/usuario/default.png" width="150px" height="150px" class="img-polaroid">';
											}
										?><br>
							
								<input type="file" name="imagen" id="imagen">																	
					</div>
					<div class="col-md-6">
								<label>Sexo</label>
								<select class="form-control" name="sexo" autocomplete="off" required>
								<option value="m" <?php if($sexo=='m'){ echo 'selected'; } ?>>Masculino</option>
                                <option value="f" <?php if($sexo=='f'){ echo 'selected'; } ?>>Femenino</option>													
								</select><br>
								<label>Tipo de Usuario</label>
								<select class="form-control" name="tipo" autocomplete="off" required>
								<option value="a" <?php if($tipo=='a'){ echo 'selected'; } ?>>Administrador</option>
                                <option value="c" <?php if($tipo=='c'){ echo 'selected'; } ?>>Asistente</option>												
								</select><br>
								<label>Consultorio;</label>
								<select class="form-control" name="consultorio" autocomplete="off" required>
									<?php
										$pa=mysql_query("SELECT * FROM consultorios");				
										while($row=mysql_fetch_array($pa)){
											if($row['id']==$consultorio){
												echo '<option value="'.$row['id'].'" selected>'.$row['nombre'].'</option>';	
											}else{
												echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';	
											}
										}
                                  	?>												
							    </select><br>
								<label>Email:</label>
								<input class="form-control" name="correo" value="<?php echo $correo; ?>" autocomplete="off" required><br>
								<label>Estado</label>
								<select class="form-control" name="estado" autocomplete="off" required>
								<option value="s" <?php if($estado=='s'){ echo 'selected'; } ?>>ACTIVO</option>
                                <option value="n" <?php if($estado=='n'){ echo 'selected'; } ?>>NO ACTIVO</option>													
								</select><br><br>
								<div align="right"> 								
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
								<button type="submit" class="btn btn-primary"><?php echo $boton; ?></button>
								</div> 
																	
					</div>                                                                        
					</div>
				    </form>
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
