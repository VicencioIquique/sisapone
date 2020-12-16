<?php 
require_once("../../clases/conexion.php"); 
require_once("../../clases/funciones.php");

$id=$_GET['id'];


$db = new MySQL();
$sql= $db->consulta("SELECT idEmpleado, Emp.estadoenEmpresa AS ESTADOEMPRESA, EMP.rut, nombres, apellidos, fnacimiento,
 fechaIngreso, fechaContrato, paisnacionalidad, cargo, EMP.fono, EMP.fono2, email, EMP.direccion,
 sueldoBase, nCargas, centroCosto, planIsapre, planAfp, pactadoSalud, planta, salud_idSalud, afp_idAfp,
 bodega_idBodega, empresa_idEmpresa, P.nombre AS nombrepais, EM.nombre AS nombremp,EMP.sexo,EMP.afc,
 B.nombre AS nombrebod, S.nombre AS nombresal,AF.nombre AS nombreafp,CA.nombre AS nombrecar,EMP.planta AS PLANTA,EMP.centroCosto AS CCOSTO
FROM empleado EMP
LEFT JOIN pais P ON paisnacionalidad = P.idPais
LEFT JOIN empresa EM ON EMP.empresa_idEmpresa = EM.idEmpresa
LEFT JOIN bodega B ON bodega_idBodega = B.idBodega
LEFT JOIN afp AF ON AF.idAfp = afp_IdAfp
LEFT JOIN salud S ON S.idSalud = salud_idSalud
LEFT JOIN cargo AS CA ON CA.idCargo = EMP.cargo
WHERE idEmpleado =$id");
$resultadoEMP = $db->fetch_array($sql);
$consulta = $db->consulta("SELECT * FROM pais"); 
$consultaSalud = $db->consulta("SELECT * FROM salud"); 
$consultaAfp= $db->consulta("SELECT * FROM afp"); 
$consultaEmp = $db->consulta("SELECT * FROM empresa");
$consultaBod = $db->consulta("SELECT * FROM bodega");  
$consultaCar = $db->consulta("SELECT * FROM cargo");  

function cambiarFecha($fecha) {
					  return implode("/", array_reverse(explode("-", $fecha)));
					}

?>
<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.css"><!-- estilos geneales-->
<script  src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js' type='text/javascript'/></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.ui.datepicker-es.js"></script>
<script language="javascript" type="text/javascript" src="../../js/jquery.validate.1.5.2.js"></script>
<script language="javascript" type="text/javascript" src="../../js/script.js"></script>
<script language="javascript" type="text/javascript" src="../../js/jquery.idTabs.js"></script>

<script language="javascript" type="text/javascript" src="../../js/jquery.Rut.js" ></script>
<script language="javascript" type="text/javascript" src="../../js/jquery.Rut.min.js" ></script>
<!--<script type="text/javascript" language="javascript" src="js/jquery-1.3.2.min.js"></script>-->
<script type="text/javascript" language="javascript" src="../../js/modal-window.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

              
			   $('#nombres').focus();
			   $( "#fnacimiento" ).datepicker({ 
			   firstDay: 1, // comenzar el lunes
			   dateFormat:'dd/mm/yy',
			   changeYear: true,
			   yearRange: "-100:+0"});
			   $( "#fingreso" ).datepicker({ 
			   firstDay: 1, 
			   dateFormat: 'dd/mm/yy',
			   changeYear: true,
			   yearRange: "-100:+0"});
			    $( "#fcontrato" ).datepicker({ 
			   firstDay: 1, 
			   dateFormat: 'dd/mm/yy',
			   changeYear: true,
			   yearRange: "-100:+0"});
			   
			   $('#rut').Rut({
  				on_error: function(){ alert('Rut incorrecto'); }
				});
			
            });

