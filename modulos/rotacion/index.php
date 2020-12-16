<?php 
require_once("clases/conexion.php");

$db = new MySQL();
$consulta = $db->consulta("SELECT * FROM pais"); 
$consultaSalud = $db->consulta("SELECT * FROM salud"); 
$consultaAfp= $db->consulta("SELECT * FROM afp"); 
$consultaEmp = $db->consulta("SELECT * FROM empresa");
$consultaBod = $db->consulta("SELECT * FROM bodega");  
$consultaCar = $db->consulta("SELECT * FROM cargo");  


//$criterio = ""; 
if (isset($_GET['criterio'])){ 
   	$txt_criterio = $_GET["criterio"]; 
   	$criterio = " WHERE (C.nombre like '%" . $txt_criterio . "%')"; 
}


?>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
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
				
				$('#sueldoBase').numeric({ negative: false }, function() { alert("No se aceptan valores Negativos"); this.value = ""; this.focus(); });
				
				$('#fono').numeric({ negative: false }, function() { alert("No se aceptan valores Negativos"); this.value = ""; this.focus(); });
				$('#fono2').numeric({ negative: false }, function() { alert("No se aceptan valores Negativos"); this.value = ""; this.focus(); });
            });

</script>

<div class="idTabs">
      <ul>
		 <li><a href="#two"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
        <li><a href="?opc=buscarEmp"><img src="images/buscar.png" width="30px" height="30px" /></a></li>
       
      </ul>
      <div class="items">
        <div id="one">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" id="horizontalFormB">
            <fieldset>
				<legend>Buscar</legend>

                      
                             <label for="pais1">
					            Buscar
                              <input name="opc" type="hidden" id="opc" size="40" class="required" value="empleado" />
                             <input name="criterio" type="text" id="busqueda" size="40"  value="<?php echo $txt_criterio;?>" />
                            </label>

			</fieldset>
			
            </form></div><!-- fin one-->
        <div id="two"> 
            <form action="javascript: fn_agregar_empleado();" method="post" id="horizontalForm">
            <fieldset>
				<legend>Datos Personales</legend>
                
						<label for="name">
					            Nombres
                            <input name="nombres" type="text" id="nombres" size="40" class="required" />
                        </label>
						<label for="name">
					            Apellidos
                            <input name="apellidos" type="text" id="apellidos" size="40" class="required" />
                        </label>
						<label for="name">
					            RUT
                            <input name="rut" type="text" id="rut" size="40" class="required" />
                        </label>
						<label for="name">
					            Fecha Nacimiento
                            <input name="fnacimiento" type="text"  id="fnacimiento" size="40"  class="required" />
                        </label>
						
						 <?php 
							 echo' <label class="first" for="name">
								Pais Nacionalidad
								<select id="pais" name="pais"    class="styled" >';
								
									if($db->num_rows($consulta)>0)
									{
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
                            <input name="direccion" type="text" id="largo" id="direccion" size="40"  />
                        </label>
						<label for="name">
					            fono
                            <input name="fono" type="text" id="fono" size="40" />
                        </label>
						<label for="name">
					            fono 2
                            <input name="fono2" type="text" id="fono2" size="40" />
                        </label>
						<label for="name">
					            eMail
                            <input name="email" type="text" id="email" size="40" />
                        </label>
						
                             <label class="first" for="name">
									N. Cargas
									<select id="nCargas" name="nCargas"  class="styled" >';
									
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
                            <input name="fingreso" type="text" id="fingreso" size="40" class="required" />
                        </label>	
							<label for="name">
					            Fecha Contrato
                            <input name="fcontrato" type="text"  id="fcontrato" size="40"  class="required" />
                        </label>
						<label for="name">
					            Sueldo Base
                            <input name="sueldoBase" type="text" id="sueldoBase" size="40" class="required" />
                        </label>
					
						<label for="name">
					            Pactado Isapre
                            <input name="pactado" type="text" id="pactado" size="40" class="required" />
                        </label>
						
                             <?php 
							
								 echo' <label class="first" for="name">
									Empresa
									<select id="empresa" name="empresa"  class="styled" >';
									
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
									Bodega
									<select id="bodega" name="bodega"  class="styled" >';
									
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
						 
							
							 <?php 
								 echo' <label class="first" for="name">
									AFP
									<select  id="afp" name="afp" class="styled" >';
									
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
									<select  id="salud" name="salud" class="styled" >';
									
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
									Centro de Costo
									<select  id="cCosto" name="cCosto" class="styled" >';
									
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
									Activo
									<select  id="activo" name="activo" class="styled" >';
									
										<option value="1">Si</option>
										<option value="0">No</option>
									 </select>
				            </label>
						
						
						
                           <input name="agregar" type="submit" id="agregar" class="submit" value="Agregar" />
                    		
                	
			</fieldset>
			
            </form>
         </div> <!-- fin dos -->
         
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
        