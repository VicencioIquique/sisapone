<?php 
require_once("clases/conexion.php");
require_once("clases/funciones.php");

//$criterio = ""; 
if (isset($_GET['criterio'])){ 
   	$txt_criterio = $_GET["criterio"]; 
   	$criterio = " WHERE (apellidos like '%" . $txt_criterio . "%')"; 
}
?>


<script type="text/javascript">
  $(document).ready(function(){

               fn_eliminar_comuna();
			   $('#busqueda').focus();
			
            });

</script>
<div class="idTabs">
      <ul>
		<li><a href="#one"><img src="images/buscar.png" width="30px" height="30px" /></a></li>
		<li><a href="?opc=empleado"><img src="images/agregar.png" width="30px" height="30px" /></a></li>       
      </ul>
      <div class="items">
        <div id="one">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" id="horizontalFormB">
            <fieldset>
				<legend>Buscar</legend>

                      
                             <label for="apellido">
					            Buscar
                              <input name="opc" type="hidden" id="opc" size="40" class="required" value="buscarEmp" />
                             <input name="criterio" type="text" id="busqueda" size="40"  value="<?php echo $txt_criterio;?>" />
                            </label>

			</fieldset>
			
            </form></div><!-- fin one-->
			<div id="two"> 
			  
			 </div> <!-- fin dos -->
         
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
        
        
                            
                    
         
         

            <table  id="ssptable" class="lista">
              <thead>
                    <tr>
                        <th>rut</th>
                        <th>apellido / nombre</th>
                        <th>&nbsp;</th>
                       
						
                    </tr>
                </thead>
                <tbody>
                                            
                          <?php

							$_pagi_cuantos = 10;
								$_pagi_nav_num_enlaces	=10;
							
							$_pagi_sql= "SELECT E.idEmpleado AS IDE,E.rut,E.nombres,E.apellidos,E.fechaIngreso FROM empleado as E 
								LEFT JOIN pais as P ON E.paisNacionalidad = P.idPais
								LEFT JOIN salud as S ON E.salud_idSalud = S.idSalud
								LEFT JOIN afp as A ON E.afp_idAfp= A.idAfp ".$criterio;
							
							
							include("clases/paginacion.php");
							$db = new MySQL();
							if($db->num_rows($_pagi_result)>0){
							  while($resultados = $db->fetch_array($_pagi_result)){ 
								 echo '<tr>
									
									<td>'.formateo_rut($resultados["rut"]).'</td> 
									<td>'.ucwords($resultados["apellidos"]).' '.ucwords($resultados["nombres"]).'</td>'; ?>
									
									<td width="10"><a href="modulos/empleado/editar.php?id=<?php echo $resultados["IDE"]; ?>" onclick="$(this).modal({width:1000, height:453}).open(); return false;"><img src="images/modificar.png " /></a></td>
					 <?php  /*	echo '<td width="10"><a class="elimina_comuna" id="'.$resultados["IDE"].'"><img src="images/delete.png" /></a></td> 
									</tr>';  */
								}
							}
							?>
                
                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidad">4</span> Empleado.</td>
                    </tr>
                </tfoot>
            </table>
            

<div id="paginacion">
	<?php echo "$_pagi_navegacion";?>
</div><!-- fin  paginacion -->
            
   