</script>
<link rel="stylesheet" type="text/css" href="../../temas/minimalverde/minimalverde.css"><!-- estilos geneales-->
<form action="actualizar.php" method="post" id="horizontalForm">
             
            <fieldset>
				<legend>Datos Personales</legend>
					<input name="idEmp" type="hidden" id="idEmp" size="40"  value="<?php echo $resultadoEMP['idEmpleado'];?>" />
						<label for="name">
					            Nombres
                            <input name="nombres" type="text" id="nombres" size="40" class="required" value="<?php echo $resultadoEMP['nombres'];?>" />
                        </label>
						<label for="name">
					            Apellidos
                            <input name="apellidos" type="text" id="apellidos" size="40" class="required" value="<?php echo $resultadoEMP['apellidos'];?>"  />
                        </label>
						<label class="first" for="name">
									Sexo
									<select  id="sexo" name="sexo" class="styled" >';
										<?php 
											if ($resultadoEMP['sexo']=='M')
											{
												
												echo'<option value="M"   selected="selected">M</option>
												<option value="F">F</option>'; 
											}
											else
											{ 
											   echo'<option value="F"   selected="selected">F</option>
													<option value="M">M</option>'; 
											}
									?>
									 </select>
				            </label>
						<label for="name">
					            RUT
                            <input name="rut" type="text" id="rut" size="40" class="required" value="<?php echo  formateo_rut($resultadoEMP['rut']);?>"  />
                        </label>
						<label for="name">
					            Fecha Nacimiento
                            <input name="fnacimiento" type="text"  id="fnacimiento" size="40"  class="required" value="<?php echo  cambiarFecha($resultadoEMP['fnacimiento']);?>"  />
                        </label>

						 <?php 
							 echo' <label class="first" for="name">
								Pais Nacionalidad
								<select id="pais" name="pais"    class="styled" >';
								
									if($db->num_rows($consulta)>0)
									{
										echo'<option value="'.$resultadoEMP['paisnacionalidad'].'"   selected="selected">'.$resultadoEMP['nombrepais'].'</option>';
										 while($resultados = $db->fetch_array($consulta))
										 { 
											echo "\n";
											echo'<option value="'.$resultados['idPais'].'">'.$resultados['nombre'].'</option>';
										 }
									}
			
							  echo'</select>
						</label>';
						?>
						
						<label for="name">
					            Direccion
                            <input name="direccion" type="text" id="largo" id="direccion" size="40"  class="required" value="<?php echo $resultadoEMP['direccion'];?>"  />
                        </label>
						<label for="name">
					            fono
                            <input name="fono" type="text" id="fono" size="40" class="required" value="<?php echo $resultadoEMP['fono'];?>" />
                        </label>
						<label for="name">
					            fono 2
                            <input name="fono2" type="text" id="fono2" size="40" class="required" value="<?php echo $resultadoEMP['fono2'];?>"  />
                        </label>
						<label for="name">
					            eMail
                            <input name="email" type="text" id="email" size="40" class="required" value="<?php echo $resultadoEMP['email'];?>"  />
                        </label>
						
						
                             <label class="first" for="name">
									N. Cargas
									<select id="nCargas" name="nCargas"  class="styled" >';
									<?php echo'<option value="'.$resultadoEMP['nCargas'].'"   selected="selected">'.$resultadoEMP['nCargas'].'</option>'; ?>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
							 </select>
				          </label>
                       
			</fieldset><!-- fin field datos personales-->
			
			<fieldset>
				<legend>Datos como Trabajador</legend>
                
						<?php 
							
								 echo' <label class="first" for="name">
									Cargo
									<select id="cargo" name="cargo"  class="styled" >';
									echo'<option value="'.$resultadoEMP['cargo'].'"   selected="selected">'.$resultadoEMP['nombrecar'].'</option>';
										if($db->num_rows($consultaCar)>0)
										{
											 while($resultados = $db->fetch_array($consultaCar))
											 { 
												 echo'<option value="'.$resultados['idCargo'].'">'.$resultados['nombre'].'</option>';
											 }
										}
				
								  echo'</select>
				            </label>';
					        ?>
						<label for="name">
					            Fecha Ingreso
                            <input name="fingreso" type="text" id="fingreso" size="40" class="required" value="<?php echo  cambiarFecha($resultadoEMP['fechaIngreso']);?>"  />
                        </label>	
						<label for="name">
					            Fecha Contrato
                            <input name="fcontrato" type="text"  id="fcontrato" size="40"  class="required" value="<?php echo  cambiarFecha($resultadoEMP['fechaContrato']);?>" />
                        </label>
						
						
                             <?php 
							
								 echo' <label class="first" for="name">
									Empresa
									<select id="empresa" name="empresa"  class="styled" >';
									echo'<option value="'.$resultadoEMP['empresa_idEmpresa'].'"   selected="selected">'.$resultadoEMP['nombremp'].'</option>';
										if($db->num_rows($consultaEmp)>0)
										{
											 while($resultados = $db->fetch_array($consultaEmp))
											 { 
												 echo'<option value="'.$resultados['idEmpresa'].'">'.$resultados['nombre'].'</option>';
											 }
										}
				
								  echo'</select>
				            </label>';
					        ?>
							
						  <?php 
								 echo' <label class="first" for="name">
									Lugar de T.
									<select id="mediano" id="bodega" name="bodega"  class="styled" >';
									echo'<option value="'.$resultadoEMP['bodega_idBodega'].'"   selected="selected">'.$resultadoEMP['nombrebod'].'</option>';
										if($db->num_rows($consultaBod)>0)
										{
											 while($resultados = $db->fetch_array($consultaBod))
											 { 
												 echo'<option value="'.$resultados['idBodega'].'">'.$resultados['nombre'].'</option>';
											 }
										}
				
								  echo'</select>
				            </label>';
					        ?>
						
						<label for="name">
					            Sueldo Base
                            <input name="sueldoBase" type="text" id="sueldoBase" size="40" class="required" value="<?php echo $resultadoEMP['sueldoBase'];?>"  />
                        </label>
						
						<label for="name">
					            Pactado Isapre
                            <input name="pactado" type="text" id="pactado" size="40" class="required" value="<?php echo $resultadoEMP['pactadoSalud'];?>"  />
                        </label>
						
							
							 <?php 
								 echo' <label class="first" for="name">
									AFP
									<select id="mediano" id="afp" name="afp" class="styled" >';
									echo'<option value="'.$resultadoEMP['afp_idAfp'].'"   selected="selected">'.$resultadoEMP['nombreafp'].'</option>';
										if($db->num_rows($consultaAfp)>0)
										{
											 while($resultados = $db->fetch_array($consultaAfp))
											 { 
												 echo'<option value="'.$resultados['idAfp'].'">'.$resultados['nombre'].'</option>';
											 }
										}
				
								  echo'</select>
				            </label>';
					        ?>
							 <?php 
								 echo' <label class="first" for="name">
									Salud
									<select id="mediano" id="salud" name="salud" class="styled" >';
									echo'<option value="'.$resultadoEMP['salud_idSalud'].'"   selected="selected">'.$resultadoEMP['nombresal'].'</option>';

										if($db->num_rows($consultaSalud)>0)
										{
											 while($resultados = $db->fetch_array($consultaSalud))
											 { 
												 echo'<option value="'.$resultados['idSalud'].'">'.$resultados['nombre'].'</option>';
											 }
										}
				
								  echo'</select>
				            </label>';
					        ?>
							 <label class="first" for="name">
									Contrato Indefinido
									<select id="fijo" name="fijo"  class="styled" >';
									<?php 
									if ($resultadoEMP['PLANTA']==1)
									{
										
								    	echo'<option value="'.$resultadoEMP['PLANTA'].'"   selected="selected">Si</option>
										<option value="0">No</option>'; 
									}
									else
									{ 
									   echo'<option value="'.$resultadoEMP['PLANTA'].'"   selected="selected">No</option>
									        <option value="1">Si</option>'; 
									}
								?>
									
									
								
							 </select>
				          </label>
							<label class="first" for="name">
									Centro de Costo
									<select  id="cCosto" name="cCosto" class="styled" >';
									<?php 
								
									if ( $resultadoEMP['centroCosto'] == 20)
										{$centroCosto = "Galpón";}
										else if ( $resultadoEMP['centroCosto'] ==21)
										{$centroCosto = "Paramo";}
										else if ( $resultadoEMP['centroCosto'] ==22)
										{$centroCosto = "Gerencia Gral.";}
										else if ( $resultadoEMP['centroCosto'] ==23)
										{$centroCosto = "Comercialización";}
										else if ( $resultadoEMP['centroCosto'] ==24)
										{$centroCosto = "Administracion";}
										else if ( $resultadoEMP['centroCosto'] ==25)
										{$centroCosto = "aeropuerto";}
										else if ( $resultadoEMP['centroCosto'] ==26)
										{$centroCosto = "Santiago";}
										else
										{ $centroCosto = $resultadoEMP['centroCosto'];}
									
									echo'<option value="'.$resultadoEMP['centroCosto'].'"   selected="selected">'.$centroCosto.'</option>'; ?>
										<option value="181">181</option>
										<option value="1132">1132</option>
										<option value="184">184</option>
										<option value="6130">6130</option>
										<option value="1010">1010</option>
										<option value="2002">2002</option>
										<option value="6115">6115</option>
										<option value="20">Galpón</option>
										<option value="21">Paramo</option>
										<option value="22">Gerencia Gral.</option>
										<option value="23">Comercialización</option>
										<option value="24">Administracion</option>
										<option value="25">aeropuerto</option>
										<option value="26">Santiago</option>
									 </select>
				            </label>
							
							
							<label class="first" for="name">
									AFC
									<select  id="afc" name="afc" class="styled" >';
										<?php 
											if ($resultadoEMP['afc']==0)
											{
												
												echo'<option value="0"   selected="selected">Si</option>
												<option value="1">No</option>'; 
											}
											else
											{ 
											   echo'<option value="1"   selected="selected">No</option>
													<option value="0">Si</option>'; 
											}
									?>
									 </select>
				            </label>
							
							 <label class="first" for="name">
									<strong>Activo en Sistema</strong>
									
									<select  id="activo" name="activo" class="styled" >';
										<?php
										
										if($resultadoEMP['ESTADOEMPRESA'] ==0)
										{
										echo'<option value="0"   selected="selected">Si</option>
												<option value="1">No</option>'; 
										}
										else
										{
										  echo'<option value="1"   selected="selected">No</option>
													<option value="0">Si</option>'; 
										}

										?>
										
									 </select>
				            </label>
						
						
						
                           <input name="modificar" type="submit" id="modificar" class="submit" value="Modificar" />
                    		
                	
			</fieldset>
</form>